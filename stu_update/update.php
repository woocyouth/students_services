<?php

header('content-type:text/html;charset=utf-8');
require '../function.php';

dbInt();

$id = isset($_GET['id']) ? $_GET['id'] : 0;
$w_q = mysql_query("select s_name from students where `id` = '$id';");
$water_name = mysql_fetch_assoc($w_q);

//bianjitouxiang
//定义用户信息：id和姓名
$info = array('id' => $id, 'name' => $water_name['s_name']);

//判断是否上传头像
if (!empty($_FILES['pic'])) {
    //获取用户上传文件信息
    $pic_info = $_FILES['pic'];

    //判断文件上传到临时文件是否出错
    if ($pic_info['error'] > 0) {
        $error_msg = '上传错误:';
        switch ($pic_info['error']) {
            case 1: $error_msg .= '文件大小超过了php.ini中upload_max_filesize选项限制的值！';
                break;
            case 2: $error_msg .= '文件大小超过了表单中max_file_size选项指定的值！';
                break;
            case 3: $error_msg .= '文件只有部分被上传！';
                break;
            case 4: $error_msg .= '没有文件被上传！';
                break;
            case 6: $error_msg .= '找不到临时文件夹！';
                break;
            case 7: $error_msg .= '文件写入失败！';
                break;
            default: $error_msg .= '未知错误！';
                break;
        }
        echo "<script> alert('$error_msg');</script>";
        return false;
    }

    //获取上传文件的类型
    $type = substr(strrchr($pic_info['name'], '.'), 1);
    //判断上传文件类型
    if ($type !== 'jpg') {
        echo '图像类型不符合要求，允许的类型为:jpg';
        return false;
    }

    //获取原图图像大小
    list($width, $height) = getimagesize($pic_info['tmp_name']);
    //设置缩略图的最大宽度和高度
    $maxwidth = $maxheight = 90;
    //自动计算缩略图的宽和高
    if ($width > $height) {
        //缩略图的宽等于$maxwidth
        $newwidth = $maxwidth;
        //计算缩略图的高度
        $newheight = round($newwidth * $height / $width);
    } else {
        //缩略图的高等于$maxwidth
        $newheight = $maxheight;
        //计算缩略图的高度
        $newwidth = round($newheight * $width / $height);
    }
    //绘制缩略图的画布
    $thumb = imageCreateTrueColor($newwidth, $newheight);
    //依据原图创建一个与原图一样的新的图像
    $source = imagecreatefromjpeg($pic_info['tmp_name']);
    //依据原图创建缩略图
    /**
     * @param $thumb 目标图像
     * @param $source 原图像
     * @param 0,0,0,0 分别代表目标点的x坐标和y坐标，源点的x坐标和y坐标
     * @param $newwidth 目标图像的宽
     * @param $newheight 目标图像的高
     * @param $width 原图像的宽
     * @param $height 原图像的高
     */
    imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

    //设置字体样式（宋体）
    $font_style = 'C:\Windows\Fonts\simsun.ttc';
    //设置字体颜色
    $color = imagecolorallocate($thumb, 255, 255, 255);

    /**
     * 生成文字水印
     * @param resource $src_img 原图像资源
     * @param int 30     文字大小
     * @param int 0      文字水印在原图像中的角度
     * @param int 0,35   文字水印在原图像中的横坐标和纵坐标
     * @param int $color 文字水印的字体颜色
     * @param string $font_style   文字水印的字体样式
     * @param string '快乐学习PHP'  文字水印的文本
     */
    imagefttext($thumb, 10, 0, 15, 85, $color, $font_style, $info['name']);
    //设置缩略图保存路径
    $new_file = '../images/w_images/' . $info['id'] . '.jpg';
    //设置缩略图保存路径
    imagejpeg($thumb, $new_file, 100);
}

//bianjitouxiang
//定义数组$skill保存预设的语言技能复选框
$skill = array('HTML', 'JavaScript', 'PHP', 'C++');
if (!empty($_POST)) {
    $update = array();
    $file = array(
        's_name' => '姓名',
        's_num' => '学号',
        'sex' => '性别',
        'd_num' => '宿舍号',
        's_hb' => '爱好',
        'skill' => '语言技能'
    );

    foreach ($file as $k => $v) {
        if (empty($_POST[$k])) {
            echo "<script>";
            echo "alert('";
            echo $v;
            echo "不能为空');</script>";
            die();
        }
        $save_data[$k] = $_POST[$k];
    }

    //复选框处理
    if (is_array($save_data['skill'])) {
        $save_data['skill'] = array_intersect($skill, $save_data['skill']); //只取出合法的数组元素
        $save_data['skill'] = implode(',', $save_data['skill']);  //将数组转换为用逗号分隔的字符串	
    } else {
        $save_data['skill'] = '';
    }

    $sql = 'update `students` set ';
    foreach ($save_data as $k => $v) {

        $sql .= "`$k`='" . mysql_real_escape_string($v) . "',"; //拼接每个字段的SQL语句，并对值进行SQL安全转义
    }
    $sql = rtrim($sql, ',') . " where id=$id "; //rtrim($sql,',')用于去除$sql中的最后一个逗号
    $rst = mysql_query($sql);
    if ($res = query($sql)) {
        header("Location: ../index_contain/test.php");
        die;
    } else {
        die('员工信息修改失败');
    }
} else {
    $sql = "select * from `students` where `id` = $id";
    $rst = mysql_query($sql);
    if (!$rst)
        die(mysql_error());
    $data = mysql_fetch_assoc($rst);
    $emp_info = fetchRow($sql);
    //判断是否查询到数据
    if (!$data) {
        die('没有找到ID为' . $id . '的用户信息！');
    }
//将skill字段通过“,”分隔符转换为数组
    $data['skill'] = explode(',', $data['skill']);
    define('test', 'itcast');
    require '../stu_update/update_html.php';
}




