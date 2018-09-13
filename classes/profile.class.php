<?php

class Profile extends Account{
  private $email;
  public $errors = array();
  public function __construct(){
    parent::__construct();
  }
  
  
  public function getData($email){
    //get account data by its id
    $query = 'SELECT 
    acc_id,
    fname, 
    lname,
    email
    FROM Account
    WHERE email = ?';
    $statement = $this -> connection -> prepare($query);
    $statement -> bind_param('s', $email );
    try{
      if( $statement -> execute() == false ){
        throw new Exception('Query failed');
      }
      else{
        $result = $statement -> get_result();
        if( $result -> num_rows == 0 ){
          throw new Exception('No account founded!');
        }
        else{
          $row = $result -> fetch_assoc();
          return $row;
        }
      }
    }
    catch( Exception $exc ){
      $this -> errors['query'] = $exc -> getMessage();
    }
    
  }
  
  public function UpdateProfile( $fname, $lname , $email, $passwords){
      //if there are no errors
      if( count($this -> errors) == 0 ){
        //update user data with password
        $query = 'UPDATE Account SET fname=?, lname=?, password=? WHERE email=?';
        $statement = $this -> connection -> prepare( $query );
        //hash password
        $hash = password_hash( $passwords, PASSWORD_DEFAULT ); 
        //bind the parameters
        $statement -> bind_param('ssss', $fname, $lname, $hash, $email );
        return ( $statement -> execute() ) ? true : false;
      }
    else{
      //user is not updating password so only update other values
      
      if( count($this -> errors) == 0 ){
        //update user data with password
        $query = 'UPDATE Account SET fname=?, lname=? WHERE email=?';
        $statement = $this -> connection -> prepare( $query );
        //bind the parameters
        $statement -> bind_param('sss', $fname, $lname, $email);
        return ( $statement -> execute() ) ? true : false;
      }
    }
  }
  
}
?>