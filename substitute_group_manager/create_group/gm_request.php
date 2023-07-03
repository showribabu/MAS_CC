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
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>adminPage</title>
    <link rel="stylesheet" href="../css/gm_request.css" />
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
            <img src="../images/admin.png" alt="Profile Picture" />


        </div>
        <div class="user_name">
            <!-- <p>Admin Name</p> -->
            <p> <?php echo $admin_name_; ?></p>
        </div>
        <p class="hello">ADMIN</p>
        <!-- for creation of nav bar -->


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
                    <a class="navbar-link" href="select_member.php">CREATE</a>
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


    <div class="table_data">

        <main class="table">
            <section class="table__header">
                <h1>Requested Members List</h1>
            </section>
            <section class="table__body">
                <table>
                    <thead class="table_attribute">
                        <tr>

                            <th>User Name</th>
                            <th>Group Type</th>
                            <!-- <th>Email</th> -->
                            <th>Message</th>

                            <th>Operations</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        include("../connector.php");
                        error_reporting(0);
                        // => table_name   

                        $query = "SELECT * FROM requests JOIN user ON requests.request_from = user.user_id where r_status = 'p' ";
                        // $query = "SELECT * FROM requests ";
                        $data = mysqli_query($con, $query);
                        $total = mysqli_num_rows($data);
                        if ($total != 0) {
                            while ($result = mysqli_fetch_assoc($data)) {
                                $username = $result['first_name'] . " " . $result['middle_name'] . " " .  $result['last_name'];
                                $groupType = $result['group_type'];
                                $email = $result['email'];
                                $message = $result['message'];
                                echo "
<tr>

<td>$username </td>
<td>$groupType</td>
    <td>$message</td>
    <td>
    
        <div class='container'>

                        <button onclick='accepted()' class='accept_button'><a href='gm_request_accepted.php?rid={$result['request_id']}&uid={$result['request_from']}&gt={$result['group_type']}'>Accept</a></button>
                        <button onclick='rejected()'  class='reject_button'><a href='rejected.php?rid={$result['request_id']}'>Reject</a></button>
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
            // <
            // a class = "navbar-link"
            // href = "../index.php" > Log Out < /a>



        }
    </script>

    <footer>
        <p>MAS : MULTIPARTY AUTHENTICATION SYSTEM</p>
    </footer>

</body>

</html>