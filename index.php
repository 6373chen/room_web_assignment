<?php
include('vendor/autoload.php');
//start session
session_start();

//generate navigation
include('includes/navigation.inc.php');

//generate products
use aitsyd\Product;

$product_class = new Product();
$products = $product_class -> getProducts();
$page_title = 'Shop Page';

//generate categories
use aitsyd\Categories;
$category_class = new Categories();
$categories = $category_class -> getCategories();

//generate paginators after products have been created
use aitsyd\Pagination;
$paginators = Pagination::create($products['totalpages']);

$loader = new Twig_Loader_Filesystem('templates');
$twig = new Twig_Environment($loader, array(
  //'cache' => 'cache'
  ));

$template = $twig -> load('home.twig');

echo $template -> render( array(
      'pages' => $pages,
      'products' => $products, 
      'pagetitle' => $page_title,
      'currentPage' => $currentPage,
      'categories' => $categories,
      'paginators' => $paginators,
      'user' => $user
      )
    );

?>
