<?php
// getting id of clicked user
session_start();
$admin_user = $_SESSION['user_id'];
include "../connection.php";
$rid = $_GET['rid'];

echo "<br>";

$sql = "select * from user  WHERE request_id = '$rid'";
$sql1 = "select * from user  WHERE userid = '$admin_user'";

$result = mysqli_query($con, $sql) or die("Query Unsuccessful");
$result1 = mysqli_query($con, $sql1) or die("Query Unsuccessful");
if (mysqli_num_rows($result) > 0) {
    while ($data = mysqli_fetch_assoc($result)) {
        $u =  $data['password'];
        echo "user Password -> " . $data['password'];
    }
} else {
    echo "<br> Password doesn't found out";
}
echo "<br>";


if (mysqli_num_rows($result1) > 0) {
    while ($data = mysqli_fetch_assoc($result1)) {
        $x = $data['password'];
        echo "admin password -> " . $data['password'];
    }
} else {
    echo "<br> admin Password doesn't found out";
}

$x_hexVal = hexdec($x);
$u_hexVal = hexdec($u);

$sql2 = "INSERT INTO groupdata (x,u) VALUES ('$x_hexVal','$u_hexVal')";
$result2 = mysqli_query($con, $sql2) or die("Query Unsuccessful");

// db.php


$query1 = 'SELECT * FROM server_param where serial = 7';
$data1 = mysqli_query($con, $query1) or die('query unsuccessful');


$total1 = mysqli_num_rows($data1);


if ($total1 != 0) {
    while ($result1 = mysqli_fetch_assoc($data1)) {
        $q = $result1['q'];
        $s =  $result1['s'];
        $gpk =  $result1['gpk'];
        $p =  $result1['p'];
    }
}

echo "<br> $u_hexVal' ";

$query2 = "SELECT * FROM groupdata where u = '$u_hexVal'";
$data2 = mysqli_query($con, $query2) or die('query unsuccessful');


$total2 = mysqli_num_rows($data2);


if ($total2 != 0) {
    while ($result2 = mysqli_fetch_assoc($data2)) {
        $x = $result2['x'];
        $u = $result2['u'];

        echo $adminId = hash('sha512', (pow($q, $x) * pow($q, $u) * $s));
        echo $groupId =  hash('sha512', (pow($q, $u) * $s));
        $memberVerifier =  (pow($q, $u)  * pow($q, $gpk));
    }
}
$query3 = "UPDATE groupdata set admin_id = '$adminId', group_id = '$groupId',  member_verifier =  '$memberVerifier' where u = '$u_hexVal'";
$data3 = mysqli_query($con, $query3) or die('query Unsuccessful');



$sql5 = "UPDATE user SET status = 'a' WHERE request_id = '$rid'";
$result = mysqli_query($con, $sql5) or die("Query Unsuccessful");
