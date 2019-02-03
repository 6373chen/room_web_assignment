<?php
namespace aitsyd;

class TokenString{
  //generates a random string (alphanumeric) of a specified length
  public static function generate($length){
    //divide by 2 since length will be read as byte
    $length = $length/2;
    if( function_exists('random_bytes') ){
      $random_string = bin2hex( random_bytes($length) );
    }
    else{
      $random_string = bin2hex( openssl_random_pseudo_bytes($length) );
    }
    return $random_string;
  }
}
?>