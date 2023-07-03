<?php 


//accept means add member to group...(credentials.php)

//ans update the request status...(a)

include "conn.php";
session_start();
if(isset($_GET['user_id']))
{
    $_SESSION['uid2'] = $_GET['user_id'];
    $uid2 = $_SESSION['uid2'];
    //members id...id1
    $gmid=$_SESSION['gmid'];


    //from->to

    $sql12='update requests set r_status="a" where request_to="'.$gmid.'" and request_from="'.$uid2.'"';
    $rr=mysqli_query($con,$sql12);
    if($rr)
    {
        echo"<script>alert('Accept Button Clicked');</script>";

        header("Location: credentials.php?user_id=" . urlencode($uid2));    
    }
}



                /*Accept button*/

                if(isset($_GET['auser_id']))
                {
                    $_SESSION['uid3'] = $_GET['auser_id'];
                    $uid3 = $_SESSION['uid3'];
                    //members id...id1
                    $gmid=$_SESSION['gmid'];
                
                
                    //from->to
                
                    $sql12='update requests set r_status="ar" where request_to="'.$gmid.'" and request_from="'.$uid3.'" and r_status="rm" and group_number="'.$_SESSION['group_number'].'"';
                    $rr=mysqli_query($con,$sql12);
                    if($rr)
                    {
                        echo"<script>alert('Accept Button Clicked');</script>";
                    
                        header("Location: rmv.php?user_id=" . urlencode($uid3));    
                    }
                }



                /*Direct Remove  button*/

                if(isset($_GET['duser_id']))
                {
                    $_SESSION['uid3'] = $_GET['duser_id'];
                    $uid3 = $_SESSION['uid3'];
                    //members id...id1
                    $gmid=$_SESSION['gmid'];
                    function rid() {

                        $char='abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                        $ucase='ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                        $lcase='abcdefghijklmnopqrstuvwxyz';
                        $rands='';
                        $index=rand(0,strlen($char)-1);
                        $rands.=$char[$index];
                        $index=rand(0,strlen($ucase)-1);
                        $rands.=$ucase[$index];
                        $rands.=rand(100,999);
                        $index=rand(0,strlen($lcase)-1);
                        $rands.=$lcase[$index];
                        
                        return $rands;
                        
                    }
                    $request_id=rid();
                
                
                    //from->to
                    
                    $sql12='insert into requests(r_status,request_from,request_to,group_number,group_type,message,request_id) values("ar","'.$gmid.'","'.$uid3.'","'.$_SESSION['group_number'].'","'.$_SESSION['group_type'].'","You are removed from a group :GM !!!! If any further information contact!!!","'.$request_id.'")';
                    $rr=mysqli_query($con,$sql12);
                    if($rr)
                    {
                        echo"<script>alert('Accept Button Clicked');</script>";
                    
                        header("Location: rmv.php?user_id=" . urlencode($uid3));    
                    }
                }


?>