<?php
   include 'conn.php';
   session_start();
   
   if(isset($_POST['user_id']) && isset($_POST['privilege']))
   {   
       $user_id = $_POST['user_id'];
       $group_number = $_POST['group_number'];
       $group_type = $_POST['group_type'];
       $privilege = $_POST['privilege'];
       // echo $user_id.','.$privilege;?>
       <script> console.log('<?php echo $user_id ?>','<?php echo $privilege ?>');</script>
       <?php
       //stores gm userid as gmid
    $_SESSION['mid']=$user_id;
    $_SESSION['group_number']=$group_number;
    $_SESSION['group_type']=$group_type;
    $_SESSION['privilege']=$privilege;


}
  
 
?>

<!DOCTYPE html>
<html>

<head>
    <title>MultiParty Authentication System</title>
    <link rel="stylesheet" href="./css/file.css">
    <style>
    body {
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            font-family: sans-serif;
            /* Change font style to sans-serif */
            background-color:#b8d5ff;
            overflow: hidden;
        }
        .container {
            width: 600px;
            height: 360px;
            margin: auto auto;
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin-top:60px;
        }

        header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background-color: #100a89;
            padding: 15px;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header img {
            margin-left: 10px;
        }

        .profile {
            margin-top: 5px;
            margin-left: 5px;
            background-color: white;
        }
        .prof {
            flex-direction:row;
        }
        .txt { 
        position: absolute;
        top: 16%;
        width: 18%;
        text-align: center;
        font-size: 15px;
    }

    nav ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            overflow: hidden;
        }

        nav li {
            float: left;
        }

        nav li a {
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }

        nav li a:hover {
            background-color: #1f84f7;
        }

        /* Added styling for the sub-menu */
        nav ul ul {
            display: none;
            position: absolute;
            background-color: #100a89;
            padding: 0;
            margin-top: 0;
        }

        nav ul li:hover>ul {
            display: inherit;
        }

        nav ul ul li {
            float: none;
            width: 100%;
        }

        nav ul ul a {
            padding: 10px 16px;
        }

        nav ul ul a:hover {
            text-decoration: underline;
            /* Add underline only on hover */
        }

        footer {
            background-color: #100a89;
            padding: 1px;
            /* Decrease the height of the footer */
            color: white;
            text-align: center;
            margin-top: auto;
        }

        footer p {
            font-weight: bold;
        }
        
    </style>
</head>
<body>
    
<?php  
$mid = $_SESSION['mid'];
$query2 = "select * from user where user_id = '$mid'";
$result2 = mysqli_query($con,$query2);
$row = mysqli_fetch_assoc($result2);
$name = $row['first_name']." ".$row['last_name'];

    ?>
    <header>
        <div class="prof">
        <img class="profile" src="user.jpg" alt="User Image" style="width: 50px; height: 50px;">
        <div class="txt">
        <h3><?php echo $name;?> </h3>
        </div>
    </div>
        <nav>
            <ul>
                <li><a href="pageformat.php">Home</a></li>
                <li><a href="requestmembership.php">Request Membership</a>
                    <ul>
                        <li><a href="requestform1.php">Become Manager</a></li>
                        <li><a href="requestform2.php">Become Member</a></li>
                        <li><a href="requestform3.php">Request for Removal</a></li>
                    </ul>
                </li>
                <li><a href="dataaccess.php">Data Access</a>
                    <ul>
                        <li><a href="fileupload.php">Upload file</a></li>
                        <li><a href="file.php">Access file</a></li>
                    </ul>
                </li>
                <li>
                    <a href="requestlist.php">Request List</a>
                    <ul>
                        <li><a href="sentlist.php">Sent</a></li>
                        <li><a href="receivedlist.php">Received</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#">Logout</a>
                </li>
            </ul>
        </nav>
    </header>
<div id="container_table" style="position:absolute; top:200px; border:2px solid black; width:80%;">
    <table>
            
            <tbody>
                <?php
                // include 'conn.php';
                $group_number = $_SESSION['group_number'];
                $group_type = $_SESSION['group_type'];
                $mid = $_SESSION['mid'];
                $query_file = "select * from files where group_number = '$group_number' ";
                $result_file = mysqli_query($con,$query_file);  

                $count = 0; // Counter to keep track of the column count
                // if($group_type=='A')
                // {
                echo "<tr>";
                    while ($row_file = mysqli_fetch_assoc($result_file)) 
                    {
                    echo "<td>";
                    ?>
                    <form method="post" action="file.php" class=form1 >
                    <input type="hidden" name="file_id" value="<?php echo $row_file['file_id'] ?>">
                    <input type="hidden" name="group_number" value="<?php echo $group_number ?>">
                    <input type="hidden" name="group_type" value="<?php echo $group_type ?>">
                    <input type="hidden" name="user_id" value="<?php echo $mid ?>">
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
                        echo "</tr><tr>";
                    }


                    if ($count % 3 == 0) {
                        // Close the row after displaying three columns
                        echo "</tr>";
                    }
                    }
                // }
                // elseif($group_type=='B')
                // {
                    
                //     require 'vendor/autoload.php';
                //     $client = new MongoDB\Client("mongodb://localhost:27017");
                //     $mas = $client->selectDatabase('mas'); 
                //     $files = $mas->files;
                //     $documents = $files->find(['userid_first' => ['$ne' => 0]]);
                //     echo "<tr>";
                //     while ($row_file = mysqli_fetch_assoc($result_file)) 
                //     {
                //         $document = $files->findOne(
                //         ['_id'=>$row_file['file_id']]
                //         ); 

                //         $fileIdExists = 0;
                //         $flag_checkf = 1;
                //         foreach($document as $key=>$value)
                //         {
                //             if($value==0 && $key!='userid_first')
                //             {
                //                 $flag_check = 0;
                //                 break;
                //             }
                //         }
                //         foreach ($documents as $document) {
                //             if ($document['_id']==$row_file['file_id'] && $document['userid_first'] != $mid && $document[$mid]==0) {
                //                 $fileIdExists = 1;
                //                 break;
                //             }
                //             elseif ($document['_id']==$row_file['file_id'] && $document['userid_first'] != $row_file['user_id'] && $document[$row_file['user_id']]==1) {
                //                 $fileIdExists = 2;
                //                 break;
                //             }
                //             elseif ($document['_id']==$row_file['file_id'] && $document['userid_first'] == $row_file['user_id'] && $document[$row_file['user_id']]==1) {
                //                 $fileIdExists = 3;
                //                 break;
                //             }
                //         } 
                //         $imgsrc = 'files.png';
                //         if($fileIdExists == 1 )
                //         $imgsrc = 'purple.png';
                //         if($fileIdExists == 2 )
                //         $imgsrc = 'brown.png';
                //         if($fileIdExists == 3 )
                //         $imgsrc = 'orange.png';
                //         if($fileIdExists == 4 )
                //         $imgsrc = 'green.png';

                //         echo "<td>";
                //         ?>
                //         <form method="post" action="file.php" class=form1 >
                //         <input type="hidden" name="file_id" value="<?php echo $row_file['file_id'] ?>">
                //         <input type="hidden" name="group_number" value="<?php echo $group_number ?>">
                //         <input type="hidden" name="group_type" value="<?php echo $group_type ?>">
                //         <input type="hidden" name="user_id" value="<?php echo $mid ?>">
                //         <button type="submit" name="enter" id="enter"> 
                //             <img style="height:60px; width:60px;" src="files.png" alt="Button" />    
                //         </button>
                //         </form>
                //         <?php echo $row_file['file_id'] ?>
                //         <?php
                //         $count++;
                //         echo "</td>";   

                //         if ($count % 3 == 0) 
                //         {
                //             // Start a new row
                //             echo "</tr><tr>";
                //         }


                //         if ($count % 3 == 0) {
                //             // Close the row after displaying three columns
                //             echo "</tr>";
                //         }
                //     }
                // }
                 ?>
                </tbody>
    </table>
</div>



<?php
if (isset($_POST['enter']))
{
    $file_id = $_POST['file_id'];
    $user_id = $_POST['user_id'];
    $group_type = $_POST['group_type'];

    require 'vendor/autoload.php';
    $client = new MongoDB\Client("mongodb://localhost:27017");
    $mas = $client->selectDatabase('mas'); 
    $files = $mas->files;
    
    // $filter = ['_id' => $file_id, $user_id => ['$exists' => true]];
    // $update = ['$set' => [$user_id => 1]];
    // $files->updateOne($filter, $update);
    
    // $document = $files->findOne(
    // ['_id'=>$file_id]
    // ); 

    
    if($group_type== 'A')
    {
        ?>
        <script>
            alert("data access!");
        </script>
        <?php
    }
    elseif($group_type == 'B')
    {
        //setting $userid_first to first click userid
        $document = $files->findOne(['_id'=>$file_id]); 
        $flag_userid_first=1;
        foreach($document as $key=>$value)
        {
            if($value==1)   //not checking key as _id and userid_first do not have 1 value.
            {
                $flag_userid_first=0;
                break;
            }
        }
        if($flag_userid_first==1)
        {
            $files->updateOne(['_id' => $file_id], ['$set' => [$userid_first => $user_id]]);
        }

        //file accessing by first user
        $flag_check = 1;
        foreach($document as $key=>$value)
        {
            if($value==0)
            {
                $flag_check = 0;
                break;
            }
        }
        if(flag_ckeck==1)
        {
            ?>
            <script>
                alert("file downloaded");
            </script>
            <?php
             $filter = ['_id' => $file_id];
             $update = ['$set' => []];
             $document = $files->findOne($filter);
             foreach ($document as $key => $value) 
             {
                 if ($key != '_id' && $key != 'userid_first') 
                 {
                     $update['$set'][$key] = 0;
                 }
             }
             $files->updateOne($filter, $update);
        }  //if nothing of above case satisfies, set flag of corressponding user_id to 1

        else
        {
            $files->updateOne(['_id' => $file_id], ['$set' => [$user_id => 1]]);
            ?>
            <script>
            alert("Wait for other members!");
            window.location.href = 'file.php';
            
            <?php 
        }
    }
}
        
?>


</body>
</html>