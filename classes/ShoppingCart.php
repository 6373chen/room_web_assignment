<?php
namespace aitsyd;
use aitsyd\TokenString;
use aitsyd\SessionManager;
//shopping cart extends database so it has access to database connection
class ShoppingCart extends Database{
  private $cart_id;
  private $session_id;
  //check if user already has a cart
  public function __construct(){
    parent::__construct();
    //initialise session
    SessionManager::initSession();
    //get the session_id
    $this -> session_id = SessionManager::getId();
  }
  private function getUserCart(){
    
  }
  private function createUserCart(){
    
  }
}
?>