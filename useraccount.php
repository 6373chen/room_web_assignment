<?php
include('vendor/autoload.php');
//start session
session_start();

//if user is not logged in, redirect to login
if( isset($_SESSION['account_id']) == false ){
  header("location: signin.php");
  exit();
}

//generate navigation
include('includes/navigation.inc.php');

$page_title = "Account details";

//get account details
use aitsyd\AccountDetail;
$account_id = $_SESSION['account_id'];
$account = new AccountDetail( $account_id );
$user_account = $account -> getDetails();

$loader = new Twig_Loader_Filesystem('templates');
$twig = new Twig_Environment($loader, array(
  //'cache' => 'cache'
  ));

$template = $twig -> load('useraccount.twig');

echo $template -> render( array(
      'pages' => $pages,
      'pagetitle' => $page_title,
      'currentPage' => $currentPage,
      'account' => $user_account,
      'user' => $user
      )
    );

?>
