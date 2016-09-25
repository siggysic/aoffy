<?php
  session_start();
  if(!isset($_SESSION["username"])) { header("LOCATION: " . $url . '/aoffy/application/main-page.php'); }
  define ('SITE_ROOT', realpath(dirname(__FILE__)));
  require_once 'connect.php';
  mysql_query("SET NAMES UTF8");

  if(isset($_POST['btnSubmit']) && $_POST['btnSubmit'] == 'ค้นหา') {
    //main manage_exam concept.
    $i = 0;
    $countSubject = 0;
    $countRoom = 0;
    $countSucc = 0;
    $countFail = 0;
    $countRealFail = 0;
    $dataRoom;
    $goodChoice;
    $success;
    $fail;
    $realFail;
    $distance;
    $countSig = 0;
    $checkDay = '';
    $checkTime = '';
    $countTime = 1;
    $checkRealDay = '';
    $countCol = 1;
    $formatCol;
    $formatTime;
    $checkRealTime = '';
    $countSec = 1;
    $checkSec = '';
    $formatSec = '';
    $checkSub = '';
    $formatSection;
    $forSend;
    $sub = '';
    $sec = '';
    //Third, get subject have exam in term and year as you want.
    if(!$_POST['sub_id']) {
      $sub = ' IS NOT NULL';
    }else {
      $sub =  ' = ' . "'" . $_POST['sub_id'] . "'";
    }
    if(!$_POST['section']) {
      $sec = ' IS NOT NULL';
    }else {
      $sec =  ' = ' . "'" . $_POST['section'] . "'";
    }
    $sqlGetSubject = "SELECT * FROM subject WHERE subject.term = " . $_POST['term'] . " AND subject.year = " . $_POST['year'] . " AND subject.subject_number" . $sub . " AND subject.section" . $sec . " ORDER BY subject.day ASC, subject.start_time ASC, subject.end_time ASC, subject.subject_number, subject.section ASC";
    $subject = mysql_query($sqlGetSubject) or die('Get subject error.');
    
    while($subjects = mysql_fetch_assoc($subject)) {
      $dataSubject[$countSubject] = $subjects;
      $countSubject++; 
    }

    if(isset($dataSubject)) {
      for($i=0; $i<count($dataSubject); $i++) {
        $strNEnd = $dataSubject[$i]['start_time']. ' - ' .$dataSubject[$i]['end_time'];
        $subSec = $dataSubject[$i]['subject_number']. '-' .$dataSubject[$i]['section'];
        if($dataSubject[$i]['day'] != $checkDay) {
          $checkDay = $dataSubject[$i]['day'];
          $countCol = 1;
        }else {
          $countCol++;
          $formatCol[$dataSubject[$i]['day']] = $countCol;
        }
        if($strNEnd != $checkTime) {
          $checkTime = $strNEnd;
          $countTime = 1;
        }else {
          $countTime++;
          $formatTime[$dataSubject[$i]['day']][$strNEnd] = $countTime;
        }
        if($subSec != $checkSub) {
          $checkSub = $subSec;
          $countSec = 1;
        }else {
          $countSec++;
          $formatSec[$subSec] = $countSec;
        }
      }
    }

    $num_rows = count($subject);
    //echo $num_rows;
  }

  if(isset($_POST['term'])) {
    $temp['term'] = $_POST['term'];
  }

  if(isset($_POST['year'])) {
    $temp['year'] = $_POST['year'];
  }

  if(isset($_POST['sub_id'])) {
    $temp['sub_id'] = $_POST['sub_id'];
  }

  if(isset($_POST['section'])) {
    $temp['section'] = $_POST['section'];
  }

  if(isset($_POST['btnUploadPdf'])) {
    $uploads_dir = SITE_ROOT."/uploads";
    if(isset($_POST['modalSubjectId'])) {
      $subjectIdForPdf = $_POST['modalSubjectId'];
    }

    if($_FILES["filePdf"]["error"] == UPLOAD_ERR_OK) {
      $tmp_name = $_FILES["filePdf"]["tmp_name"];
      $name = basename($_FILES["filePdf"]["name"]);
      //if uploads to folder success.
      if(move_uploaded_file($tmp_name, "$uploads_dir/$name")) {
        //update filename in db
        $sql = "UPDATE subject SET filename=" . "'" . $name . "'" . " WHERE subject_id=" . "'" . $subjectIdForPdf . "'";
        mysql_query($sql) or die('Update pdf failed.');
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
            <li><a href="../application/manage-pdf.php">ข้อมูลตารางสอบ PDF</a></li>
            <li><a href="../application/manage-exam.php">จัดห้องสอบอัตโนมัติ</a></li>
          </ul>
        </div>

        <div class="col-sm-10">
          <!-- block head in manage-exam -->
          <blockquote>

            <form name="autoExam" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
              <h3 class="text-center">อัพโหลดรายชื่อผู้เข้าสอบ PDF</h3>
              <div class="input-group area-padding">
                <span class="input-group-addon" id="term-select">ภาคเรียนที่</span>
                <input name="term" type="number" class="form-control" aria-describedby="term-select" min="0" 
                  value="<?php echo (isset($temp['term'])) ? $temp['term'] : ''; ?>" />
              </div>
              
              <div class="input-group area-padding">
                <span class="input-group-addon" id="year-select">ปีการศึกษา</span>
                <input name="year" type="number" class="form-control" aria-describedby="year-select" min="2500"
                  value="<?php echo (isset($temp['year'])) ? $temp['year'] : ''; ?>" /> 
              </div>

              <div class="input-group area-padding">
                <span class="input-group-addon" id="year-select">รหัสวิชา</span>
                <input name="sub_id" type="number" class="form-control" value="<?php echo (isset($temp['sub_id'])) ? $temp['sub_id'] : ''; ?>" /> 
              </div>

              <div class="input-group area-padding">
                <span class="input-group-addon" id="year-select">Section</span>
                <input name="section" type="number" class="form-control" value="<?php echo (isset($temp['section'])) ? $temp['section'] : ''; ?>" /> 
              </div>

              <div class="area-padding text-center">
                <input name="btnSubmit" type="submit" class="btn btn-primary area-padding" value="ค้นหา">
              </div>
            </form>

              <hr/>
          </blockquote>

          <?php
            if(isset($_POST['btnSubmit']) && $_POST['btnSubmit'] == 'ค้นหา') {

              if($num_rows == 0) {
          ?>
                <div class="alert alert-danger text-center" role="alert">
                  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                  <span class="sr-only">ผิดพลาด:</span>
                  ไม่พบข้อมูลที่คุณต้องการ
                </div>
          <?php
              }else {
          ?>

            <div class="container-fluid">
              <table class="table table-hover" border="1">
                <thead>
                  <tr>
                    <th>วันที่</th>
                    <th>เวลา</th>
                    <th>รหัสวิชา</th>
                    <th>ชื่อวิชา</th>
                    <th>ตอนที่</th>
                    <th>ห้องสอบ</th>
                    <th>ผู้เข้าสอบ</th>
                    <th>แก้ไข Pdf</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    if(isset($dataSubject)) {
                      for($i=0; $i<count($dataSubject); $i++) {
                    ?>
                      <tr>
                          <?php if($dataSubject[$i]['day'] != $checkRealDay) { ?>
                            <td rowspan="<?php echo $formatCol[$dataSubject[$i]['day']]; ?>">
                              <?php
                                $checkRealDay = $dataSubject[$i]['day'];
                                echo $dataSubject[$i]['day'];
                              ?>
                            </td>
                          <?php } ?>
                          <?php $strEnd = $dataSubject[$i]['start_time'] . ' - ' . $dataSubject[$i]['end_time'];
                            if($strEnd != $checkRealTime) {
                          ?>
                            <td rowspan="<?php echo $formatTime[$dataSubject[$i]['day']][$strEnd]; ?>">
                              <?php
                                $checkRealTime = $strEnd;
                                echo $strEnd;
                              ?>
                            </td>
                          <?php } ?>
                          <?php $subSection = $dataSubject[$i]['subject_number']. '-' .$dataSubject[$i]['section'];
                            if($checkSec != $subSection) {
                          ?>
                            <td>
                              <?php
                                $checkSec = $subSection;
                                echo $dataSubject[$i]['subject_number'];  
                              ?>
                            </td>
                            <td>
                              <?php
                                echo $dataSubject[$i]['name'];
                              ?>
                            </td>
                            <td>
                              <?php
                                echo $dataSubject[$i]['section'];
                              ?>
                            </td>
                            <td>
                              <?php
                                echo $dataSubject[$i]['exam_room'];
                              ?>
                            </td>
                            <td>
                              <?php 
                                if($dataSubject[$i]['exam_room'] != 'ไม่ได้ห้อง') {
                                  if($dataSubject[$i]['filename'] != "") {
                              ?>
                                  <a href="<?php echo "./uploads/".$dataSubject[$i]['filename']; ?>" target="_blank"><?php echo $dataSubject[$i]['filename']; ?></a>
                              <?php 
                                  }else {
                              ?>
                                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#uploadPdfModal" data-whatever="<?php echo $dataSubject[$i]['subject_id'] ?>">Upload รายชื่อ</button>
                              <?php
                                  }
                                }
                              ?>
                            </td>
                            <td style="text-align: center;">
                              <?php
                                if($dataSubject[$i]['filename'] != "") {
                              ?>
                                <i class="glyphicon glyphicon-edit" aria-hidden="true" data-toggle="modal" data-target="#uploadPdfModal" data-whatever="<?php echo $dataSubject[$i]['subject_id'] ?>"></i>
                              <?php
                                }
                              ?>
                            </td>
                          <?php } ?>
                        </tr>
                    <?php
                      }
                    }else { ?>
                      <div class="alert alert-danger text-center" role="alert">
                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                        <span class="sr-only">ผิดพลาด:</span>
                        ไม่พบข้อมูลที่คุณต้องการ
                      </div>
                    <?php } ?>
                </tbody>
              </table>
            </div><hr/>

          <?php } /* end else if */ } /* end if */ ?>

        </div>
      </div>
    </div>

    <div class="padding-footer"></div>

    <nav class="navbar navbar-default navbar-fixed-bottom footer">
      <div class="container">
        <h5 class="text-center">คณะครุฑศาสตร์อุตสาหกรรม มหาวิทยาลัยเทคโนโลยีพระจอมเกล้าพระนครเหนือ</h5>
      </div>
    </nav>

    <!-- Modal upload pdf -->
      <div class="modal fade" id="uploadPdfModal" tabindex="-1" role="dialog" aria-labelledby="uploadPdfModalLabel">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modalLabel">Upload PDF</h4>
            </div>
            <div class="modal-body">
              <form enctype="multipart/form-data" name="uploadPdf" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                <div class="form-group">
                  <label for="filePdf" class="control-label">Select file pdf:</label>
                  <input type="file" class="form-control" style="width: 100%;" id="filePdf" name="filePdf" accept="application/pdf">
                </div>
                <input type="hidden" name="modalSubjectId" id="modalSubjectId">
                <input type="submit" name="btnUploadPdf" class="btn btn-primary" value="Upload">
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
    <!-- End modal upload pdf -->
  </body>

  <!-- If order to tag head on top it will doesn't working. -->
  <script src="../lib/js/manage-pdf.js"></script>

</html>