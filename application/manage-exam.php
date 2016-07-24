<?
  require_once 'connect.php';

  $sql = "SELECT * FROM subject";
  $result = mysql_query($sql) or die('Select Error.');
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
              <li class="active"><a href="#"><i class="glyphicon glyphicon-home padding-right"></i>หน้าหลัก</a></li>
              <li><a href="#"><i class="glyphicon glyphicon-th-list padding-right"></i>จัดตารางสอบ</a></li>
              <li><a href="#"><i class="glyphicon glyphicon-search padding-right"></i>ตรวจสอบตารางสอบ</a></li>
              <li><a href="#">เปลี่ยนรหัสผ่าน</a></li>
              <li><a href="#">ติดต่อเรา</a></li>
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
          <blockquote>
            <h3>จัดตารางสอบ</h3><hr/>
            <footer>ข้อมูลรายวิชาที่จัดสอบสอบ</footer>
          </blockquote>
          <div class="container-fluid">
          
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>วันที่</th>
                  <th>เวลา</th>
                  <th>รหัสวิชา</th>
                  <th>ชื่อวิชา</th>
                  <th>ตอนที่</th>
                </tr>
              </thead>

              <?php
                while($subject = mysql_fetch_assoc($result)) {
              ?>

              <tbody>
                <tr>
                  <td><?php echo $subject['day'] ?></td>
                  <td><?php echo $subject['start_time'] . ' - ' . $subject['end_time'] ?></td>
                  <td><?php echo $subject['subject_number'] ?></td>
                  <td><?php echo $subject['name'] ?></td>
                  <td><?php echo $subject['section'] ?></td>
                </tr>
              </tbody>

              <?php
                }
              ?>

            </table>

            <div class="container-fluid text-center">
              <button type="button" class="btn btn-primary"><i class="glyphicon glyphicon-plus padding-right"></i>เพิ่ม</button>
            </div>
          </div><hr/>
          <div class="container-fluid">
            <table class="table table-bordered">
              <thread>
                <th>วันที่</th>
                <th>เวลา</th>
                <th>รหัสวิชา</th>
                <th>ชื่อวิชา</th>
                <th>ตอนที่</th>
                <th>ตัวเลือก</th>
              </thread>
              <tr>
                <td>12/09/59</td>
                <td>12.09 น.</td>
                <td>5002923</td>
                <td>Thai study</td>
                <td>4</td>
                <td><i class="glyphicon glyphicon-pencil padding-right icon-color-edit"></i>| <i class="glyphicon glyphicon-remove icon-color-delete"></i></td>
              </tr>
              <tr>
                <td>12/09/59</td>
                <td>12.09 น.</td>
                <td>5002923</td>
                <td>Thai study</td>
                <td>4</td>
                <td><i class="glyphicon glyphicon-pencil padding-right icon-color-edit"></i>| <i class="glyphicon glyphicon-remove icon-color-delete"></i></td>
              </tr>
            </table>
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