<?php 

include "conn.php";
session_start();


if (isset($_GET['user_id'])) {
    $_SESSION['uid3'] = $_GET['user_id'];
    $uid3 = $_SESSION['uid3'];





    // $group_number='A1';

    $group_number=$_SESSION['group_number'];




    /*Suspend*/

    // $sql3='update group_data set activity_status="inactive" where user_id="'.$uid3.'" and group_number="'.$group_number.'"';
    // $r3=mysqli_query($con, $sql3);
    // if($r3) {
    //     echo"<script>alert('Suspended Successfully .... !!!');</script>";
    //     // include "remove.php";
    // } else {
    //     echo"<script>alert('Nodata Found');</script>";
    // }





    /* remove...*/
    //to remove the member first  gm : (user_id, group_number) need to take

    $gmid=$_SESSION['gmid'];


    $sql1='select * from group_data where user_id="'.$gmid.'" and group_number="'.$group_number.'"';
    $r=mysqli_query($con, $sql1);
    if($r) 
    {
        foreach($r as $i) 
        {
            if($i['user_id']==$gmid) 
            {

                // $hgm=$i['password'];
                //password from the user table...
                $mmid=$i['member_id'];
                $group_type=$i['group_type'];

            }
        }
    }

    $sql2='select * from user';
    $r=mysqli_query($con, $sql2);
    if($r) 
    {
        foreach($r as $i) 
        {
            if($i['user_id']==$gmid) 
            {

                $secret2=$i['secret'];

            }
        }
    }
    else 
    {
        echo "<script>alert('Query not executed:');</script>";
    }


    $s=$_SESSION['s'];
    $p=$_SESSION['p'];
    $q=$_SESSION['q'];

    // function secret($hash)
    // {

    //     $p=$_SESSION['p'];
    //     $q=$_SESSION['q'];
    //     $binary=hex2bin($hash);
    //     //but here binary is large so..use GMP module
    //     $u=gmp_strval(gmp_import($binary));
    //     $secret=gmp_strval(gmp_powm($q, $u, $p));
    //     return $secret;
    // }
    // $secret2=secret($hgm);

    //get the encrypted data afrom group data..
    /*Decryption*/
    $iv=hash('sha256', $secret2);
    $iv=substr($iv, 0, 16);

    $sql3='select * from group_data where user_id="'.$uid3.'" and group_number="'.$group_number.'"';
    $r3=mysqli_query($con, $sql3);
    if($r3) 
    {
        foreach($r3 as $row) 
        {
            $secret3=openssl_decrypt(base64_decode($row['enc_key']), 'AES-256-CBC', $secret2, OPENSSL_RAW_DATA, $iv);
            $mv=$row['mv'];
            $pgpk=$row['pgk'];
            echo "<script>alert('decryption of user secret done.!!! ');</script>";
            // printf("Decrypted:");
            // print_r($dec);
        }
    }


/*  HERE one UPDATE IS THAT backup_data : now add time in that table with the time of the backup data inserted...*/

date_default_timezone_set('Asia/Kolkata');
    $creation_time = date('Y-m-d H:i:s');

//creation_time
//"'.$creation_time.'"



    /*TYPE A*/

    if($group_type=='A') 
    {

        $qpowu=gmp_strval(gmp_powm($q, $secret3, $p));

        //member id

        $hmid=hash('sha512', $qpowu*$mv);
        $sql21='select * from group_data where member_id="'.$hmid.'"';
        $r34=mysqli_query($con, $sql21);
        if($r34) 
        {

            foreach($r3 as $i) {
                $uid3=$i['user_id'];
                $group_type=$i['group_type'];
                $group_number=$i['group_number'];
                $admin_id=$i['admin_id'];
                $group_id=$i['group_id'];
                $mv=$i['mv'];
                $hmid=$i['member_id'];
                // $mid=$i['mid'];
                $pgpk=$i['pgk'];
                $bindx=$i['bi'];
                $activity_status=$i['activity_status'];
                $enc_key=$i['enc_key'];
                $privilege=$i['privilege'];
                $atime=$i['creation_time'];

            }
            $sql5='INSERT INTO backup_data(user_id,group_type,group_number,admin_id,group_id,mv,member_id,pgk,bi,privilege,activity_status,enc_key,creation_time) values("'.$uid3.'","'.$group_type.'","'.$group_number.'","'.$admin_id.'","'.$group_id.'","'.$mv.'","'.$hmid.'","'.$pgpk.'","'.$bindx.'","'.$privilege.'","'.$activity_status.'","'.$enc_key.'","'.$creation_time.'")';

            $r6 = mysqli_query($con, $sql5);
            if ($r6 && mysqli_affected_rows($con) > 0) 
            {
                echo "<script>alert('data stored on the backup_data!!!');</script>";


                $sql23='delete from group_data where user_id="'.$uid3.'" and group_number="'.$group_number.'"';
                //$sql23='update group_data set admin_id="NULL",group_id="NULL",mv="NULL",member_id="NULL" , pgk="NULL", bi="NULL" ,activity_status="inactive",privilege="NULL",enc_key="NULL",creation_time="'.$atime.'"  where user_id="'.$uid3.'" and group_number="'.$group_number.'" ';
                $r7=mysqli_query($con, $sql23);
                if ($r7 && mysqli_affected_rows($con) > 0) {
                    echo "<script>alert('Member removed successfully!!!');</script>";
                } else {
                    echo "<script>alert('Failed to delete  group data.');</script>";

                }

            }
             else 
            {
                echo "<script>alert('Failed to upload into  backup_data.');</script>";

            }

        }
    }   


    /*TYPE B*/

    if($group_type=='B') {

        $sql3='select * from group_data where user_id="'.$uid3.'" and group_number="'.$group_number.'"';
        $r34=mysqli_query($con, $sql3);
        if($r34) {

            foreach($r3 as $i) {
                $uid3=$i['user_id'];
                $group_type=$i['group_type'];
                $group_number=$i['group_number'];
                $admin_id=$i['admin_id'];
                $group_id=$i['group_id'];
                $mv=$i['mv'];
                $hmid=$i['member_id'];
                // $mid=$i['mid'];
                $pgpk=$i['pgk'];
                // echo gettype($pgpk);
                $bindx=$i['bi'];
                $activity_status=$i['activity_status'];
                $enc_key=$i['enc_key'];
                $privilege=$i['privilege'];
                $atime=$i['creation_time'];

            }
            $sql5='INSERT INTO backup_data(user_id,group_type,group_number,admin_id,group_id,mv,member_id,pgk,bi,privilege,activity_status,enc_key,creation_time) values("'.$uid3.'","'.$group_type.'","'.$group_number.'","'.$admin_id.'","'.$group_id.'","'.$mv.'","'.$hmid.'","'.$pgpk.'","'.$bindx.'","'.$privilege.'","'.$activity_status.'","'.$enc_key.'","'.$creation_time.'")';

            $r6 = mysqli_query($con, $sql5);
            if ($r6 && mysqli_affected_rows($con) > 0) {
                echo "<script>alert('data stored on the backup_data!!!');</script>";

                $sql23='delete from group_data where user_id="'.$uid3.'" and group_number="'.$group_number.'"';
                //$sql23='update group_data set admin_id="NULL",group_id="NULL",mv="NULL", member_id="NULL" , pgk="NULL", bi="NULL" ,activity_status="inactive", privilege="NULL", enc_key="NULL", creation_time="'.$atime.'"  where user_id="'.$uid3.'" and group_number="'.$group_number.'" ';
                $r7=mysqli_query($con, $sql23);
                if ($r7 && mysqli_affected_rows($con) > 0) {
                    //once data stored on the backup data...and delete record from the group_data
                    //now update remain data...


                    $dgpk =$mv/gmp_strval(gmp_powm($q, $secret2, $p));
                    // $dgpk = gmp_powm($mv, gmp_invert(gmp_powm($q, $secret2, $p), $p), $p);
                    $dgpk = gmp_strval($dgpk);
                    $old_sec=$pgpk/$dgpk;

                    $qpowu=gmp_strval(gmp_powm($q, $secret3, $p));

                    //eliminate the persons secret....
                    $new_sec=$old_sec /$qpowu;

                    //member id
                    $hmid=hash('sha512', $new_sec*$mv);
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
                    $mid=hash2mid($hmid);

                    //partial group key..
                    $pgpk=$new_sec*$dgpk;

                    //Bio index
                    $ix=$_SESSION['ix'];
                    $bindx=hash('sha512', $new_sec*$ix);


                    //update remain members data....
                    $sql123='update group_data set member_id="'.$hmid.'" ,pgk="'.$pgpk.'",bi="'.$bindx.'"  where group_number="'.$group_number.'" and user_id !="'.$uid3.'"';
                    $r7=mysqli_query($con, $sql123);
                    if ($r7 && mysqli_affected_rows($con) > 0) {
                        echo "<script>alert('Member removed successfully!!!');</script>";
                    } else {
                        echo "<script>alert('Failed to delete  group data.');</script>";

                    }
                }
            }
        }
    }   


    /*TYPE C*/

    if($group_type=='C' || $group_type=='D') 
    {

        $qpowu=gmp_strval(gmp_powm($q, $secret3, $p));
        $qpowgm=gmp_strval(gmp_powm($q,$secret2,$p));

        //member id
        //Derivation of 'r'...
        //here I considered GM as authority mmeber...

        $kv=$_SESSION['kv'];

        //derive 'r' from gm member id...
        try{
            $dr=(int)$mmid/((int)$qpowgm*(int)$kv*(int)$mv);        }
        catch (Exception $e)
        {
            $dr=(int)$mmid/((int)$qpowgm*(int)$kv*(int)$mv);
        }

//         $dr = gmp_div($mmid, $qpowgm);
// $result = gmp_mul($dr, gmp_mul($kv, $mv));
// $drString = gmp_strval($result);


        $hmid= $qpowu*$mv*$kv*$dr;

        $sql21='select * from group_data where member_id="'.$hmid.'"';
        $r34=mysqli_query($con, $sql21);
        if($r34) 
        {

            foreach($r3 as $i) {
                $uid3=$i['user_id'];
                $group_type=$i['group_type'];
                $group_number=$i['group_number'];
                $admin_id=$i['admin_id'];
                $group_id=$i['group_id'];
                $mv=$i['mv'];
                $hmid=$i['member_id'];
                // $mid=$i['mid'];
                $pgpk=$i['pgk'];
                $bindx=$i['bi'];
                $activity_status=$i['activity_status'];
                $enc_key=$i['enc_key'];
                $privilege=$i['privilege'];
                $atime=$i['creation_time'];

            }
            $sql5='INSERT INTO backup_data(user_id,group_type,group_number,admin_id,group_id,mv,member_id,pgk,bi,privilege,activity_status,enc_key,creation_time) values("'.$uid3.'","'.$group_type.'","'.$group_number.'","'.$admin_id.'","'.$group_id.'","'.$mv.'","'.$hmid.'","'.$pgpk.'","'.$bindx.'","'.$privilege.'","'.$activity_status.'","'.$enc_key.'","'.$creation_time.'")';

            $r6 = mysqli_query($con, $sql5);
            if ($r6 && mysqli_affected_rows($con) > 0) 
            {
                echo "<script>alert('data stored on the backup_data!!!');</script>";

                $sql23='delete from group_data where user_id="'.$uid3.'" and group_number="'.$group_number.'"';

                //$sql23='update group_data set admin_id="NULL",group_id="NULL", mv="NULL", member_id="NULL", pgk="NULL", bi="NULL" , activity_status="inactive" , privilege="NULL" , enc_key="NULL",creation_time="'.$atime.'"  where user_id="'.$uid3.'" and group_number="'.$group_number.'" ';
                $r7=mysqli_query($con, $sql23);
                if ($r7 && mysqli_affected_rows($con) > 0) {
                    echo "<script>alert('Member removed successfully!!!');</script>";
                } else {
                    echo "<script>alert('Failed to delete  group data.');</script>";

                }

            }
             else 
            {
                echo "<script>alert('Failed to upload into  backup_data.');</script>";

            }

        }
    }   




}

?>