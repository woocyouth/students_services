<?php if(!defined('test')) die('error!');?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8" >
        <title>添加学生</title>
        <link type="text/css" rel="stylesheet" href="../CSS/add_html.css"/>
    </head>
    <body>
        <div class="box">
            <h1>添加学生</h1>
            <div class="p_box">
            
                <img src="<?php echo '../images/w_images/' . $info['id'] . '.jpg?rand=' . rand(); ?>" onerror="this.src='../images/default.jpg'" />
                
                <form method="post" enctype="multipart/form-data">
                    <p class="upload"><input name="pic" type="file"/>上传头像</p>
                    <p><button class="sub" type="submit">保存头像</button></p>
                </form>
            </div>
            <form method="post" action="../stu_add/add.php">
                <table class="profile-table">

                    <tr><td><input type="text" name="s_name" placeholder="姓名"/></td></tr>
                    <tr><td><input type="text" name="s_num" placeholder="学号"/></td></tr>
                    <tr><td><input id="sex" name="sex" type="text" placeholder="性别"></td></tr>
                    <tr><td><input id="d_num" name="d_num" type="text" placeholder="宿舍号"></td></tr>
                    <tr><td><input id="s_hb" name="s_hb" type="text" placeholder="爱好"></td></tr>
                    
                            <input type="checkbox" name="skill[]" id="ck1" value="HTML" /><label for="ck1">HTML</label>
                            <input type="checkbox" name="skill[]" id="ck2" value="JavaScript" /><label for="ck2">JavaScript</label>
                            <input type="checkbox" name="skill[]" id="ck3" value="PHP" /><label for="ck3">PHP</label>
                            <input type="checkbox" name="skill[]" id="ck4" value="C++" /><label for="ck4">C++</label>
                 
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

