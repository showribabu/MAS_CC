<?php 

include "conn.php";



    $gmid = $_SESSION['gmid'];
    $group_type=$_SESSION['group_type'];
   
    // $gmid = 'John_123';
    // $group_type='A'; 

    //members id...id1
    // $admid=1;
    //id1 is the gm user id...

    $sql1='select * from user';
    $r=mysqli_query($con, $sql1);
    if($r) {
        foreach($r as $i) {
            if($i['user_id']==$gmid) {

                $secret2=$i['secret'];
                
            }
        }

    } 
    else 
    {
        echo "<script>alert('Query not executed:');</script>";

    }


    //admin credentials..

    $sql='select * from admin';
    $r34=mysqli_query($con, $sql);
    if($r34) 
    {
        foreach($r34 as $i) {
            $secret1=$i['secret'];
        }
    }
    else 
    {
        echo "<script>alert('Query not executed:');</script>";

    }
    // $secret1=secret2($hadm);

   
    
    /* Group initialization */
    $sql2='select * from server_parameters';

    $r2=mysqli_query($con, $sql2);
    if($r2) {
        foreach($r2 as $i) {
         
            $_SESSION['p']=$i['p'];
            $_SESSION['q']=$i['q'];
            $_SESSION['kv']=$i['kv'];
            $_SESSION['ix']=$i['ix'];
            $_SESSION['spk']=$i['spk'];
            $_SESSION['s']=$i['s'];
    
    
        }
    }
$s=$_SESSION['s'];
$p=$_SESSION['p'];
$q=$_SESSION['q'];



//here gpk and r value are the group specific .....

function rnd($len)
{
    // Generate a random number with the desired bit size
    $rnum = gmp_random_bits($len);

    // Set the most significant bit to ensure the minimum bit size
    gmp_setbit($rnum, $len - 1);

    $val=strval($rnum);
    return $val;
}

$gpk=rnd(166);
$r=rnd(64);

echo "$gpk";
$_SESSION['r']=$r;


//here when file call data get randomly...


$hadmid=hash('sha512',gmp_strval(gmp_powm($q,$secret1,$p)) * gmp_strval(gmp_powm($q,$secret2,$p)) * $s);//hash(q pow sec1 mod p , q pow sec2 mod p , s)//from hash value we need to generate id...
// echo"<br>admin_id:".$hadmid;
$hgrpid=hash('sha512',gmp_strval(gmp_powm($q,$secret2,$p)) * $s);
// echo"<br>grpidid:".$hgrpid;
//mv=q pow gm * q pow gpk... also NO!! Hash.......
// $mv=gmp_strval(gmp_powm($q,$secret2,$p)) * gmp_strval(gmp_powm($q,$gpk,$p));
$mv=gmp_mul(gmp_strval(gmp_powm($q,$secret2,$p)),gmp_strval(gmp_powm($q,$gpk,$p)));
$qgpk=gmp_strval(gmp_powm($q,$gpk,$p));
echo"<br>qpow gpk:".$qgpk;
echo"<br>mv:".$mv;


date_default_timezone_set('Asia/Kolkata');
$currentDateTime = date('Y-m-d H:i:s');



//the group num based on the group type...

$sql22 = 'SELECT * FROM server_parameters';
$r7 = mysqli_query($con, $sql22);
if ($r7) {
 
    foreach($r7 as $i)
    {
        if($group_type=="A")
        {
            $count=$i['ac'];
            $count1=$count+1;
            $sql33='UPDATE `server_parameters` SET ac="'.$count1.'"  where ac="'.$count.'"';

        }
        if($group_type=="B")
        {
            $count=$i['bc'];
            $count1=$count+1;
            $sql33='UPDATE `server_parameters` SET bc="'.$count1.'"  where bc="'.$count.'"';


        }
        if($group_type=="C")
        {
            $count=$i['cc'];
            $count1=$count+1;
            $sql33='UPDATE `server_parameters` SET cc="'.$count1.'"  where cc="'.$count.'"';


        }
        if($group_type=="D")
        {
            $count=$i['dc'];
            $count1=$count+1;
            $sql33='UPDATE `server_parameters` SET dc="'.$count1.'"  where dc="'.$count.'"';

        }

        
        $rr=mysqli_query($con,$sql33);
        if(!$rr)
        {
            echo "Error executing query: " . mysqli_error($con);

        }

    }
} else {
    echo "Error executing query: " . mysqli_error($con);
}

$group_number=$group_type.$count1;

// $_SESSION['group_number']=$group_number;



$kv=$_SESSION['kv'];
$r=$_SESSION['r'];

$qpowu=gmp_strval(gmp_powm($q,$secret2,$p));
$mv=gmp_strval($mv);
if($group_type=='C')
{
        $hmid=gmp_strval($qpowu*$mv*$kv*$r);


}
else{
    $hmid=hash('sha512',$qpowu * $mv);

}
// $mid=hash2mid($hmid);


$dgpk =$mv/gmp_strval(gmp_powm($q, $secret2, $p));
$dgpk = gmp_strval($dgpk);

$pgpk=$qpowu*$dgpk;

$ix=$_SESSION['ix'];
if($group_type=='D')
{
    $bindx=hash('sha512',$qpowu*$ix*$r);

}
else
{
$bindx=hash('sha512',$qpowu*$ix);

}




$sql4 = 'INSERT INTO group_data (user_id,group_type,admin_id,group_id,mv,group_number,member_id,pgk,bi,privilege,activity_status,creation_time) VALUES ("'.$gmid.'", "'.$group_type.'", "'.$hadmid.'", "'.$hgrpid.'", "'.$mv.'", "'.$group_number.'","'.$hmid.'","'.$pgpk.'","'.$bindx.'","gm","active","'.$currentDateTime.'")';
$r4 = mysqli_query($con, $sql4);
if ($r4 && mysqli_affected_rows($con) > 0) {
    echo "<script>alert('Group data initialized.....!!!');</script>";
} 
else 
{
    $sql3 = 'UPDATE group_data SET user_id = "'.$gmid.'", group_type = "'.$group_type.'", admin_id = "'.$hadmid.'", group_id = "'.$hgrpid.'", mv = "'.$mv.'", group_number = "'.$group_number.'", member_id = "'.$hmid.'",  pgk = "'.$pgpk.'", bi = "'.$bindx.'", activity_status="active", privilege="gm",creation_time="'.$currentDateTime.'" WHERE user_id="'.$gmid.'"';
    $r5 = mysqli_query($con, $sql3);
    if ($r5 && mysqli_affected_rows($con) > 0) 
    {
        echo "<script>alert('Group data updated.....!!!');</script>";
    } 
    else 
    {
        if (mysqli_num_rows(mysqli_query($con, 'SELECT * FROM group_data WHERE user_id="'.$gmid.'"')) > 0) 
        {
            echo "<script>alert('Failed to update group data.');</script>";
        } 
        else 
        {
            echo "<script>alert('Failed to initialize or update group data.');</script>";
        }
    }
}


 /*enc_keyryptiion and decryption...*/

    /*enc_keyryption*/
    $iv=hash('sha256', $secret1);
    $iv=substr($iv, 0, 16);

    $enc_key=openssl_encrypt($secret2, 'AES-256-CBC', $secret1, OPENSSL_RAW_DATA, $iv);
    $enc_key=base64_encode($enc_key);
    $sql2='update group_data set enc_key="'.$enc_key.'" where user_id="'.$gmid.'" and group_number="'.$group_number.'"';
    $r=mysqli_query($con, $sql2);
    if($r) {
        echo "<script>alert('Encryption of group manger secret done.!!!');</script>";
    } else {
        echo "<script>alert('user id is not found');</script>";
    }






/*

INSERT INTO `group_data`(`user_id`, `group_type`, `group_number`, `admin_id`, `group_id`, `mv`, `member_id`, `pgk`, `bi`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]','[value-6]','[value-7]','[value-8]','[value-9]')

*/
?>