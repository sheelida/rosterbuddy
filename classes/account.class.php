<?php 
class Account extends Database{
    public $errors = array();
    public function __construct(){
        parent::__construct();
        
    
    }
    public function create($fname, $lname, $email, $password){
        //create array to store errors
        $errors = array();
        
        //validade names
       // if(filter_var($fname,$lname,Validator::name))
        //validate email
        if(filter_var($email,FILTER_VALIDATE_EMAIL)== false){
            $errors['email']='Invalid email address!';
        }
        //check password length
        if(strlen($password)<6){
            $errors['password'] = 'Minimum 6 characters!';
            
        }
        //check if there are no errors
        if(count($errors)==0){
            //proceed and create account
            $query = "INSERT INTO Account(fname, lname, email, password, role_id)
            VALUES
            (?,?,?,?,3)";
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $statement = $this -> connection -> prepare($query);
            $statement -> bind_param('ssss', $fname, $lname, $email, $hash);
            $success = $statement -> execute() ? true : false;
            //check the error code 
            if ($success == false && $this -> connection -> errno == '1062'){
                $errors['email'] = 'Email address already used!';
                $this -> errors = $errors;
            }
            
            return $success;
        }
        else {
            $this -> errors = $errors;
            return false;
            
        }

        }
        
        public function GetAllEmployees(){
            $employees = array();
            $query = "SELECT * FROM Account WHERE role_id = 3";
            $statement = $this -> connection -> prepare($query);
            try{
                $success = $statement -> execute();
                  if($success == false ){
                    throw new Exception('Query failed');
                  }
                  else{
                    $result = $statement -> get_result();
                    if( $result -> num_rows == 0 ){
                      throw new Exception('No messages founded!');
                      return $employees;
                    }
                    else{
                    
                        while( $row = $result -> fetch_assoc() ){
                            array_push($employees, $row );  
                          }
                      return $employees;
                    }
                  }
    }catch( Exception $exc ){
      $this -> errors['query'] = $exc -> getMessage();
    }
            
        }
        public function authenticate($email, $password){
            $query = 'SELECT acc_id, email, password
            from Account 
            WHERE email = ?';
            $statement = $this -> connection -> prepare($query);
            $statement -> bind_param('s', $email);
            $statement -> execute();
            $result = $statement -> get_result();
            if($result -> num_rows == 0){
                //account does not exist
                return false;
                
            }
            else {
                $account = $result -> fetch_assoc();
                $acc_id = $account['acc_id'];
                $email = $account['email'];
                $hash = $account['password'];
                $match = password_verify($password, $hash);
                if($match == true){
                    //pasword is correct 
                    return true;
                    
                }
                else{
                    //wrong password
                    return false;
                }
            }
                   
        }
    }
?>