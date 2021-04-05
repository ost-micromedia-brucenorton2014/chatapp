<?php
  //connect to the database 
  require_once('../_includes/connect.php');

  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
  //define table
  $tbl = "marmalade_messages";//change table name as required

  //get posted data
  $fromUser = isset($_REQUEST['fromuser']) ? $_REQUEST['fromuser'] : 'not_set';
  $toUser = isset($_REQUEST['touser']) ? $_REQUEST['touser'] : 'not_set';


  //write query
  $query = "SELECT $tbl.messageID, $tbl.fromUser, $tbl.toUser, $tbl.message FROM $tbl WHERE $tbl.fromUser = ? AND $tbl.toUser = ?";
  //prepare statement, execute, store_result
  if($displayStmt = $mysqli->prepare($query)){
    $displayStmt->bind_param("ii", $fromUser, $toUser);
    $displayStmt->execute();
    $displayStmt->store_result();
    $numResults = $displayStmt->num_rows;
  }
  //bind results
  $displayStmt->bind_result($messageID, $fromUser, $toUser, $message);

  //create an array for the results
  $messageArray = [];

  //fetch results
  while($displayStmt->fetch()){
    //create array for json
    $messageArray[] = [
      "messageID"=>$messageID,
      "fromuser"=>$fromUser,
      "touser"=>$toUser, 
      "message"=>$message];

  }
  //encode the array in json format
  echo( json_encode($messageArray));


?>