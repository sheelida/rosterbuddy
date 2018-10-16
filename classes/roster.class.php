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
    $query = "SELECT s.shift_id, s.location,s.job_position,s.description,date(s.start_time) as start_date, date(s.end_time)as end_date,time(s.start_time)as start_time, time(s.end_time) as end_time,s.shift_status, a.fname, a.lname
              FROM Shift s
              JOIN Shift_event e on e.shift_id = s.shift_id
			        JOIN Account a on s.assigned_by = a.acc_id
              WHERE e.acc_id= ? and s.shift_status != 'cancelled'
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
    
    $query = "SELECT distinct m.message_id, m.message_desc, m.message_date, m.recipient_id, a.fname receiver, b.fname as sender_name
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

public function GetShiftsAssignedBy($acc_id){
  $shifts = array();
  $query = "SELECT s.shift_id, s.location, s.job_position, s.description, s.start_time, s.end_time, s.shift_status, a.fname, a.lname, e.acc_id AS assign_to, b.fname AS assignto_fname, b.lname AS assignto_lname
    FROM Shift s
    JOIN Account a ON s.assigned_by = a.acc_id
    JOIN Shift_event e ON s.shift_id = e.shift_id
    JOIN Account b ON e.acc_id = b.acc_id
    WHERE s.assigned_by = ? AND s.start_time > CURDATE( ) 
    ORDER BY s.start_time ASC";

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
              return $shifts;
            }
            else{
            
                while( $row = $result -> fetch_assoc() ){
                    array_push($shifts, $row );  
                  }
              return $shifts;
            }
          }
    }catch( Exception $exc ){
      $this -> errors['query'] = $exc -> getMessage();
    }
}


public function GetAllShifts($acc_id){
  $shifts = array();
  $query = "SELECT s.shift_id, s.job_position, s.start_time, s.end_time, s.shift_status, s.description, s.location, a.fname,a.lname
            FROM Shift s 
            JOIN Account a ON s.assigned_by = a.acc_id
            WHERE assigned_by = ? AND s.start_time > CURDATE( ) 
          ORDER BY start_time ASC  ";

//
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
              return $shifts;
            }
            else{
            
                while( $row = $result -> fetch_assoc() ){
                    array_push($shifts, $row );  
                  }
              return $shifts;
            }
          }
    }catch( Exception $exc ){
      $this -> errors['query'] = $exc -> getMessage();
    }
}
public function GetShiftByShiftId($shift_id){
  $query = "Select * from Shift 
            WHERE Shift_id= ?";
    $statement = $this -> connection -> prepare($query);
    $statement -> bind_param('i', $shift_id);
    try{
          if( $statement -> execute() == false ){
            throw new Exception('Query failed');
          }
          else{
            $result = $statement -> get_result();
            if( $result -> num_rows == 0 ){
              throw new Exception('No shift founded!');
            }
            else{
              $row = $result -> fetch_assoc();
              return $row;
            }
          }
    }catch( Exception $exc ){
      $this -> errors['query'] = $exc -> getMessage();
    }
}

public function AssignShift($acc_id,$shift_id){
  
    $query = "INSERT INTO Shift_event(acc_id, shift_id) VALUES(?, ?)";
    $statement = $this -> connection -> prepare($query);
    $statement -> bind_param('ii', $acc_id, $shift_id);
    
    return ( $statement -> execute() ) ? true : false;

}
public function UpdateRoster($location, $job_position, $description, $start_time, $end_time, $shift_status, $shift_id, $newacc_id, $oldacc_id){
        //update roster data 
        $query = 'UPDATE Shift SET location=?, job_position=?, description=?, start_time=?, end_time=?, shift_status=?
        WHERE shift_id=?';

        $statement = $this -> connection -> prepare( $query );
        //bind the parameters
        $statement -> bind_param('ssssssi', $location, $job_position, $description, $start_time, $end_time, $shift_status, $shift_id);
        
        $success =  $statement -> execute();
        
        //update shift_event data 
        $querys = 'UPDATE Shift_event SET acc_id=? WHERE shift_id=? AND acc_id=?';

        $statements = $this -> connection -> prepare( $querys );
        //bind the parameters
        $statements -> bind_param('iii', $newacc_id, $shift_id, $oldacc_id);
        
        $success =  $statements -> execute();
        
        return ($success) ? true : false;
}
public function InsertNewShift($location, $job_position, $description, $start_time, $end_time, $shift_status, $acc_id){
        //update roster data 
        $query = 'INSERT INTO Shift(location, job_position, description, start_time, end_time, shift_status, assigned_by) VALUES (?,?,?,?,?,?,?)';
        $statement = $this -> connection -> prepare( $query );
        //bind the parameters
        $statement -> bind_param('ssssssi', $location, $job_position, $description, $start_time, $end_time, $shift_status, $acc_id);
        
        return ( $statement -> execute() ) ? true : false;
}
public function InsertNewMessage($message_desc, $recipient_id, $sender_id){
         //update roster data 
        $query = 'INSERT INTO Message(message_desc, message_date, recipient_id, sender_id) VALUES (?,CURRENT_TIMESTAMP(),?,?)';
        $statement = $this -> connection -> prepare( $query );
        //bind the parameters
        $statement -> bind_param('sii', $message_desc, $recipient_id, $sender_id);
        
        return ( $statement -> execute() ) ? true : false;
}

}
?>


