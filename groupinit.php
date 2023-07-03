<?php 



include "conn.php";
session_start();

include "nav.html";
include "button.html";

    
    $gmid=$_SESSION['gmid'];
    $group_number=$_SESSION['group_number'];

    // $sql = 'SELECT * FROM user WHERE privilege != "admin" and user_id !="'.$gmid.'"';
    $sql = 'SELECT * FROM user WHERE user_id NOT IN (SELECT user_id FROM group_data WHERE group_number = "' . $group_number . '") ORDER BY doj';


    $r=mysqli_query($con, $sql);

    if($r) {
        $udata=$r;
    } else {
        echo"<script>alert('Nodata Found');</script>";
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
        <p class="pp" id="req">LIST OF MEMBERS</p>
        <table border="5px" cellpadding="8px" align="center" cellspacing="5px" class="tb" style="height:100px; width:780px;  text-align:center; align-items:center;">
            <tr id="tr1"><th>NAME</th><th>EMAIL ID</th><th>MEMBER SELECTION</th></tr>
            <?php

        try{
            foreach ($udata as $i) {
                $name=$i['first_name'].$i['middle_name'].$i['last_name'];

                echo "<tr><td>$name</td>";
                echo"<td>$i[email]</td>";
                echo "<td><a href='grpinit.php?muid=$i[user_id]'  class='btn btn-danger' id='R'>SELECT</a></td>";

                echo "</tr>";
               

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
        }
        catch (Exception $e) 
        {
            echo "<script>alert('Error');</script>";
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