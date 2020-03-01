<?php

//设定字符集
header('Content-Type:text/html;charset=utf-8');

$error = array();	//保存错误信息
//开启session
@session_start();
//封装函数：载入HTML模板文件
function showRegPage(){

	$error = $GLOBALS['error'];//从全局变量读取错误信息
	
	define('APP','itcast');
	require '../login_register/register_html.php';

	die;  //终止程序继续执行
}

//没有表单提交时，显示注册页面
if(empty($_POST)){
	showRegPage();
}

////获取用户输入的验证码字符串



//执行到此处说明有表单提交

//判断表单中各字段是否都已填写
$check_fields = array(
    'username' => '用户',
    'password' => '密码',
    'email' => '邮箱');
foreach($check_fields as $k => $v){
	if(empty($_POST[$k])){
		$error[] = $k.'字段不能为空！';
	}
}
if(!empty($error)){
	showRegPage();  //显示错误信息并停止程序
}

//连接数据库，设置字符集，选择数据库
@mysql_connect('localhost','root','') or die('数据库连接失败！');
mysql_query('set names utf8');
mysql_query('use `itcast`') or die('itcast数据库不存在！');

//接收需要处理的表单字段
$username = trim($_POST['username']);
$password = $_POST['password'];
$email = trim($_POST['email']);

//载入表单验证函数库，验证用户名和密码格式
require '../check_form.lib.php';
if(($result = checkUsername($username)) !== true)  $error[] = $result;
if(($result = checkPassword($password)) !== true)  $error[] = $result;
if(($result = checkEmail($email)) !== true)  $error[] = $result;
if(!empty($error)){
	showRegPage();  //显示错误信息并停止程序
}
if(!empty($_POST)){
      //获取用户输入的验证码字符串
$code = isset($_POST['captcha']) ? trim($_POST['captcha']) : '';

//判断SESSION中是否存在验证码
if(empty($_SESSION['captcha_code'])){
	die('验证码已过期，请重新登录。');
}

//将字符串都转成小写然后再进行比较
if (strtolower($code) == strtolower($_SESSION['captcha_code'])){
	 echo '验证码正确';	 
} else{
	echo "<script> alert('验证码输入错误');</script>";
        die;
}
unset($_SESSION['captcha_code']); //清除SESSION数据
}


//SQL转义
$username = mysql_real_escape_string($username);
$email = mysql_real_escape_string($email);

//判断用户名是否存在
$sql = "select `id` from `user` where `username`='$username'";
$rst = mysql_query($sql);
if(mysql_fetch_row($rst)){
	$error[] = '用户名已经存在，请换个用户名。';
	showRegPage();  //显示错误信息并停止程序
}

//生成密码盐
$salt = md5(uniqid(microtime()));

//提升密码安全
$password = md5($salt.md5($password));

//拼接SQL语句
$sql = "insert into `user` (`username`,`password`,`salt`,`email`) values ('$username','$password','$salt','$email')";

//执行SQL语句
$rst = mysql_query($sql);

if($rst){

	//用户注册成功，自动登录
	@session_start();
	
	//获取新注册用户的ID
	$id = mysql_insert_id();
	
	$_SESSION['userinfo'] = array(
		'id' => $id,				//将用户id保存到SESSION
		'username' => $username		//将用户名保存到SESSION
	);

	//注册成功，自动跳转到会员中心
	echo '<script>alert("注册成功！");window.location.href="../user_log.php"; </script>';
	die;
}else{
	$error[] = '注册失败，数据库操作失败。';
	showRegPage();  //显示错误信息并停止程序
}
