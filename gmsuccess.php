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
    

    <!-- Name at the top nav bar -->
    <?php
            
            foreach($rr as $i)
            {
   
                $name=$i['first_name'].$i['last_name'];
                // echo "<p>NAME : $name </p>";
                $_SESSION['name']=$name;
                // echo "<p>Privilege : Group Manager</p>";
                
             
            }

    ?>



<!-- FIle access information -->


<!-- <div style="width:350px; left:74%; position:absolute; top:180px;">

    <table style=" background-color: #1b2c4b; color:white;" class="color-meaning">
        <tr>
            <th border: 3px solid red;>File Color</th>
            <th>Meaning</th>
        </tr>
        <tr>
            <th><div style=" background-color:white; height:20px; width:20px; margin-left:16px;"></div></th>
            <th style="padding:10px 10px;">No One has requested for that file</th>
        </tr>
        <tr>
            <th><div style=" background-color:orange; height:20px; width:20px;margin-left:16px;"></div></th>
            <th style="padding:10px 10px;">You have requested for the file</th>
        </tr>
        <tr>
            <th><div style=" background-color:purple; height:20px; width:20px;margin-left:16px;"></div></th>
            <th style="padding:10px 10px;">You need to give the permission for the file</th>
        </tr>
        <tr>
            <th><div style=" background-color:brown; height:20px; width:20px;margin-left:16px;"></div></th>
            <th style="padding:10px 10px;">You have given permission for the file</th>
        </tr>
        <tr>
            <th><div style=" background-color:green; height:20px; width:20px;margin-left:16px;"></div></th>
            <th style="padding:10px 10px;">You can download the file</th>
        </tr>
    </table>
</div> -->




<!-- File dislay purspose- MongoDB -->



<!-- <div style = " display:visible; margin-top:80px; margin-left:60px; text-align:center; color:white;background-color: #1b2c4b; padding:5px; font-size:18px; padding:20px; width: 63%; height:40px;">
        THIS GROUP HAS FOLLOWING FILES:
        <br>
        <div style="margin:4px; font-size:18px; ">
        Group Number : <?//php echo $_SESSION['group_number']; ?>
        </div>
</div>
<div id="container_table" style="margin-top:100px;  width:63%; margin-left:60px; overflow-y:auto;height:400px; max-height:400px; background-color:white;">
    <table> 
        <tbody>
                <?php
                // include 'conn.php';
                $group_number = $_SESSION['group_number'];
                $group_type = $_SESSION['group_type'];
                $gmid = $_SESSION['gmid'];
                $query_file = "select * from files where group_number = '$group_number' ";
                $result_file = mysqli_query($con,$query_file);  

                $count = 0; 
                if($group_type=='A')
                {
                echo "<tr>";
                    while ($row_file = mysqli_fetch_assoc($result_file)) 
                    {
                    echo "<td>";
                    ?>
                    <form method="post" action="gmfile.php" class=form1 >
                    <input type="hidden" name="file_id" value="<?php echo $row_file['file_id'] ?>">
                    <input type="hidden" name="group_number" value="<?php echo $group_number ?>">
                    <input type="hidden" name="group_type" value="<?php echo $group_type ?>">
                    <input type="hidden" name="user_id" value="<?php echo $gmid ?>">
                    <button type="submit" name="enter"> 
                    <img style="height:60px; width:60px;" src="green.jpg" alt="Button" />    
                    </button>
                    </form>
                    <?php echo $row_file['file_name'] ?>
                    <?php
                    $count++;
                    echo "</td>";

                    if ($count % 3 == 0) 
                    {
                        // Start a new row
                        echo "</tr>";
                    }

                    // if ($count % 3 == 0) {
                    //     // Close the row after displaying three columns
                    //     echo "</tr>";
                    // }
                    
                    }
                }
                elseif($group_type=='B' || $group_type=='C')
                {   
                    require 'vendor/autoload.php';
                    $client = new MongoDB\Client("mongodb://localhost:27017");
                    $mas = $client->selectDatabase('mas'); 
                    $files = $mas->files;
                    // $unclicked_docs = $files->find(['userid_first' => 'null']);
                    // $unclicked_docs_array = iterator_to_array($unclicked_docs);
                    echo "<tr>";
                    // $query_file = "select * from files where group_number = '$group_number' ";
                    // $result_file = mysqli_query($con,$query_file); 
                    while ($row_file = mysqli_fetch_assoc($result_file)) 
                    {
                        $imgsrc = 'white.jpg';

                        $document = $files->findOne(
                        ['_id'=>$row_file['file_id']]
                        ); 
                        

                        if ($document['userid_first'] == 'null') {
                            $imgsrc = 'white.jpg';
                        }
                        else
                        {
                            if($document['userid_first'] != $gmid)
                            {
                                $imgsrc = ($document[$gmid]==0 ? 'purple.jpg' : 'brown.jpg');
                            }
                            else
                            {
                                $userid_check = 1;
                                foreach($document as $key=>$value)
                                {
                                    if($value==0)
                                    {
                                        $userid_check = 0;
                                        break;
                                    }
                                }
                                $imgsrc = ($userid_check==1 ? 'green.jpg' : 'orange.jpg');
                                
                            }
                        }
                    // }
                    // echo "<tr>";
                    // while ($row_file = mysqli_fetch_assoc($result_file)) 
                    // {
                    echo "<td>";
                    ?>
                    <form method="post" action="" class=form1  >
                    <input type="hidden" name="file_id" value="<?php echo $row_file['file_id'] ?>">
                    <input type="hidden" name="group_number" value="<?php echo $group_number ?>">
                    <input type="hidden" name="group_type" value="<?php echo $group_type ?>">
                    <input type="hidden" name="user_id" value="<?php echo $gmid ?>">
                    <input type="hidden" name="imgsrc" value="<?php echo $imgsrc ?>">
                    <button type="submit" name="enter"> 
                    <img style="height:60px; width:60px;" src="<?php echo $imgsrc;?>" alt="Button" />    
                    </button>
                    </form>
                    <?php echo $row_file['file_name'] ?>
                    <?php
                    $count++;
                    echo "</td>";

                    if ($count % 3 == 0) 
                    {
                        // Start a new row
                        echo "</tr><tr>";
                    }


                    if ($count % 3 == 0) {
                        // Close the row after displaying three columns
                        echo "</tr>";
                    }
                    }    
                    
                } 
                elseif($group_type=='D')
                {
                    require 'vendor/autoload.php';
                    $client = new MongoDB\Client("mongodb://localhost:27017");
                    $mas = $client->selectDatabase('mas'); 
                    $files = $mas->files;
                    // $unclicked_docs = $files->find(['userid_first' => 'null']);
                    // $unclicked_docs_array = iterator_to_array($unclicked_docs);
                    echo "<tr>";
                    // $query_file = "select * from files where group_number = '$group_number' ";
                    // $result_file = mysqli_query($con,$query_file); 
                    while ($row_file = mysqli_fetch_assoc($result_file)) 
                    {
                        $imgsrc = 'white.jpg';

                        $document = $files->findOne(
                        ['_id'=>$row_file['file_id']]
                        ); 
                        

                        if ($document['userid_first'] == 'null') {
                            $imgsrc = 'white.jpg';
                        }
                        else
                        {
                            if($document['userid_first'] != $gmid)
                            {
                                $imgsrc = ($document[$gmid]==0 ? 'purple.jpg' : 'brown.jpg');
                            }
                            else
                            {
                                $userid_count = 0;
                                foreach($document as $key=>$value)
                                {
                                    if($value==1 && $key!='k')
                                    {
                                        $userid_count = $userid_count + 1 ;
                                    }
                                }
                                $imgsrc = ($userid_count>=$document['k'] ? 'green.jpg' : 'orange.jpg');
                                
                            }
                        }
                    // }
                    // echo "<tr>";
                    // while ($row_file = mysqli_fetch_assoc($result_file)) 
                    // {
                    echo "<td>";
                    ?>
                    <form method="post" action="" class=form1  >
                    <input type="hidden" name="file_id" value="<?php echo $row_file['file_id'] ?>">
                    <input type="hidden" name="group_number" value="<?php echo $group_number ?>">
                    <input type="hidden" name="group_type" value="<?php echo $group_type ?>">
                    <input type="hidden" name="user_id" value="<?php echo $gmid ?>">
                    <input type="hidden" name="imgsrc" value="<?php echo $imgsrc ?>">
                    <button type="submit" name="enter"> 
                    <img style="height:60px; width:60px;" src="<?php echo $imgsrc;?>" alt="Button" />    
                    </button>
                    </form>
                    <?php echo $row_file['file_name'] ?>
                    <?php
                    $count++;
                    echo "</td>";

                    if ($count % 3 == 0) 
                    {
                        // Start a new row
                        echo "</tr><tr>";
                    }


                    if ($count % 3 == 0) {
                        // Close the row after displaying three columns
                        echo "</tr>";
                    }
                    } 
                }
                     
                ?>
        </tbody>
    </table>
</div> -->






<!-- Files displaying -->

    <!-- <div class="fimg">
        <?php 
        // for($i=1;$i<=20;$i++)
        // {

        //     echo "<div class='in'><a href='#' style='text-style:none;'><img src='fimg.png'></a>file.$i</div>";
        // }
        
        ?>
    </div> -->



<!-- Image on top left -->

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
