<?php


include "conn.php";
session_start();

include "nav.html";
include "button.html";

if(isset($_POST['user_id']))
{
    $user_id=$_POST['user_id'];
    $group_number=$_POST['group_number'];
    $group_type=$_POST['group_type'];
    $privilege=$_POST['privilege'];
// echo $user_id.','.$privilege;

//stores gm userid as gmid
$_SESSION['gmid']=$user_id;
$_SESSION['group_number']=$group_number;
$_SESSION['group_type']=$group_type;
$_SESSION['privilege']=$privilege;


}
else
{
    echo "Not coming";
}



/* System parameters*/

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


/*IMage url from database..*/
$sql34 = "SELECT photo_location FROM user WHERE user_id='$_SESSION[gmid]'";
$rr = mysqli_query($con, $sql34);
if ($rr) {
    $photo_location = mysqli_fetch_row($rr)[0];
    // $photo_location = './%23'.substr($photo_location,1,strlen($photo_location));
    $_SESSION['photo_location'] = './'.$photo_location;
    // echo "photo_location: ".$_SESSION['photo_location'];
} else {
    echo "<script>alert('Error in finding Image location');</script>";
}




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Group Manager</title>


 <style>
    .fimg 
    {
        display:flex;
        flex-wrap: wrap;
        background-color: white;
        align-items:center;
        height:fit-content;
        width:600px;
        margin-top:50px;
        margin-left:28%;
        overflow:scroll;
        max-height: 500px;
        scroll-behavior: smooth;
        
    }

    .in 
    {
        background-color: blue;
        margin:6px;
        display:flex;
        flex-direction:column;
        align-items:center;
        color:white;
        font-weight:bold;
        padding:6px;

    }
</style>
</head>

<body>

    <?php  
    $gmid=$_SESSION['gmid'];
    $sql='select * from user where user_id="'.$gmid.'"';
    $rr=mysqli_query($con,$sql);
    if(!$rr)
    {
        echo "<script>alert('Error executing the query');</script>";
    }
    ?>
<!-- Image AND Data -->

    <!-- <div class='main'> 
        <div class='pic'>
            <img src="gm1.jpg" alt="group manager">
        </div>
        <div class='data2'>
            <?php
            
            // foreach($rr as $i)
            // {
   
            //     $name=$i['first_name'].$i['last_name'];
            //     echo "<p>NAME : $name </p>";
            //     $_SESSION['name']=$name;
            //     echo "<p>Privilege : Group Manager</p>";
                
             
            // }

            ?>

        </div>
    </div> -->
    

    <?php
            
            foreach($rr as $i)
            {
   
                $name=$i['first_name'].$i['last_name'];
                // echo "<p>NAME : $name </p>";
                $_SESSION['name']=$name;
                // echo "<p>Privilege : Group Manager</p>";
                
             
            }

            ?>

    <div class="fimg">
        <?php 
        for($i=1;$i<=20;$i++)
        {

            echo "<div class='in'><a href='#' style='text-style:none;'><img src='fimg.png'></a>file.$i</div>";
        }
        
        ?>
    </div>

    <div class='pic'>
    <!-- <img src="gm1.jpg" alt="group manager"> -->
    <!-- <img src="./%23images/userimage.png" alt="group manager"> -->
    <img src="<?php echo $_SESSION['photo_location'];?>" alt="group manager">





    </div>
    
    <p class="data2"><?php echo $_SESSION['name'];?></p>

    <!-- Footer  -->
    <footer>
        <p>MAS : MULTI PARTY AUTHENTICATION SYSTEM</p>
    </footer>

</body>
</html>
