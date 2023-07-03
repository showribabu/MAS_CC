<?php
// error_reporting(0);

session_start();
$admin_id_ = $_SESSION['user_id'];
$admin_name_ = $_SESSION['admin_name_'];
include '../connector.php';

echo $gmid = $_GET['uid'];

echo "<br>";
echo $group_type = $_GET['tid'];
echo "<br>";
// $sum = 0;
// $query = "SELECT * FROM group_data WHERE group_type = '$group_type'";
// $res = mysqli_query($con, $query) or die("Query Unsuccessful");

// while (mysqli_fetch_assoc($res)) {
//     $sum += 1;
// }

// echo $grp_num = $group_type . ($sum + 1);



// for group_number calculation 
$sql22 = 'SELECT * FROM server_parameters';
$r7 = mysqli_query($con, $sql22);
if ($r7) {

    foreach ($r7 as $i) {
        if ($group_type == "A") {
            $count = $i['ac'];
            $count1 = $count + 1;
            $sql33 = 'UPDATE `server_parameters` SET ac="' . $count1 . '"  where ac="' . $count . '"';
        }
        if ($group_type == "B") {
            $count = $i['bc'];
            $count1 = $count + 1;
            $sql33 = 'UPDATE `server_parameters` SET bc="' . $count1 . '"  where bc="' . $count . '"';
        }
        if ($group_type == "C") {
            $count = $i['cc'];
            echo var_dump($count);
            $count1 = $count + 1;
            $sql33 = 'UPDATE `server_parameters` SET cc="' . $count1 . '"  where cc="' . $count . '"';
        }
        if ($group_type == "D") {
            $count = $i['dc'];
            $count1 = $count + 1;
            $sql33 = 'UPDATE `server_parameters` SET dc="' . $count1 . '"  where dc="' . $count . '"';
        }


        $rr = mysqli_query($con, $sql33);
        if (!$rr) {
            echo "Error executing query: " . mysqli_error($con);
        }
    }
} else {
    echo "Error executing query: " . mysqli_error($con);
}
echo  $count1;

echo $grp_num = $group_type . $count1;


// echo $grp_num = $group_type . "" . $count;

echo "<br>hope so value printed";


// getting id of clicked user as well as adminId

echo "<br>";

$sql = "select * from user WHERE user_id = '$gmid'";
$sql1 = "select * from admin WHERE user_id = '$admin_id_'";


//fetching user secret
$result = mysqli_query($con, $sql) or die("Query Unsuccessful");
if (mysqli_num_rows($result) > 0) {
    while ($data = mysqli_fetch_assoc($result)) {
        $secret2 = $data['secret'];
        echo "user Password -> " . $data['secret'];
    }
} else {
    echo "<br> Password doesn't found out";
}
echo "<br>";


//fetching admin secret 
$result1 = mysqli_query($con, $sql1) or die("Query Unsuccessful");
if (mysqli_num_rows($result1) > 0) {
    while ($data = mysqli_fetch_assoc($result1)) {
        $secret1 = $data['secret'];
        echo "admin password -> " . $data['secret'];
    }
} else {
    echo "<br> admin Password doesn't found out";
}

echo "<br>printing hex vlaue <br>";
echo $x_hexVal = hexdec($secret1);
echo "<br>";
echo $u_hexVal = hexdec($secret2);

// calculating gpk and r

function hash2mid($hash)
{
    $id = substr(date('y'), -2); // last 2 digits from the current year
    $id .= 'MB'; // Next 2 characters ('GP')
    $id .= substr($hash, 0, 1); // Next character (one digit)
    $id .= chr(69); // Next character (capital letter)
    $id .= substr($hash, 1, 2); // Next 2 characters (two digits)
    $id .= chr(73); // Next character (capital letter)
    $id .= substr($hash, 3, 1); // Next character (one digit)

    return $id;
}

function rnd($len)
{
    // Generate a random number with the desired bit size
    $rnum = gmp_random_bits($len);

    // Set the most significant bit to ensure the minimum bit size
    gmp_setbit($rnum, $len - 1);

    $val = strval($rnum);
    return $val;
}

$gpk = rnd(166);
$r = rnd(64);


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



if (!is_null($gmid)) {

    $hadmid = hash('sha512', gmp_strval(gmp_powm($q, $secret1, $p)) * gmp_strval(gmp_powm($q, $secret2, $p)) * $s); //hash(q pow sec1 mod p , q pow sec2 mod p , s)//from hash value we need to generate id...
    // echo"<br>admin_id:".$hadmid;
    $hgrpid = hash('sha512', gmp_strval(gmp_powm($q, $secret2, $p)) * $s);
    // echo"<br>grpidid:".$hgrpid;
    //mv=q pow gm * q pow gpk... also NO!! Hash.......
    // $mv=gmp_strval(gmp_powm($q,$secret2,$p)) * gmp_strval(gmp_powm($q,$gpk,$p));
    $mv = gmp_mul(gmp_strval(gmp_powm($q, $secret2, $p)), gmp_strval(gmp_powm($q, $gpk, $p)));
    $qgpk = gmp_strval(gmp_powm($q, $gpk, $p));
    echo "<br>qpow gpk:" . $qgpk;
    echo "<br>mv:" . $mv;
}


date_default_timezone_set('Asia/Kolkata');
$currentDateTime = date('Y-m-d H:i:s');



// assuming that group manager can also  act as group memeber

$qpowu = gmp_strval(gmp_powm($q, $secret2, $p));
$mv = gmp_strval($mv);
if ($group_type == 'C') {
    $hmid = ($qpowu * $mv * $kv * $r);
} else {
    $hmid = hash('sha512', $qpowu * $mv);
}
$mid = hash2mid($hmid);


$dgpk = $mv / gmp_strval(gmp_powm($q, $secret2, $p));
$dgpk = gmp_strval($dgpk);

$pgpk = $qpowu * $dgpk;

if ($group_type == 'D') {
    $bindx = hash('sha512', $qpowu * $ix * $r);
} else {
    $bindx = hash('sha512', $qpowu * $ix);
}


$sql = "INSERT INTO group_data (admin_id,group_id,mv,user_id,group_type,group_number,creation_time,member_id,pgk,bi,privilege,activity_status) VALUES ('$hadmid',
'$hgrpid','$mv.','$gmid','$group_type','$grp_num','$currentDateTime','$hmid','$pgpk','$bindx','gm','active')";
$result = mysqli_query($con, $sql) or die("Query Unsuccessful");








/*enc_keyryptiion and decryption...*/

/*enc_keyryption*/
$iv = hash('sha256', $secret1);
$iv = substr($iv, 0, 16);

$enc_key = openssl_encrypt($secret2, 'AES-256-CBC', $secret1, OPENSSL_RAW_DATA, $iv);
$enc_key = base64_encode($enc_key);
$sql2 = 'update group_data set enc_key="' . $enc_key . '" where user_id="' . $gmid . '" and group_number="' . $grp_num . '"';
$r = mysqli_query($con, $sql2);
if ($r) {
    echo "<script>alert('Encryption of group manger secret done.!!!');</script>";
} else {
    echo "<script>alert('user id is not found');</script>";
}


header("Location: gm_selected.php");


mysqli_close($con);
