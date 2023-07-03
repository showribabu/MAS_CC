<?php
session_start();
$admin_user = $_SESSION['user_id'];
include "../connector.php";


echo $rid = $_GET['rid'];
echo $uid = $_GET['uid'];
echo $gt = $_GET['gt'];


$sum = 0;
$query = "SELECT * FROM group_data WHERE group_type = '$gt'";
$res = mysqli_query($con, $query) or die("Query Unsuccessful");

while (mysqli_fetch_assoc($res)) {
    $sum += 1;
}

echo $grp_num = $gt  . ($sum + 1);


echo "<br>";

$sql = "select * from user  WHERE user_id = '$uid'";
$sql1 = "select * from admin  WHERE user_id = '$admin_user'";

$result = mysqli_query($con, $sql) or die("Query Unsuccessful");
$result1 = mysqli_query($con, $sql1) or die("Query Unsuccessful");
if (mysqli_num_rows($result) > 0) {
    while ($data = mysqli_fetch_assoc($result)) {
        $u =  $data['secret'];
        echo "user Password -> " . $data['secret'];
    }
} else {
    echo "<br> Password doesn't found out";
}
echo "<br>";


if (mysqli_num_rows($result1) > 0) {
    while ($data = mysqli_fetch_assoc($result1)) {
        $x = $data['secret'];
        echo "admin password -> " . $data['secret'];
    }
} else {
    echo "<br> admin Password doesn't found out";
}

echo "<br>printing hex vlaue <br>";
echo $x_hexVal = intval(hexdec($x));
echo "<br>";
echo $u_hexVal = intval(hexdec($u));

// $x_hexVal = ($x);
// $u_hexVal = ($u);

// $sql2 = "INSERT INTO groupdata (x,u) VALUES ('$x_hexVal','$u_hexVal') where user_id = {$uid} ";
// $result2 = mysqli_query($con, $sql2) or die("Query Unsuccessful");

// db.phps


$query1 = 'SELECT * FROM server_parameters';
$data1 = mysqli_query($con, $query1) or die('query unsuccessful');


$total1 = mysqli_num_rows($data1);


if ($total1 != 0) {
    while ($result1 = mysqli_fetch_assoc($data1)) {
        $q = intval($result1['q']);
        $s =  intval($result1['s']);
        $gpk =  $result1['gpk'];
        $p =  intval($result1['p']);
    }
};



if (!is_null($uid)) {


    echo "<br> calculating secret ";
    // echo $x = intval($x);
    // echo "----";
    // echo $u = intval($u);
    $x = $x_hexVal;
    $u = $u_hexVal;

    echo "<br> without hasing value ";

    echo  $ad = gmp_powm($q, $x, $p) * gmp_powm($q, $u, $p) * $s;
    echo  $gd = gmp_powm($q, $u, $p) * $s;

    echo "<br> after hasing value ";

    echo $adminId = hash('sha512', (gmp_powm($q, $x, $p) * gmp_powm($q, $u, $p) * $s));
    echo "----";
    echo $groupId =  hash('sha512', (gmp_powm($q, $u, $p) * $s));
    echo "----";
    $memberVerifier =  (gmp_powm($q, $u, $p)  * gmp_powm($q, $gpk, $p));
}


date_default_timezone_set('Asia/Kolkata');
$currentDateTime = date('Y-m-d H:i:s');

$sql = "INSERT INTO group_data (admin_id,group_id,mv,user_id,group_type,group_number,creation_time) VALUES ('$adminId', '$groupId','$memberVerifier','$uid','$gt','$grp_num','$currentDateTime' )";
$result = mysqli_query($con, $sql) or die("Query Unsuccessful");

// // $currentDateTime = date('Y-m-d');
// // $currentDateTime = 2023 - 06 - 24;

// // Prepare the SQL query

$sql5 = "UPDATE requests SET r_status = 'a' WHERE request_id = '$rid'";
$result = mysqli_query($con, $sql5) or die("Query Unsuccessful");


header("Location: gm_request.php");


// mysqli_close($con);