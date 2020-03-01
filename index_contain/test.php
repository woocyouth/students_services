
<?php

header('content-type:text/html;charset=utf-8');
require '../function.php';
dbInt();


//启动SESSION
session_start();

//用户退出
if (isset($_GET['action']) && $_GET['action'] == 'logout') {

    //清除COOKIE数据
    setcookie('username', '', time() - 1);
    setcookie('password', '', time() - 1);

    //清除SESSION数据
    unset($_SESSION['userinfo']);

    //如果SESSION中没有其他数据，则销毁SESSION
    if (empty($_SESSION)) {
        session_destroy();
    }

    //跳转到登录页面
    header('Location: ../login.php');

    //终止脚本
    die;
}

//判断SESSION中是否存在用户信息
if (isset($_SESSION['userinfo'])) {
    //用户信息存在，说明用户已经登录
    $login = true;   //保存用户登录状态
    $userinfo = $_SESSION['userinfo'];  //获取用户信息
} else {
    //用户信息不存在，说明用户没有登录
    $login = false;
}



//数据排序
$sql_order = "";

$file = array('id', 's_num');

$order = isset($_GET['order']) ? $_GET['order'] : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : '';

if (in_array($order, $file)) {
    if ($sort == 'desc') {
        $sql_order = "order by $order desc";
        $sort = 'asc';
    } else {
        $sql_order = "order by $order asc";
        $sort = 'desc';
    }
}

//数据查找

$sql_where = '';

if (isset($_POST['s_name'])) {
    $s_name = $_POST['s_name'];

    $s_name_key = mysql_real_escape_string($s_name);

    $sql_where = "where s_name like '%$s_name_key%'";
}

//数据分页
//设置每页显示的信息数量
$page_size = 5;

//使用sql语句中的count计数函数
$res = mysql_query("select count(*) from students");
if (!$res)
    die(mysql_error());

//用列排序数组
$count = mysql_fetch_row($res);

//取出一列的值
$count = $count[0];

//设置最大页数
$total_pages = ceil($count / $page_size);
//
//获取当前的页数
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

//显示页码数量
$showPage = 5;

//页码偏移量
$pageoffset = ($showPage - 1) / 2;

//第一个页码/最后页码
$star = 1;
$end = $total_pages;

//设置limit语句
$limit = ($page - 1) * $page_size;
$sql_limit = " limit {$limit},{$page_size}";

//组合分页连接
$page_banner = "";

if ($page > 1) {
    $page_banner .= "<a style=' text-decoration: none; color:#fff;' href = './test.php?page=1'>首页</a>";
    $page_banner .= "<a style=' text-decoration: none; color:#fff;' href = './test.php?page=" . ($page - 1) . "'>&nbsp;&nbsp;<上一页&nbsp;&nbsp;</a>";
} else {
    $page_banner .= "<span>首页</span>";
    $page_banner .= "<span>&nbsp;&nbsp;<上一页&nbsp;&nbsp;</span>";
}

//页码块
if ($total_pages > $showPage) {
    if ($page > $pageoffset + 1) {
        $page_banner .= "...";
    }

    if ($page > $pageoffset) {
        $star = $page - $pageoffset;
        $end = $total_pages > $page + $pageoffset ? $page + $pageoffset : $total_pages;
    } else {
        $star = 1;
        $end = $total_pages > $showPage ? $showPage : $total_pages;
    }

    if ($page + $pageoffset > $total_pages) {
        $star = $star - ($page + $pageoffset - $end);
    }
}

for ($i = $star; $i <= $end; $i++) {
    if ($page == $i) {
        $page_banner .= "<span>" . $i . "</span>";
    } else {
        $page_banner .= "<a href = './test.php?p" . $i . "'>" . $i . "</a>";
    }
}

if ($page + $pageoffset < $total_pages && $total_pages > $showPage) {
    $page_banner .= "...";
}

if ($page < $total_pages) {
    $page_banner .= "<a style=' text-decoration: none; color:#fff;' href = './test.php?page=" . ($page + 1) . "'>&nbsp;&nbsp;下一页>&nbsp;&nbsp;</a>";
    $page_banner .= "<a style=' text-decoration: none; color:#fff;' href = './test.php?page=" . $total_pages . "'>尾页&nbsp;&nbsp;</a>";
} else {
    $page_banner .= "<span>&nbsp;&nbsp;下一页>&nbsp;&nbsp;</span>";
    $page_banner .= "<span>尾页</span>";
}

$page_banner .= "<span>共计" . $total_pages . "页";

$sql = "select * from students ";
$sql .= $sql_where;
//$sql .= $sql_where_num;
$sql .= $sql_order;
$sql .= $sql_limit;
$students_info = fetchAll($sql);

define('test', 'itcast');
require '../index_contain/index_html.php';


