<?php if(!defined('test')) die('error!'); ?>
<!doctype html>
<html>
<head>

<meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title>欢迎登录</title>

<link rel="stylesheet" href="../CSS/log_html_style.css">
<link rel="stylesheet" href="../CSS/animate.css">
        <style>
            body{
                background-image:url('../images/208_n.jpg');
                background-size: cover;
                animation: bounceInDown 2s linear;
            }
            .connect p{  
                animation: bounceInLeft 2.5s linear;
            }
        </style>
</head>
<body>

        
        <div class="login-container">
	<h1>登录</h1>
	
	<div class="connect">
		<p>www.woocyouth.cn</p>
	</div>
	
        <form action="../login_register/login.php" method="post" id="loginForm">
		<div>
			<input type="text" name="username" class="username" placeholder="用户名" autocomplete="off"/>
		</div>
		<div>
			<input type="password" name="password" class="password" placeholder="密码" oncontextmenu="return false" onpaste="return false" />
		</div>
            
            <input name="auto_login" class="checkbox" id="auto_login" type="checkbox" value="on"><label for="auto_login" class="la_che">下次自动登录</label>
            
            <button id="submit" type="submit">登 陆</button>
	</form>

	<a href="../login_register/register.php">
		<button type="button" class="register-tis">还有没有账号？</button>
	</a>
   <?php if(!empty($error)): ?>
	<div class="error-box">
		<ul><?php foreach($error as $v) echo "<li class='error_li'>$v</li>"; ?></ul>
	</div>
<?php endIf; ?>
</div>  
 
    <div class="foot_a">
        <a href="http://www.beian.miit.gov.cn/" class="f_a">阿里云备案|粤ICP备19066038号-2</a>
    </div>
</body>
</html>