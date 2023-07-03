<?php



include "conn.php";
session_start();

include "nav.html";
include "button.html";
//now with status column also

/*

                 if ($i['status'] == 'accept') {
                     echo "<td class='status accepted'><a href='upload.php' style='background-color: green; color: #fff;' id='A'>Accepted</a></td>";
                 } elseif ($i['status'] == 'reject') {
                     echo "<td class='status rejected'><a href='#' class='btn btn-danger' id='R'>Rejected</a></td>";
                 } elseif ($i['status'] == 'pending') {
                     echo "<td class='status pending'><a href='#' class='custom-button' id='P'>$i[status]</a></td>";
                 } else {
                     echo "<td>$i[status]</td>";
                 }
*/


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
        
            <p class="pp" id="req">REQUESTING FOR MEMBERSHIP</p>

        <table border="5px" cellpadding="8px" align="center" cellspacing="5px" class="tb" style="height:80px; width:850px;  text-align:center; align-items:center;">
            <tr id="tr1"><th>NAME</th><th>EMAIL ID</th><th>MESSAGE</th><th>ACCEPT</th><th>REJECT</th></tr>
        
            <?php

            //select members from request/status table where the members are having  request id. ;




$gmid=$_SESSION['gmid'];
$sql1='select * from requests where request_to="'.$gmid.'" and r_status="p"';

// $sql1='select * from requests where user_id !="'.$gmid.'" and requestid !=""';


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

                echo "<td>$i[message]</td>";

                // echo "<td>$i[request_from]</td>";

                // echo "<td><a href='rmv.php' class='btn btn-danger' id='A'>SUSPEND</a></td>";
                //     // ?user_id=<?php echo $i[user_id];?////>
                //     $_SESSION['uid3']=$j['user_id']; <a href='#'></a>

        //         echo "<td><button  class='btn btn-success' onclick='accepted()'> Accept</button>
        //         <button  onclick = 'rejected()' class='btn btn-danger'>Reject</button>
        //   </td>";

                //  echo "<td colspan='2'><a href='requests.php?user_id={$i['request_from']}' class='btn btn-success'>ACCEPT</a> <a href='requestss.php?user_id={$i['request_from']}' class='btn btn-danger'>REJECT</a></td>";

                
                //here we need to add condition for the remove request....
                
                //then stsuts as remove

                echo "<td colspan='2'><a href='requests.php?user_id={$i['request_from']}' class='btn btn-success'>ACCEPT</a> <a href='requestss.php?user_id={$i['request_from']}' class='btn btn-danger'>REJECT</a></td>";
                
               
                echo "</tr>";



    }
}
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

?>

<!-- <script>
        function accepted() {
            alert("Clicked on Accept Button ");

        }

        function rejected() {
            alert("clicked on rejected Button");
        }
    </script> -->

            
        
        
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

