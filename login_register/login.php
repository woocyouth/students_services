<?php
header('Content-Type:text/html;charset=utf-8');

//连接数据库，设置字符集，选择数据库
@mysql_connect('localhost','root','123456') or die('数据库连接失败！');
mysql_query('set names utf8');
mysql_query('use `itcast`') or die('itcast数据库不存在！');

$error = array();	//保存错误信息

//当有表单提交时
if(!empty($_POST)){
	
	//接收用户登录表单
	$username = isset($_POST['username']) ? trim($_POST['username']) : '';
	$password = isset($_POST['password']) ? $_POST['password'] : '';

	//载入表单验证函数库，验证用户名和密码格式
	require '../check_form.lib.php';
	if(($result = checkUsername($username)) !== true)  $error[] = $result;
	if(($result = checkPassword($password)) !== true)  $error[] = $result;

	//表单验证通过，再到数据库中验证
	if(empty($error)){

		//SQL转义
		$username = mysql_real_escape_string($username);

		//根据用户名取出用户信息
		$sql = "select `id`,`password`,`salt` from `user` where `username`='$username'";
		if($rst = mysql_query($sql)){           //执行SQL，获得结果集
			$row = mysql_fetch_assoc($rst);     //处理结果集

			//数据库密码加密
			$password_db = md5($row['salt'].md5($password));

			if($password_db == $row['password']){  //判断密码是否正确
				
				//判断用户是否勾选了记住密码
				if(isset($_POST['auto_login']) && $_POST['auto_login']=='on'){

					//将用户名和密码保存到COOKIE，并对密码加密
					$ua = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
					$password_cookie = md5($row['password'].md5($ua.$row['salt']));
					$cookie_expire = time()+2592000;                        //保存1个月(60*60*24*30)
					setcookie('username',$username,$cookie_expire);         //保存用户名
					setcookie('password',$password_cookie,$cookie_expire);  //保存密码
				}

				//登录成功，保存用户会话
				session_start();
				$_SESSION['userinfo'] = array(
					'id' => $row['id'],      //将用户id保存到SESSION
					'username' => $username  //将用户名保存到SESSION
				);

				//登录成功，跳转到会员中心
				header('Location: ../user_log.php');

				//终止脚本继续执行
				die;
			}
		}
		$error[] = '用户名不存在或密码错误。';
	}
}

//当COOKIE中存在登录状态时
if(isset($_COOKIE['username']) && isset($_COOKIE['password'])){
	
	//取出用户名和密码
	$username = $_COOKIE['username'];
	$password = $_COOKIE['password'];

	//SQL转义
	$username = mysql_real_escape_string($username);
	//根据用户名取出用户信息
	$sql = "select `id`,`password`,`salt` from `user` where `username`='$username'";
	if($rst = mysql_query($sql)){           //执行SQL，获得结果集
		$row = mysql_fetch_assoc($rst);     //处理结果集

		//计算COOKIE密码
		$ua = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
		$password_cookie = md5($row['password'].md5($ua.$row['salt']));

		//比对COOKIE密码
		if($password == $password_cookie){

			//登录成功，保存用户会话
			session_start();
			$_SESSION['userinfo'] = array(
				'id' => $row['id'],      //将用户id保存到SESSION
				'username' => $username  //将用户名保存到SESSION
			);

			//登录成功，跳转到会员中心
			header('Location: ../user_log.php');

			//终止脚本继续执行
			die;
		}
	}
	$error[] = '登录状态已失效，请重新登录。';
}

//加载HTML模板文件
define('test','itcast');
require '../login_register/login_html.php';