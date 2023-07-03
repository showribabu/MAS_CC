<?php

include 'conn.php';
session_start();
if(isset($_SESSION['mid']))
{

    $_SESSION['mid']=$_SESSION['mid'];
}



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
            background-color:#b8d5ff;
            overflow: hidden;
        }
        .container {
            width: 600px;
            height: 360px;
            margin: auto auto;
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin-top:60px;
        }

        header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background-color: #100a89;
            padding-top: 5px;
            padding-left: 15px;
            padding-right: 15px;
            padding-bottom: 5px;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header img {
            margin-left: 10px;
            max-height:50px;
        }

        .profile {
            margin-top: 5px;
            margin-left: 5px;
            background-color: white;
            /* height:15px; */
        }
        /* .profile img{
            height:10px;
            width:20px;
        } */
        .prof {
            flex-direction:row;
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
$result2 = mysqli_query($con,$query2);
$row = mysqli_fetch_assoc($result2);
$name = $row['first_name'];
$imgsrc = $row['photo_location'];


    ?>
    <header>
        <div class="prof">
        <img class="profile" src="<?php echo "./".$imgsrc ?>" alt="User Image" style="width: 50px; height: 50px;">
        <div class="txt">
        <h3><?php echo $name;?> </h3>
        </div>
    </div>
        <nav>
            <ul>
                <li><a href="group.php">Home</a></li>
                <li><a href="request_membership.php">Request Membership</a>
                    <ul>
                        <li><a href="request_form1.php">Become Manager</a></li>
                        <li><a href="request_form2.php">Become Member</a></li>
                    </ul>
                </li>

                <li>
                    <a href="request_list.php">Request List</a>
                    <ul>
                        <li><a href="sent_list.php">Sent</a></li>
                        <li><a href="received_list.php">Received</a></li>
                    </ul>
                </li>
                <li>
                    <a onclick="logout()" href="index.php">Logout</a>
                </li>
            </ul>
        </nav>
    </header>

    <!-- Page Content Goes Here -->
<!-- <script>
 function logout(){
    </script>
<?php
session_abort();
echo "hi";
?>
<script>
alert("hi");
window.location.href="index.php";
 }
</script> -->

</body>

</html>
