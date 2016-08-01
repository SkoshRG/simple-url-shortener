<?php

require 'default.php';

$db = getDB();

if(isset($_GET['title'])) {
  $title = htmlspecialchars($_GET['title']);
  $result = $db->prepare('SELECT * FROM links WHERE title=?');
  $result->bind_param('s', $title);
  $result->execute();
  $result = $result->get_result();
  $goto = $result->fetch_array();
  header("Location: ".$goto['url']);
}

function generateRandomString($length = 5) {
  $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $charactersLenght = strlen($characters);
  $randomString = '';
  for($i = 0; $i < $length; $i++) {
    $randomString .= $characters[rand(0, $charactersLenght - 1)];
  }
  return $randomString;
}

if(isset($_POST['shorten'])) {

  $link_to_shorten = htmlspecialchars($_POST['shorten']);

  // Generate Title
  $title = generateRandomString();

  if(!checkTitle($title)) {
    $title = generateRandomString();
  }

  // Insert http
  $link_to_shorten = addhttp($link_to_shorten);

  $result = $db->prepare("INSERT INTO links VALUES('', ?, ?)");
  $result->bind_param('ss', $link_to_shorten, $title);
  $result->execute();

  echo jsonSuccess(array('shortened_link' => 'http://surls.ga/'.$title));
}

function checkTitle($title) {
  $db = getDB();
  $result = $db->prepare('SELECT * FROM links WHERE title=?');
  $result->bind_param('s', $title);
  $result->execute();
  $result = $result->get_result();
  if($result->num_rows > 0) {
    return false;
  } else {
    return true;
  }
}

function addhttp($url) {
    if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
        $url = "http://" . $url;
    }
    return $url;
}


?>
