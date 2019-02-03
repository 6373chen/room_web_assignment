<?php
include('vendor/autoload.php');

//generate navigation
include('includes/navigation.inc.php');

//generate product
use aitsyd\ProductDetail;


$detail_class = new ProductDetail();
$product = $detail_class -> getProductById();

//set page_title to be capitalised
$page_title = ucwords($product['name']);

$loader = new Twig_Loader_Filesystem('templates');
$twig = new Twig_Environment($loader, array(
    //'cache' => 'cache'
));

$template = $twig -> load('detail.twig');

echo $template -> render( 
        array(
            'product' => $product, 
            'pagetitle' => $page_title,
            'pages' => $pages,
            'currentPage' => $currentPage
        )
    );

?>
