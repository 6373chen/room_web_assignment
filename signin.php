<?php
include('vendor/autoload.php');

use aitsyd\Account;
$page_title = 'Sign In';
//start session
session_start();

//handle POST request
if( $_SERVER['REQUEST_METHOD'] == 'POST' ){
  //handle POST variables
  $username = $_POST['user'];
  $password = $_POST['password'];
  
  //create instance of account class
  $account = new Account();
  $signin = $account -> signIn( $username, $password );
  if( $signin['success'] == true ){
    $_SESSION['email'] = $signin['email'];
    $_SESSION['username'] = $signin['username'];
    $_SESSION['account_id'] = $signin['account_id'];
    //redirect user to home page
    header("location:/");
  }
}

//generate navigation
include('includes/navigation.inc.php');

$loader = new Twig_Loader_Filesystem('templates');
$twig = new Twig_Environment($loader, array(
  //'cache' => 'cache'
));

$template = $twig -> load('signin.twig');

echo $template -> render( array(
      'pages' => $pages,
      'pagetitle' => $page_title,
      'currentPage' => $currentPage,
      'user' => $user,
      'response' => $signin
      )
    );
?>