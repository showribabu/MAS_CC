<?php


include "conn.php";
session_start();

include "nav.html";
include "button.html";


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
    <!-- <div class="hd">
        <h2>GROUP MANAGER</h2>
        <nav>

            <li><a href="group.php">Home</a></li>
            <li id="grp"><a href="#">Add a Member</a>
                <ul class="sub-menu">
                    <li ><a href="request.php" >From Requestlist</a></li>
                    <li><a href="groupinit.php" >By Selecting</a></li>
                </ul>
            </li>
            <li><a href="remove.php">Remove</a></li>
            <li><a href="suspend.php">Suspend</a></li>
            <li><a href="unsuspend.php">Suspended Members</a></li>
            <li><a href="group_view.php">Group View</a></li>
            <li><a href="gmstatus.php">Status</a></li>
            <li id="grp"><a href="#" >Data Access</a>
                <ul class="sub-menu">
                    <li><a href="fileupload.php">Upload file</a></li>
                    <li><a href="files.php">Access file</a></li>
                </ul>
            </li>
            <li><a href="index.php">Logout</a></li>
        </nav>
    </div> -->
    <div class="data">
        
            <p class="pp" id="req">STATUS OF REQUESTS</p>

        <table class="tb"  border="5px" cellpadding="8px" align="center" cellspacing="5px" style="height:80px; width:780px;  text-align:center; align-items:center;">
            <tr id="tr1"><th>NAME</th><th>EMAIL ID</th><th>MEMBER SELECTION</th><th>STATUS</th></tr>
            <?php
            $gmid=$_SESSION['gmid'];
            $group_number=$_SESSION['group_number'];

                // $sql = 'SELECT * FROM requests where request_from="'.$gmid.'"';

                $sql = 'SELECT * FROM requests WHERE request_from = "' . $gmid . '" AND request_to NOT IN (SELECT user_id FROM group_data WHERE group_number = "'.$group_number .' ")';

                $r=mysqli_query($con, $sql);

                if($r) 
                {
                    $udata=$r;
                    foreach ($udata as $i) 
                    {

                        $sql5="select first_name,middle_name,last_name,email from user where user_id='$i[request_to]'";
                        $r5=mysqli_query($con,$sql5);
                        if($i['r_status']=='a' || $i['r_status']=='p' || $i['r_status']=='r')
                        {
                            if($r5)
                            {
                                $row=$r5->fetch_assoc();
                                $name=$row['first_name'].$row['middle_name'].$row['last_name'];
                                echo "<tr><td>$name</td>";
                                echo"<td>$row[email]</td>";
                                echo "<td>Selected</td>";
                            
                            if ($i['r_status'] == 'a') {
                                echo "<td class='status accepted'><a href='credentials.php?user_id={$i['request_to']}' class='btn btn-success' id='A'>Accepted</a></td>";
                            } elseif ($i['r_status'] == 'r') {
                                echo "<td class='status rejected'><a href='#' class='btn btn-danger' id='R'>Rejected</a></td>";
                            } elseif ($i['r_status'] == 'p') {
                                echo "<td class='status pending'><a href='#' class='btn btn-warning' id='P'>Pending</a></td>";
                            } else {
                                echo "<td>$i[r_status]</td>";
                            }
                        
                            echo "</tr>";
                            }
                            // echo "<tr><td>$i[request_to]</td>";
                            // echo "<td><a href='#' class='btn btn-success' id='R'>SELECTED</a></td>";
                        
                    
                        }
                    }
                } 
                else 
                {
                    echo"<script>alert('Nodata Found');</script>";
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

