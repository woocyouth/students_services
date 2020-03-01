<?php 
header('Content-type:text/html;charset=utf-8');

require '../stu_add/add_check.php';
require '../function.php';
dbInt();
//从数据库中获取id的最大值
$id_sql = "select MAX(`id`) from students;";
$g_id = mysql_query($id_sql);
$g_id_fe = mysql_fetch_array($g_id); 

//定义用户信息：id和姓名
$info = array('id' => $g_id_fe[0]+1);

//判断是否上传头像
if(!empty($_FILES['pic'])){	
	//获取用户上传文件信息
	$pic_info = $_FILES['pic'];
	
	//判断文件上传到临时文件是否出错
	if($pic_info['error'] >0){
		$error_msg = '上传错误:';
		switch($pic_info['error']){
			case 1: $error_msg .= '文件大小超过了php.ini中upload_max_filesize选项限制的值！'; break;
			case 2: $error_msg .= '文件大小超过了表单中max_file_size选项指定的值！'; break;
			case 3: $error_msg .= '文件只有部分被上传！'; break;
			case 4: $error_msg .= '没有文件被上传！'; break;
			case 6: $error_msg .= '找不到临时文件夹！'; break;
			case 7: $error_msg .= '文件写入失败！'; break;
			default: $error_msg .='未知错误！'; break; 
		}
		echo $error_msg;
		return false;
	}
	
	//获取上传文件的类型
	$type = substr(strrchr($pic_info['name'],'.'),1);
	//判断上传文件类型
	if($type !== 'jpg'){
		echo '图像类型不符合要求，允许的类型为:jpg';
		return false;
	}

	//获取原图图像大小
	list($width, $height) = getimagesize($pic_info['tmp_name']);
	//设置缩略图的最大宽度和高度
	$maxwidth = $maxheight= 90;
	//自动计算缩略图的宽和高
	if($width > $height){
		//缩略图的宽等于$maxwidth
		$newwidth = $maxwidth;
		//计算缩略图的高度
		$newheight = round($newwidth*$height/$width);
	}else{
		//缩略图的高等于$maxwidth
		$newheight = $maxheight;
		//计算缩略图的高度
		$newwidth = round($newheight*$width/$height);
	}
	//绘制缩略图的画布
	$thumb = imageCreateTrueColor($newwidth,$newheight);
	//依据原图创建一个与原图一样的新的图像
	$source = imagecreatefromjpeg($pic_info['tmp_name']);
	//依据原图创建缩略图
	/**
	  *@param $thumb 目标图像
	  *@param $source 原图像
	  *@param 0,0,0,0 分别代表目标点的x坐标和y坐标，源点的x坐标和y坐标
	  *@param $newwidth 目标图像的宽
	  *@param $newheight 目标图像的高
	  *@param $width 原图像的宽
	  *@param $height 原图像的高
	  */
	imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
	//设置缩略图保存路径
	$new_file = '../images/w_images/'.$info['id'].'.jpg';
	//保存缩略图到指定目录
	imagejpeg($thumb,$new_file,100);
}



//定义数组$skill保存预设的语言技能复选框
$skill = array('HTML','JavaScript','PHP','C++');
if(!empty($_POST)){
	$save_data = array();

//判断表单中各字段是否都已填写
$check_fields = array(
    's_name' => '姓名',
    's_num' => '学号',
    'sex' => '性别',
    'd_num' => '宿舍号',
    's_hb' => '爱好',
    'skill' => '语言技能'
);

foreach($check_fields as $k => $v){
	if(empty($_POST[$k])){
		echo "<script>";
                echo "alert('";
                echo $v;
                echo "不能为空');</script>";
                die();
	}
        $save_data[$k] = $_POST[$k];
}

//复选框处理
	if(is_array($save_data['skill'])){
		$save_data['skill'] = array_intersect($skill,$save_data['skill']);	//只取出合法的数组元素
		$save_data['skill'] = implode(',',$save_data['skill']);  //将数组转换为用逗号分隔的字符串	

	}else{
		$save_data['skill'] = '';
	}


$validate = array(
	's_name' => 'checks_name',
	's_num' => 'checks_num',
	'sex' => 'checksex',
        'd_num' => 'checkd_num',
);

//$error数组保存验证失败时的错误信息
$error = array();

//循环验证每个字段，保存错误信息
foreach($validate as $k=>$v){
	//运用可变函数，实现不同字段调用不同函数
	$result = $v($save_data[$k]);
	if($result !== true){
		$error[] = $result;
	}
}

//如果$error数组为空，说明没有错误
if(!empty($error)){
//加载HTML模板文件
define('test','itcast');
require '../stu_add/add_error_html.php';
	die;
}

//接收需要处理的表单字段
$s_name = $_POST['s_name'];
$s_num = $_POST['s_num'];
$sex = $_POST['sex'];
$d_num = $_POST['d_num'];
$s_hb = $_POST['s_hb'];
$skill = $_POST['skill'];

//防止SQL注入
$s_name = mysql_real_escape_string($s_name);

//判断用户名是否存在
$sql = "select `id` from `students` where `s_name`='$s_name'";
$rst = mysql_query($sql);
if(mysql_fetch_row($rst)){
	die('用户名已经存在，请换个用户名。');
}

//通过循环数组，自动拼接SQL语句，保存到数据库中
	$sql = "insert into `students` (`s_name`,`s_num`,`sex`,`d_num`,`s_hb`,`skill`) values (";
	foreach($save_data as $k=>$v){

		$sql .= "'".mysql_real_escape_string($v)."',"; //拼接每个字段的SQL语句，并对值进行SQL安全转义
	}
	$sql = rtrim($sql,',')." );"; //rtrim($sql,',')用于去除$sql中的最后一个逗号

//输出执行的SQL语句和执行结果，便于调试程序
//echo "SQL语句：$sql<br>";
if($res = query($sql)){
		//成功时返回到 showList.php
		header('Location: ../index_contain/test.php');
		//停止脚本
		die;
	}else{
		//执行失败
		die('添加学生失败！');
	}
}



define('test', 'itcast');
include '../stu_add/add_html.php';