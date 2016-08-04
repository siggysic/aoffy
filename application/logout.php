<?php

session_start();

if(!isset($_SESSION["username"])) { header("LOCATION: " . $url . '/aoffy/application/main-page.php'); }

if(isset($_SESSION["username"])) {
  session_destroy();
}

header("LOCATION: " . $url . '/aoffy/application/main-page.php');

?>