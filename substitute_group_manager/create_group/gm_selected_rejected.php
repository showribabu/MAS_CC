<?php
echo "you Are Successfully Accepted <br>";
echo

$rid = $_GET['rid'];

include "../connector.php";

$sql = "UPDATE user SET status = 'r' WHERE request_id = '$rid'";
// $sql = "DELETE FROM user WHERE request_id = '$rid'";
$result = mysqli_query($con, $sql) or die("Query Unsuccessful");

header("Location: gm_selected.php");


mysqli_close($con);
