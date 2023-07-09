<?php



include "conn.php";
session_start();

// include "nav.html";
// include "button.html";

if (isset($_GET['muid'])) {
    $uid1 = $_GET['muid'];
    $_SESSION['uid1']=$uid1;
    $r_status='p';
    $priv='Member';

}
if(isset($_GET['authuser_id']))
{
    $uid1 = $_GET['authuser_id'];
    $_SESSION['uid1']=$uid1;
    // $_SESSION['authority']=1;
    $r_status='au';
    $priv=' Authority Member';

}
if(isset($_GET['reguser_id']))
{
    $uid1 = $_GET['reguser_id'];
    $_SESSION['uid1']=$uid1;
    // $_SESSION['regular']=1;
    $r_status='re';
    $priv='Regular Member';

}

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

    $msg="You are selected as a ".$priv. " of group type : ".$group_type." and group number : ".$group_number." from Group manager !!!";
    $sql3 = 'INSERT INTO requests (request_id,request_from,request_to,message,r_status,group_type,group_number) VALUES ("'.$request_id.'","' . $gmid . '","'.$uid1.'","'.$msg.'","'.$r_status.'","'.$group_type.'","'.$group_number.'")';


    $r1 = mysqli_query($con, $sql3);

    if ($r1) 
    {
    echo "<script>alert('Request sent successfully');</script>";
    header("Location: gmstatus.php");
    } 
    else 
    {
        echo "<script>alert('User ID not found');</script>";
    }


    // if ($r1) {
    //     $_SESSION['request_status'] = 'success';
       
    // } else {
    //     $_SESSION['request_status'] = 'failure';
    //     header("Location: gmstatus.php");
    // }


?>
