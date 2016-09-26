<?php

  $host = 'mysql9.000webhost.com';
  $user = 'a4950250_siggy';
  $pass = '123456';
  $db = 'a4950250_fb';

  mysql_connect($host, $user, $pass) or die('Connect Failed.');
  mysql_query('set name utf8');
  mysql_select_db($db) or die('Select Database Failed.');


?>