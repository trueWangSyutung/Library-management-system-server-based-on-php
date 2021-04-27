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
$bookname=$_GET['user'];
$days = $_GET['days'];
$code = $_GET['code'];
if($code != "wxdqwe123"){
    echo(0);
}else{
if($bookname==null && $days!=null) {
    $stmt = $link->prepare("SELECT * FROM xuexi.net_borrow where DATE_SUB(CURDATE(), INTERVAL ? DAY) <= date(borrowed_time)");
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
            $outData['msg'] = "获得{$numrows}申请";
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
        $str = $bookname;
        $stmt = $link->prepare("select * from xuexi.net_borrow where user=?");
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
                $outData['msg']="获得{$numrows}申请";
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
        $str =$bookname;
        $stmt = $link->prepare("select * from xuexi.net_borrow where user= ?  and DATE_SUB(CURDATE(), INTERVAL ? DAY) <= date(borrowed_time)");
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
                $outData['msg']="获得{$numrows}申请";
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
     $str = "%{$bookname}%";
        $stmt = $link->prepare("select * from xuexi.net_borrow");
        $link = null;

        if ($stmt->execute()) {
            // get the rowcount
            $numrows = $stmt->rowCount();
            if ($numrows > 0) {
                // match
                // Fetch rows
                $outData['data']['size']=$numrows;
                $outData['msg']="获得{$numrows}申请";
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
}
}
