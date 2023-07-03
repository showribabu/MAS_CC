<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        /* .suspend {
            background-color: red;
            color: white;
            padding: 5px 10px;
            border: none;
            cursor: pointer;
        } */
    </style>
  
</head>
<body>
<?php
include "conn.php";
session_start();

include "nav.html";
include "button.html";

$group_type = $_SESSION['group_type'];
$group_number = $_SESSION['group_number'];
$gm_id = $_SESSION['gmid'];
?>
<div class="data">
    <p class="pp" id="req">MEMBERS OF THE GROUP</p>
    <table border="5px" cellpadding="8px" align="center" cellspacing="5px" class="tb" style="height:80px; width:780px;  text-align:center; align-items:center;">
        <tr id="tr1">
            <th>NAME</th>
            <th>EMAIL ID</th>
            <th>ACTIVITY STATUS</th>
            <th>ACTION</th>
        </tr>
        <?php
        global $con;
        $sql = "SELECT user_id, activity_status FROM group_data WHERE group_number = '$group_number' && (activity_status='active' ) && privilege!='gm'";
        $result = mysqli_query($con, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            while ($member = mysqli_fetch_assoc($result)) {
                echo "<tr>";

                // echo "<td>" . $member['user_id'] . "</td>";

                $user_id = $member['user_id'];

                $query = "SELECT * FROM user WHERE user_id = '$user_id'";
                $res = mysqli_query($con, $query);
                $row1 = $res->fetch_assoc();

                if ($row1) {
                    $name=$row1['first_name'].$row1['middle_name'].$row1['last_name'];
                    echo "<td>" . $name . "</td>";
                    echo "<td>" . $row1['email'] . "</td>";
                } 

                echo "<td>" . $member['activity_status'] . "</td>";

                // Display the "Suspend" button only if the user is not already suspended
                if ($member['activity_status'] != 'suspended') {
                    echo "<td>";
                    echo "<form method='POST'>";
                    echo "<input type='hidden' name='userId' value='" . $member['user_id'] . "'>";
                    $user_id = $member['user_id'];
                    // echo "<input type='submit' name='suspendButton' value='Suspend' class='suspend'>";
                    echo "<input type='submit' name='suspendButton' value='Suspend' class='btn btn-danger'>";


                    echo "</form>";
                    echo "</td>";
                } else {
                    echo "<td id='txt'>Suspended</td>";
                }

                echo "</tr>";
            }
        } 
        // else {
        //     echo "There are no members in the group";
        // }

        // Function to suspend a user by updating the activity_status in the groupdata table as suspended for type A or C or D
        function suspendUserAC($userId)
        {
            global $con;
            $sql = "UPDATE group_data SET activity_status = 'suspended' WHERE user_id = '$userId'";
            $result = mysqli_query($con, $sql);
            if ($result) {
                echo "<script>alert('User ID: " . $userId . " suspended successfully.');</script>";
            } else {
                echo "Error suspending user: " . mysqli_error($con) . "<br><br>";
            }
        }

       // Function to suspend a user by updating the activity_status in the groupdata table as suspended for type B
        function suspendUserB($userId)
        {
            global $con;
            global $gm_id;
            global $group_number;

            $query1 = "SELECT enc_key, mv, pgk FROM group_data WHERE user_id='$userId' AND group_number='$group_number'";
            $result1 = mysqli_query($con, $query1);

            if ($result1) {
                $row = $result1->fetch_assoc();

                if ($row) {
                    $enc_key = $row['enc_key'];
                    $mv = $row['mv'];
                    $pgpk = $row['pgk'];

                    $query2 = "SELECT secret FROM user WHERE user_id='$gm_id'";
                    $result2 = mysqli_query($con, $query2);
                    $row2 = $result2->fetch_assoc();

                    if ($row2) {
                        $gm_secret_dec = $row2['secret'];

                        // Update the activity_status as suspended
                        $query3 = "UPDATE group_data SET activity_status='suspended'  WHERE user_id='$userId' AND group_number='$group_number'";
                        $result3 = mysqli_query($con, $query3);

                        if ($result3) {
                            echo "<script>alert('User ID: " . $userId . " suspended successfully.');</script>";
                        } else {
                            echo "Error suspending user: " . mysqli_error($con) . "<br><br>";
                        }

                    } else {
                        echo "Error in retrieving group manager's secret";
                    }
                } else {
                    echo "Error fetching enc_key, mv, and pgk";
                }
            } else {
                echo "Error in query execution: " . mysqli_error($con);
            }
        }

        // Check if the suspendButton form is submitted
        if (isset($_POST['suspendButton'])) {
            $userId = $_POST['userId'];

            if ($group_type == 'A' || $group_type == 'C' || $group_type == 'D') {
                suspendUserAC($userId);
            } else if ($group_type == 'B') {
                suspendUserB($userId);
            }
        }

        mysqli_close($con);
        ?>
    </table>
</div>
<div class='pic'>
    <img src="<?php echo $_SESSION['photo_location']; ?>" alt="group manager">
</div>

<footer>
    <p>MAS : MULTI PARTY AUTHENTICATION SYSTEM</p>
</footer>

<script>
    var groupType = "<?php echo $group_type; ?>";
</script>
<p class="data2"><?php echo $_SESSION['name']; ?></p>

</body>
</html>