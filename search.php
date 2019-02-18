<?php
session_start();

include('vendor/autoload.php');
include('includes/navigation.inc.php');
use aitsyd\ProductSearch;

//search keyword
if( isset($_GET['search']) ){
  $keyword = $_GET['search'];
  $search = new ProductSearch();
  $search_result = $search -> search( $keyword );
}

$page_title = "Search Result for $keyword";

$loader = new Twig_Loader_Filesystem('templates');
$twig = new Twig_Environment($loader, array(
  //'cache' => 'cache'
  ));

$template = $twig -> load('search.twig');

echo $template -> render( array(
      'pages' => $pages,
      'search' => $search_result, 
      'pagetitle' => $page_title,
      'currentPage' => $currentPage,
      'user' => $user
      )
    );
?>