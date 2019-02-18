<?php
include('vendor/autoload.php');

use aitsyd\Account;
$page_title = 'sign up';

session_start();
if( $_SERVER['REQUEST_METHOD'] == 'POST'){
    //handle POST varibles
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    // create instance of account class
    $account = new Account();
    $signup = $account -> signup($username,$email,$password);
    if($signup['success']){
       echo "<script>alert('yea bro, succeed')</script>";
       header("location:/signin.php");
    }
    else{
        // print_r($signup);
    }
   // print_r($signup);
   
}
include('includes/navigation.inc.php');

$loader = new Twig_Loader_Filesystem('templates');
$twig = new Twig_Environment($loader, array(
  //'cache' => 'cache'
  ));
$template = $twig -> load('signup.twig');

echo $template -> render( 
        array(
            
            'pagetitle' => $page_title,
            'pages' => $pages,
            'currentPage' => $currentPage,
            'response' => $signup
        )
    );

?>