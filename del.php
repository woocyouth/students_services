<?php 
header('content-type:text/html;charset=utf-8');
require './function.php';

dbInt();
$id = isset($_GET['id']) ? $_GET['id'] : '';

  if(!empty($id)){
      $sql = "delete from `students` where `id`=$id";
      if($res = query($sql)){
          header("Location: ./test.php");
           die("删除成功");
      }else{
          die("删除失败");
      }
     
  }
  
  define('test', 'itcast');
  require './test.php';


    
