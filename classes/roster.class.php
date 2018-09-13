<?php

class Roster extends Account{
  private $acc_id;
  public $errors = array();
  public function __construct(){
    parent::__construct();
  }
  
public function GetAccIdbySession($email){
    $query = "SELECT acc_id 
                FROM Account
                WHERE email = ?";
                    
    $statement = $this -> connection -> prepare($query);
    $statement -> bind_param('s', $email);
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
              $acc_id = $row['acc_id'];
              return $acc_id;
            }
          }
    }catch( Exception $exc ){
      $this -> errors['query'] = $exc -> getMessage();
    }
}

public function GetShiftById($acc_id){
  
    $shift_details = array();
    $query = "SELECT s.shift_id, s.location,s.job_position,s.description,date(s.start_time) as start_date, date(s.end_time)as end_date,time(s.start_time)as start_time, time(s.end_time) as end_time,s.shift_status, s.assigned_by 
              FROM Shift s
              JOIN Shift_event e on e.shift_id = s.shift_id
              WHERE e.acc_id= ?
              ORDER BY start_date asc";
        
    $statement = $this -> connection -> prepare($query);
    $statement -> bind_param('i', $acc_id);
    try{
        $success = $statement -> execute();
          if($success == false ){
            throw new Exception('Query failed');
          }
          else{
            $result = $statement -> get_result();
            if( $result -> num_rows == 0 ){
              throw new Exception('No shift founded!');
              return $shift_details;
            }
            else{
            
                while( $row = $result -> fetch_assoc() ){
                    array_push($shift_details, $row );  
                  }
              return $shift_details;
            }
          }
    }catch( Exception $exc ){
      $this -> errors['query'] = $exc -> getMessage();
    }
}
public function GetMessageById($acc_id){
    $message_details = array();
    
    $query = "SELECT distinct m.message_id, m.message_desc, m.message_date, m.recipient_id, a.fname receiver, b.fname
              FROM Message m
              JOIN Account a on (a.acc_id = m.recipient_id)
			        JOIN Account b on b.acc_id = m.sender_id
              WHERE m.recipient_id = ?
              ORDER BY message_date DESC";
              
    $statement = $this -> connection -> prepare($query);
    $statement -> bind_param('i', $acc_id);
    
    try{
        $success = $statement -> execute();
          if($success == false ){
            throw new Exception('Query failed');
          }
          else{
            $result = $statement -> get_result();
            if( $result -> num_rows == 0 ){
              throw new Exception('No messages founded!');
              return $message_details;
            }
            else{
            
                while( $row = $result -> fetch_assoc() ){
                    array_push($message_details, $row );  
                  }
              return $message_details;
            }
          }
    }catch( Exception $exc ){
      $this -> errors['query'] = $exc -> getMessage();
    }
}

}
?>


