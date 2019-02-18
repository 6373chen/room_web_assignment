<?php
include('vendor/autoload.php');

use aitsyd\ProductDetail;
use aitsyd\Categories;
$page_title = 'post a room';

session_start();
$category_class = new Categories();
$categories = $category_class -> getCategories();

if( $_SERVER['REQUEST_METHOD'] == 'POST' ){
  $title = $_POST['title'];
  $description = $_POST['description'];
  $price = $_POST['price'];
  $bathroom = $_POST['bathroom'];
  $parking = $_POST['parking'];
  $bond = $_POST['bond'];
  $bedroom = $_POST['bedroom'];
  $date = $_POST['date'];
  $category_id = $_POST['categories'];
  print_r($categories);
  
  
  
    
    $file = $_FILES['image'];
    //print_r($file);
    $fileName = $_FILES['image']['name'];
    $fileTmpName = $_FILES['image']['tmp_name'];
    $fileError = $_FILES['image']['error'];
    $fileType = $_FILES['image']['type'];
    $fileSize = $_FILES['image']['size'];
    $fileExt = explode('.',$fileName);
    $fileActualExt = strtolower(end($fileExt));
    
    $allowed = array('jpg','jpeg','png','pdf');
    
    if(in_array($fileActualExt,$allowed)){
      if($fileError === 0){
        if($fileSize < 5000000 ){
          $fileNameNew = uniqid('',true).".".$fileActualExt;
          
          $fileDestination = '/home/ubuntu/workspace/images/products/products/'.$fileNameNew;
          
          move_uploaded_file($fileTmpName,$fileDestination);
          echo "<script>alert('yea bro, succeed')</script>";
          $product_detail = new ProductDetail();
          $upload_product = $product_detail -> uploadProduct($title,$description,$price,$bathroom,$bedroom,$bond,$date,$parking);
          $upload_image = $product_detail -> uploadImage($fileNameNew);
          $upload_product_image = $product_detail -> uploadProduct_image($upload_product,$upload_image);
          //$upload_prodcut_category = $product_detail -> uploadProduct_category($upload_product,$category_id);
          
        }else{
          echo "<script>alert('Your file is too big')</script>";
        }
      }else{
        //echo "There was an error unploading your file";
        echo "<script>alert('There was an error unploading your file')</script>";
      }
      
    }else{
      //echo "Wrong type of file".$fileActualExt;
      echo "<script>alert('Wrong type of file')</script>";
    }
  
  
}
include('includes/navigation.inc.php');

$loader = new Twig_Loader_Filesystem('templates');
$twig = new Twig_Environment($loader, array(
  //'cache' => 'cache'
  ));
$template = $twig -> load('post_room.twig');

echo $template -> render( 
        array(
            
            'pagetitle' => $page_title,
            'pages' => $pages,
            'currentPage' => $currentPage,
            'categories' => $categories,
        )
    );

?>