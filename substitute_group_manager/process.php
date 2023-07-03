<?php
echo "you Are Successfully Accepted <br>";

echo $rid = $_GET['rid'];

include "../connection.php";

$sql = "UPDATE user SET status = 'a' WHERE request_id = '$rid'";
// $sql = "DELETE FROM user WHERE request_id = '$rid'";
$result = mysqli_query($con, $sql) or die("Query Unsuccessful");

header("Location: substitute_gm.php");


mysqli_close($con);
