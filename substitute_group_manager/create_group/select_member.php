<?php
session_start();
$admin_id_ = $_SESSION['user_id'];
$admin_name_ = $_SESSION['admin_name_'];
include '../connector.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <link rel="stylesheet" href="../css/select_member.css" />
    <script src="https://kit.fontawesome.com/4fd4293e71.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
</head>

<body>
    <header class="header">
        <div class="details">
            <img src="../images/admin.png" alt="Profile Picture" />


        </div>
        <div class="user_name">
            <!-- <p>Admin Name</p> -->
            <p> <?php echo $admin_name_; ?></p>
        </div>
        <p class="hello">ADMIN</p>

        <!-- for creation of nav bar -->
        <nav class="navbar">
            <ul class="navbar-list">
                <li>
                    <a class="navbar-link" href="../admin_home_page.php">Home</a>
                </li>
                <li>
                    <a class="navbar-link" href="../create_group/gm_request.php">Request List</a>
                </li>
                <li>
                    <a class="navbar-link" href="#">CREATE</a>
                </li>
                <li>
                    <a class="navbar-link" href="../delete_group/grp_deletion.php">DELETE</a>
                </li>
                <li>
                    <a class="navbar-link" href="../substitute_group_manager/substitute_gm.php">SUBSTITUTE</a>
                </li>
                <li>
                    <a class="navbar-link" href="../view_group/vg_option.php">VIEW</a>
                </li>
                <li>
                    <a class="navbar-link" href="../index.php">Log Out</a>
                </li>

            </ul>
        </nav>

        <div class="mobile-navbar-btn">
            <ion-icon name="menu-outline" class="mobile-nav-icon"></ion-icon>
            <ion-icon name="close-outline" class="mobile-nav-icon"></ion-icon>
        </div>
    </header>

    <div class="container">
        <h4 class="header1">Select Group Type</h4>

        <div class="button">


            <div class="requestlist">
                <button id="typea"><a href="gm_selected.php?tid=A">Type A</a></button>
                <button id="typeb"><a href="gm_selected.php?tid=B">Type B</a></button>
                <button id="typec"><a href="gm_selected.php?tid=C">Type C</a></button>
                <button id="typed"><a href="gm_selected.php?tid=D">Type D</a></button>
            </div>
        </div>
    </div>
    <footer>
        <p>MAS : MULTIPARTY AUTHENTICATION SYSTEM</p>
    </footer>
</body>

</html>