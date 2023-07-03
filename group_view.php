<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .container {
            width: 720px;
            margin: 100px auto;
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            /* overflow-y: scroll;
            max-height:500px; */
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 22px;
        }
 
        th, td {
            padding: 8px;
            text-align: left;
            border: 2px solid blue;
            background-color: lightgray;
            font-size: 22px;
            text-align: center;
        }
        th{
            /* background-color: rgb(103 98 185/48%); */
            background-color: rgba(212, 148, 255, 0.966);
            /* background-color: rgb(142 136 251 0.864); */
            color:black;
            font-size: 24px;
        } 

        /* th, td {
            padding: 8px;
            text-align: left;
            border:2px solid blue;
            font-size: 22px;
        }
        th{
            /* background-color: rgb(103 98 185/48%); */
            /* background-color: rgba(212, 148, 255, 0.966); */
            /* background-color: rgb(142 136 251 0.864); */
            /* background-color:rgb(220, 211, 211);  */
/* 
            color:black;
            font-size: 24px;
        } */
        h1{
            text-align: center;
            background-color: rgb(103 98 185/48%);
            padding:4px;
        }
        .table_container{
            overflow-y: scroll;
            max-height:351px;
        }
        .table_container table thead {
        position: sticky;
        top: 0;
        z-index: 1;
    }


    </style>
</head>
<body>
<?php


include "conn.php";
session_start();

include "nav.html";
include "button.html";
     $group_type=$_SESSION['group_type'];
     $group_number=$_SESSION['group_number']; 
     $gm_id=$_SESSION['gmid'];
     global  $group_type, $group_number, $gm_id;


  ?>
    <div class="container">
        <h1>Members Of The Group</h1>
        <?php


        displayGroupMem();
        function displayGroupMem()
        {
            $host='localhost';
            $user='root';
            $pass='';
            $db='MAS';
            $con=mysqli_connect($host,$user,$pass,$db);

            // include "conn.php";
            global $group_number;
         
         if(!$con)
         {
             echo die('Error:'.mysqli_connect_error());
         }
            // include 'conn.php';
        $sql = "SELECT user_id, activity_status FROM group_data WHERE group_number = '$group_number'  && (activity_status='active' || activity_status='suspended') && privilege!='gm'";
        $result = mysqli_query($con, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            echo "<div class='table_container'>";
            echo "<table>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>User ID</th>";
            echo "<th>Name</th>";
            echo "<th>Email</th>";
            echo "<th>Activity Status</th>";
            echo "</thead>";
            echo "<tbody>";
            // echo "<th>Action</th>";
            echo "</tr>";

            while ($member = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $member['user_id'] . "</td>";
                $user_id=$member['user_id'];
                // echo "<td>**NAME***</td>";
                // echo "<td>**MAIL***</td>";
                // echo "<td>**Privilege***</td>";

                

                $query= "SELECT first_name, email FROM user WHERE user_id = '$user_id'";
                $query= "SELECT * FROM user WHERE user_id = '$user_id'";

                $res = mysqli_query($con, $query);
                $row1 = $res->fetch_assoc();
              
                if ($row1) { 
                  echo "<td>" . $row1['first_name'] . "</td>";
                // echo "<td>**NAME***</td>";

                  echo "<td>" . $row1['email'] . "</td>";
                // echo "<td>**MAIL***</td>";

                }
                 else {
                  echo "<td>-</td>";
                 echo "<td>-</td>";
                  }

             echo "<td>" . $member['activity_status'] . "</td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
            echo "</div>";
        } else {
            echo "No group members found.";
        }
    

        mysqli_close($con);
    }
        ?>
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