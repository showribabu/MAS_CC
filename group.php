<?php

session_start();
$user_id = $_SESSION['user_id'];
$_SESSION['mid']=$user_id;
include 'conn.php';
  $query1 = "select * from group_data where user_id = '$user_id'";
  $result = mysqli_query($con,$query1);
  $row1 = mysqli_fetch_assoc($result);


  $query2 = "select * from user where user_id = '$user_id'";
  $result2 = mysqli_query($con,$query2);
  $row = mysqli_fetch_assoc($result2);
  $name = $row['first_name']." ".$row['middle_name']." ".$row['last_name'];
  $imgsrc = $row['photo_location'];
        

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Groups</title>
<link rel="stylesheet" href="./css/group.css">
</head>
<body>
<div class="container">
    
        <div class="heading1">
        </div>
            
        <header>
    <div class="prof">
    <img class="profile" src="<?php echo "./".$imgsrc ?>" alt="User Image" style="width: 50px; height: 50px;">
    <div class="txt">
    <h3 style="top:12px; position:absolute; left:65px"><?php echo $name;?> </h3>
    </div>
</div>
    <nav>
        <ul>
            <li><a href="group.php">Home</a></li>
            <li><a href="request_membership.php">Request Membership</a>
                <ul>
                    <li><a href="request_form1.php">Become Manager</a></li>
                    <li><a href="request_form2.php">Become Member</a></li>
                </ul>
            </li>

            <li>
                <a href="request_list.php">Request List</a>
                <ul>
                    <li><a href="sent_list.php">Sent</a></li>
                    <li><a href="received_list.php">Received</a></li>
                </ul>
            </li>
            <li>
                <a onclick="logout()" href="index.php">Logout</a>
            </li>
        </ul>
    </nav>
</header>

            <?php
            if(count((array)$row1) > 0)
            {
                ?>
            <div class="outside_box">

            <div class="inner-heading">
            <h2 >You are part of shown groups :</h2>
            </div>

            <div class="table">
            <table>

                <thead>
                    <tr>
                    <th>Group Number</th>
                    <th>Group Type</th>
                    <th>Privilege</th>
                    <!-- <th>Action</th> -->
                    </tr>
                </thead>

                <tbody>
                    <?php
                     $query1 = "select * from group_data where user_id = '$user_id'";
                     $result = mysqli_query($con,$query1);
                    while($row1=mysqli_fetch_assoc($result))
                    {
                        ?>
             <tr class="my-button" onclick="redirectform('<?php echo $row1['privilege'] ?>','<?php echo $user_id ?>','<?php echo $row1['group_number'] ?>','<?php echo $row1['group_type'] ?>')" style="cursor: pointer;">
                <td><?php echo $row1['group_number'] ?></td>
                <td><?php echo $row1['group_type'] ?></td>
                <td><?php echo ($row1['privilege'] == 'gm') ? "Group Manager" : (($row1['privilege'] == 'member') ? "Member" : "Authority Member"); ?></td>
                
                    <form id="myForm" action="" method="post">
                        <input type="hidden" name="group_number" id="group_number" value="<?php echo $row1['group_number'] ?>">
                        <input type="hidden" name="group_type" id="group_type" value="<?php echo $row1['group_type'] ?>">
                        <input type="hidden" name="privilege" id="privilege" value="<?php echo $row1['privilege'] ?>">
                        <input type="hidden" name="user_id" id="user_id" value="<?php echo $user_id ?>">
                    </form>
                
            </tr>

                <?php
                    }
                    
                    ?>
                </tbody>
                </table>
            </div>
            </div>
            <?php
            }
                else
                {
            ?>
                    <h1 class="nogroup">You are not the part of any group</h1>
            <?php
                }
            ?>
          
          <footer>
              <p>MAS : MULTY PARTY AUTHENTICATION SYSTEM</p>
          </footer>
        </div>
   

<script src="./js/group.js"></script>
<script>
function redirectform(a,b,gnumber,type){
// console.log(a,b,gnumber,type);
document.getElementById("user_id").value=b;
document.getElementById("privilege").value=a;
document.getElementById("group_number").value=gnumber;
document.getElementById("group_type").value = type;
if(a == 'member' || a=='authority_member')
{
    // window.location.href="pageformat.php";
    document.getElementById("myForm").setAttribute("action","fileaccess.php");
    document.getElementById("myForm").submit();
}
else if(a == 'gm')
{
    // window.location.href="gmsuccess.php";
    document.getElementById("myForm").setAttribute("action","gmsuccess.php");
    document.getElementById("myForm").submit();

}
// document.getElementById("myForm").submit();

}
</script>
</body>
</html>