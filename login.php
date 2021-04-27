<?php
 error_reporting(0); 


header('content-type:application/json;charset=utf-8');

$outData = array(
    'code'=>0,
    'msg'=>"未请求到数据",
    'data'=> array(
        
        )
);

$q =  array(
            user=>"",    
            name=>"",    
            quanxian=>""
);
//php接口的写法，php访问mysql数据库的基本步骤,获取用户

//1 连接数据库服务器：  mysql_connect("服务器名称","用户名","密码");or die("前面语句执行不成功后返回的信息".mysql_error());
//.mysql_error() 这个函数的意思是什么原因导致前面的sql语句执行失败

$link=new PDO("mysql:host=127.0.0.1;port=3306;dbname=xuexi","xuexi","1234");
$link->query("set names utf8");

session_start();/*开启会话*/
$user=$_GET['username'];/*获取登录表单提交过来的数据*/
$pwd=$_GET['password'];

$result=$link->query("select * from xuexi.user where user='$user' and password='$pwd'");
$stmt = $link->prepare("select user,name,quanxian from xuexi.user where user=? and password=?");
$link = null;
$stmt->bindParam(1, $user);
$stmt->bindParam(2, $pwd);

if ($stmt->execute()) {

    // get the rowcount
    $numrows = $stmt->rowCount();
    if ($numrows > 0) {
        // match
        // Fetch rows
        $rowset = $stmt->fetchAll();
        $outData['code']=666;

        $outData['msg']="密码正确，登陆成功";

        $q['user']=$rowset[0]['0'];
        $q['name']=$rowset[0]['1'];
        $q['quanxian']=$rowset[0]['2'];
        
        $outData['data']= $q;

        $json = json_encode($outData,JSON_UNESCAPED_UNICODE);
        echo $json;
    }
    else {
        $outData['msg']="密码错误，登陆失败";
        $outData['code']=000;

        $outData['data']=null;
       
        $json = json_encode($outData,JSON_UNESCAPED_UNICODE);
        echo $json;

    }
}


