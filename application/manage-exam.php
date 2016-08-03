<?php
  require_once 'connect.php';
  mysql_query("SET NAMES UTF8");

  $term = '';
  $year = '';

  if(isset($_POST['term'])) {
    $temp['term'] = $_POST['term'];
  }

  if(isset($_POST['year'])) {
    $temp['year'] = $_POST['year'];
  }

  if(isset($_POST['term_depart'])) {
    $temp['term'] = $_POST['term_depart'];
  }

  if(isset($_POST['year_depart'])) {
    $temp['year'] = $_POST['year_depart'];
  }

  if(isset($_POST['btnSubmit']) && $_POST['btnSubmit'] == 'เริ่มจัดอัตโนมัติ') {
    //main manage_exam concept.
    $i = 0;
    $countSubject = 0;
    // $countRoom = 0;
    $countSucc = 0;
    $countFail = 0;
    $countRealFail = 0;
    // $dataRoom;
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
    $stdCount = 1;
    $stdDepart = '';
    $formatStd;
    $secCount = 1;
    $setupDepart;
    $setupCount = 1;
    $department;
    $cDepartment = 0;

    //First, get department will take exam in term and year as you want.
    // $sqlGetDept = "SELECT std.department_code AS dept_code, dep.name AS dept_name, std.subject_number AS subject_number, std.section AS section FROM student AS std, department AS dep WHERE std.term = " . $_POST['term'] ." AND std.year = " . $_POST['year'] . " AND std.department_code = dep.code GROUP BY std.department_code";
    // $dept = mysql_query($sqlGetDept) or die('Get department error.');
    // $num_rows_dept = mysql_num_rows($dept);

    // while($depts = mysql_fetch_assoc($dept)) {
    //   //Second, count student each department.
    //   $sqlCountStd = "SELECT COUNT(department_code) AS dep_sum FROM student WHERE department_code = '" . $depts['dept_code'] . "'";
    //   $std = mysql_query($sqlCountStd) or die('Count student error.');

    //   while($stds = mysql_fetch_assoc($std)) {
    //     //save department_code and count of student in array.
    //     $dataStd[$i] = array($depts['dept_code'], $stds['dep_sum']);
    //     $i++;
    //   }
    // }

    //$sqlGetNumberStudent = "SELECT * FROM student WHERE term = " .$_POST['term'] . "AND year = " . $_POST['year'] . ""

    $sqlGetAllDepart = "SELECT department.name, department.code FROM subject INNER JOIN student ON student.subject_number = subject.subject_number LEFT JOIN department ON student.department_code = department.code WHERE subject.term = " . $_POST['term'] . " AND subject.year = " . $_POST['year'] . " GROUP BY department.code";
    $queryAllDepart = mysql_query($sqlGetAllDepart) or die('Get department error.');

    while ($queryAllDeparts = mysql_fetch_assoc($queryAllDepart)) {
      $department[$cDepartment] = $queryAllDeparts;
      $cDepartment++;
    }

    //Third, get subject have exam in term and year as you want.
    // $sqlGetSubject = "SELECT subject.*, student.*, department.name AS department_name FROM subject INNER JOIN student ON student.subject_number = subject.subject_number LEFT JOIN department ON student.department_code = department.code WHERE subject.term = " . $_POST['term'] . " AND subject.year = " . $_POST['year'] . " ORDER BY subject.day ASC, subject.start_time ASC, subject.end_time ASC, subject.subject_number, subject.section ASC";
    // $subject = mysql_query($sqlGetSubject) or die('Get subject error.');
    
    // while($subjects = mysql_fetch_assoc($subject)) {
    //   $dataSubject[$countSubject] = $subjects;
    //   $countSubject++; 
    // }

    // $sqlGetRoom = "SELECT * FROM room";
    // $room = mysql_query($sqlGetRoom) or die('Get room error.');

    // while($rooms = mysql_fetch_assoc($room)) {
    //   $dataRoom[$countRoom] = $rooms;
    //   $countRoom++;
    // }

    if(isset($dataSubject)) {
      // print_r($dataSubject);exit();
      for($i=0; $i<count($dataSubject); $i++) {
        $strNEnd = $dataSubject[$i]['start_time']. ' - ' .$dataSubject[$i]['end_time'];
        $subSec = $dataSubject[$i]['subject_number']. '-' .$dataSubject[$i]['section'];
        if(empty($setupDepart[$dataSubject[$i]['department_code']])) {
          $setupDepart[$dataSubject[$i]['department_code']] = $dataSubject[$i]['department_code'];
          $setupCount = 1;
        }else {
          $setupCount++;
          $formatStd[$dataSubject[$i]['department_code']]['people'] = $setupCount;
        }
        if(empty($stdDepart[$dataSubject[$i]['department_code']])) {
          $stdDepart[$dataSubject[$i]['department_code']] = $dataSubject[$i]['department_code'];
          $stdCount = 1;
        }else {
          $stdCount++;
          $formatStd[$dataSubject[$i]['department_code']]['people'] = $stdCount;
        }
        if(empty($formatStd[$dataSubject[$i]['department_code']]['subject'])) {
          $formatStd[$dataSubject[$i]['department_code']]['subjects'] = $dataSubject[$i]['subject_number'];
          $secCount = 1;
        }else {
          $secCount++;
          $formatStd[$dataSubject[$i]['department_code']]['subject_people'] = $secCount;
        }
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
    // print_r($formatStd);exit();
    function roomDevide($people, $dataRoom) {

    }

    function findFullRoom($people, $dataRoom) {
      if(isset($dataRoom)) {
        for($i=0; $i>count($dataRoom); $i++) {
          if($dataRoom[$i]['status'] == 'ว่าง') {
            if($people == $dataRoom[$i]['seat']) {
              return $dataRoom[$i];
            }
          }
        }
      }
    }

    function findRoom($people, $dataRoom) {
      $cFunction = 0;
      if(isset($dataRoom) && 0 < $people) {
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



    if(isset($formatSec) && isset($dataRoom)) {
      foreach ($formatSec as $key => $value) {
        $checkFullRoom = findFullRoom($formatSec[$key], $dataRoom);
        if($checkFullRoom) {

        }else if(!$checkFullRoom) {
          $checkRoom = findRoom($formatSec[$key], $dataRoom);
          if(!empty($checkRoom)) {
            $dataRoom[$checkRoom['key']]['status'] = 'ถูกใช้งานแล้ว';
            $formatSection[$key]['student'] = $formatSec[$key];
            $formatSection[$key]['room_number'] = $checkRoom['room_number'];
            $formatSection[$key]['room_id'] = $checkRoom['room_id'];
          }else {
            $checkRoom2 = roomDevide($formatSec[$key], $dataRoom);
          }
        }
      }
    }

    // $num_rows = count($subject);
    //echo $num_rows;
  }

  if(isset($_POST['confirmExam'])) {
    print_r("expression");exit();
    $dataSubject;
    $dataRoom;
    $countSubject = 0;
    $countRoom = 0;

    $sqlGetSubject = "SELECT subject.*, student.*, department.name AS department_name FROM subject INNER JOIN student ON student.subject_number = subject.subject_number LEFT JOIN department ON student.department_code = department.code WHERE subject.term = " . $temp['year'] . " AND subject.year = " . $temp['year'] . " ORDER BY subject.day ASC, subject.start_time ASC, subject.end_time ASC, subject.subject_number, subject.section ASC";
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
    <div class="row">
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
            <a class="navbar-brand" href="#">Brand</a>
          </div>

          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
              <li class="active"><a href="../application/manage-exam.php"><i class="glyphicon glyphicon-home padding-right"></i>หน้าหลัก</a></li>
              <li><a href="../application/manage-exam.php"><i class="glyphicon glyphicon-th-list padding-right"></i>จัดตารางสอบ</a></li>
              <li><a href="#"><i class="glyphicon glyphicon-search padding-right"></i>ตรวจสอบตารางสอบ</a></li>
              <li><a href="#">เปลี่ยนรหัสผ่าน</a></li>
              <li><a href="../application/contact-us.php">ติดต่อเรา</a></li>
            </ul>
          </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
      </nav>
    </div>
    
    <div class="row">
      <div class="container">
        <div class="col-sm-2">
          <a href="#sidebar" data-toggle="collapse"><i class="glyphicon glyphicon-align-justify"></i></a>
          <ul id="sidebar" class="nav nav-pills nav-stacked panel-collapse collapse">
            <li><a href="#">ข้อมูลวิชาสอบ</a></li>
            <li><a href="#">ข้อมูลห้องสอบ</a></li>
            <li><a href="#">ข้อมูลผู้สอบ</a></li>
            <li><a href="#">จัดห้องสอบอัตโนมัติ</a></li>
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
              if(!empty($department)) {
          ?>
                <select id="selectDepartment" class="form-control" style="width:30%; display:inline-block;">
                  <?php for($i=0; $i<count($department); $i++) { ?>
                    <option value="<?php echo $department[$i]['code']; ?>"><?php echo $department[$i]['name']; ?></option>
                  <?php } ?>
                </select>
                <input type="hidden" id="year_depart" name="year_depart" value="<?php echo $temp['year']; ?>">
                <input type="hidden" id="term_depart" name="term_depart" value="<?php echo $temp['term']; ?>">
                <input type="submit" name="confirmExam" class="btn btn-success" value="ยืนยัน" onclick="callExamPlan()">
            <?php }else { ?>
              <div class="alert alert-danger text-center" role="alert">
                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                <span class="sr-only">ผิดพลาด:</span>
                ไม่พบข้อมูลที่คุณต้องการ
              </div>
            <?php } ?>
          <?php } ?>
          <?php if(isset($_POST['confirmExam'])) { ?>
            <select class="form-control" style="width:30%; display:inline-block;">
              <?php for($i=0; $i<count($department); $i++) { ?>
                <option><?php echo $department[$i]['name']; ?></option>
              <?php } ?>
            </select>
          <?php } ?>
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