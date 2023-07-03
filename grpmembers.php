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
        
            <p class="pp" id="req">LIST OF MEMBERS</p>

        <table border="5px" cellpadding="8px" align="center" cellspacing="5px" class="tb" style="height:100px; width:780px;  text-align:center; align-items:center;">
            <tr id="tr1"><th>USER ID</th><th>Group Number</th><th>STATUS OF MEMBER</th></tr>
                       
           <?php

//select members from group data where the members are having the Same MV : which is from the GM user_id ;

/*

$sql1='select mv from group_data where user_id="'.$gmid.'"';

//from login we get the group_number and user_id.....

//based on that we can get the users avilable in the group

//$sql='select * from group_data where user_id="'.$gmid.'" and group_number="'.$group_number.'"';

$r1=mysqli_query($con,$sql1);
if($r1)
{
    foreach($r1 as $i)
    {
        $sql2='select * from group_data where mv="'.$i['mv'].'"';
        $r2=mysqli_query($con,$sql2);
        if($r2)
        {
            foreach($r2 as $j)
            {
//user_id,group_number,mid,activity_status-0/1

                echo "<tr><td>$j[user_id]</td>";

                echo "<td>$j[group_number]</td>";


                if ($j['activity_status'] == 'active') {
                    echo "<td><a href='#' class='btn btn-success' id='A'>ACTIVE</a></td>";
                } 
                elseif ($j['activity_status'] == 'inactive') {
                    echo "<td><a href='#' class='btn btn-danger' id='R'>IN ACTIVE</a></td>";
                } 
                else {
                    echo "<td>$j[activity_status]</td>";
                }
                
                echo "</tr>";



            }
        }
    }
}
*/

// $group_number='A1';

$group_number=$_SESSION['group_number'];



$sql1='select * from group_data where group_number="'.$group_number.'" and user_id != "'.$gmid.'"';
$r1=mysqli_query($con,$sql1);
if($r1)
{
    foreach($r1 as $j)
            {
//user_id,group_number,mid,activity_status-0/1

                echo "<tr><td>$j[user_id]</td>";

                echo "<td>$j[group_number]</td>";


                if ($j['activity_status'] == 'active') {
                    echo "<td><a href='#' class='btn btn-success' id='A'>ACTIVE</a></td>";
                } 
                elseif ($j['activity_status'] == 'inactive') {
                    echo "<td><a href='#' class='btn btn-danger' id='R'>IN ACTIVE</a></td>";
                } 
                else {
                    echo "<td>$j[activity_status]</td>";
                }
                
                echo "</tr>";

            }
}

?>
             
        </table>
    </div>
    <div class='pic'>
               <!-- <img src="gm1.jpg" alt="group manager"> -->
               <img src="<?php echo $_SESSION['photo_location'];?>" alt="group manager">
    </div>
    <p class="data2"><?php echo $_SESSION['name'];?></p>
    <footer>
        <p>MAS : MULTI PARTY AUTHENTICATION SYSTEM</p>
    </footer>
</body>

</html>

