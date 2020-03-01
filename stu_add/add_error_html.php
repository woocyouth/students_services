<?php if(!defined('test')) die('error!'); ?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>欢迎注册</title>
<link type="text/css" rel="stylesheet" href="../CSS/add_error_html.css">
</head>
<body>
<div class="error-box">
	<span>添加失败|错误信息如下</span>
    <ul>
        <?php foreach($error as $v) echo "<li>$v</li>"; ?>
    </ul>
        <button class="button" onclick="window.location.href='./add.php'">返回添加页面</button>
</div>
</body>
</html>