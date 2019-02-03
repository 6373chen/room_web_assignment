<?php
namespace aitsyd;
class Pagination{
  public static function create($totalPages){
    //array of numbers to create pagination
    $paginator = array();
    $counter = 0;
    $pagers = array();
    //check the page variable in the GET request and validate it as an integer
    if( isset($_GET['page']) && filter_var($_GET['page'], FILTER_VALIDATE_INT) ){
      $currentPage = $_GET['page'];
    }
    //if not an integer set current page to 1
    else{
      $currentPage = 1;
    }
    //generate the number for pages in the paginator up to the last page
    while( $counter < $totalPages ){
      $counter++;
      $pageLink = self::concatGetVars( $counter );
      $page = array('number' => $counter, 'link' => '?' . $pageLink );
      array_push( $pagers , $page );
    }
    $paginators['pagers'] = $pagers;
    $paginators['active'] = $currentPage;
    $prevPage = $paginators['active']- 1;
    $paginators['previous'] = ( $prevPage > 0 )? '?' . self::concatGetVars( $prevPage ) : 0;
    // $paginators['previous']['page'] = ( $prevPage > 0 ) ? $prevPage : '';
    $nextPage = $paginators['active'] + 1;
    $paginators['next'] = ( $nextPage <= $totalPages ) ? '?' . self::concatGetVars( $nextPage ) : '';
    $paginators['total'] = $totalPages;
    return $paginators;
  }
  //create a link for each paginator to add each GET variable eg page=1&category=2, etc
  public static function concatGetVars( $pagenum ){
    // if( count( $_GET ) > 0 ){
      $varstring = array();
      foreach( $_GET as $key => $value ){
        //add GET variables, but not page to the array (to prevent double)
        if( $key !== 'page'){
          $str = "$key=$value";
          array_push( $varstring, $str );
        }
      }
      //add page variable
      array_push($varstring, 'page='.$pagenum );
      //return as array as a string separated by & like 'page=1&category=2'
      return implode('&',$varstring);
    // }
  }
}
?>