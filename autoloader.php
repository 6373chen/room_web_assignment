<?php
function loadClass( $classname ){
  $classdir = 'classes';
  //define root of website
  $root = __DIR__;
  //construct path to class file
  $classfile = strtolower($classname) . '.class.php';
  include_once( $root . '/' . $classdir . '/' . $classfile);
}

spl_autoload_register('loadClass');
?>