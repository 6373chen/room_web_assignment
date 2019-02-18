<?php
namespace aitsyd;

class ProductDetail extends Product{
  protected $product_id;
  public $product = array();
  public function __construct(){
    parent::__construct();
    $this -> product_id = $_GET['id'];
  }
  public function  uploadProduct($title,$description,$price,$bathroom,$bedroom,$bond,$date_avail,$parking){
      $query = 'INSERT INTO product (
                 
                  name ,
                  description,
                  price,
                  bathroom,
                  active ,
                  created ,
                  
                  bedroom ,
                  parking ,
                  bond ,
                  date_availaible
                  )
                  VALUES (
                  ?,  ?,  ?, ? ,  1, NOW() , ? , ? , ?,?)';
                
      $statement = $this -> connection -> prepare($query);
      $statement -> bind_param( 'ssiiiiis' , $title,$description,$price,$bathroom,$bedroom,$parking ,$bond,$date_avail);
      if($statement -> execute()){
       // echo "<script>alert('yea bro, succeed')</script>";
      }else{
        echo "<script>alert('Oh no something wrong')</script>";
      }
    return $this -> connection -> insert_id;
    
  }
  public function uploadImage($imageName){
    $query = "INSERT INTO image(image_file_name,date_added)
              VALUES(?,NOW())";
    $statement = $this -> connection -> prepare($query);
    $statement -> bind_param('s',$imageName);
    $statement -> execute();
    return $this -> connection -> insert_id;
  }
  public function uploadProduct_image($product_id, $image_id){
    
     $query = "INSERT INTO product_image(product_id,image_id)
              VALUES(?,?)";
    $statement = $this -> connection -> prepare($query);
    $statement -> bind_param('ii',$product_id,$image_id);
    $statement -> execute();
    return $this -> connection -> insert_id;
  }
  
  public function uploadProduct_category($product_id,$category_id)
  {
    $query = "INSERT INTO product_category(product_id,category_id)
              VALUES(?,?)";
    $statement = $this -> connection -> prepare($query);
    $statement -> bind_param('ii',$product_id,$category_id);
    if($statement -> execute()){
      return $this -> connection -> insert_id;
    }
     else{
       echo "<script>alert('Oh no something wrong categories')</script>";
     }
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
      product.parking,
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