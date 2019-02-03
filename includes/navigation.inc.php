<?php
use aitsyd\Navigation;
use aitsyd\Page;

$nav = new Navigation();
$pages = $nav -> pages;

$currentPage = Page::getName();

if( isset($_SESSION['email']) ){
  $user = array();
  $user['email'] = $_SESSION['email'];
  $user['username'] = $_SESSION['username'];
  $user['account_id'] = $_SESSION['account_id'];
}
else{
  $user = null;
}

?>