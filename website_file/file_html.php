<?php if(!defined('test')) die('error!'); ?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>学生文件管理</title>
<link type="text/css" rel="stylesheet" href="../CSS/file_html.css">
</head>
<body>
<div class="box">
	<!--错误信息-->
	<?php if(!empty($error)): ?>
		<div class="error"><ul>
			<?php foreach($error as $v): ?>
			<li><?php echo $v; ?></li>
			<?php endforeach; ?>
		</ul></div>
	<?php endif; ?>

	<!--创建文件夹-->
	<form method="post">
            <div class="leftbox"><input type="text" name="newdir" placeholder="新建文件夹"/></div>
            <button class="sub" type="submit" >创建</button>
	</form>	
	<div class="clear"></div>

	<!--上传文件-->
	<form method="post" action="?folder=<?php echo $folder_id ?>" enctype="multipart/form-data">
		<div class="leftbox"><input type="file" name="file" class="file"></div>
		<input class="sub" type="submit" value="上传" />
	</form>
       
	<div class="clear"></div>

	<!--目录列表-->
         
        <div class="position"><a href="../index_contain/test.php">返回首页</a>&nbsp;您的位置：<a href="?folder=0">主目录</a>
		<?php foreach($path as $v): ?>
			&gt; <a href="?folder=<?php echo $v['folder_id']; ?>"><?php echo $v['folder_name']; ?></a>
		<?php endforeach; ?>
	</div>

	<!--文件列表-->
	<table border="1">
		<tr><th>文件名</th><th>大小</th><th>上传时间</th><th>操作</th></tr>
		<!--列出目录-->
		<?php foreach($folder as $v): ?>
			<tr><td><a class="filename" href="?folder=<?php echo $v['folder_id'] ?>"><?php echo $v['folder_name'] ?></a></td><td>-</td><td><?php echo $v['folder_time'] ?></td>
			<td><a href="?folder=<?php echo $v['folder_id'] ?>">打开</a> | <a href="?folder=<?php echo $folder_id ?>&del=<?php echo $v['folder_id'] ?>&type=folder">删除</a></td></tr>
		<?php endforeach; ?>
		<!--列出文件-->
		<?php foreach($file as $v): ?>
			<tr><td><a class="filename" href="?download=<?php echo $v['file_id'] ?>" target="_blank"><?php echo $v['file_name'] ?></a></td><td><?php echo round($v['file_size']/1024) ?>KB</td>
			<td><?php echo $v['file_time'] ?></td>
			<td><a href="?download=<?php echo $v['file_id'] ?>" target="_blank">下载</a> | <a href="?folder=<?php echo $folder_id ?>&del=<?php echo $v['file_id'] ?>&type=file">删除</a></td></tr>
		<?php endforeach; ?>
	</table>
</div>
</body>
</html>