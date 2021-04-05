<?php
  require_once('../_includes/connect.php');

  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
  //https://micromedia.vanier.college/home/web2/chatapp/app/signup.php?fullname=Bruce%20Norton&username=bruno&userpassword=ostmh&email=nortonb@vanier.college&colour=marmalade
  //get posted form data (notice the difference in capitalization)
  $fullName = isset($_REQUEST['fullname']) ? $_REQUEST['fullname'] : 'not_set';
  $userName = isset($_REQUEST['username']) ? $_REQUEST['username'] : 'not_set';
  $userPassword = isset($_REQUEST['userpassword']) ? password_hash($_REQUEST['userpassword'], PASSWORD_BCRYPT) : 'not_set';
  $email = isset($_REQUEST['email']) ? $_REQUEST['email'] : 'not_set';
  $colour = isset($_REQUEST['colour']) ? $_REQUEST['colour'] : 'not_set';

  //echo("response: $username, $name, $email, $colour")

   $tbl = "marmalade_users";//change to your table i.e. John_app
  //write query
    $query = "INSERT INTO $tbl (fullName, userName, userPassword, email, colour) VALUES (?,?,?,?,?)";
  //prepare statement, execute, store_result
    if($insertStmt = $mysqli->prepare($query)){
      $insertStmt->bind_param("sssss", $fullName, $userName, $userPassword, $email, $colour);
      $insertStmt->execute();
      $insertRows = $insertStmt->affected_rows;
      $insertID = $mysqli->insert_id;
      
    }else{
      $jsonResponse["response"] = "error";
      $jsonResponse["messageError"] = "$insertStmt->error $mysqli->error";
    }
    //if the info got inserted
    if($insertRows > 0){
      $jsonResponse["response"] = "success";
      $jsonResponse["messageSuccess"] = "$insertRows inserted";
      $jsonResponse["insertID"] = $insertID;
      $jsonResponse["email"] = $email;
    }else{
      $jsonResponse["response"] = "error";
      $jsonResponse["messageError"] = "else error $insertStmt->error $mysqli->error";
    }
    $insertStmt->close();
    $mysqli->close();

    echo(json_encode($jsonResponse));

?>