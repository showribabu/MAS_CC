<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
   include "conn.php";
   session_start();
  
   //including navigation bar page
   include "nav.html";

   //including styles page
   include "button.html";
   $group_type=$_SESSION['group_type'];
   $group_number=$_SESSION['group_number']; 
   $gm_id=$_SESSION['gmid'];
   global  $group_type, $group_number, $gm_id;


?>
    <div class="data">
        <!-- <h1>Members Of The Group</h1> -->
        <p class="pp" id="req">MEMBERS OF THE GROUP</p>

            <table border="5px" cellpadding="8px" align="center" cellspacing="5px" class="tb" style="height:80px; width:780px;  text-align:center; align-items:center;">
                <tr id="tr1">
                    <th>NAME</th>
                    <th>EMAIL ID</th>
                    <th>ACTIVITY STATUS</th>
                    <th>ACTION</th>
                </tr>    
<?php


    displayGroupMem();
    function displayGroupMem()
    {
   
        //  $host='localhost';
        //  $user='root';
        //  $pass='';
        //  $db='MAS';
        //  $con=mysqli_connect($host,$user,$pass,$db);
         global $group_number;
         global $con;    
         $sql = "SELECT user_id, activity_status FROM group_data WHERE group_number = '$group_number'  && (activity_status='active' || activity_status='suspended') && privilege!='gm'";
         $result = mysqli_query($con, $sql);

         if ($result && mysqli_num_rows($result) > 0)
         {
            while ($member = mysqli_fetch_assoc($result))
            {
                echo "<tr>";
                // echo "<td>" . $member['user_id'] . "</td>";

                $user_id=$member['user_id'];

                $query = "SELECT * FROM user WHERE user_id = '$user_id'";
                $res = mysqli_query($con, $query);
                $row1 = $res->fetch_assoc();

                if ($row1) {
                    $name=$row1['first_name'].$row1['middle_name'].$row1['last_name'];
                    echo "<td>" . $name . "</td>";
                    echo "<td>" . $row1['email'] . "</td>";
                } 

                echo "<td>" . $member['activity_status'] . "</td>";

                if ($member['activity_status'] == 'active') {
                    echo "<td><a href='#' class='btn btn-success' id='A'>ACTIVE</a></td>";
                }
                else if($member['activity_status'] == 'suspended')
                {
                    echo "<td><a href='#' class='btn btn-danger' id='A'>SUSPENDED</a></td>";

                }
                else
                {
                    echo "<td>" . $member['activity_status'] . "</td>";

                }
                echo "</tr>";
            }
        } 
        // else
        // {
        //     echo "No group members found.";
        // }
    

        mysqli_close($con);
    }
?>
         </table>
    </div>
    
   
           
    <div class='pic'>
              <img src="<?php echo $_SESSION['photo_location'];?>" alt="group manager">
    </div>

    <p class="data2"><?php echo $_SESSION['name'];?></p>

    <footer>
        <p>MAS : MULTI PARTY AUTHENTICATION SYSTEM</p>
    </footer>
</body>
</html>