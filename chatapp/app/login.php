<?php
  //good resource?? https://supunkavinda.blog/php/prepared-statements
  //connect to the database 
  require_once('../_includes/connect.php');

  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
  //define table
  $tbl = "marmalade_users";//change table name as required
  
  //get posted data
  $email = isset($_REQUEST['email']) ? $_REQUEST['email'] : 'not_set';
  $loginPassword = isset($_REQUEST['userpassword']) ? $_REQUEST['userpassword'] : 'not_set';


  //write query
  $query = "SELECT $tbl.userID, $tbl.fullName, $tbl.userName, $tbl.userPassword, $tbl.email, $tbl.colour FROM $tbl WHERE $tbl.email=?";
  //prepare statement, execute, store_result
  if($displayStmt = $mysqli->prepare($query)){
    $displayStmt->bind_param("s", $email);
    $displayStmt->execute();
    $displayStmt->store_result();
    $numResults = $displayStmt->num_rows;
  }
  //bind results
  $displayStmt->bind_result($userID, $fullName, $userName, $userPassword, $email, $colour);


  //create an array for the results
  $userArray = [];
 
  //fetch results
  while($displayStmt->fetch()){
    if(password_verify($loginPassword, $userPassword)){
      //create array for json
      $userArray[] = [
        "message"=>"login successful",
        "userID"=>$userID, 
        "fullName"=>$fullName, 
        "userName"=>$userName,
        "userPassword"=>$userPassword, 
        "email"=>$email, 
        "colour"=>$colour];
    }else{
      $userArray[] = [
        "message"=>"login failed"];
    }
    

  }
  //encode the array in json format
  echo( json_encode($userArray));

 

?>