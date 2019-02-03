<?php
namespace aitsyd;
use aitsyd\Product;
use Exception;

class ProductSearch extends Product{
  private $keywords;
  public $searchResult = array();
  public $searchTotal;
  public function __construct(){
    parent::__construct();
  }
  public function search( $keywords ){
    //user a query with LIKE for more matches
    $query = "SELECT  
    @pid := product_id AS product_id,
    name,
    description,
    price,
    @image_id := ( SELECT image_id FROM product_image WHERE product_id = @pid LIMIT 1 ) AS image_id,
    ( SELECT image_file_name FROM image WHERE image_id = @image_id ) AS image_file_name
    FROM product 
    WHERE ( product.name LIKE ? OR product.description LIKE ? ) AND active=1";
    
    //pad keywords with %keyword%
    $search_param = "%$keywords%";
    
    $statement = $this -> connection -> prepare($query);
    $statement -> bind_param('ss',$search_param, $search_param);
    try{
      if($statement -> execute() == false ){
        throw new Exception('query error');
      }
      else{
        $result = $statement -> get_result();
        if( $result -> num_rows > 0 ){
          $this -> searchTotal = $result -> num_rows;
          while( $row = $result -> fetch_assoc() ){
            array_push( $this -> searchResult, $row );
          }
        }
        return $this -> searchResult;
      }
    }
    catch(Exception $exc){
      error_log($exc -> getMessage() );
    }
  }
}
?>