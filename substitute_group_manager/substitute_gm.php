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
    <link rel="stylesheet" href="../css/substitute.css" />
    <script src="https://kit.fontawesome.com/4fd4293e71.js" crossorigin="anonymous"></script>
</head>


<body>
    <footer>
        <p>MAS : MULTIPARTY AUTHENTICATION SYSTEM</p>
    </footer>


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
                    <a class="navbar-link" href="#">Substitute Group
                        Manager</a>
                </li>
                <li>
                    <a class="navbar-link" href="../view_group/vg_option.php">View Group</a>
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
                <h1>Group Manager Substitution</h1>
            </section>
            <section class="table__body">
                <table>
                    <thead class="table_attribute">
                        <tr>
                            <!-- <th>Group Name</th> -->
                            <th>Group Number</th>
                            <th>Group Manager</th>
                            <th>Group Type</th>
                            <th>Operation</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php
                        include("../connection.php");
                        error_reporting(0);
                        // -> table_name
                        $query = "SELECT * FROM  user where status = 'a'";
                        $data = mysqli_query($con, $query);
                        $total = mysqli_num_rows($data);


                        if ($total != 0) {
                            while ($result = mysqli_fetch_assoc($data)) {
                                echo "
    <tr>
    <td>" . $result['group_number'] . "</td>
    <td>" . $result['fname'] . " " . $result['mname'] . " " . $result['lname'] . "</td>
    <td>" . $result['group_type'] . "</td>
    <td>
    <button> <a href='substitute_request.php?rid=$result[group_number]'>substitute </a></button>
    </td>
  </tr> 
 ";
                            }
                        } else {

                            echo '<script>alert("No more Groups Found!!")</script>';
                        }
                        ?>
                    </tbody>
                </table>
            </section>
        </main>
    </div>

</body>

</html>