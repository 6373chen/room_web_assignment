<?php
namespace aitsyd;

class Product extends Database{
  //we will return other information along with products, so 
  public $products = array();
  public $page;
  public $category;
  public $perpage;
  //constructor function
  public function __construct(){
    //construct database connection (the parent class)
    parent::__construct();
    $this -> validateRequest();
  }
  private function validateRequest(){
    //read GET request variable and set good defaults to avoid unexpected behaviours
    //--if category is requested, validate it as an integer, otherwise set to 1
    if( isset($_GET['category']) ){
      $this -> category = ( filter_var($_GET['category'],FILTER_VALIDATE_INT) )? $_GET['category'] : 1;
    }
    //--if page number is requested, validate it as an integer, otherwise set to 1
    if( isset($_GET['page']) ){
      $this -> page = ( filter_var($_GET['page'],FILTER_VALIDATE_INT) ) ? $_GET['page'] : 1;
    }
    else{
      $this -> page = 1;
    }
    //if perpage is requested, check if it is an integer (has to be between 8 and 36)
    //if not set, set it to 8
    if( isset($_GET['perpage']) ){
      //check if it is an integer
      if( filter_var($_GET['perpage'],FILTER_VALIDATE_INT) ){
        //if integer make sure it is between 8 and 36, if not, set to 8
        $this -> perpage = ( $_GET['perpage'] >= 8 && $_GET['perpage'] <= 36 )? $_GET['perpage'] : 8;
      }
    }
    else{
      //if perpage is not requested, set it to 8
      $this -> perpage = 8;
    }
    
  }
  public function getProducts(){
    if( isset( $this->category ) ){
      return $this -> getProductsInCategory();
    }
    else{
      $query = "SELECT 
      @pid := product_id AS product_id,
      name,
      description,
      price,
      bathroom,
      bedroom,
      parking,
      bond,
      date_availaible,
      @image_id := ( SELECT image_id FROM product_image WHERE product_id = @pid LIMIT 1 ) AS image_id,
      ( SELECT image_file_name FROM image WHERE image_id = @image_id ) AS image_file_name
      FROM product 
      WHERE active=1";
      
      //get the total number of products, before query has limit and offset applied
      $this -> products['total'] = $this -> getProductTotal( $query );
      
      //set the page variable and apply the limit and offset
      $this -> products['page'] = $this -> page;
      $query = $query . ' ' . 'LIMIT ? OFFSET ?';
      
      $this -> products['perpage'] = $this -> perpage;
      $totalpages = ceil( $this -> products['total'] / $this -> perpage );
      $this -> products['totalpages'] = $totalpages;
      
      $statement = $this -> connection -> prepare( $query );
      $offset = ( $this -> page - 1 ) * $this -> perpage;
      $statement -> bind_param('ii', $this -> perpage, $offset );
        
      $statement -> execute();
      $result = $statement -> get_result();
      if( $result -> num_rows > 0 ){
        $products_result = array();
        while( $row = $result -> fetch_assoc() ){
          array_push( $products_result, $row );
        }
        $this -> products['items'] = $products_result;
      }
      return $this -> products;
    }
  }
  
  protected function getProductsInCategory(){
    //different query for getting product in category
    $query = "SELECT 
    @pid := product.product_id AS product_id,
    name,
    description,
    price,
    @image_id := ( SELECT image_id FROM product_image WHERE product_id = @pid LIMIT 1 ) AS image_id,
	  product_category.category_id AS category_id,
    ( SELECT image_file_name FROM image WHERE image_id = @image_id ) AS image_file_name
    FROM product
	  INNER JOIN product_category
	  ON product_category.product_id = product.product_id
    WHERE product_category.category_id = ? AND product.active=1";
    
    //run the total query before limit and offset are applied
    $this -> products['total'] = $this -> getProductTotal( $query );
    
    //set page variable (the current page number)
    $page = $this -> page;
    //add limit and offset for pagination
    $query = $query . ' ' . 'LIMIT ? OFFSET ?';
    //set the number of products to show per page
    $perpage = $this -> perpage;
    //calculate the number of pages based on totalproducts/perpage
    $totalpages = ceil( $this -> products['total'] / $perpage );
    //set the current variables in the final array
    $this -> products['perpage'] = $perpage;
    $this -> products['totalpages'] = $totalpages;
    $this -> products['page'] = $this -> page;
    //prepare the query
    $statement = $this -> connection -> prepare( $query );
    //set database offset as (current page -1) * perpage
    $offset = ( $page - 1 ) * $perpage;
    //bind category, perpage and offset to query
    $statement -> bind_param('iii', $this-> category, $perpage, $offset );
    try{
      if( $statement -> execute() == false ){
        throw new Exception('query error');
      }
      else{
        $result = $statement -> get_result();
        if( $result -> num_rows > 0 ){
          $products_result = array();
          while( $row = $result -> fetch_assoc() ){
            array_push( $products_result , $row );
          }
        }
        $this -> products['items'] = $products_result;
        return $this -> products;
      }
    }
    catch( Exception $exc ){
      error_log( $exc -> getMessage() );
    }
  }
  
  protected function getProductTotal($query){
    //return the total number of products
    //call this function before applying pagination
    $statement = $this -> connection -> prepare($query);
    //check if category is set
    if( isset($this -> category ) ){
      //apply category parameter to query
      $statement -> bind_param('i', $this->category );
    }
    try{
      if( $statement -> execute() ){
        $result = $statement -> get_result();
        //return the total number of products
        return $result -> num_rows;
      }
      else{
        throw new Exception('query error');
      }
    }
    catch( Exception $exc ){
      error_log( $exc -> getMessage() );
    }
  }
}
?>