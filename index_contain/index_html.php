<?php if(!defined('test')) die('error!');?>
<?php // require '../funtion.php'; dbInt();?>
<!doctype html>
<html>
 <head>
  <meta charset="utf-8">
  <title>学生信息列表</title>
  <link type="text/css" rel="stylesheet" href="../CSS/index_html.css">

 </head>
 <body>
	<form action="../index_contain/test.php" method="post">
		<div class="box">     
                
                    <div class="search">
                    <!--<input class="in_text"type="text" name="s_name" or name="s_num" placeholder="快速查询">--> 
                    <input type="text" placeholder="search" name="s_name">
                         
                </div>
                    <button class="in_ser"type="submit" >查询</button>
                        <br>       
                <br/>
                
                <div class="login-container">
                    
                </div>
                <div class="content">
                    
               
		<table border="1">
			<tr>
                            <th width="5%"><a href="../index_contain/test.php?order=id&sort=<?php echo ($order = 'id') ? $sort : 'desc' ?> ">ID</a></th>
				<th>姓名</th>
                                <th><a href="../index_contain/test.php?order=s_num&sort=<?php echo ($order = 's_num') ? $sort : 'desc' ?> ">学号</a></th>
				<th>性别</th><th>宿舍号</th>
                                <th>爱好</th>
                                <th>技能</th>
				<th width="25%">相关操作</th>
                                
			</tr>
			<?php if(!empty($students_info)){ ?>
			<?php foreach($students_info as $row){ ?>
			<tr>
				 <td><?php echo $row['id']; ?></td>
				 <td><?php echo $row['s_name']; ?></td>
				 <td><?php echo $row['s_num']; ?></td>
				 <td><?php echo $row['sex']; ?></td>
				 <td><?php echo $row['d_num']; ?></td>
                                 <td><?php echo $row['s_hb']; ?></td>
                                  <td><?php echo $row['skill']; ?></td>
				 <td>
					<div align="center">
						<span>
                                                    <img  src="../images/edt.gif" width="16" height="16" /><a class="up_a" href="<?php echo '../stu_update/update.php?id='.$row['id'] ?>">编辑</a>&nbsp; &nbsp;
							<a class="up_a" href="<?php echo './del.php?id='.$row['id'] ?>"><img  src="../images/del.gif" width="16" height="16" />删除</a>
<!--                                                        &nbsp;&nbsp;&nbsp;<a class="up_a" href="./file.php"><img src="images/download.png" width="16" height="16">文件</a>-->
						</span>
					</div>
				</td>
			</tr>
			<?php } ?>
			<?php }else{ ?>
			<tr><td colspan="7">查询的结果不存在！</td></tr>
			<?php } ?>
		</table>
                    
                     </div>
                
                <div class="page_div">
                    <div class="page"><?php echo $page_banner; ?></div>
                </div>

	
                                
                
                
        </div>

        </form>
    
     
 </body>
</html>