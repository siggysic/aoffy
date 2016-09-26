<?php

  $to = "siggysic@gmail.com";
  $subject = "TEST EMAIL";
  $txt = "username : TEST EMAIL";
  $headers = "From: webmaster@example.com" . "\r\n" .
  "CC: somebodyelse@example.com";

  mail($to,$subject,$txt,$headers);

?>

<html>
  <head></head>

  <body>
    <div style="width:250px;height:250px;color:red;"></div>
  </body>
</html>