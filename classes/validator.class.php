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
?>