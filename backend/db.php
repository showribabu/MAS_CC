<?php


include '../connection.php';
// error_reporting(0);
$query1 = 'SELECT * FROM server_param where serial = 7';
$data1 = mysqli_query($con, $query1) or die('query unsuccessful');


$total1 = mysqli_num_rows($data1);


if ($total1 != 0) {
    while ($result1 = mysqli_fetch_assoc($data1)) {
        $q = $result1['q'];
        $s =  $result1['s'];
        $gpk =  $result1['gpk'];
        $p =  $result1['p'];

        echo '<br>';
        echo 'Printing Server Parameters:-';
        echo '<br>';
        echo "Q value:- " . $q;
        echo '<br>';
        echo "S value:- " . $s;
        echo '<br>';
        echo "Gpk value:- " . $gpk;
        echo '<br>';
        echo "p value :- " . $p;
        echo '<br>';
    }
}

echo "----------------------------------------";

$query2 = 'SELECT * FROM groupdata where serial = 3';
$data2 = mysqli_query($con, $query2) or die('query unsuccessful');


$total2 = mysqli_num_rows($data2);


if ($total2 != 0) {
    while ($result2 = mysqli_fetch_assoc($data2)) {
        $x = $result2['x'];
        $u = $result2['u'];
        $unew = $result2['unew'];


        echo '<br>';
        echo "Printing secrets ";
        echo '<br>';
        echo "x value:- " . $x;
        echo '<br>';
        echo "u value:- " . $u;
        echo '<br>';
        echo "unew value:- " . $u;
        echo '<br>';



        $adminId = hash('sha512', (pow($q, $x) * pow($q, $u) * $s));
        $groupId =  hash('sha512', (pow($q, $u) * $s));
        $memberVerifier =  (pow($q, $u)  * pow($q, $gpk));
    }
}
include '../connection.php';
$query3 = "UPDATE groupdata set admin_id = '$adminId', group_id = '$groupId',  member_verifier =  '$memberVerifier' where serial = 3";
$data3 = mysqli_query($con, $query3) or die('query Unsuccessful');

mysqli_close($con);
