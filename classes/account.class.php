<?php 
class Account extends Database{
    public $errors = array();
    public function __construct(){
        parent::__construct();
        
        
    }
    public function create($email, $password){
        //create array to store errors
        $errors = array();
        
        //validate email
        if(filter_var($email,FILTER_VALIDATE_EMAIL)== false){
            $errors['email']='invalid email address';
        }
        //check password length
        if(strlen($password)<6){
            $errors['password'] = 'minimum 6 characters';
            
        }
        //check if there are no errors
        if(count($errors)==0){
            //proceed and create account
            $query = "INSERT INTO account (fname, lname, email, password, role_id)
            VALUES
            (?,?,?,?,?)";
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $statement = $this -> connection -> prepare($query);
            $statement -> bind_param('ssssi', $fname, $lname,$email, $hash, $roleid);
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
        
        
        public function authenticate($email, $password){
            $query = 'SELECT email, password
            from account 
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