<?php
// echo "you Are Successfully Accepted <br>";
echo "<h1> Wait for addition of members in Group</h1>";


// here we primary require user_id of prev , user_id of new 
// so what we have to do in requests table replace request_from prev to news


session_start();
$admin_id_ = $_SESSION['user_id'];
$admin_name_ = $_SESSION['admin_name_'];
include '../connector.php';




//user_id is basically string name_123 like
echo $uid = $_GET['uid'];
echo "<br>";
echo $rej_id = $_GET['rej_id'];
echo "<br>";


//getting server parameters

$query1 = 'SELECT * FROM server_parameters';
$data1 = mysqli_query($con, $query1) or die('query unsuccessful');


$total1 = mysqli_num_rows($data1);


if ($total1 != 0) {
    while ($result1 = mysqli_fetch_assoc($data1)) {
        echo $q = ($result1['q']);
        echo  $s = ($result1['s']);
        echo $p = ($result1['p']);
        echo $kv = ($result1['kv']);
        echo $ix = ($result1['ix']);
    }
};


//getting old manager secret

$sql = "select * from user WHERE user_id = '$rej_id'";


$result = mysqli_query($con, $sql) or die("Query Unsuccessful");
if (mysqli_num_rows($result) > 0) {
    while ($data = mysqli_fetch_assoc($result)) {
        $secret2 = $data['secret'];
        echo "<br>old user Password -> " . $data['secret'];
    }
} else {
    echo "<br> old manager Password doesn't found out";
}
echo "<br>";


//getting new manager secret
$sql = "select * from user WHERE user_id = '$uid'";


$result = mysqli_query($con, $sql) or die("Query Unsuccessful");
if (mysqli_num_rows($result) > 0) {
    while ($data = mysqli_fetch_assoc($result)) {
        $secret2_new = $data['secret'];
        echo "<br>new user Password -> " . $data['secret'];
    }
} else {
    echo "<br> new manager Password doesn't found out";
}
echo "<br>";






//gettig admin secret

$sql1 = "select * from admin WHERE user_id = '$admin_id_'";
$result1 = mysqli_query($con, $sql1) or die("Query Unsuccessful");
if (mysqli_num_rows($result1) > 0) {
    while ($data = mysqli_fetch_assoc($result1)) {
        $secret1 = $data['secret'];
        echo "<br>admin password -> " . $data['secret'];
    }
} else {
    echo "<br> admin Password doesn't found out";
}

// caclulation of adminId


echo "<br> hashed form of adminid";
echo "<br>";


echo $hadmid = hash('sha512', gmp_strval(gmp_powm($q, $secret1, $p)) * gmp_strval(gmp_powm($q, $secret2, $p)) * $s); //hash(q pow sec1 mod p , q pow sec2 mod p , s)//from hash value we need to generate id...

echo "old group_id";
echo "<br>";
echo $hgrpid = hash('sha512', gmp_strval(gmp_powm($q, $secret2, $p)) * $s);
echo "<br>";
echo $hadmid_new = hash('sha512', gmp_strval(gmp_powm($q, $secret1, $p)) * gmp_strval(gmp_powm($q, $secret2_new, $p)) * $s); //hash(q pow sec1 mod p , q pow sec2 mod p , s)//from hash value we need to generate id...
echo "<br>";
echo $hgrpid_new = hash('sha512', gmp_strval(gmp_powm($q, $secret2_new, $p)) * $s);
echo "<br>";
// // echo"<br>grpidid:".$hgrpid;
// //mv=q pow gm * q pow gpk... also NO!! Hash.......
// // $mv=gmp_strval(gmp_powm($q,$secret2,$p)) * gmp_strval(gmp_powm($q,$gpk,$p));


//getting mv and pgk from database

$sql_req = "select * from group_data where admin_id = '$hadmid'";
$res1_req = mysqli_query($con, $sql_req) or die("Query unsuccessful");
while ($data_req = mysqli_fetch_assoc($res1_req)) {
    echo "mv value ";
    echo $mv =  $data_req['mv'];
    echo "<br> ";
    echo "pgk";
    echo $pgk = $data_req['pgk'];
    echo "<br> ";
}

echo $qpowgmcurr = gmp_strval(gmp_powm($q, $secret2, $p));
echo "<br> ";

//derivation of group key 
echo $qpowgpk = $mv / $qpowgmcurr;
echo "<br> ";

//calculation of new memberVerifier
echo $mvnew = gmp_strval(gmp_powm($q, $secret2_new, $p)) * gmp_strval(gmp_powm($q, $qpowgpk, $p));
echo "<br> ";

echo "<br> xxxxxxxxxxxxxxxxx";

//calculatoin of new memberId
if ($qpowgpk != 0) {
    $qpowu = $pgk / $qpowgpk;
    $midnew = $qpowu * gmp_strval(gmp_powm($q, $secret2_new, $p)) * gmp_strval(gmp_powm($q, $qpowgpk, $p));
}






//updation in group_data table

$query99 = "update group_data set user_id = '$rej_id',admin_id = '$hadmid', mv = '$mvnew ' where group_id = '$hgrpid'";
$res99 = mysqli_query($con, $query99) or die("query unsucessful");


$query100 = "update group_data SET group_id = '$hgrpid_new'_ where group_id = '$hgrpid'";
$res100 = mysqli_query($con, $query99) or die("query unsucessful");

// //updation in request table

//update request table 
$query101 = "update group_data set user_id  = '$uid' where user_id = '$rej_id'";
$res101 = mysqli_query($con, $query101) or die("query unsucessful");


header("location: substitute_gm.php");
