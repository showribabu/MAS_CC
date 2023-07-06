<?php



include "conn.php";
session_start();

// include "nav.html";
// include "button.html";

if (isset($_GET['muid'])) {
    $uid1 = $_GET['muid'];
    $_SESSION['uid1']=$uid1;
    $gmid=$_SESSION['gmid'];
    $group_number=$_SESSION['group_number'];
    $group_type=$_SESSION['group_type'];

    function rid()
    {

        $char='abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $ucase='ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $lcase='abcdefghijklmnopqrstuvwxyz';
        $rands='';
        $index=rand(0, strlen($char)-1);
        $rands.=$char[$index];
        $index=rand(0, strlen($ucase)-1);
        $rands.=$ucase[$index];
        $rands.=rand(100, 999);
        $index=rand(0, strlen($lcase)-1);
        $rands.=$lcase[$index];

        return $rands;

    }
    $request_id=rid();

    $sql3 = 'INSERT INTO requests (request_id,request_from,request_to,message,r_status,group_type,group_number) VALUES ("'.$request_id.'","' . $gmid . '","'.$uid1.'","You are selected as a group member: from Group manager - check status table..!!!","p","'.$group_type.'","'.$group_number.'")';


    $r1 = mysqli_query($con, $sql3);

    // if ($r1) {
    //     header("Location: gmstatus.php?status=success");
    // } else {
    //     header("Location: gmstatus.php?status=failure");
    // }


    if ($r1) {
        $_SESSION['request_status'] = 'success';
        header("Location: gmstatus.php");
    } else {
        $_SESSION['request_status'] = 'failure';
        header("Location: gmstatus.php");
    }

}
?>
