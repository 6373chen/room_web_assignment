<?php
namespace aitsyd;

class Categories extends Database{
  public function __construct(){
    parent::__construct();
  }
  public function getCategories(){
    $query = "SELECT category_id,category_name
    FROM category
    WHERE active = 1";
    $statement = $this -> connection -> prepare( $query );
    $statement -> execute();
    $result = $statement -> get_result();
    if( $result -> num_rows > 0 ){
      $items = array();
      while( $row = $result -> fetch_assoc() ){
        $category = array('id' => $row['category_id'],'name' => $row['category_name']);
        array_push( $items , $category );
      }
      $this -> categories['items'] = $items;
      $this -> categories['active'] = $this -> getActive();
      return $this -> categories;
    }
    else{
      return null;
    }
  }
  public function getActive(){
    //if category validates as an integer
    if( isset($_GET['category']) 
      && filter_var($_GET['category'],FILTER_VALIDATE_INT) )
    {
      $category = $_GET['category'];
    }
    else{
      $category = '';
    }
    return $category;
  }
}
?>