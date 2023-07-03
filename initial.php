<?php

include "conn.php";

if($con) {
    $sql2='select * from server_parameters';

    $r2=mysqli_query($con, $sql2);
    if($r2) {
        foreach($r2 as $i) {
            session_start();
            $_SESSION['p']=$i['p'];
            $_SESSION['q']=$i['q'];
            $_SESSION['kv']=$i['kv'];
            $_SESSION['ix']=$i['ix'];
            $_SESSION['spk']=$i['spk'];
            $_SESSION['s']=$i['s'];
        }
    }
}

?>