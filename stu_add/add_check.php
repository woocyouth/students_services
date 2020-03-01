<?php

function checks_name($s_name){
    if(!preg_match('/^[\w\x{4e00}-\x{9fa5}]{2,9}$/u', $s_name)){
        return '学生名格式不符合要求';
    }else{
        return true;
    }
}

function checks_num($s_num){
    if(!preg_match('/^\d{11}$/u', $s_num)){
        return '学号格式不符合要求';
    }else{
        return true;
    }
}

function checksex($sex){
    if(!preg_match('/^[男女]$/u', $sex)){
        return '性别格式不符合要求';
    }else{
        return true;
    }
}

function checkd_num($d_num){
    if(!preg_match('/^(\d{1,2}-)\d{3}$/u', $d_num)){
        return '宿舍号格式不符合要求';
    }else{
        return true;
    }
}

/**
 * 添加水印功能
 * @param string $source 原图
 * @param string $path 水印图片存放路径,默认为空，表示在当前目录
 * @return 
 */
function watermark($source,$path = ''){
	//新图片文件名前缀
	$waterPrefix = 'font_';
	//图片类型和对应创建画布资源的函数名
	$from = array(
		'image/gif'  => 'imagecreatefromgif',
		'image/png'  => 'imagecreatefrompng',
		'image/jpeg' => 'imagecreatefromjpeg'
	);
	//图片类型和对应生成图片的函数名
	$to = array(
		'image/gif'  => 'imagegif',
		'image/png'  => 'imagepng',
		'image/jpeg' => 'imagejpeg'
	);
}	
	