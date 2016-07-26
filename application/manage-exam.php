<?php
  require_once 'connect.php';

  if(isset($_POST['btnSubmit']) && $_POST['btnSubmit'] == 'เริ่มจัดอัตโนมัติ') {
    //main manage_exam concept.
    $i = 0;
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

    //First, get department will take exam in term and year as you want.
    $sqlGetDept = "SELECT std.department_code AS dept_code, dep.name AS dept_name, std.subject_number AS subject_number, std.section AS section FROM student AS std, department AS dep WHERE std.term = " . $_POST['term'] ." AND std.year = " . $_POST['year'] . " AND std.department_code = dep.code GROUP BY std.department_code";
    $dept = mysql_query($sqlGetDept) or die('Get department error.');
    $num_rows_dept = mysql_num_rows($dept);

    while($depts = mysql_fetch_assoc($dept)) {
      //Second, count student each department.
      $sqlCountStd = "SELECT COUNT(department_code) AS dep_sum FROM student WHERE department_code = '" . $depts['dept_code'] . "'";
      $std = mysql_query($sqlCountStd) or die('Count student error.');

      while($stds = mysql_fetch_assoc($std)) {
        //save department_code and count of student in array.
        $dataStd[$i] = array($depts['dept_code'], $stds['dep_sum']);
        $i++;
      }
    }

    //Third, get subject have exam in term and year as you want.
    $sqlGetSubject = "SELECT * FROM subject WHERE term = " . $_POST['term'] . " AND year = " . $_POST['year'] . " ORDER BY day ASC";
    $subject = mysql_query($sqlGetSubject) or die('Get subject error.');
    
    $sqlGetRoom = "SELECT * FROM room";
    $room = mysql_query($sqlGetRoom) or die('Get room error.');

    while($rooms = mysql_fetch_assoc($room)) {
      $dataRoom[$countRoom] = $rooms;
      $countRoom++;
    }

    if(isset($dataStd) && isset($dataRoom)) {
    //Forth, get student case student equal room and save in variable for use future.
      for($i=0; $i<count($dataStd); $i++) {
        for($j=0; $j<count($dataRoom); $j++) {
          if($dataStd[$i][1] == $dataRoom[$j]['seat']) {
            $success[$countSucc] = array($dataStd[$i][0], $dataStd[$i][1], $dataRoom[$j]['room_number'], $dataRoom[$j]['seat'], $dataRoom[$j]['seat']-$dataStd[$i][1]);
            $countSucc++;
            $makeRoom = array_slice($dataRoom, $j);
            $makeStd = array_slice($dataStd, $i);
          }else {
            $fail[$countFail] = array($dataStd[$i][0], $dataStd[$i][1], $dataRoom[$j]['room_number'], $dataRoom[$j]['seat'], $dataRoom[$j]['seat']-$dataStd[$i][1]);
            $countFail++;
          }
        }
      }

      if(isset($fail)) {
        // for($i=0; $i<count($fail); $i++) {
        //   for($j=0; $j<count($makeStd); $j++) {
        //     if($makeStd[$j][0] == $fail[$i][0]) {

        //     }
        //   }
        // }
        if(isset($success)) {
          for($i=0; $i<count($success); $i++) {
            for($j=0; $j<count($fail); $j++) {
              if($success[$i][0] != $fail[$j][0]) {
                $realFail[$countRealFail] = $fail[$j];
                $countRealFail++;
              }
            }
            $real_auto['department'][$success[$i][0]] = $success[$i][0];
            $real_auto['room_number'][$success[$i][0]] = $success[$i][2];
            $real_auto['distance'][$success[$i][0]] = $success[$i][4];
          }
        }else {
          $realFail = $fail;
        }

        if(isset($realFail)) {
          for($i=0; $i<count($realFail); $i++) {
            $auto_data[$i]['department'] = $realFail[$i][0];
            $auto_data[$i]['room_number'] = $realFail[$i][2];
            $auto_data[$i]['distance'] = $realFail[$i][4];
            for($j=0; $j<count($dataStd); $j++) {
              if($dataStd[$j][0] == $auto_data[$i]['department']) {
                $real_auto['department'][$auto_data[$i]['department']] = $auto_data[$i]['department'];
                if($auto_data[$i]['distance'] > 0) {
                  if($i != 0) {
                    if($auto_data[$i]['distance'] < $auto_data[$i-1]['distance'] || $auto_data[$i-1]['distance'] < 0) {
                      $real_auto['distance'][$auto_data[$i]['department']] = $auto_data[$i]['distance'];
                      $real_auto['room_number'][$auto_data[$i]['department']] = $auto_data[$i]['room_number'];
                    }
                  }
                }
              }
            }
          }
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
              <table class="table table-hover">
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

                <?php
                  while($subjects = mysql_fetch_assoc($subject)) {
                ?>

                <tbody>
                  <tr>
                    <td><?php echo $subjects['day'] ?></td>
                    <td><?php echo $subjects['start_time'] . ' - ' . $subjects['end_time'] ?></td>
                    <td><?php echo $subjects['subject_number'] ?></td>
                    <td><?php echo $subjects['name'] ?></td>
                    <td><?php echo $subjects['section'] ?></td>
                    <td><?php echo $subjects['section'] ?></td>
                  </tr>
                </tbody>

                <?php
                  }
                ?>
              </table>

            </div><hr/>

          <?php } /* end else if */ } /* end if */ ?>

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