<?php
include "../connector.php";

echo $rid = $_GET['rid'];



date_default_timezone_set('Asia/Kolkata');
$currentDateTime = date('Y-m-d H:i:s');

$sql = "UPDATE requests SET r_status = 'r',  deletion_time = '$currentDateTime' WHERE request_id = '$rid'";
$result = mysqli_query($con, $sql) or die("Query Unsuccessful");

header("Location: gm_request.php");


mysqli_close($con);
