<?php
  session_start();
?>
<html lang="en">
  <head>
    <meta charset="utf-8">
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
              <li><a href="../application/search-subject.php"><i class="glyphicon glyphicon-search padding-right"></i>ตรวจสอบตารางสอบ</a></li>
              <li><a href="../application/change-password.php">เปลี่ยนรหัสผ่าน</a></li>
              <li class="active"><a href="../application/contact-us.php">ติดต่อเรา</a></li>
            </ul>
          </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
      </nav>
    </div>
    
    <div class="row">
      <div class="container">
        <div class="col-sm-12">
          <div class="container-fluid">
            <div class="panel panel-primary">
              <div class="panel-heading"><i class="glyphicon glyphicon-user padding-right"></i>ติดต่อเรา</div>
              <div class="panel-body">
                <div class="row">
                  <div class="container-fluid text-center">
                    <img src="img/contact.jpg" width="200px" height="200px">
                  </div>
                </div><br>
                <div class="row">
                  <div class="container-fluid text-center">
                    <h4><strong>ชื่อ : </strong>นางปะนะรี ปัญญาชีวิตา</h4>
                    <h4><strong>ตำแหน่ง : </strong>นักวิชาการศึกษา</h4>
                    <h4><strong>โทรศัพท์ : </strong>0-2555-2000 ต่อ 3226</h4>
                    <h4><strong>Email : </strong>panaree.p@fte.kmutnb.ac.th</h4>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <nav class="navbar navbar-default navbar-fixed-bottom footer">
      <div class="container">
        <h5 class="text-center">คณะครุฑศาสตร์อุตสาหกรรม มหาวิทยาลัยเทคโนโลยีพระจอมเกล้าพระนครเหนือ</h5>
      </div>
    </nav>

  </body>

</html>