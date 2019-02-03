<?php
namespace aitsyd;

class Page{
  public $props = array();
  private $title = 'untitled';
  public function __construct($title){
    $this -> title = filter_var( $title, FILTER_SANITIZE_STRING);
  }
  public function getName(){
    $name = basename( $_SERVER['PHP_SELF'] );
    //if url is empty it must be at root eg home page
    if( $name == '' ){ $url = 'index.php'; }
    return $name;
  }
  private function getInfo(){
    return $this -> props;
  }
}
?>
