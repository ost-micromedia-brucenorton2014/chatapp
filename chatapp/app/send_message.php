<?php
  require_once('../_includes/connect.php');

  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
  //get posted form data (notice the difference in capitalization)
  $fromUser = isset($_REQUEST['fromuser']) ? $_REQUEST['fromuser'] : '0';
  $toUser = isset($_REQUEST['touser']) ? $_REQUEST['touser'] : '0';
  $message = isset($_REQUEST['message']) ? $_REQUEST['message'] : 'not_set';

  //echo("response: $fromUser, $toUser, $message<br>");

   $tbl = "marmalade_messages";//change to your table i.e. John_app
  //write query
  $query = "INSERT INTO $tbl (fromUser, toUser, message) VALUES (?,?,?)";

  //prepare statement, execute, store_result
    if($insertStmt = $mysqli->prepare($query)){
      $insertStmt->bind_param("iis", $fromUser,$toUser,$message);
      $insertStmt->execute();
      $insertRows = $insertStmt->affected_rows;
      $insertID = $mysqli->insert_id;
      
    }else{
     $jsonResponse["response"] = "error";
      //$jsonResponse["messageError"] = "$insertStmt->error $mysqli->error";
      
    }
    //if the info got inserted
    if($insertRows > 0){
      $jsonResponse["response"] = "success";
      $jsonResponse["messageSuccess"] = "$insertRows inserted";
      $jsonResponse["insertID"] = $insertID;
      $jsonResponse["fromUser"] = $fromUser;
      $jsonResponse["toUser"] = $toUser;
      $jsonResponse["message"] = $message;
    }else{
      $jsonResponse["response"] = "error";
      $jsonResponse["messageError"] = "else error $insertStmt->error $mysqli->error";
    }
    $insertStmt->close();
    $mysqli->close();

    echo(json_encode($jsonResponse));

?>