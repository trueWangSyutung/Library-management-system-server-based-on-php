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
$bookname=$_GET['bookname'];
$days = $_GET['days'];
if($bookname==null && $days!=null) {
    $stmt = $link->prepare("SELECT * FROM xuexi.book_list where DATE_SUB(CURDATE(), INTERVAL ? DAY) <= date(book_pubdate)");
    $link = null;
    //echo("select * from book_list where bookname like {$str}");
    $stmt->bindParam(1, $days);
    if ($stmt->execute()) {
        // get the rowcount
        $numrows = $stmt->rowCount();
        if ($numrows > 0) {
            // match
            // Fetch rows
            $outData['data']['size'] = $numrows;
            $outData['msg'] = "获得{$numrows}本书";
            $rowset = $stmt->fetchAll();
            $outData['code'] = 666;
            //echo($rowset);
            $outData['data']['dataSet'] = $rowset;
            echo json_encode($outData);
        } else {
            $outData['msg'] = "查询错误";
            $outData['code'] = 000;
            $outData['data'] = null;
            echo json_encode($outData);
        }
    }
}else if($bookname!=null && $days==null) {
        $str = "%{$bookname}%";
        $stmt = $link->prepare("select * from xuexi.book_list where book_name like ?");
        $link = null;
        //echo("select * from book_list where bookname like {$str}");
        $stmt->bindParam(1, $str);
        if ($stmt->execute()) {
            // get the rowcount
            $numrows = $stmt->rowCount();
            if ($numrows > 0) {
                // match
                // Fetch rows
                $outData['data']['size']=$numrows;
                $outData['msg']="获得{$numrows}本书";
                $rowset = $stmt->fetchAll();
                $outData['code']=666;
                //echo($rowset);
                $outData['data']['dataSet']=$rowset;
                echo json_encode($outData);
            } else {
                $outData['msg']="查询错误";
                $outData['code']=000;
                $outData['data']=null;
                echo json_encode($outData);
            }
        }
}else if ($bookname!=null && $days!=null) {
        $str = "%{$bookname}%";
        $stmt = $link->prepare("select * from xuexi.book_list where book_name like ?  and DATE_SUB(CURDATE(), INTERVAL ? DAY) <= date(book_pubdate)");
        $link = null;
        //echo("select * from book_list where bookname like {$str}");
        $stmt->bindParam(1, $str);
        $stmt->bindParam(2, $days);
        if ($stmt->execute()) {
            // get the rowcount
            $numrows = $stmt->rowCount();
            if ($numrows > 0) {
                // match
                // Fetch rows
                $outData['data']['size']=$numrows;
                $outData['msg']="获得{$numrows}本书";
                $rowset = $stmt->fetchAll();
                $outData['code']=666;
                //echo($rowset);
                $outData['data']['dataSet']=$rowset;
                echo json_encode($outData);
            } else {
                $outData['msg']="查询错误";
                $outData['code']=000;
                $outData['data']=null;
                echo json_encode($outData);
            }
        }
}else {
    //String bookName,int pageNo,int pageSize
    echo 0;
}
