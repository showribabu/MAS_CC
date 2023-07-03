<?php
include 'pageformat.php';
include 'conn.php';


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
</head>
<body>
<footer>
        <p>MULTIPARTY AUTHENTICATION SYSTEM</p>
    </footer>
</body>

</html>