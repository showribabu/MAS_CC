<?php
include "../connection.php";

$uid = 'nitish_123';

$sql1 = "select * from user WHERE user_id = $uid";

$result1 = mysqli_query($con, $sql1) or die("Query Unsuccessful");


if (mysqli_num_rows($result1) > 0) {
    while ($data = mysqli_fetch_assoc($result1)) {
        $x = $data['secret'];
        echo "group password -> " . $data['secret'];
    }
} else {
    echo "<br> group Password doesn't found out";
}
