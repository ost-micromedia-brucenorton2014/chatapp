<?php
  $host = "localhost";
  //you will need to change these
  $user = "username";
  $password = "password";
  $db = "databasename";

  $mysqli = new mysqli($host, $user, $password, $db);
  if ($mysqli->connect_error) {
      die('Connect Error (' . $mysqli->connect_errno . ') '
              . $mysqli->connect_error);
  }else{
    //be sure to comment out the echo below once you have tested the connection
    //echo("Connected successfully to $db as $user");
  }
?>