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
  $sql = "SELECT room_id, build, floor, room_number, seat FROM room WHERE room_id = " . $_GET['id'];
  $result = mysql_query($sql);

  while($roomsData = mysql_fetch_assoc($result)) {
    $data = $roomsData;
  }
}


if(isset($_POST['btnSubmit']) && isset($_POST['id'])) {
  $id = $_POST['id'];
  if(empty($id)) {
    addRoom($_POST['building'], $_POST['floor'], $_POST['roomNumber'], $_POST['seat']);
  }else if(!empty($id)) {
    updateRoom($_POST['id'], $_POST['building'], $_POST['floor'], $_POST['roomNumber'], $_POST['seat']);
  }
}

function addRoom($build, $floor, $number, $seat) {
  $sql = "INSERT INTO room (build, floor, room_number, seat, remain, status) VALUE ('$build', '$floor', '$number', $seat, $seat, 'ว่าง')";

  mysql_query($sql) or die('Insert room failed.');
}

function updateRoom($id, $build, $floor, $number, $seat) {
  $sql = "UPDATE room SET build = " . $build . " , floor = " . $floor . " , room_number = " . $number . " , seat = " . $seat
        . " WHERE room_id = " . $id;

  mysql_query($sql) or die('Update room failed.');
}

$sql = "SELECT room_id, build, floor, room_number, seat FROM room";
$room = mysql_query($sql) or die('Get room failed.');

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
        text-align: cenetr;
      }
    </style>

  </head>

  <body>
    <div class="row backgroud-green">
      <div class="container" >
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
        <!-- Start Content -->

        <div class="col-sm-10">
          <!-- block head in manage-exam -->
          <blockquote>

            <form name="addRoom" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
              <h3 class="text-center">ข้อมูลห้องสอบ</h3>

              <input name="id" type="hidden" value="<?php if(isset($data)) { echo $data['room_id']; } ?>" />
              
              <div class="row">
                <div class="col-md-6">
                  <div class="input-group area-padding">
                    <span class="input-group-addon" id="building">ตึก</span>
                    <input name="building" type="number" class="form-control" aria-describedby="building" min="0" 
                      max="100" value="<?php if(isset($data)) { echo $data['build']; } ?>" required="true" />
                  </div>
                
                  <div class="input-group area-padding">
                    <span class="input-group-addon" id="floor">ชั้น</span>
                    <input name="floor" type="number" class="form-control" aria-describedby="floor" min="0"
                      max="10" value="<?php if(isset($data)) { echo $data['floor']; } ?>" required="true"/> 
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="input-group area-padding">
                    <span class="input-group-addon" id="room-number">รหัสห้องสอบ</span>
                    <input name="roomNumber" type="number" class="form-control" aria-describedby="room-number" min="0" 
                      max="999" value="<?php if(isset($data)) { echo $data['room_number']; } ?>" required="true"/>
                  </div>
                  
                  <div class="input-group area-padding">
                    <span class="input-group-addon" id="seat">จำนวนที่นั่งสอบ</span>
                    <input name="seat" type="number" class="form-control" aria-describedby="seat" min="0"
                      max="999" value="<?php if(isset($data)) { echo $data['seat']; } ?>" required="true"/> 
                  </div>
                </div>
              </div>

              <div class="area-padding text-center">
                <input name="btnSubmit" type="submit" class="btn btn-primary area-padding" style="width: 100px;" value="เพิ่ม">
              </div>
              
            </form>

              <hr/>
          </blockquote>

            <div class="container-fluid">
              <table class="table table-hover text-center" border="1">
                <thead>
                  <tr>
                    <th class="text-center">ลำดับ</th>
                    <th class="text-center">ตึก</th>
                    <th class="text-center">ชั้น</th>
                    <th class="text-center">รหัสห้องสอบ</th>
                    <th class="text-center">จำนวนที่นั่งสอบ</th>
                    <th class="text-center">แก้ไข</th>
                    <th class="text-center">ลบ</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  //if(isset($room)) {
                    while($rooms = mysql_fetch_assoc($room)) {
                  ?>
                      <tr>
                        <td><?php echo $numberOrder++; ?></td>
                        <td><?php echo $rooms['build'] ?></td>
                        <td><?php echo $rooms['floor']; ?></td>
                        <td><?php echo $rooms['room_number']; ?></td>
                        <td><?php echo $rooms['seat']; ?></td>
                        <td><a href="<?php echo $url . '/aoffy/application/room.php' . '?id=' . $rooms['room_id']; ?>" style="color: black;"><span class="glyphicon glyphicon-edit"></span></a></td>
                        <td><a href="#" style="color: black;"><span class="glyphicon glyphicon-trash"></span></a></td>
                      </tr>
                  <?php
                    //}
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