<?php
namespace aitsyd;

//class to get and update user account
class AccountDetail extends Account{
  private $accountId;
  private $updatePassword = false;
  
  public function __construct($accountId){
    parent::__construct();
    $this -> accountId = $accountId;
  }
  public function getDetails(){
    $query = "SELECT username,email FROM account WHERE account_id = ?";
    $statement = $this -> connection -> prepare($query);
    $statement -> bind_param('i', $this -> accountId );
    try{
      if( $statement -> execute() == false ){
        throw new Exception('query error');
        return null;
      }
      else{
        $result = $statement -> get_result();
        if( $result -> num_rows > 0 ){
          $account = $result -> fetch_assoc();
          return $account;
        }
        else{
          return null;
        }
      }
    }
    catch( Exception $exc ){
      error_log( $exc -> getMessage() );
    }
  }
  public function update( $username, $email, $password1, $password2 ){
    //validate username and email
    //array to store errors
    
    $errors = array();
    //array to send as response
    $response = array();
    
    $validusername = Validator::username($username);
    if( $validusername['success'] == false ){
      $errors['username'] = $validusername['errors'];
      print_r("fkfkfkfkfkfk1");
    }
    $validemail = Validator::email($email);
    if( $validemail['success'] == false ){
      $errors['email'] = $validemail['errors'];
      print_r("fkfkfkfkfkfk2");
    }
    //check if user is updating password (if both passwords have value / not null )
    if( isset($password1) || isset($password2) ){
      $validpassword = Validator::twoPasswords($password1,$password2);
      //if password does not pass validation
      if( $validpassword['success'] == false ){
       
        $errors = $validpassword['errors'];
      }
      else{
        //set flag to update password
        $this -> updatePassword = true;
      }
    }
    //check if there are errors in validation
    if( count($errors) > 0 ){
      
      $response['success'] = false;
      $response['errors'] = $errors;
      
    }
    else{
      //update user's details in the database
     
        
        $hash = password_hash($password1,PASSWORD_DEFAULT);
        $this -> updateDetails($username,$email,$hash);
       
     
    
    }
    return $response;
    
  }
  protected function updateDetails($username,$email,$password1){
    //print_r($_SESSION['accound_id']);
    $query = 'UPDATE account SET username =? ,email=?,password=? WHERE account_id = ?';
    $statement = $this ->connection ->prepare($query);
    $statement -> bind_param('sssi',$username,$email,$password1,$this->accountId);
    if($statement -> execute())
    {
       echo "<script>alert('yea bro, succeed')</script>";
    }
    else{
      echo "<script>alert('Oh nooooo.. Something wrong')</script>";
    }
  }
  protected function updatePassword($accountId){}
}
?>