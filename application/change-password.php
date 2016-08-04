<?php
  session_start();
  if(!isset($_SESSION["username"])) { header("LOCATION: " . $url . '/aoffy/application/login.php'); }
  require_once 'connect.php';
  mysql_query("SET NAMES UTF8");

  if(isset($_POST['btnSubmit'])) {
    $checkVariable;

    $sql = "SELECT login_id, username, password FROM login WHERE username = ". "'" . $_SESSION['username'] . "'";
    $result = mysql_query($sql);

    while($results = mysql_fetch_assoc($result)) {
      $data[0] = $results;
    }

    if(count($data) > 1) {
      $checkVariable = 'ผิดพลาด : กรุณาลองใหม่';
    }else {
      if(isset($_POST['password']) && isset($_POST['password_new']) && isset($_POST['password_confirm'])) {
        $encrypt =  hash('sha512', $_POST['password']);
        if($encrypt == $data[0]['password']) {
          if($_POST['password_new'] == $_POST['password_confirm']) {
            $encrypt2 =  hash('sha512', $_POST['password_new']);
            $sql = "UPDATE login SET password = " . "'" . $encrypt2 . "'" . "WHERE login_id = " . "'" . $data[0]['login_id'] . "'";
            mysql_query($sql);
            $checkVariable = 'เรียบร้อย : เปลี่ยนรหัสผ่านสำเร็จ';
          }
        }else {
          $checkVariable = 'ผิดพลาด : รหัสผ่านเดิมไม่ถูกต้อง';
        }
      }else {
        $checkVariable = 'ผิดพลาด : กรุณากรอกให้ครบถ้วน';
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

  <body>
    <div class="row backgroud-green">
      <div class="container">
        <!-- <img src="img/kmutnb.png" class="img-responsive img-logo"> -->
        <h3 class="text-center">ระบบจัดการตารางสอบ</h3>
        <h4 class="text-right">คณะครุศาสตร์อุตสาหกรรม</h4>
      </div>
    </div>

    <div class="row">
      <nav class="navbar navbar-default">
        <div class="container">
          <!-- Brand and toggle get grouped for better mobile display -->
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">KMUTNB</a>
          </div>

          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
              <li><a href="../application/main-page.php"><i class="glyphicon glyphicon-home padding-right"></i>หน้าหลัก</a></li>
              <li><a href="../application/subject.php"><i class="glyphicon glyphicon-th-list padding-right"></i>จัดตารางสอบ</a></li>
              <li><a href="#"><i class="glyphicon glyphicon-search padding-right"></i>ตรวจสอบตารางสอบ</a></li>
              <li class="active"><a href="../application/change-password.php">เปลี่ยนรหัสผ่าน</a></li>
              <li><a href="../application/contact-us.php">ติดต่อเรา</a></li>
              <li><a href="../application/login.php">ออกจากระบบ</a></li>
            </ul>
          </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
      </nav>
    </div>
    
    <div class="row">
      <div class="container">
        <div class="col-sm-2">
          <a href="#sidebar" data-toggle="collapse"><i class="glyphicon glyphicon-align-justify"></i></a>
          <ul id="sidebar" class="nav nav-pills nav-stacked panel-collapse collapse in">
            <li><a href="../application/subject.php">ข้อมูลวิชาสอบ</a></li>
            <li><a href="../application/room.php">ข้อมูลห้องสอบ</a></li>
            <li><a href="../application/subject.php">ข้อมูลผู้สอบ</a></li>
            <li><a href="../application/manage-exam.php">จัดห้องสอบอัตโนมัติ</a></li>
          </ul>
        </div>

        <div class="col-sm-10">
          <!-- block head in manage-exam -->
          <blockquote>

            <form name="changePassword" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
              <h3 class="text-center">เปลี่ยนรหัสผ่าน</h3>
              <div class="input-group area-padding">
                <span class="input-group-addon" id="term-select">รหัสผ่านเดิม</span>
                <input name="password" type="password" class="form-control"/>
              </div>
              
              <div class="input-group area-padding">
                <span class="input-group-addon" id="year-select">รหัสผ่านใหม่</span>
                <input name="password_new" type="password" class="form-control"/> 
              </div>

              <div class="input-group area-padding">
                <span class="input-group-addon" id="year-select">ยืนยันรหัสผ่านใหม่</span>
                <input name="password_confirm" type="password" class="form-control"/> 
              </div>

              <div class="area-padding text-center">
                <input name="btnSubmit" type="submit" class="btn btn-primary area-padding" value="เปลี่ยนรหัสผ่าน">
              </div>
              <?php if(isset($_POST['btnSubmit'])) { ?>
                <?php if($checkVariable == "เรียบร้อย : เปลี่ยนรหัสผ่านสำเร็จ") { ?>
                  <div class="alert alert-success text-center" role="alert">
                    <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                    <span class="sr-only"></span>
                    <?php echo $checkVariable; ?>
                  </div>
                <?php }else { ?>
                  <div class="alert alert-danger text-center" role="alert">
                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                    <span class="sr-only"></span>
                    <?php echo $checkVariable; ?>
                  </div>
                <?php } ?>
              <?php } ?>
            </form>
            <hr/>
          </blockquote>
        </div>
      </div>
    </div>

    <nav class="navbar navbar-default navbar-fixed-bottom footer">
      <div class="container">
        <h5 class="text-center">คณะครุฑศาสตร์อุตสาหกรรม มหาวิทยาลัยเทคโนโลยีพระจอมเกล้าพระนครเหนือ</h5>
      </div>
    </nav>

    <script>
      function callExamPlan() {
        var selectedValue = document.getElementById('selectDepartment');
        var codeDepartment = selectedValue.options[selectedValue.selectedIndex].value;
        alert(codeDepartment);
      }
    </script>

  </body>

</html>