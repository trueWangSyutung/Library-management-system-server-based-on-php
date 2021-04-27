<?php
header('content-type:application/json;charset=utf-8');

$outData = array(
    'code'=>0,
    'msg'=>"未请求到数据",
    'data'=>""
);

//php接口的写法，php访问mysql数据库的基本步骤,获取用户

//1 连接数据库服务器：  mysql_connect("服务器名称","用户名","密码");or die("前面语句执行不成功后返回的信息".mysql_error());
//.mysql_error() 这个函数的意思是什么原因导致前面的sql语句执行失败

$link=new PDO("mysql:host=127.0.0.1;port=3306;dbname=xuexi","xuexi","1234");
$link->query("set names utf8");

session_start();/*开启会话*/
$book_id=$_GET['bookid'];/*获取登录表单提交过来的数据*/
$user=$_GET['user'];

$stmt = $link->prepare("select book_list.shifoujiechu from xuexi.book_list where book_id=?");
$stmt->bindParam(1, $book_id);

if ($stmt->execute()) {

    // get the rowcount
    $numrows = $stmt->rowCount();
    if ($numrows > 0) {
        
            $d = date("ymdh");
            $x = rand(100,999);
            $bid = "B$d$x" ;
            $row=$link->prepare("insert into xuexi.net_borrow(id,user,book_id,borrowed_time,return_time) values (?,?,?,?,?)");
            $row->bindParam(1, $bid);
            $row->bindParam(2, $user);
            $row->bindParam(3, $book_id);
             $a = date("Y-m-d");
            $re =  date("Y-m-d",strtotime($a.' +1 month'));
            $row->bindParam(4, $a);
            $row->bindParam(5, $re);
            $row->execute();
            $c = $link->prepare("UPDATE `book_list` SET `shifoujiechu` = shifoujiechu -1 WHERE `book_list`.`book_id` = ?");
            $c->bindParam(1,$book_id);
            $c->execute();
            
        $link=null;
        echo 2;
    }else{
        echo 0;
    }
   
}else{
    echo 1;
}


