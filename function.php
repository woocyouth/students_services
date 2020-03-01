<?php

  function dbInt(){
      @$link = mysql_connect('localhost','root','123456');
  if(!$link){
    die('数据库连接失败'.mysql_error());
  }
     
   mysql_set_charset('utf8');
   mysql_select_db('itcast');
 
}

function query($sql){
    if($result = mysql_query($sql)){
        return $result;
    }else{
        echo 'SQL执行失败<br>';
        echo '错误的SQL为：'.$sql;
        echo '错误代码为：'.mysql_errno();
        echo '错误信息为：'.mysql_error();
        die; 
    }
}

function makeHtmlPage($page,$max_page){
      //保存$_GET参数数组,并删除page的值
      $params = $_GET;
      unset($params['page']);
      
      //将数组转换为GET字符串
      $params = http_build_query($params);
      if($params){
          $params .= '&';
      }
      
      //设置上一页
      $prev_page = $page - 1;
      if($prev_page < 1){
          $prev_page = 1;
      }
      
      //设置下一页
      $next_page = $page + 1;
      if($next_page > $max_page){
          $next_page = $max_page;
      }
      
      //重新拼接html代码
      $page_html  = "<a href='?".$params."page=1'>首页</a>&nbsp;";
      $page_html .= "<a href='?".$params."page=".$prev_page."'>上一页</a>&nbsp;";
      $page_html .= "<a href='?".$params."page=".$next_page."'>下一页</a>&nbsp;";
      $page_html .= "<a href='?".$params."page=".$max_page."'>尾页</a>&nbsp;";
      return $page_html;
}
      //调用函数，生成分页连接
//      $page_html = makeHtmlPage($page, $max_page);
function fetchAll($sql){
    if($res = query($sql)){
        $rows = array();
        while($row = mysql_fetch_array($res)){
            $rows[] = $row;
        }
        mysql_free_result($res);
        return($rows);
    }else{
        return false;
    }
}

function fetchRow($sql){
    if($result = query($sql)){
        $row = mysql_fetch_array($result,MYSQLI_ASSOC);
        return $row;
    }else{
        return false;
    }
}






