<?php 



include "conn.php";
session_start();

include "nav.html";
include "button.html";

$gmid=$_SESSION['gmid'];



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

</head>
<body>

<div class="data">
        
        <p class="pp" id="req">REQUESTS FOR REMOVAL</p>

    <table border="5px" cellpadding="8px" align="center" cellspacing="5px" class="tb" style="height:80px; width:893px;  text-align:center; align-items:center;">
    <tr id="tr1"><th>NAME</th><th>EMAIL ID</th><th>MESSAGE</th><th>ACCEPT</th><th>REJECT</th></tr>
            <?php

                $group_number=$_SESSION['group_number'];
                $group_type=$_SESSION['group_type'];

                $sql1='select * from requests where request_to="'.$gmid.'" and r_status="rm" and group_number="'.$group_number.'"';
                
                $r1=mysqli_query($con,$sql1);
                if($r1)
                {
                    foreach($r1 as $i)
                    {



                        $sql5="select first_name,middle_name,last_name,email from user where user_id='$i[request_from]'";
                        $r5=mysqli_query($con,$sql5);
                        if($r5)
                        {
                           $row=$r5->fetch_assoc();
                           $name=$row['first_name'].$row['middle_name'].$row['last_name'];
                           echo "<tr><td>$name</td>";
                           echo"<td>$row[email]</td>";
                        }

                        // echo "<tr><td>$i[request_id]</td>";
                        // $request_id=$i['request_id'];
                        // $_SESSION['request_id']=$i['request_id'];

                        // echo "<td>$i[request_from]</td>";

                        echo "<td>$i[message]</td>";

                
                        // echo "<td><a href='rmv.php?user_id={$i['request_from']}' class='btn btn-danger' id='A'>REMOVE</a></td>";                
                        
                        echo "<td colspan='2'><a href='requests.php?auser_id={$i['request_from']}' class='btn btn-success'>ACCEPT</a> <a href='requestss.php?ruser_id={$i['request_from']}' class='btn btn-danger'>REJECT</a></td>";


                    }
                }


                ?>
        </table>
    </div>
    <div class='pic'>
               <!-- <img src="gm1.jpg" alt="group manager"> -->
               <img src="<?php echo $_SESSION['photo_location'];?>" alt="group manager">
    </div>

<footer>
        <p>MAS : MULTI PARTY AUTHENTICATION SYSTEM</p>
</footer>

<p class="data2"><?php echo $_SESSION['name'];echo "<br>"; echo $_SESSION['group_number'];?></p>
</body>

</html>

