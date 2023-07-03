<?php
// error_reporting(0);
echo "<br>";
echo $grp_num = $_GET['gnum'];


include("../connector.php");
$grp_name_up = "grp11b";
$grp_num_up = "18";
$grp_manager_up = "Mr. Rahul";



$query = "UPDATE group_created_data set group_name = '$grp_name_up', group_number = '$grp_num_up',  group_manager = '$grp_manager_up'  where group_number = '$grp_num'";
$data = mysqli_query($con, $query) or die('query Unsuccessful');
echo "hello";

header("Location: substitute_gm.php");


mysqli_close($con);
