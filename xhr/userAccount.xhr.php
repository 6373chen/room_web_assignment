<?php
if( $_SERVER['REQUEST_METHOD'] == 'POST' ){
  $test = array('fruit' => 'apple', 'drink' => 'tequilla');
  echo json_encode($test);
}
?>