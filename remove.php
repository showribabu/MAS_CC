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





    <!-- </div>div class="data">
        
            <p class="pp" id="req">LIST OF MEMBERS</p>

        <table border="5px" cellpadding="8px" align="center" cellspacing="5px" class="tb" style="height:100px; width:780px;  text-align:center; align-items:center;">
            <tr id="tr1"><th>USER ID</th><th>Group Number</th><th>SUSPEND/REMOVE</th></tr> 
                       
           <?php

//select members from group data where the members are having the Same MV : which is from the GM user_id ;



// $group_number='A1';


// $sql1='select * from group_data where group_number="'.$group_number.'" and user_id != "'.$gmid.'"';

// $r1=mysqli_query($con,$sql1);
// if($r1)
// {
 
//             foreach($r1 as $j)
//             {
// //user_id,group_number,mid,activity_status-0/1

//                 if ($j['activity_status'] == 'active') 
//                 {
//                 echo "<tr><td>$j[user_id]</td>";

//                 echo "<td>$j[group_number]</td>";


//                 // echo "<td>$j[mid]</td>";

//                 // echo "<td><a href='rmv.php' class='btn btn-danger' id='A'>SUSPEND</a></td>";
//                 echo "<td><a href='rmv.php?user_id={$j['user_id']}' class='btn btn-danger' id='A'>SUSPEND</a></td>";

//                     // ?user_id=<?php echo $i[user_id];?////>
//                     // $_SESSION['uid3']=$j['user_id'];
//                 } 
//                 echo "</tr>";



//             }
//     }





?>
             
        </table>
    </div> -->


<div class="data">
        
        <p class="pp" id="req">LIST OF MEMBERS</p>

    <table border="5px" cellpadding="8px" align="center" cellspacing="5px" class="tb" style="height:80px; width:780px;  text-align:center; align-items:center;">
        <tr id="tr1"><th>NAME</th><th>EMAIL ID</th><th>REMOVE</th></tr>
<?php



// $group_number='A1';

$group_number=$_SESSION['group_number'];


//remove the members based on the member id...(But member id need to calculate )

//firt display the members of same group...



$sql2='SELECT * FROM user WHERE user_id IN(select user_id from group_data where group_number="'.$group_number.'" and user_id != "'.$gmid.'" and activity_status="active" order by creation_time)';
$r2=mysqli_query($con,$sql2);
        if($r2)
        {
            foreach($r2 as $j)
             {
                //user_id,group_number,mid,activity_status-0/1
                $name=$j['first_name'].$j['middle_name'].$j['last_name'];

                echo "<tr><td>$name</td>";
                echo"<td>$j[email]</td>";

                // echo "<td>$j[group_number]</td>";

                // echo "<td>$j[mid]</td>";

                echo "<td><a href='requests.php?duser_id={$j['user_id']}' class='btn btn-danger' id='A'>REMOVE</a></td>";
                // ?user_id=<?php echo $i[user_id];?////>
                // $_SESSION['uid3']=$j['user_id'];
    
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

<footer>
        <p>MAS : MULTI PARTY AUTHENTICATION SYSTEM</p>
</footer>

<p class="data2"><?php echo $_SESSION['name'];?></p>
</body>

</html>

