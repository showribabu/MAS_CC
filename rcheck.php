<?php
include "conn.php";

if($_SERVER['REQUEST_METHOD'] == 'POST')
{

    $user_id=trim($_POST['userid']);
    $password=trim($_POST['password']);
    $hpassword=hash('sha512',$user_id.$password);
}

$sql='select * from user';
$dd=mysqli_query($con,$sql);
if($dd)
{
    $f=0;
    foreach($dd as $i)
    {
        if($i['user_id']==$user_id){
            $f=1;
            break;
        }
    }
    if($f==0)
    {
        
             // Insert data into user table
            $sql = "INSERT INTO user (user_id,password,privilege,type,status) VALUES ('".$user_id."','".$hpassword."','NULL','NULL','NULL')";

            // Execute the query
            $r = mysqli_query($con, $sql);

             if ($r){
                echo "<script>alert('Successfully registered!!!Then Login Now!!')</script>";
                include "login.html";
                

                //  $message = "Successfully registered!!!Then Login Now!!";
             } 
             else{
                 echo"<br>Something went wrong. Error: " . mysqli_error($con);
             }
            
            
    }
    else{

        echo"<script>alert('User already registered!!!...Login now!!!');</script>";
        include "login.html";

    }
   
}


?>