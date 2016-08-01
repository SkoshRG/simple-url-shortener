<?php

function getDB() {
  $dbHost   = 'localhost';
  $dbName  = 'url_shortener';
  $dbUser   = 'root';
  $dbPass   = '';
  

  $db = new mysqli($dbHost, $dbUser, $dbPass, $dbName);
  if($db->connect_error) {
    die("Sorry, there was a problem connecting to our database.");
  }
  return $db;
}

function jsonSuccess($data) {
  return json_encode(array('success' => 1, 'data' => $data));
}

function jsonErr($errMsg) {
  return json_encode(array('success' => 0, 'errMsg' => $errMsg));
}

?>
