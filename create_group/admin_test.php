<?php
session_start();
$admin_user = $_SESSION['user_id'];
include "../connection.php";


$sql1 = "select * from admin  WHERE user_id = '$admin_user'";

$result1 = mysqli_query($con, $sql1) or die("Query Unsuccessful");


if (mysqli_num_rows($result1) > 0) {
    while ($data = mysqli_fetch_assoc($result1)) {
        $x = $data['secret'];
        echo "admin password -> " . $data['secret'];
    }
} else {
    echo "<br> admin Password doesn't found out";
}
