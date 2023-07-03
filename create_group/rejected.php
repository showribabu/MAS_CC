<?php
include "../connection.php";

echo $rid = $_GET['rid'];


$sql = "UPDATE requests SET r_status = 'r' WHERE request_id = '$rid'";
$result = mysqli_query($con, $sql) or die("Query Unsuccessful");

header("Location: gm_request.php");


mysqli_close($con);
