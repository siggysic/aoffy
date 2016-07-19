<html lang="en">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../lib/css/bootstrap.min.css">

    <script type="text/javascript" src="../lib/js/jquery-3.1.0.min.js"></script>

    <style type="text/css">
      .padding-rgiht{
        padding-right: 5px;
      }
      .footer{
        position: absolute;
        bottom: 0;
        width: 100%;
        height: 40px;
        background-color: #e6e6e6;
      }
    </style>
  </head>

  <body>
    <div class="row">
<!--       <img src="img/kmutnb.png" class="img-logo"> -->
      <div class="container">
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
              <li class="active"><a href="#"><i class="glyphicon glyphicon-home padding-rgiht"></i>หน้าหลัก</a></li>
              <li><a href="#"><i class="glyphicon glyphicon-th-list padding-rgiht"></i>จัดตารางสอบ</a></li>
              <li><a href="#"><i class="glyphicon glyphicon-search padding-rgiht"></i>ตรวจสอบตารางสอบ</a></li>
              <li><a href="#">เปลี่ยนรหัสผ่าน</a></li>
              <li><a href="#">ติดต่อเรา</a></li>
            </ul>
          </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
      </nav>
    </div>
    
    <div class="container">
      <div class="row">
        <div class="col-sm-2">
          <ul id="sidebar" class="nav nav-stacked affix">
            <li></li>
            <li><a href="#">ข้อมูลวิชาสอบ</a></li>
            <li><a href="#">ข้อมูลห้องสอบ</a></li>
            <li><a href="#">ข้อมูลผู้สอบ</a></li>
            <li><a href="#">จัดห้องสอบอัตโนมัติ</a></li>
          </ul>
        </div>
        <div class="col-sm-10">
          <blockquote>
            <h3>จัดตารางสอบ</h3><hr/>
            <footer>ข้อมูลรายวิชาสอบ</footer>
          </blockquote>
        </div>
      </div>
    </div>

    <div class="footer">
      <h5 class="text-center">คณะครุฑศาสตร์อุตสาหกรรม มหาวิทยาลัยเทคโนโลยีพระจอมเกล้าพระนครเหนือ</h5>
    </div>

  </body>

</html>