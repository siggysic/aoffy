<?php

  $host = 'localhost';
  $user = 'root';
  $pass = 'admin';
  $db = 'manage_exam';

  mysql_connect($host, $user, $pass) or die('Connect Failed.');
  mysql_query('set name utf8');
  mysql_select_db($db) or die('Select Database Failed.');


?>