<?php if(!defined('test')) die('error!');?>
<!doctype html>
<html lang="en">
<head>
<title>学生管理系统</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<!-- VENDOR CSS -->
<link rel="stylesheet" type="text/css" href="http://apps.bdimg.com/libs/bootstrap/3.3.4/css/bootstrap.css">
<link rel="stylesheet" href="CSS/contain_main.css">
<link rel="stylesheet" href="CSS/contain_style.css">
</head>

<body>
<div id="loading">
   	 <div></div>
	 <div></div>
	 <span></span>
</div>
<!-- WRAPPER -->
<div id="wrapper"> 
  <!-- NAVBAR -->
  <nav class="navbar navbar-default navbar-fixed-top">
    <div class="brand">
        <a href="#"><img src="./images/stu_logo.png" alt="Klorofil Logo" class="img-responsive logo" width="139" height="21"></a>
      
    </div>
    <div class="container-fluid">
      <div class="navbar-btn" style="padding: 0; padding-top: 10px;">
          <button type="button" class="btn-toggle-fullwidth btn-toggle-mx"><img src="./images/left.png" height="40px" alt=""></button>
      </div>
        <img src="./images/user_2.png" width="30" height="30" class="icon_user">
        <form class="user_lo" action="./login_register/login.php" method="post">
            <?php if($login):?>
            <div class="user"><span class="u">"<?php echo $userinfo['username'];?>"</span>&nbsp;管理员，欢迎来到学生管理中心&nbsp;&nbsp;&nbsp;<a href="?action=logout" class="u">退出</a></div>
                <?php else: ?>
                <div class="error-box">您还未登录，请先 <a href="./login_register/login.php" class="log">登录</a> 或 <a href="./login_register/register.php" class="log">注册新用户</a> </div>
                <?php endif;?>
        </form>
    </div>
      
  </nav>
  <!-- END NAVBAR --> 
  <!--_________________________________________________________________________________________--> 
  <!-- LEFT SIDEBAR -->
  <div id="sidebar-nav" class="sidebar">
    <div class="sidebar-scroll">
      <nav>
         <ul class="nav">
             <li><a href="./index_contain/test.php" target="_blank" class="iframe_link active"><span>学生信息表</span></a></li>
             <li><a href="./stu_add/add.php" target="_blank" class="iframe_link"><span>添加学生</span></a></li>
		  <li> 
			<a href="javascript:;" class="nav-togg"> <span>其它</span> </a>
            <div>
              <ul>
                  <li><a href="./website_file/file.php" target="_blank" class="iframe_link"><span>文件管理</span></a></li>
                  <li><a href="./about.html" target="_blank" class="iframe_link"><span>关于我们</span></a></li>
              </ul>
            </div>
          </li>
        </ul>
      </nav>
    </div>
  </div>
  <div class="main">
    <div class="main-content" style="height: 100%;">
        <iframe src="./index_contain/test.php" class="iframe_mx uicss-cn"></iframe>
    </div>
  </div>
</div>
<script src="./js/jquery.min.js"></script>
<script src="./js/bootstrap.min.js"></script> 
<script src="./js/jquery.slimscroll.min.js"></script>
<script src="./js/klorofil-common.js" ></script> 

</body>
</html>