<?php

require('connect.php');
session_start();

if(!isset($_SESSION["username"])) { header("LOCATION: " . $url . '/aoffy/application/main-page.php'); }

mysql_query('SET NAMES UTF8');

$numberOrder = 1;
$sql = '';
$url = "http://" . $_SERVER['SERVER_NAME'];         //get server name
$data;

if(isset($_GET['id'])) {
  $sql = "SELECT subject_id, subject_number, name, start_time, end_time, day, section, term, year, amount FROM subject WHERE subject_id = " . $_GET['id'];
  $result = mysql_query($sql);

  while($subjectsData = mysql_fetch_assoc($result)) {
    $data = $subjectsData;
  }
}

if(isset($_POST['btnSubmit'])) {
  echo $_POST['day'];
  echo $_POST['start_time'];
  echo $_POST['end_time'];
}

if(isset($_POST['Import'])) {
  echo $filename=$_FILES["file"]["tmp_name"];
  
}

//get all subjects.
$sql = "SELECT subject_id, subject_number, name, start_time, end_time, day, section, term, year, amount FROM subject";
$subject = mysql_query($sql) or die ('Get subject failed.');

?>

<html lang="en">
  <head>
    <meta http-equiv=Content-Type content="text/html; charset=utf-8"> 
    <link rel="stylesheet" href="../lib/css/bootstrap.min.css">
    <link rel="stylesheet" href="../lib/css/custom.css">
    <script src="../lib/js/jquery-1.12.4.min.js"></script>
    <script src="../lib/js/bootstrap.min.js"></script>

    <style>
      .text-center {
        text-align: center;
      }
    </style>

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
              <li class="active"><a href="../application/subject.php"><i class="glyphicon glyphicon-th-list padding-right"></i>จัดตารางสอบ</a></li>
              <li><a href="../application/search-subject.php"><i class="glyphicon glyphicon-search padding-right"></i>ตรวจสอบตารางสอบ</a></li>
              <li><a href="../application/change-password.php">เปลี่ยนรหัสผ่าน</a></li>
              <li><a href="../application/contact-us.php">ติดต่อเรา</a></li>
              <li><a href="../application/logout.php">ออกจากระบบ</a></li>
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
        <!-- Start Content -->

        <div class="col-sm-10">
          <!-- block head in manage-exam -->
          <blockquote>

            <form enctype="multipart/form-data" name="addSubject" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" role="form">
              <h3 class="text-center">ข้อมูลรายวิชาสอบ</h3>

              <input name="id" type="hidden" value="<?php if(isset($data)) { echo $data['subject_id']; } ?>" />
              
              <div class="row">
                <div class="col-md-3">
                  <div class="input-group area-padding">
                    <span class="input-group-addon" id="number">รหัสวิชา</span>
                    <input name="number" type="text" class="form-control" aria-describedby="number" value="<?php if(isset($data)) { echo $data['subject_id']; } ?>" required="true" />
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="input-group area-padding">
                    <span class="input-group-addon" id="name">ชื่อวิชา</span>
                    <input name="name" type="text" class="form-control" aria-describedby="name" value="<?php if(isset($data)) { echo $data['name']; } ?>" required="true" />
                  </div>
                </div>

                <div class="col-md-3">
                  <div class="input-group area-padding">
                    <span class="input-group-addon" id="section">ตอนที่</span>
                    <input name="section" type="number" class="form-control" aria-describedby="section" min="0" 
                      max="99" value="<?php if(isset($data)) { echo $data['section']; } ?>" required="true"/>
                  </div>
                </div> 
              </div>

              <div class="row">
                <div class="col-md-4">
                  <div class="input-group area-padding">
                    <span class="input-group-addon" id="day">วันที่</span>
                    <input name="day" type="date" class="form-control" aria-describedby="day" value="<?php if(isset($data)) { echo $data['day']; } ?>" required="true" />
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="input-group area-padding">
                    <span class="input-group-addon" id="start-time">เวลาเริ่มสอบ</span>
                    <input name="start_time" type="time" class="form-control" aria-describedby="start-time" value="<?php if(isset($data)) { echo $data['start_time']; } ?>" required="true" />
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="input-group area-padding">
                    <span class="input-group-addon" id="end-time">เวลาสิ้นสุด</span>
                    <input name="end_time" type="time" class="form-control" aria-describedby="end-time" value="<?php if(isset($data)) { echo $data['end_time']; } ?>" required="true" />
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-4">
                  <div class="input-group area-padding">
                    <span class="input-group-addon" id="term">ภาคการเรียน</span>
                    <input name="term" type="number" class="form-control" aria-describedby="term" min="1" max="3" value="<?php if(isset($data)) { echo $data['term']; } ?>" required="true" />
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="input-group area-padding">
                    <span class="input-group-addon" id="year">ปีการศึกษา</span>
                    <input name="year" type="number" class="form-control" aria-describedby="year" min="2499" max="3000" value="<?php if(isset($data)) { echo $data['year']; } ?>" required="true" />
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="input-group area-padding">
                    <span class="input-group-addon" id="amount">จำนวนผู้เข้าสอบ</span>
                    <input name="amount" type="number" class="form-control" aria-describedby="amount" min="1" max="99" value="<?php if(isset($data)) { echo $data['amount']; } ?>" required="true" />
                  </div>
                </div>
              </div>

              <div class="area-padding text-center">
                <input name="btnSubmit" type="submit" class="btn btn-primary area-padding" style="width: 100px;" value="เพิ่ม">
              </div>
              
            </form>

              <hr/>
          </blockquote>

          <blockquote>
            <form enctype="multipart/form-data" method="post" role="form">
                <div class="form-group">
                    <label for="exampleInputFile">File Upload</label>
                    <input type="file" name="file" id="file" size="150">
                    <p class="help-block">Only Excel/CSV File Import.</p>
                </div>
                <button type="submit" class="btn btn-default" name="Import" value="Import">Upload</button>
            </form>
          </blockquote>

            <div class="container-fluid">
              <table class="table table-hover text-center" border="1">
                <thead>
                  <tr>
                    <th class="text-center">ลำดับ</th>
                    <th class="text-center">รหัส</th>
                    <th class="text-center">ชื่อ</th>
                    <th class="text-center">ตอนที่</th>
                    <th class="text-center">วันที่</th>
                    <th class="text-center">เวลา</th>
                    <th class="text-center">ภาคเรียน</th>
                    <th class="text-center">ปีการศึกษา</th>
                    <th class="text-center">จำนวนคนสอบ</th>
                    <th class="text-center">แก้ไข</th>
                    <th class="text-center">ลบ</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  if(isset($subject)) {
                    while($subjects = mysql_fetch_assoc($subject)) {
                  ?>
                      <tr>
                        <td><?php echo $numberOrder++; ?></td>
                        <td><?php echo $subjects['subject_number'] ?></td>
                        <td><?php echo $subjects['name']; ?></td>
                        <td><?php echo $subjects['section']; ?></td>
                        <td><?php echo $subjects['day']; ?></td>
                        <td><?php echo $subjects['start_time']. ' - ' .$subjects['end_time'] ?></td>
                        <td><?php echo $subjects['term'] ?></td>
                        <td><?php echo $subjects['year'] ?></td>
                        <td><?php echo $subjects['amount'] ?></td>
                        <td><a href="<?php echo $url . '/aoffy/application/subject.php' . '?id=' . $subjects['subject_id']; ?>" style="color: black;"><span class="glyphicon glyphicon-edit"></span></a></td>
                        <td><a href="#" style="color: black;"><span class="glyphicon glyphicon-trash"></span></a></td>
                      </tr>
                  <?php
                    }
                  }
                  ?>
                </tbody>
              </table>

            </div><hr/>

        </div>

        <!-- End Content -->

      </div>
    </div>

    <nav class="navbar navbar-default navbar-fixed-bottom footer">
      <div class="container">
        <h5 class="text-center">คณะครุฑศาสตร์อุตสาหกรรม มหาวิทยาลัยเทคโนโลยีพระจอมเกล้าพระนครเหนือ</h5>
      </div>
    </nav>

  </body>

</html>