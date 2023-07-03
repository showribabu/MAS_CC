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
    <link rel="stylesheet" href="../css/gm_selected.css" />
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
                    <a class="navbar-link" href="gm_request.php">Request List</a>
                </li>
                <li>
                    <a class="navbar-link" href="select_member.php">Create Group</a>
                </li>
                <li>
                    <a class="navbar-link" href="../delete_group/grp_deletion.php">Delete Group</a>
                </li>
                <li>
                    <a class="navbar-link" href="../substitute_group_manager/substitute_gm.php">Substitute Group
                        Manager</a>
                </li>
                <li>
                    <a class="navbar-link" href="../view_group/vg_option.php">View Group</a>
                </li>
                <li>
                    <a class="navbar-link" href="#">Log Out</a>
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
            <div class="admin">
                <h1 class="admin_details">Admin Page</h1>
            </div>
            <section class="table__header">
                <h1>Selected Member List</h1>

            </section>
            <section class="table__body">
                <table>
                    <thead class="table_attribute">
                        <tr>
                            <!-- <th>Serial Number</th> -->
                            <!-- <th>User Id</th> -->
                            <!-- <th>User Id</th> -->
                            <!-- <td>" . $result['user_id']   . "</td> -->
                            <th>Email</th>
                            <th>User Name</th>
                            <!-- <th>Group Type</th> -->
                            <th>Operations</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php
                        // working
                        // $dum['tid'] = $_GET['tid'];


                        include("../connector.php");
                        error_reporting(0);
                        // => table_name

                        $query = "SELECT * FROM user";
                        $data = mysqli_query($con, $query);
                        $total = mysqli_num_rows($data);
                        if ($total != 0) {
                            while ($result = mysqli_fetch_assoc($data)) {

                                // echo $uid = $result['user_id'];
                                $tid = $_GET['tid'];
                                $uid = $result['user_id'];


                                echo "
  <tr>
   
    <td>" . $result['email']   . "</td>
    <td>" . $result['first_name'] . " " . $result['middle_name'] . " " .  $result['last_name'] . "</td>
    <td>
    <div class='container'>

    <button onclick='accepted()' class='accept-button'><a href='gm_selected_accepted.php?uid=$uid&tid=$tid'>Accept</a></button>
                        ";
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
            alert("Clicked on Accept Button ");

        }

        function rejected() {
            alert("clicked on rejected Button");
        }
    </script>
    <footer>
        <p>MAS : MULTIPARTY AUTHENTICATION SYSTEM</p>
    </footer>
</body>

</html>