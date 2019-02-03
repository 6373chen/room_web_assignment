<?php
namespace aitsyd;

class ProductDetail extends Product{
  protected $product_id;
  public $product = array();
  public function __construct(){
    parent::__construct();
    $this -> product_id = $_GET['id'];
  }
  public function getProductById(){
    if( isset($this -> product_id) == false ){
      exit();
    }
    else{
      $query = 'SELECT
      product.product_id,
      product.name,
      product.description,
      product.price,
      product.bedroom,
      product.bathroom,
      product.bond,
      product.date_availaible,
      image.image_file_name
      FROM product
      INNER JOIN product_image
      ON product.product_id = product_image.product_id
      INNER JOIN image
      ON product_image.image_id = image.image_id
      WHERE product.product_id = ?';
      
      $statement = $this -> connection -> prepare($query);
      $statement -> bind_param( 'i' , $this -> product_id );
      if( $statement -> execute() ){
        $tmp_array = array();
        $result = $statement -> get_result();
        while( $row = $result -> fetch_assoc() ){
          array_push( $tmp_array, $row );
        }
        //add the rows from the first row (row[0]) to the product array
        $this -> product['product_id'] = $tmp_array[0]['product_id'];
        $this -> product['name'] = $tmp_array[0]['name'];
        $this -> product['price'] = $tmp_array[0]['price'];
        $this -> product['description'] = $tmp_array[0]['description'];
        $this -> product['bathroom'] = $tmp_array[0]['bathroom'];
        $this -> product['bedroom'] = $tmp_array[0]['bedroom'];
        $this -> product['bond'] = $tmp_array[0]['bond'];
        $this -> product['date_availaible'] = $tmp_array[0]['date_availaible'];
        $this -> product['parking'] = $tmp_array[0]['parking'];
        //add images to an array
        $img_array = array();
        foreach( $tmp_array as $product ){
          array_push( $img_array, $product['image_file_name'] );
        }
        //add the images array to the product array as 'images'
        $this -> product['images'] = $img_array;
        
        return $this -> product;
      }
      
      
    }
  }
}
?>