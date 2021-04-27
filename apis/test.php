<?php
    $d = date("ymdh");
    $x = rand(100,999);
    echo "B$d$x" ;
    $a = date("Y-m-d");
    echo date("Y-m-d",strtotime($a.' +1 month'))

?>