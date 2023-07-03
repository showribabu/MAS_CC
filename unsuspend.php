<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        /* .unsuspend {
            background-color: orange;
            color: white;
            padding: 5px 10px;
            border: none;
            cursor: pointer;
        } */
    </style>
  
</head>
<body>

<?php
include "conn.php";
session_start();

include "nav.html";
include "button.html";

$group_type=$_SESSION['group_type'];
$group_number=$_SESSION['group_number']; 
$gm_id=$_SESSION['gmid'];
global  $group_type, $group_number, $gm_id;
?>
    <div class="data">
        <p class="pp" id="req">SUSPENDED MEMBERS LIST</p>

        <!-- <div class='table_container'> -->
            <table border="5px" cellpadding="8px" align="center" cellspacing="5px" class="tb" style="height:80px; width:780px;  text-align:center; align-items:center;">
                <!-- <thead> -->
                  <tr id="tr1">
                    <th>NAME</th>
                    <th>EMAIL ID</th>
                    <th>ACTIVITY STATUS</th>
                    <th>ACTION</th> 
                </tr>
                <!-- </thead> -->
            <!-- <tbody> -->
<?php
//   include "header2.php";
   

if(!$con)
{
    echo die('Error:'.mysqli_connect_error());
}

        
        $sql = "SELECT * FROM group_data WHERE group_number = '$group_number' and activity_status='suspended'";
        $result = mysqli_query($con, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            while ($member = mysqli_fetch_assoc($result)){       
                echo "<tr>";
                // echo "<td>" . $member['user_id'] . "</td>";
 
                $user_id=$member['user_id'];
                // echo "<td>**NAME***</td>";
                // echo "<td>**MAIL***</td>";
                $query = "SELECT * FROM user WHERE user_id = '$user_id'";
                $res = mysqli_query($con, $query);
                $row1 = $res->fetch_assoc();

                if ($row1) {
                    $name=$row1['first_name'].$row1['middle_name'].$row1['last_name'];
                    echo "<td>" . $name . "</td>";
                    echo "<td>" . $row1['email'] . "</td>";
                } 


                echo "<td>" . $member['activity_status'] . "</td>"; 

                echo "<td>";
                echo "<form method='POST'>";
                echo "<input type='hidden' name='userId' value='" . $member['user_id'] . "'>";
                echo "<input type='submit' name='unsuspendButton' value='Unsuspend' class='btn btn-success'>";
                echo "</form>";
                echo "</td>";

                echo "</tr>";
            }
        } 
        // else {
        //     echo "No suspended group members found.";
        // }

        // Function to unsuspend a user by updating the activity_status in the groupdata table as active for type A or type C
        function unsuspendUserAC($userId) {
            global $con, $group_number;
            $sql = "UPDATE group_data SET activity_status = 'active' WHERE user_id = '$userId' and group_number='$group_number'";
            $result = mysqli_query($con, $sql);
            if ($result) {
                echo "<script>alert('User ID: " . $userId . " unsuspended successfully.');</script>";
            } else {
                echo "Error unsuspending user: " . mysqli_error($con) . "<br><br>";
            }
        }

       // Function to unsuspend a user by updating the activity_status in the groupdata table as active for type B
       function unsuspendUserB($userId) {
       
        global  $group_type, $group_number, $gm_id;

        $query1="select enc_key from group_data where user_id='$userId' and group_number='$group_number'";
        global $con;
        global $mv;
        global $pgpk;

        $result1 = mysqli_query($con, $query1);

        $row = $result1->fetch_assoc();
          global $enc_key;
        if ($row) { // Check if a row is fetched
         $enc_key=$row['enc_key'];
        //  $mv=$row['mv'];
        //  $pgpk=$row['pgk'];
        }
        else{
            echo "enc_key fetching unsuccessful";
        }
        $query9="select mv,pgk from group_data where activity_status='active' and group_number='$group_number'";
        $result9 = mysqli_query($con, $query9);
        $row9 = $result9->fetch_assoc();

        if ($row9) { // Check if a row is fetched
            $mv=$row9['mv'];
            $pgpk=$row9['pgk'];
           }
           else{
               echo "mv, pgk fetching unsuccessful";
           }

 $query2="select secret from user where user_id='$gm_id'";
 $result2 = mysqli_query($con, $query2);
 $row2 = $result2->fetch_assoc();
 if ($row2) { // Check if a row is fetched
  $gm_secret_dec=$row2['secret'];

  }
  else{
     echo "error in retrieving group manager's secret";
  }
        // // global $gm_secret_dec;

   function secret($hash,$p,$q)
   {
    $binary=hex2bin($hash);
    //but here binary is large so..use GMP module
    $u=gmp_strval(gmp_import($binary));
    $secret=gmp_strval(gmp_powm($q, $u, $p));
    return $secret;
}


global $con;
$query3="select p,q,ix from server_parameters";
$result3 = mysqli_query($con, $query3);
$row3 = $result3->fetch_assoc();

$p=$row3['p'];
$q=$row3['q'];
$ix=$row3['ix'];


//    $gm_secret_dec=secret($gm_secret,$p,$q);


   $iv=hash('sha256',  $gm_secret_dec);
   $iv=substr($iv,0,16);

   $user_secret=openssl_decrypt(base64_decode($enc_key),'AES-256-CBC',$gm_secret_dec,OPENSSL_RAW_DATA,$iv);
// $user_secret= base64_decode(openssl_decrypt($enc_key, 'AES-256-CBC',$gm_secret_dec, OPENSSL_RAW_DATA, $iv));

   $dgpk =$mv/gmp_strval(gmp_powm($q,  $gm_secret_dec, $p));
                // $dgpk = gmp_powm($mv, gmp_invert(gmp_powm($q, $secret2, $p), $p), $p);
//    $dgpk = gmp_strval($dgpk);
  $old_sec=$pgpk/$dgpk;

   $qpowu=gmp_strval(gmp_powm($q, $user_secret, $p));

                //eliminate the persons secret....
                $new_sec=$old_sec * $qpowu;

                //member id
                $hmid=hash('sha512',$new_sec*$mv);

                //new partial group key
                $pgpk=$new_sec*$dgpk;

                //Bio index
                $bindx=hash('sha512', $new_sec*$ix);


        $query5="update group_data set activity_status='active' where user_id='$userId' and group_number='$group_number'";
        $result5=mysqli_query($con,$query5);
        
        if ($result5) {
            echo "<script>alert('User ID: " . $userId . " unsuspended successfully.');</script>";

        } 

         else {
            echo "Error unsuspending user: " . mysqli_error($con) . "<br><br>";
        }


          $query4 = "UPDATE group_data SET member_id='$hmid' , pgk='$pgpk', bi='$bindx' WHERE activity_status='active' and group_number='$group_number'";
          $result4=mysqli_query($con,$query4);
          if($result4)
          {
            echo "<script>alert('Data updated successfully');</script>";
          }
          else{
            echo "<script>alert('Data is not updated successfully');</script>";

          }
    }













  // Check if the unsuspendButton form is submitted
        if (isset($_POST['unsuspendButton'])) {
            
            $userId = $_POST['userId'];

            if($group_type== 'A' ||  $group_type== 'C' ||  $group_type== 'D')
            {
              unsuspendUserAC($userId);
            }
            else if($group_type=='B')
            {

                unsuspendUserB($userId);
            }
        }


        mysqli_close($con);
    ?>
    </table>
    </div>
    <div class='pic'>
               <!-- <img src="gm1.jpg" alt="group manager"> -->
               <img src="<?php echo $_SESSION['photo_location'];?>" alt="group manager">
    </div>

    

    <footer>
        <p>MAS : MULTI PARTY AUTHENTICATION SYSTEM</p>
    </footer>
    <p class="data2"><?php echo $_SESSION['name'];?></p>

 </body>
 </html>