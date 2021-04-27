<?php
$outData = array(
    'code'=>0,
    'msg'=>"未请求到数据",
    'data'=>array(
        'size'=>0,
        'dataSet'=>[]
    )
);

$link=new PDO("mysql:host=127.0.0.1;port=3306;dbname=xuexi","xuexi","1234");
$link->query("set names utf8");
$bookid=$_GET['bookid'];


    $stmt = $link->prepare("SELECT book_list.book_name FROM book_list WHERE book_list.book_id = ?");
    $link = null;
    //echo("select * from book_list where bookname like {$str}");
    $stmt->bindParam(1, $bookid);
    if ($stmt->execute()) {
        // get the rowcount
        $numrows = $stmt->rowCount();
        if ($numrows > 0) {
            $row = $stmt->fetchAll();
            echo $row[0]['book_name'];
        } else {

            echo 0;
        }
    }
