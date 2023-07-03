<?php
session_start();
// error_reporting(0);
// receiving the user_id passed from log_in page
$admin_user_ = $_SESSION['user_id'];
include 'connector.php';

$query1 = "select * from admin where user_id = '$admin_user_'";
$result1 = mysqli_query($con, $query1);
$row = mysqli_fetch_assoc($result1);
$admin_name_ = $row['first_name'] . " " . $row['middle_name'] . " " . $row['last_name'];
$_SESSION['admin_name_'] = $admin_name_;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>adminPage</title>
    <link rel="stylesheet" href="css/admin_home_page.css" />
    <style>
        .group-buttons {
            display: none;
        }
    </style>
    <script src="https://kit.fontawesome.com/4fd4293e71.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
</head>

<body>

    <header class="header">
        <div class="details">
            <img src="images/admin.png" alt="Profile Picture" />


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
                    <a class="navbar-link" href="create_group/gm_request.php">Request List</a>
                </li>
                <li>
                    <a id="create-group-btn" onclick="showGroupButtons()" class="navbar-link" href="create_group/select_member.php">CREATE</a>
                </li>
                <li>
                    <a class="navbar-link" href="delete_group/grp_deletion.php">DELETE</a>
                </li>
                <li>
                    <a class="navbar-link" href="substitute_group_manager/substitute_gm.php">SUBSTITUTE</a>
                </li>
                <li>
                    <a class="navbar-link" href="view_group/vg_option.php">VIEW</a>
                </li>
                <li>
                    <a class="navbar-link" href="index.php">Log Out</a>
                </li>

            </ul>
        </nav>

        <div class="mobile-navbar-btn">
            <ion-icon name="menu-outline" class="mobile-nav-icon"></ion-icon>
            <ion-icon name="close-outline" class="mobile-nav-icon"></ion-icon>
        </div>

        <div id="group-buttons-container" class="group-buttons">
            <button onclick="handleGroupSelection('A')">Type A</button>
            <button onclick="handleGroupSelection('B')">Type B</button>
            <button onclick="handleGroupSelection('C')">Type C</button>
            <button onclick="handleGroupSelection('D')">Type D</button>
        </div>



    </header>




    <main>
        <section class="section-hero">
            <div class="hero">
                <p>Welcome to Admin Page</p>
            </div>
        </section>
    </main>


    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script src="javaScript/admin_home_page.js"></script>

    <script>
        function showGroupButtons() {
            var groupButtonsContainer = document.getElementById(
                "group-buttons-container"
            );
            var createGroupBtn = document.getElementById("create-group-btn");

            groupButtonsContainer.style.display = "block";
            createGroupBtn.style.marginBottom = "10px";
        }

        function handleGroupSelection(type) {
            alert("Group " + type + " selected!");
        }
    </script>


    <footer>
        <p>MAS : MULTIPARTY AUTHENTICATION SYSTEM</p>
    </footer>
</body>

</html>