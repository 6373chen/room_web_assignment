<?php
include('vendor/autoload.php');

//start session
session_start();

//if user is not logged in, redirect to login

//generate navigation
include('includes/navigation.inc.php');
if( isset($_SESSION['account_id']) == false ){
  header("location: signin.php");
  exit();
}



$page_title = "Account details";

//get account details
use aitsyd\AccountDetail;
$account_id = $_SESSION['account_id'];
$account = new AccountDetail( $account_id );
$user_account = $account -> getDetails();
if( $_SERVER['REQUEST_METHOD'] == 'POST'){
    //handle POST varibles
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password1 = $_POST['password1'];
    $password2= $_POST['password2'];
    
    // create instance of account class
    //$accountdetail = new AccountDetail($_SESSION['account_id']);
    $update = $account -> update($username,$email,$password1,$password2);
   // print_r($signup);
   
}
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
