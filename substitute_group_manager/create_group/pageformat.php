<?php

include '../connection.php';
session_start();
// if(isset($_POST['user_id']))
// {
//     $user_id=$_POST['user_id'];
//     $group_number=$_POST['group_number'];
//     $group_type=$_POST['group_type'];
//     $privilege=$_POST['privilege'];
// // echo $user_id.','.$privilege;

// //stores gm userid as gmid
//     $_SESSION['mid']=$user_id;
//     $_SESSION['group_number']=$group_number;
//     $_SESSION['group_type']=$group_type;
//     $_SESSION['privilege']=$privilege;


// }
// else
// {
//     echo "Not coming";
// }


?>

<!DOCTYPE html>
<html>

<head>
    <title>MultiParty Authentication System</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            font-family: sans-serif;
            /* Change font style to sans-serif */
            background-color: #b8d5ff;
            overflow: hidden;
        }

        .container {
            width: 780px;
            height: 360px;
            margin: auto auto;
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin-top: 120px;
        }

        header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background-color: #100a89;
            padding: 15px;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header img {
            margin-left: 10px;
        }

        .profile {
            margin-top: 5px;
            margin-left: 5px;
            background-color: white;
        }

        .prof {
            flex-direction: row;
        }

        .txt {
            position: absolute;
            top: 16%;
            width: 18%;
            text-align: center;
            font-size: 15px;
        }

        nav ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            overflow: hidden;
        }

        nav li {
            float: left;
        }

        nav li a {
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }

        nav li a:hover {
            background-color: #1f84f7;
        }

        /* Added styling for the sub-menu */
        nav ul ul {
            display: none;
            position: absolute;
            background-color: #100a89;
            padding: 0;
            margin-top: 0;
        }

        nav ul li:hover>ul {
            display: inherit;
        }

        nav ul ul li {
            float: none;
            width: 100%;
        }

        nav ul ul a {
            padding: 10px 16px;
        }

        nav ul ul a:hover {
            text-decoration: underline;
            /* Add underline only on hover */
        }

        footer {
            background-color: #100a89;
            padding: 1px;
            /* Decrease the height of the footer */
            color: white;
            text-align: center;
            margin-top: auto;
        }

        footer p {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <?php
    $mid = $_SESSION['mid'];
    $query2 = "select * from user where user_id = '$mid'";
    $result2 = mysqli_query($con, $query2);
    $row = mysqli_fetch_assoc($result2);
    // try{
    // $name = $row['first_name']." ".$row['last_name'];
    // }
    // catch(Exception e)
    // {

    // }
    $name = $row['first_name'];
    /*IMage url from database..*/
    $sql34 = "SELECT photo_location FROM user WHERE user_id='$mid'";
    $rr = mysqli_query($con, $sql34);
    if ($rr) {
        $photo_location = mysqli_fetch_row($rr)[0];
        $photo_location = './%23' . substr($photo_location, 1, strlen($photo_location));
        $_SESSION['photo_location'] = $photo_location;
        // echo "photo_location: ".$_SESSION['photo_location'];
    } else {
        echo "<script>alert('Error in finding Image location');</script>";
    }
    ?>
    <header>
        <div class="prof">
            <img class="profile" src="user.jpg" alt="User Image" style="width: 50px; height: 50px;">
            <div class="txt">
                <h3><?php echo $name; ?> </h3>
            </div>
        </div>
        <nav>
            <ul>
                <li><a href="group.php">Home</a></li>
                <li><a href="requestmembership.php">Request Membership</a>
                    <ul>
                        <li><a href="requestform1.php">Become Manager</a></li>
                        <li><a href="requestform2.php">Become Member</a></li>
                        <li><a href="requestform3.php">Request for Removal</a></li>
                    </ul>
                </li>
                <li><a href="dataaccess.php">Data Access</a>
                    <ul>
                        <li><a href="fileupload.php">Upload file</a></li>
                        <li><a href="file.php">Access file</a></li>
                    </ul>
                </li>
                <li>
                    <a href="requestlist.php">Request List</a>
                    <ul>
                        <li><a href="sentlist.php">Sent</a></li>
                        <li><a href="receivedlist.php">Received</a></li>
                    </ul>
                </li>
                <li>
                    <?php
                    // // Check if the user is already logged in
                    // if (!isset($_SESSION['mid'])) {
                    // // Redirect to the login page if not logged in
                    // header("Location: index.php");
                    // exit();
                    // }

                    // Handle the logout process
                    if (isset($_GET['logout'])) {
                        // Clear all session variables
                        session_unset();

                        // Destroy the session
                        session_destroy();

                        // Redirect to the login page after logout
                        header("Location: index.php");
                        exit();
                    }
                    ?>

                    <!-- Logout button -->
                    <a href="index.php?logout=true">Logout</a>
                </li>
            </ul>
        </nav>
    </header>

    <!-- Page Content Goes Here -->


</body>

</html>