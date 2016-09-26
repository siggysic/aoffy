<?php
  session_start();
  if(!isset($_SESSION["username"])) { header("LOCATION: " . $url . '/aoffy/application/main-page.php'); }
  require_once 'connect.php';
  mysql_query("SET NAMES UTF8");

  if(isset($_POST['btnSubmit']) && $_POST['btnSubmit'] == 'เริ่มจัดอัตโนมัติ') {
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

    //Third, get subject have exam in term and year as you want.
    $sqlGetSubject = "SELECT * FROM subject WHERE subject.term = " . $_POST['term'] . " AND subject.year = " . $_POST['year'] . " ORDER BY subject.day ASC, subject.start_time ASC, subject.end_time ASC, subject.subject_number, subject.section ASC";
    $subject = mysql_query($sqlGetSubject) or die('Get subject error.');
    
    while($subjects = mysql_fetch_assoc($subject)) {
      $dataSubject[$countSubject] = $subjects;
      $countSubject++; 
    }

    $sqlGetRoom = "SELECT * FROM room";
    $room = mysql_query($sqlGetRoom) or die('Get room error.');

    while($rooms = mysql_fetch_assoc($room)) {
      $dataRoom[$countRoom] = $rooms;
      $countRoom++;
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

    function roomDevide($people, $dataRoom) {
      $cFunction = 0;
      if(isset($people) && isset($dataRoom) && 0 < $people) {
        for($i=0; $i<count($dataRoom); $i++) {
          if($dataRoom[$i]['status'] == 'ว่าง') {
            $distance[$i] = $dataRoom[$i]['seat'] - $people;
            if(empty($value)) {
              $value = $distance[$i];
              $dataRoom[$i]['key'] = $i;
              $dataRoom[$i]['distance'] = $distance[$i];
              $GLOBALS['forSend'] = $dataRoom[$i];
            }
            if(!empty($value)) {
              if($value > $distance[$i]) {
                $value = $distance[$i];
                $dataRoom[$i]['key'] = $i;
                $dataRoom[$i]['distance'] = $distance[$i];
                $GLOBALS['forSend'] = $dataRoom[$i];
              }
            }
          }
          if($cFunction == count($dataRoom)-1) {
            if(empty($value)) {
              return;
            }else {
              return $GLOBALS['forSend'];
            }
          }
          $cFunction = $cFunction+1;
        }
      }
    }

    function findFullRoom($people, $dataRoom) {
      if(isset($people) && isset($dataRoom)) {
        for($i=0; $i<count($dataRoom); $i++) {
          if($dataRoom[$i]['status'] == 'ว่าง') {
            if($people == $dataRoom[$i]['seat']) {
              $dataRoom[$i]['key'] = $i;
              $dataRoom[$i]['distance'] = 0;
              $GLOBALS['forSend'] = $dataRoom[$i];
              return $GLOBALS['forSend'];
            }
          }
        }
      }
    }

    function findRoom($people, $dataRoom) {
      $cFunction = 0;
      if(isset($people) && isset($dataRoom) && 0 < $people) {
        for($i=0; $i<count($dataRoom); $i++) {
          if($dataRoom[$i]['status'] == 'ว่าง') {
            $distance[$i] = $dataRoom[$i]['seat'] - $people;
            if($distance[$i] > 0) {
              if(empty($value)) {
                $value = $distance[$i];
                $dataRoom[$i]['key'] = $i;
                $dataRoom[$i]['distance'] = $distance[$i];
                $GLOBALS['forSend'] = $dataRoom[$i];
              }
              if(!empty($value)) {
                if($value > $distance[$i]) {
                  $value = $distance[$i];
                  $dataRoom[$i]['key'] = $i;
                  $dataRoom[$i]['distance'] = $distance[$i];
                  $GLOBALS['forSend'] = $dataRoom[$i];
                }
              }
            }
          }
          if($cFunction == count($dataRoom)-1) {
            if(empty($value)) {
              return;
            }else {
              return $GLOBALS['forSend'];
            }
          }
          $cFunction = $cFunction+1;
        }
      }
    }

    if(isset($dataSubject) && isset($dataRoom)) {
      foreach ($dataSubject as $key => $value) {
        $checkFullRoom = findFullRoom($dataSubject[$key]['amount'], $dataRoom);
        if($checkFullRoom) {
          $dataRoom[$checkFullRoom['key']]['status'] = 'ถูกใช้งานแล้ว';
          $formatSection[$key][0]['student'] = $dataSubject[$key]['amount'];
          $formatSection[$key][0]['subject_id'] = $dataSubject[$key]['subject_id'];
          $formatSection[$key][0]['room_number'] = $checkFullRoom['room_number'];
          $formatSection[$key][0]['room_id'] = $checkFullRoom['room_id'];
          $formatSection[$key][0]['distance'] = $formatSection[$key][0]['student'];
        }else if(!$checkFullRoom) {
          $checkRoom = findRoom($dataSubject[$key]['amount'], $dataRoom);
          if($checkRoom['distance'] > 0) {
            $dataRoom[$checkRoom['key']]['status'] = 'ถูกใช้งานแล้ว';
            $formatSection[$key][0]['student'] = $dataSubject[$key]['amount'];
            $formatSection[$key][0]['subject_id'] = $dataSubject[$key]['subject_id'];
            $formatSection[$key][0]['room_number'] = $checkRoom['room_number'];
            $formatSection[$key][0]['room_id'] = $checkRoom['room_id'];
            $formatSection[$key][0]['distance'] = $formatSection[$key][0]['student'];
          }else if(empty($checkRoom)) {
            $cCount = 0;
            $checkRoom = roomDevide($dataSubject[$key]['amount'], $dataRoom);
            if($checkRoom['key']) {
              $dataRoom[$checkRoom['key']]['status'] = 'ถูกใช้งานแล้ว';
              $formatSection[$key][$cCount]['student'] = $dataSubject[$key]['amount'];
              $formatSection[$key][$cCount]['subject_id'] = $dataSubject[$key]['subject_id'];
              $formatSection[$key][$cCount]['room_number'] = $checkRoom['room_number'];
              $formatSection[$key][$cCount]['room_id'] = $checkRoom['room_id'];
              $formatSection[$key][$cCount]['distance'] = $checkRoom['distance'];
              if($formatSection[$key][$cCount]['distance'] < 0) {
                $formatSection[$key][$cCount]['distance'] = $formatSection[$key][$cCount]['student'] + $formatSection[$key][$cCount]['distance'];
              }else {
                $formatSection[$key][$cCount]['distance'] = $formatSection[$key][$cCount]['student'];
              }
              while ($checkRoom['distance'] < 0) {
                $cCount++;
                $checkRoom = roomDevide(-$checkRoom['distance'], $dataRoom);
                $dataRoom[$checkRoom['key']]['status'] = 'ถูกใช้งานแล้ว';
                $formatSection[$key][$cCount]['student'] = $dataSubject[$key]['amount'];
                $formatSection[$key][$cCount]['subject_id'] = $dataSubject[$key]['subject_id'];
                $formatSection[$key][$cCount]['room_number'] = $checkRoom['room_number'];
                $formatSection[$key][$cCount]['room_id'] = $checkRoom['room_id'];
                $formatSection[$key][$cCount]['distance'] = $checkRoom['distance'];
                if($formatSection[$key][$cCount]['distance'] < 0) {
                  $formatSection[$key][$cCount]['distance'] = $formatSection[$key][$cCount]['student'] + $formatSection[$key][$cCount]['distance'];
                }else {
                  $formatSection[$key][$cCount]['distance'] = $formatSection[$key][$cCount]['student'] - $formatSection[$key][$cCount-1]['distance'];
                }
              }
            }
          }
        }
      }
    }

    $num_rows = count($subject);
    $_SESSION['storeSection'] = $formatSection;
    //echo $num_rows;
  }

  if(isset($_POST['term'])) {
    $temp['term'] = $_POST['term'];
  }

  if(isset($_POST['year'])) {
    $temp['year'] = $_POST['year'];
  }

  if(isset($_POST['btnSave'])) {
    $sql = "UPDATE subject SET exam_room='ไม่ได้ห้อง' WHERE term=" . "'" . $_POST['term_tmp'] . "'" . " AND year=" . "'" . $_POST['year_tmp'] . "'";
    mysql_query($sql) or die('Update exam room failed.');
    $storeSave = $_SESSION['storeSection'];
    foreach ($storeSave as $key => $value) {
      for($j=0; $j<count($storeSave[$key]); $j++) {
        if($j==0) {
          $formatExam = $storeSave[$key][$j]['room_number'];
        }else {
          $formatExam = $formatExam . ', ' . $storeSave[$key][$j]['room_number'];
        }
      }
      $sql = "UPDATE subject SET exam_room=" . "'" . $formatExam . "'" . " WHERE subject_id=" . "'" . $storeSave[$key][0]['subject_id'] . "'";
      mysql_query($sql) or die('Update exam room failed.');
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
            <li><a href="../application/manage-exam.php">จัดห้องสอบอัตโนมัติ</a></li>
          </ul>
        </div>

        <div class="col-sm-10">
          <!-- block head in manage-exam -->
          <blockquote>

            <form name="autoExam" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
              <h3 class="text-center">จัดห้องสอบอัตโนมัติ</h3>
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

              <div class="area-padding text-center">
                <input name="btnSubmit" type="submit" class="btn btn-primary area-padding" value="เริ่มจัดอัตโนมัติ">
              </div>
            </form>

              <hr/>
          </blockquote>

          <?php
            if(isset($_POST['btnSubmit']) && $_POST['btnSubmit'] == 'เริ่มจัดอัตโนมัติ') {

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
              <div class="area-padding text-right">
                <form name="saveExam" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                  <input name="btnSave" type="submit" class="btn btn-success area-padding" value="บันทึก">
                  <input type="hidden" name="term_tmp" value="<?php if(isset($temp['term'])){ echo $temp['term']; } ?>">
                  <input type="hidden" name="year_tmp" value="<?php if(isset($temp['year'])){ echo $temp['year']; } ?>">
                </form>
              </div><br>
              <table class="table table-hover" border="1">
                <thead>
                  <tr>
                    <th>วันที่</th>
                    <th>เวลา</th>
                    <th>รหัสวิชา</th>
                    <th>ชื่อวิชา</th>
                    <th>ตอนที่</th>
                    <th>ห้องสอบ</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
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
                          <?php if(isset($formatSection[$i])) { ?>
                            <td>
                              <?php for($j=0; $j<count($formatSection[$i]); $j++) { ?>
                                <?php if($j==0) {
                                  $formatEcho = $formatSection[$i][$j]['room_number'];
                                }else {
                                  $formatEcho = $formatEcho. ', ' .$formatSection[$i][$j]['room_number'];
                                } ?>
                              <?php } ?>
                              <?php echo $formatEcho; ?>
                            </td>
                            <?php }else { ?>
                              <td><?php echo "ไม่ได้ห้อง"; ?></td>
                            <?php } ?>
                          <?php } ?>
                      </tr>
                  <?php
                    }
                  ?>
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

  </body>
</html>