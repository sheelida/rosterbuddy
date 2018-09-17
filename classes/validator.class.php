<?php
//simple validator to validate username, email and password
class Validator{
  public static $errors = array();
  public static function name($name){
    //check for length / max 16
    $len = strlen($name);
    if( $len > 20 ){
      self::$errors['length'] = 'Sorry, name cannot be longer than 20 characters';
    }
    //check if shorter than 6 characters
    if( $len < 3 ){
      self::$errors['length'] = 'Sorry, name cannot be shorter than 3 characters';
    }
    //check for tags
    if( strlen(strip_tags($name)) !== $len ){
      self::$errors['tags'] = 'Sorry, name cannot contain tags';
    }
    //check for spaces
    if( strlen( str_replace(" ","",$name) ) !== $len  ){
      self::$errors['spaces'] = 'Sorry, name cannot contain spaces';
    }
    return count(self::$errors) == 0 ? true : false;
  }
public static function password($pwd){
    $len = strlen($pwd);
    //---password must me 8 characters or longer
    if( $len < 6 ){
      self::$errors['length'] = 'Password must be 6 characters or longer!';
    }
    //---password must contain special characters
    if( ctype_alnum($pwd) ){
      self::$errors['characters'] = 'Password must contain special characters!';
    }
    //----password must contain a number and uppercase character
    //split each character into array
    $chrs = str_split($pwd);
    //set to true when a number is found
    $is_num = false;
    //set to true when uppercase character is found
    $is_upper = false;
    //loop through characters to see if there is a number
    foreach($chrs as $char ){
      if(ctype_digit($char)){
        $is_num = true;
      }
      if(ctype_upper($char)){
        $is_upper = true;
      }
    }
    if( $is_num == false ){
      self::$errors['number'] = 'Password must contain a number!';
    }
    if( $is_upper == false ){
      self::$errors['uppercase'] = 'Password must contain an uppercase character!';
    }
    
    return count(self::$errors) == 0 ? true : false;
  }
}
?>