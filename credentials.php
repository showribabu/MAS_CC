<?php 

//when person click on yes button data store on the user table store secret....

//when GM click on the active ....(admin id,group id,group num,mv -->already existed) calculate the member id,member IID,partial group key,bio index.

//sending the request may check count of people existed in the group....size...type also nedd...

//finally alert message to manager and member(suggestion table...);


include "conn.php";
session_start();

if (isset($_GET['user_id'])) {
    $_SESSION['uid2'] = $_GET['user_id'];
    $uid2 = $_SESSION['uid2'];
    //members id...id1
    $gmid=$_SESSION['gmid'];
    //id1 is the gm user id...

    echo $uid2.','.$gmid;

    $sql1='select * from user';
    $r=mysqli_query($con, $sql1);
    if($r) {
        foreach($r as $i) {
            if($i['user_id']==$uid2) {
//secret....

                $secret3=$i['secret'];

            }
            if($i['user_id']==$gmid) {

                $secret2=$i['secret'];
            }


        }
    } else {
        echo "<script>alert('Query not executed:');</script>";

    }




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


    /*encryptiion and decryption...*/

    //include "admcred.php";

    //fetch group_number from group_data ... or ....fetch by login....


    //*************************************************************** */

    // $group_number='A1';
    $group_number=$_SESSION['group_number'];


    //************************************************************ */

   

    /*decryption*/

    /*
     $sql3='select * from user where user_id="'.$uid2.'"';
     $r3=mysqli_query($con, $sql3);
     if($r3)
     {
         foreach($r3 as $row)
         {

             $dec=openssl_decrypt(base64_decode($row['enc']),'AES-256-CBC',$secret2,OPENSSL_RAW_DATA,$iv);
             echo "<script>alert('decryption of user secret done.!!! ');</script>";
             printf("Decrypted:");
             print_r($dec);

         }

     }
*/







    





    //group data repositoty created....

    //member credentials calculated....
    //fetch mv by calculating the group_id..
    //fetch data from group_data...

    $sql4='select * from group_data where user_id="'.$gmid.'" and group_number="'.$group_number.'"';

    // $sql4='select * from group_data where user_id="'.$gmid.'"';

    try {
        $r4=mysqli_query($con, $sql4);
        if($r4) {
            //herer gm is in one group(Assume)
            foreach($r4 as $i) {
                $mv=$i['mv'];
                //user_id, group_type, admin_id, group_id, mv, group_number
                $group_type=$i['group_type'];
                $admin_id=$i['admin_id'];
                $group_id=$i['group_id'];
                $group_number=$i['group_number'];
                $mmid=$i['member_id'];
            }
        }
    } catch(Exception $e) {
        echo "<script>alert('No data in the group data with user id or group_number ');</script>";

    }

    $s=$_SESSION['s'];
    $p=$_SESSION['p'];
    $q=$_SESSION['q'];

    //foe every one we need gpk value...

    //derive gpk....

    // $dgpk = gmp_div($mv1, gmp_strval(gmp_powm($q, $secret2, $p)));
    $dgpk =$mv/gmp_strval(gmp_powm($q, $secret2, $p));
    // $dgpk = gmp_powm($mv, gmp_invert(gmp_powm($q, $secret2, $p), $p), $p);    
    $dgpk = gmp_strval($dgpk);
    printf("<br>Derived gpk :%s", $dgpk);

    
    /*TYPE A*/

    if($group_type=='A')
    {

        $qpowu=gmp_strval(gmp_powm($q, $secret3, $p));

        //member id

        $hmid=hash('sha512', $qpowu*$mv);
        $mid=hash2mid($hmid);
    
        //partial group key..
        $pgpk=$qpowu*$dgpk;
    
        //Bio index 
        $ix=$_SESSION['ix'];
        $bindx=hash('sha512', $qpowu*$ix);
    
        printf("<br>MEmber Id: %s<br> partial groupkey: %s <br> bi: %s", $mid, $pgpk, $bindx);
        printf("<br>Gm id : %s <br> user id : %s<br>", $gmid, $uid2);
    }

    if($group_type=='B')
    {
        //check data avilable or not

        //if it is new entry...insert command
        //else update command

        //here data need to store on the NO SQL (MongoDB)....
        
        $qpowu=gmp_strval(gmp_powm($q, $secret3, $p));

        //fetch data  from record...

        $sql12='select * from group_data where user_id="'.$gmid.'" and group_number="'.$group_number.'" and member_id !=" " and pgk!=" " and bi !=" "';
        
    try {
        $r4=mysqli_query($con, $sql4);
        if($r4) {
            //herer gm is in one group(Assume)
            foreach($r4 as $i) {
                $member_id=$i['member_id'];
                $pgpk=$i['pgk'];
                $bi=$i['bi'];
                
                // echo gettype($pgpk).','.gettype($dgpk);


                //derive old secret from partial group key...
                // global $old_sec;
                $old_sec=$pgpk/$dgpk;

                // $old_sec=gmp_strval($old_sec);

                //now add user secret to it..

                $qpowu=gmp_strval(gmp_powm($q, $secret3, $p));

                // $new_sec=gmp_mul($old_sec,$qpowu);
                $new_sec=$old_sec * $qpowu;
            }
        }
    } 
    catch(Exception $e) {
        echo "<script>alert('No data in the group data with user id or group_number .... New Group .. ');</script>";

    }


        //member id

        $hmid=hash('sha512', $new_sec*$mv);
        $mid=hash2mid($hmid);
    
        //partial group key..
        $pgpk=$new_sec*$dgpk;
    
        //Bio index 
        $ix=$_SESSION['ix'];
        $bindx=hash('sha512', $new_sec*$ix);
    
        printf("<br>MEmber Id: %s<br> partial groupkey: %s <br> bi: %s", $mid, $pgpk, $bindx);
        printf("<br>Gm id : %s <br> user id : %s<br>", $gmid, $uid2);

    }

    if($group_type=='C')
    {
        // Display the form

        $qpowu=gmp_strval(gmp_powm($q, $secret3, $p));

        //member id
        $kv=$_SESSION['kv']; //system parameter...

        //derived 'r'
        // $r=$_SESSION['r'];

       
        
        //Derivation of r
        
        $qpowu=gmp_strval(gmp_powm($q, $secret3, $p));
        $qpowgm=gmp_strval(gmp_powm($q,$secret2,$p));

        //member id
        //Derivation of 'r'...

        //here I considered GM as authority mmeber...

        $kv=$_SESSION['kv'];

        //derive 'r' from gm member id...
        try{

            $r=$mmid/$qpowgm*$kv*$mv;

        }
        catch(Exception $e){

            $r=$mmid/$qpowgm*$kv*$mv;

        }





        $hmid= $qpowu*$mv*$kv*$r;
        $mid=hash2mid($hmid);
    
        //partial group key..
        $pgpk=$qpowu*$dgpk;
    
        //Bio index 
        $ix=$_SESSION['ix'];
        // if($authority==1)
        // {
        //     $bindx=hash('sha512', $qpowu*$ix);

        // }
        // else
        // {
        //     $bindx=hash('sha512', $qpowu*$ix*$r);

        // }
        $bindx=hash('sha512', $qpowu*$ix);
    
        printf("<br>MEmber Id: %s<br> partial groupkey: %s <br> bi: %s", $mid, $pgpk, $bindx);
        printf("<br>Gm id : %s <br> user id : %s<br>", $gmid, $uid2);


    }
    if($group_type=='D')
    {

        //any k
        
        $qpowu=gmp_strval(gmp_powm($q, $secret3, $p));

        //member id
        $kv=$_SESSION['kv'];
        // $r=$_SESSION['r'];

        $qpowu=gmp_strval(gmp_powm($q, $secret3, $p));
        $qpowgm=gmp_strval(gmp_powm($q,$secret2,$p));
        try{

            $r=(int)$mmid/((int)$qpowgm*(int)$kv*(int)$mv);

        }
        catch(Exception $e){

            $r=(int)$mmid/((int)$qpowgm*(int)$kv*(int)$mv);

        }
        $hmid= $qpowu*$mv*$kv*$r;
        $mid=hash2mid($hmid);
    
        //partial group key..
        $pgpk=$qpowu*$dgpk;
    
        //Bio index 
        $ix=$_SESSION['ix'];
        $bindx=hash('sha512', $qpowu*$ix*$r);
    
        printf("<br>MEmber Id: %s<br> partial groupkey: %s <br> bi: %s", $mid, $pgpk, $bindx);
        printf("<br>Gm id : %s <br> user id : %s<br>", $gmid, $uid2);

    }

    date_default_timezone_set('Asia/Kolkata');
    $currentDateTime = date('Y-m-d H:i:s');





//If type B update remain member data where group_number is same....

if($group_type=='B')
{
    $sql5='INSERT INTO group_data(user_id,group_type,group_number,admin_id,group_id,mv,member_id,pgk,bi,privilege,activity_status,creation_time) values("'.$uid2.'","'.$group_type.'","'.$group_number.'","'.$admin_id.'","'.$group_id.'","'.$mv.'","'.$hmid.'","'.$pgpk.'","'.$bindx.'","member","active","'.$currentDateTime.'")';

    //INSERT INTO `group_data`(`user_id`, `group_type`, `group_number`, `admin_id`, `group_id`, `mv`, `member_id`, `pgk`, `bi`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]','[value-6]','[value-7]','[value-8]','[value-9]')
try {
    $r6 = mysqli_query($con, $sql5);

    if ($r6 && mysqli_affected_rows($con) > 0) {
        //update remain members data....
        $sql123='update group_data set member_id="'.$hmid.'" ,pgk="'.$pgpk.'",bi="'.$bindx.'"  where group_number="'.$group_number.'" and activity_status="active"';
        $r7=mysqli_query($con, $sql123);
        if ($r7 && mysqli_affected_rows($con) > 0) {
            echo "<script>alert('Member added successfully!!!');</script>";
        } else {
            echo "<script>alert('Failed to update group data.');</script>";

        }

    }
}
catch (Exception $e ){
    echo "<script>alert('User with userid already exists!!!');</script>";
} 
}
else 
{


    $sql5='INSERT INTO group_data(user_id,group_type,group_number,admin_id,group_id,mv,member_id,pgk,bi,privilege,activity_status,creation_time) values("'.$uid2.'","'.$group_type.'","'.$group_number.'","'.$admin_id.'","'.$group_id.'","'.$mv.'","'.$hmid.'","'.$pgpk.'","'.$bindx.'","member","active","'.$currentDateTime.'")';

    //INSERT INTO `group_data`(`user_id`, `group_type`, `group_number`, `admin_id`, `group_id`, `mv`, `member_id`, `pgk`, `bi`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]','[value-6]','[value-7]','[value-8]','[value-9]')
    $r6 = mysqli_query($con, $sql5);
    if ($r6 && mysqli_affected_rows($con) > 0) {
        echo "<script>alert('Member added successfully!!!');</script>";
    } else {

        $sql6 = 'UPDATE group_data SET user_id = "'.$uid2.'", group_type = "'.$group_type.'", group_number = "'.$group_number.'", admin_id = "'.$admin_id.'", group_id = "'.$group_id.'", mv = "'.$mv.'", member_id = "'.$hmid.'",pgk = "'.$pgpk.'", bi = "'.$bindx.'",activity_status="active", privilege="member",$currentDateTime="'.$currentDateTime.'" where user_id="'.$uid2.'" ';

        $r7=mysqli_query($con, $sql6);
        if ($r7 && mysqli_affected_rows($con) > 0) {
            echo "<script>alert('Member added successfully!!!');</script>";
        } else {
            if (mysqli_num_rows(mysqli_query($con, 'SELECT * FROM group_data WHERE user_id="'.$uid2.'"')) > 0) {
                echo "<script>alert('Failed to update group data.');</script>";
            } else {
                echo "<script>alert('Failed to add member or update group data.');</script>";
            }
        }
    }
}
     /*encryption*/
     $iv=hash('sha256', $secret2);
     $iv=substr($iv, 0, 16);
    
     $enc_key=openssl_encrypt($secret3, 'AES-256-CBC', $secret2, OPENSSL_RAW_DATA, $iv);
     $enc_key=base64_encode($enc_key);
     //but if the user exists in differ groups but here data is updated so not get exact value...(for each grp it can enc so update their gm encrypted secret)
     //$sql2='update user set enc="'.$enc_key.'" where user_id="'.$uid2.'"';
     $sql2='update group_data set enc_key="'.$enc_key.'" where user_id="'.$uid2.'" and group_number="'.$group_number.'"';
    
     $r=mysqli_query($con, $sql2);
     if($r) {
         echo "<script>alert('Encryption of user secret done.!!!');</script>";
     } else {
         echo "<script>alert('user id is not found');</script>";
     }




    /*Authentication*/


    //$sql5 = 'UPDATE group_data SET user_id = "'.$uid2.'", group_type = "'.$group_type.'", group_number = "'.$group_number.'", admin_id = "'.$admin_id.'", group_id = "'.$group_id.'", mv = "'.$mv.'", member_id = "'.$hmid.'", mid = "'.$mid.'", pgk = "'.$pgpk.'", bi = "'.$bindx.'" where user_id="'.$user_id.'" ';

    /*
    $id='123';
    $pass='12345678';
    $hash=hash('sha512',$id.$pass);
    $sec=secret($hash);
    $bio=hash('sha512',gmp_strval(gmp_powm($q,$sec,$p))*$ix);

    if($bio==$bindx)
    {
        echo "<br>Login successfully";
    }

    else
    {
        echo "1<br> Not matched";
    }



    $ddgpk=$pgpk/gmp_strval(gmp_powm($q,$sec,$p));
    printf("<br>pgpk1: %s <br> pgpk2: %s",$dgpk,$ddgpk);

    if($ddgpk==$dgpk)
    {
        echo "<br>Yes gpk derived.. from partial group key....";

    }
    else{
        echo "<br>Not derived gpk";
    }

    $spk=$_SESSION['spk'];
    $gk=hash('sha512',$ddgpk*gmp_strval(gmp_powm($q,$spk,$p)));

    printf("<br>The Gk value for encryption and decption of data is..::: %s ",$gk);


    }
    */
    
}
?>