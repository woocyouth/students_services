<?php if (!defined('test')) die('error!'); ?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>学生信息编辑</title>
        <link type="text/css" rel="stylesheet" href="../CSS/update_html.css"/>
    </head>
    <body>
        <div class="box">
            <h1>修改学生信息</h1>
            <div class="p_box">
            
                <img src="<?php echo '../images/w_images/' . $info['id'] . '.jpg?rand=' . rand(); ?>" onerror="this.src='../images/default.jpg'" />
                
                <form method="post" enctype="multipart/form-data">
                    <p class="upload"><input name="pic" type="file"/>上传头像</p>
                    <p><button class="sub" type="submit">保存头像</button></p>
                </form>
            </div>
            
            
            <form method="post" >
                <table class="profile-table">
                    <tr><td><input type="text" name="s_name" value="<?php echo $emp_info['s_name']; ?>"/></td></tr>
                    <tr><td><input type="text" name="s_num" value="<?php echo $emp_info['s_num']; ?>"/></td></tr>
                    <tr><td><input id="date_of_birth" name="sex" type="text" value="<?php echo $emp_info['sex']; ?>"></td></tr>
                    <tr><td><input id="date_of_entry" name="d_num" type="text" value="<?php echo $emp_info['d_num']; ?>"></td></tr>
                    <tr><td><input type="text" name="s_hb"  value="<?php echo $emp_info['s_hb']; ?>"></td></tr>              
                    
			<?php foreach($skill as $k=>$v): ?>
				<input type="checkbox" name="skill[]" id="ck<?php echo $k; ?>" value="<?php echo $v; ?>" 
                                    <?php if(in_array($v,$data['skill'])) echo 'checked'; ?> /><label for="ck<?php echo $k; ?>"><?php echo $v; ?></label>
			<?php endForeach; ?>
		
                    <tr><td colspan="2" class="td-btn">
                            <button type="submit" class="button">保存资料</button>
                            <button type="reset"  class="button" >重新填写</button>
                            <button value="返回首页" class="button" onclick="window.location.href='./test.php'">返回首页</button>
                        </td></tr>
                </table>
            </form>
        </div>
    </body>
</html>