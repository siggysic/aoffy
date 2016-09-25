<?php
  require('connect.php');
  session_start();

  mysql_query('SET NAMES UTF8');

  $sql = '';
  $loginFailed = false;
  $url = "http://" . $_SERVER['SERVER_NAME'];         //get server name
  $data;

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
          header("LOCATION: " . $url . '/aoffy/application/main-page.php');
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

  <body>
    <div class="row backgroud-green">
      <div class="container">
        <!-- <img src="img/kmutnb.png" class="img-responsive img-logo"> -->
        <h3 class="text-center">ระบบจัดการตารางสอบ</h3>
        <h4 class="text-right">คณะครุศาสตร์อุตสาหกรรม</h4>
      </div>
    </div>

    <!-- Start Menu -->
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
              <li class="active"><a href="../application/main-page.php"><i class="glyphicon glyphicon-home padding-right"></i>หน้าหลัก</a></li>
              <li><a href="../application/subject.php"><i class="glyphicon glyphicon-th-list padding-right"></i>จัดตารางสอบ</a></li>
              <li><a href="../application/search-subject.php"><i class="glyphicon glyphicon-search padding-right"></i>ตรวจสอบตารางสอบ</a></li>
              <li><a href="../application/change-password.php">เปลี่ยนรหัสผ่าน</a></li>
              <li><a href="../application/contact-us.php">ติดต่อเรา</a></li>
              <?php 
                if(isset($_SESSION['username'])) {
              ?>
                <li><a href="../application/logout.php">ออกจากระบบ</a></li>
              <?php } ?>
            </ul>
          </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
      </nav>
    </div>
    <!-- End Menu -->

    <!-- Start Login -->

    <?php if(!isset($_SESSION['username'])) { ?>

    <div class="row">
      <div class="col-sm-6"></div>
      <div class="col-sm-6 text-right padding-right-20">
        <form name="loginForm" class="form-signin" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
          <input type="text" name="username" class="form-control" placeholder="Username" required>
          <input type="password" name="password" class="form-control" placeholder="Password" required>
          <input type="submit" name="btnLogin" class="btn btn-primary" value="เข้าสู่ระบบ">
        </form>

        <?php 
          if($loginFailed) {
        ?>
          <span class="glyphicon glyphicon-remove-sign color-red"> ชื่อผู้ใช้งานหรือรหัสผ่านผิดพลาด</span>
        <?php } ?>
      </div>
    </div>

    <?php } ?>

    <!-- End Login -->
    
    <div class="row">
      <div class="container">
        <!-- <div class="col-sm-2">
          <a href="#sidebar" data-toggle="collapse"><i class="glyphicon glyphicon-align-justify"></i></a>
          <ul id="sidebar" class="nav nav-pills nav-stacked panel-collapse collapse">
            <li><a href="../application/subject.php">ข้อมูลวิชาสอบ</a></li>
            <li><a href="../application/room.php">ข้อมูลห้องสอบ</a></li>
            <li><a href="../application/subject.php">ข้อมูลผู้สอบ</a></li>
            <li><a href="../application/manage-pdf.php">ข้อมูลตารางสอบ PDF</a></li>
            <li><a href="../application/manage-exam.php">จัดห้องสอบอัตโนมัติ</a></li>
          </ul>
        </div> -->

        <div class="col-sm-12">
          <br>
          <div id="myCarousel" class="carousel slide" data-ride="carousel">
            <!-- Indicators -->
            <ol class="carousel-indicators">
              <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
              <li data-target="#myCarousel" data-slide-to="1"></li>
              <li data-target="#myCarousel" data-slide-to="2"></li>
              <li data-target="#myCarousel" data-slide-to="3"></li>
            </ol>

            <!-- Wrapper for slides -->
            <div class="carousel-inner" role="listbox">
              <div class="item active">
                <img src="img/main-menu1.png" alt="Chania" width="644" height="226">
              </div>

              <div class="item">
                <img src="img/main-menu2.png" alt="Chania" width="644" height="226">
              </div>
            
              <div class="item">
                <img src="img/main-menu3.png" alt="Flower" width="644" height="226">
              </div>
            </div>

            <!-- Left and right controls -->
            <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
              <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
              <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
              <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
              <span class="sr-only">Next</span>
            </a>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="container">
        <div class="col-sm-12">
          <div class="page-header">
            <h3>ประชาสัมพันธ์ <small><span class="label label-danger">ล่าสุด</span></small></h3>
          </div>
          <div class="data-body">
            <div class="padding">
              <span class="label label-warning"><i class="glyphicon glyphicon-plus"></i></span>
              <span>ประกาศผลการรับสมัครผู้เข้ารับการสรรหาเป็นผู้สมควรดำรงตำแหน่งอธิการบดี มจพ (15 กรกฎาคม 2559)</span>
            </div>
            <div class="padding">
              <span class="label label-warning"><i class="glyphicon glyphicon-plus"></i></span>
              <span>เชิญชวนคณาจารย์ บุคลากรและนักศึกษารวมพลังทำความสะอาด (กิจกรรม 5ส) (13 กรกฎาคม 2559)</span>
            </div>
            <div class="padding">
              <span class="label label-warning"><i class="glyphicon glyphicon-plus"></i></span>
              <span>สารประชาสัมพันธ์ คณะครุศาสตร์อุตสาหกรรม มจพ. ปีที่ 2 ฉบับที่ 7 มิติใหม่แห่งครูช่าง จัดทำโดยงานสารสนฯ (4 กรกฎาคม 2559)</span>
            </div>
            <div class="padding">
              <span class="label label-warning"><i class="glyphicon glyphicon-plus"></i></span>
              <span>สารประชาสัมพันธ์ คณะครุศาสตร์อุตสาหกรรม มจพ. ปีที่ 2 ฉบับพิเศษ มิติใหม่แห่งครูช่าง จัดทำโดยงานสารสนฯ (22 มิถุนายน 2559)</span>
            </div>
            <div class="padding">
              <span class="label label-warning"><i class="glyphicon glyphicon-plus"></i></span>
              <span>ม. ศิลปากร ประชาสัมพันธ์โครงการประชุมนำเสนอผลงานวิจัยระดับชาติ และนานาชาติ (20 มิถุนายน 2559)</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="padding-footer"></div>

    <nav class="navbar navbar-default navbar-fixed-bottom footer">
      <div class="container">
        <h5 class="text-center">คณะครุฑศาสตร์อุตสาหกรรม มหาวิทยาลัยเทคโนโลยีพระจอมเกล้าพระนครเหนือ</h5>
      </div>
    </nav>
  </body>

</html>