<?php
session_start();
//signout by unsetting session variables that were set during signup and signin
if( isset($_SESSION['account_id']) ){
  unset( $_SESSION['account_id'] );
}
if( isset($_SESSION['username']) ){
  unset( $_SESSION['username'] );
}
if( isset($_SESSION['email']) ){
  unset( $_SESSION['email'] );
}
$origin = $_SERVER['HTTP_REFERER'];
header("location:/");
?>