<?php
  require('connect.php');
  session_start();

  mysql_query('SET NAMES UTF8');

  $sql = '';
  $loginFailed = false;
  $url = "http://" . $_SERVER['SERVER_NAME'];         //get server name
  $data;

  if(isset($_SESSION["username"])) {
    session_destroy();
  }

  if(isset($_POST['btnLogin'])) {
    if(isset($_POST['username']) && isset($_POST['password'])) {
      $user = $_POST['username'];
      $pass = $_POST['password'];

      if($user == "admin") {
        $encrypt =  hash('sha512', $pass);

        $sql = "SELECT username, COUNT(password) AS total FROM login WHERE password = '" . $encrypt . "' ";
        $result = mysql_query($sql);

        while($results = mysql_fetch_assoc($result)) {
          $data = $results;
        }

        if($data['total'] == 1) {
          $_SESSION["username"] = $data['username'];
          session_write_close();
          header("LOCATION: " . $url . '/aoffy/application/subject.php');
        }else {
          $loginFailed = true;  
        }

      }else {
        $loginFailed = true;
      }

    }
  }
?>

<html lang="en">
  <head>
    <meta http-equiv=Content-Type content="text/html; charset=utf-8"> 
    <link rel="stylesheet" href="../lib/css/bootstrap.min.css">
    <link rel="stylesheet" href="../lib/css/custom.css">
    <script src="../lib/js/jquery-1.12.4.min.js"></script>
    <script src="../lib/js/bootstrap.min.js"></script>
  </head>

  <body class="background-login">
    
    <div class="container">
        <div class="card card-container">
            <form name="loginForm" class="form-signin" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                <span id="username"></span>
                <input type="text" id="inputUsername" name="username" class="form-control" placeholder="Username" required autofocus>
                <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required>
                <input type="submit" name="btnLogin" class="btn btn-lg btn-primary btn-block btn-signin" value="เข้าสู่ระบบ">
            </form><!-- /form -->
            <a href="#" class="forgot-password">
                Forgot the password?
            </a>
            <?php 
              if($loginFailed) {
            ?>
              <div class="alert alert-danger top-5" role="alert">
                <p class="alert-link text-center">ชื่อผู้ใช้หรือรหัสผ่านผิดพลาด</p>
              </div>
            <?php
              }
            ?>
        </div><!-- /card-container -->
    </div><!-- /container -->

  </body>

</html>