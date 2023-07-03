<?php



include "conn.php";
session_start();

include "nav.html";
include "button.html";

if (isset($_GET['muid'])) {
    $uid1 = $_GET['muid'];
    $_SESSION['uid1']=$uid1;
    $gmid=$_SESSION['gmid'];
    $group_number=$_SESSION['group_number'];
    $group_type=$_SESSION['group_type'];

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

    $sql3 = 'INSERT INTO requests (request_id,request_from,request_to,message,r_status,group_type,group_number) VALUES ("'.$request_id.'","' . $gmid . '","'.$uid1.'","You are selected as a group member: from Group manager - check status table..!!!","p","'.$group_type.'","'.$group_number.'")';
   

    $r1 = mysqli_query($con, $sql3);


    if ($r1) {
       echo "<script>alert('Request sended successfully');</script>";
    }
} else {
    echo "<script>alert('user id is not found');</script>";
}



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
        <p class="pp" id="req">SELECTED MEMBERS LIST</p>
    
        <table border="5px" cellpadding="8px" align="center" cellspacing="5px" class="tb" style="height:100px; width:780px;  text-align:center; align-items:center;">
            <tr id="tr1"><th>NAME</th><th>EMAIL ID</th><th>MEMBER SELECTION</th><th>STATUS</th></tr>
            <?php

                $sql = 'SELECT * FROM requests WHERE request_from = "'.$gmid.'"';

                $r=mysqli_query($con, $sql);

                if($r) {
                    $udata=$r;
                } else {
                    echo"<script>alert('Nodata Found');</script>";
                }

            foreach ($udata as $i) {
                $sql5="select * from user where user_id='$i[request_to]'";
                $r5=mysqli_query($con,$sql5);
                if($r5)
                {
                    if($i['r_status']=='a' || $i['r_status']=='r' || $i['r_status']=='p')
                    {
                        $row=$r5->fetch_assoc();
                        if($row['first_name']!='')
                        {
                            $name=$row['first_name'].$row['middle_name'].$row['last_name'];
                            echo "<tr><td>$name</td>";
                            echo"<td>$row[email]</td>";
                        }

                    
                        // echo "<td><a href='#' class='btn btn-success' id='R'>Selected</a></td>";
                        echo "<td>Selected</td>";

                        if ($i['r_status'] == 'a') {
                            echo "<td class='status accepted'><a href='credentials.php?user_id={$i['request_to']}' class='btn btn-success' id='A'>Accepted</a></td>";
                        }elseif ($i['r_status'] == 'r') {
                            echo "<td class='status rejected'><a href='#' class='btn btn-danger' id='R'>Rejected</a></td>";
                        } elseif ($i['r_status'] == 'p') {
                            echo "<td class='status pending'><a href='#' class='btn btn-warning' id='P'>Pending</a></td>";
                        } 
                    
                        echo "</tr>";
                    }
                }
               

              

                //  if ($i['status'] == 'a') {
                //      echo "<td class='status accepted'><a href='upload.php' class='btn btn-success' id='A'>Accepted</a></td>";
                //  } elseif ($i['status'] == 'r') {
                //      echo "<td class='status rejected'><a href='#' class='btn btn-danger' id='R'>$i[status]</a></td>";
                //  } elseif ($i['status'] == 'Pending') {
                //      echo "<td class='status pending'><a href='#' class='btn btn-warning' id='P'>$i[status]</a></td>";
                //  } else {
                //      echo "<td>$i[status]</td>";
                //  }

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

