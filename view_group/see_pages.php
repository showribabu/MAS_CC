<?php
session_start();
$admin_id_ = $_SESSION['user_id'];
$admin_name_ = $_SESSION['admin_name_'];
include '../connector.php';
?>

<!DOCTYPE html>
<html lang="en" title="Coding design">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Group Manager Request</title>
    <link rel="stylesheet" href="../css/grp_deletion.css" />
    <script src="https://kit.fontawesome.com/4fd4293e71.js" crossorigin="anonymous"></script>
</head>


<body>

    <header class="header">
        <div class="details">
            <img src="../pngwing.com.png" alt="Profile Picture" />


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
                    <a class="navbar-link" href="../create_group/select_member.php">Create Group</a>
                </li>
                <li>
                    <a class="navbar-link" href="../delete_group/grp_deletion.php">Delete Group</a>
                </li>
                <li>
                    <a class="navbar-link" href="../substitute_group_manager/substitute_gm.php">Substitute Group
                        Manager</a>
                </li>
                <li>
                    <a class="navbar-link" href="vg_option.php">View Group</a>
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

    <div class="table_data">
        <main class="table">

            <section class="table__header">
                <h1>GROUPS LIST</h1>
            </section>
            <section class="table__body">
                <table>
                    <thead class="table_attribute">
                        <tr>
                            <!-- <th>Serial Number</th> -->
                            <!-- <th>User Id</th> -->
                            <th>Group Manager</th>
                            <th>Group Type</th>
                            <th>Group Number</th>
                            <th>Email</th>
                            <th>contact</th>
                            <th>Group Creation Date</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        include("../connection.php");
                        error_reporting(0);
                        $query1 = "SELECT * FROM group_data ";
                        $data1 = mysqli_query($con, $query1);
                        $total1 = mysqli_num_rows($data1);
                        if ($total1 != 0) {
                            while ($result1 = mysqli_fetch_assoc($data1)) {
                                $uid = $result1['user_id'];
                                $query2 = "select * from user where user_id = '$uid'";
                                $result2 = mysqli_fetch_assoc(mysqli_query($con, $query2));

                                echo "
                                        <tr>
                                        <td>" . $result2['first_name'] . " " . $result2['middle_name'] . " " .  $result2['last_name'] . "</td>
                                        <td>" . $result1['group_type'] . "</td>
                                        <td>" . $result1['group_number'] . "</td>
                                        <td>" . $result2['email'] . "</td>
                                        <td>" . $result2['contact'] . "</td>
                                        <td>" . $result1['creation_time'] . "</td>
                                        </tr>";
                            }
                        } else {

                            echo '<script>
                    alert("No more Groups Present!!")
                    </script>';
                        }
                        ?>

                    </tbody>
                </table>
            </section>
        </main>
    </div>
    <footer>
        <p>MAS : MULTIPARTY AUTHENTICATION SYSTEM</p>
    </footer>



</html>