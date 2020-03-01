<?php if (!defined('APP')) die('error!'); ?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>欢迎注册</title>
        <link rel="stylesheet" href="../CSS/log_html_style.css">
        <link rel="stylesheet" href="../CSS/animate.css">
        <style>
            body{
                background-image:url('../images/208_v.jpg');
                background-size: cover;
                animation: bounceInDown 2s linear;
            }
            .connect p{  
                animation: bounceInLeft 2.5s linear;
            }
        </style>
    </head>
    <body>
        <div class="register-container">
	<h1>欢迎注册</h1>
	
	<div class="connect">
		<p>Welcome to join us.</p>
	</div>
        <form method="post" id="registerForm" action="../login_register/register.php" onsubmit="return checkForm()"  >
          
                
                <div><input type="text" name="username" class="username" placeholder="您的用户名" autocomplete="off"/></div>
                <div><input type="text" name="email" class="email" placeholder="输入邮箱地址" /></div>
                <div><input type="password" name="password" class="password" placeholder="输入密码"  /></div>
                <div><input type="password" class="confirm_password" placeholder="再次输入密码"/></div>
                <div><input type="text" name="captcha" placeholder="验证码"/></div> 
                <div><img class="code_img" src="../login_register/code.php" alt="" id="code_img"/><a class="look" href="#" id="change">看不清，换一张</a></div>               
                <div>
                        <button id="submit" type="submit" name="res">注 册</button>
                        <button type="button" class="register-tis" onclick="location.href = './login.php'" >已经有账号？</button>
                </div>     
        </form>
        </div>
        <?php if (!empty($error)): ?>
            <div class="error-box">
                <ul><?php foreach ($error as $v)
                 echo "<li class='error_li'>$v</li>";
            ?></ul>
            </div>
    <?php endIf; ?>
        <script>
            var change = document.getElementById("change");
            var img = document.getElementById("code_img");
            change.onclick = function () {
                img.src = "../login_register/code.php?t=" + Math.random(); //增加一个随机参数，防止图片缓存
                return false; //阻止超链接的跳转动作
            }
        </script>
    </body>
    
</html>