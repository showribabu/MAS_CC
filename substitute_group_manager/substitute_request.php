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
    <link rel="stylesheet" href="../css/gm_request.css" />
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
                    <a class="navbar-link" href="create_group/gm_request.php">Request List</a>
                </li>
                <li>
                    <a class="navbar-link" href="create_group/select_member.php">Create Group</a>
                </li>
                <li>
                    <a class="navbar-link" href="delete_group/grp_deletion.php">Delete Group</a>
                </li>
                <li>
                    <a class="navbar-link" href="substitute_group_manager/substitute_gm.php">Substitute Group
                        Manager</a>
                </li>
                <li>
                    <a class="navbar-link" href="view_group/vg_option.php">View Group</a>
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
                <h1>Probable Group Manager</h1>
            </section>
            <section class="table__body">
                <table>
                    <thead class="table_attribute">
                        <tr>
                            <!-- <th>Serial Number</th> -->
                            <!-- <th>User Id</th> -->
                            <th>Request Id</th>
                            <th>User Name</th>
                            <th>Operations</th>
                        </tr>
                    </thead>
                    <!-- ... previous HTML code ... -->

                    <tbody>
                        <?php
                        include("../connection.php");
                        error_reporting(0);
                        // yahin wo point hai jahan se we can remove the data 
                        $rid =  $_GET['rid'];
                        // echo $rid;

                        $sql1 = "UPDATE group_created_data SET status = 'x' WHERE group_number = '$rid'";
                        // $sql = "DELETE FROM user WHERE request_id = '$rid'";
                        $result1 = mysqli_query($con, $sql1) or die("Query Unsuccessful");
                        // => table_name

                        $query = "SELECT * FROM user where status = 'r'";
                        $data = mysqli_query($con, $query);
                        $total = mysqli_num_rows($data);
                        session_start();
                        if ($total != 0) {
                            while ($result = mysqli_fetch_assoc($data)) {
                                $requestId = $result['request_id'];
                                $admin_name_ = $result['fname'] . " " . $result['midname'] . " " .  $result['lname'];

                                echo "
<tr>
    <td>$requestId</td>
    <td>$admin_name_</td>
    <td>
        <div class='container'>

        <button onclick='accepted()' class='accept-button'><a href='process.php?rid=$result[request_id]'>Approve</a></button>
        </div>
        </td>
        </tr>";
                            }
                        } else {
                            echo '<script>
            alert("No More Requests Found !!")
        </script>';
                        }
                        ?>
                    </tbody>





                </table>
            </section>
        </main>
    </div>


    <script>
        function accepted() {
            alert("Request Accepted");
        }

        function rejected() {
            alert("Request Rejected");
        }
    </script>
    <footer>
        <p>MAS : MULTIPARTY AUTHENTICATION SYSTEM</p>
    </footer>
</body>

</html>