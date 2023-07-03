<?php
session_start();
$admin_id_ = $_SESSION['user_id'];
$admin_name_ = $_SESSION['admin_name_'];
include '../connector.php';

$rej_uid = $_GET['uid'];
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
                    <a class="navbar-link" href="../create_group/select_member.php">CREATE</a>
                </li>
                <li>
                    <a class="navbar-link" href="#">DELETE</a>
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

    <div class="table_data">
        <main class="table">

            <section class="table__header">
                <h1>Select Substitute</h1>
            </section>
            <section class="table__body">
                <table>
                    <thead class="table_attribute">
                        <tr>
                            <!-- <th>User Id</th> -->
                            <th>Group Manager</th>
                            <th>Email</th>
                            <th>Contact</th>
                            <th>Operations</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include("../connector.php");
                        error_reporting(0);
                        $query1 = "SELECT * FROM group_data where user_id <> '$rej_uid'";
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
                                        <td>" . $result2['email'] . "</td>
                                        <td>" . $result2['contact'] . "</td>
                                        <td>
                                          <button> <a href='process.php?uid={$result1['user_id']}&gnum={$result1['group_number']}&rej_id=$rej_uid'>confirm</a></button> 
                                        </td>
                                        
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
</body>


<!--      <a href='delete_helper.php?request_id = <?php echo 'hello' ?> '>Delete</a>
 -->

</html>