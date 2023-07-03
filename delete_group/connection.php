<?php


// for my machine
$servername = "localhost";
$password = "";

$admin_name_ = "root";
$dbname = "mas";

$con = mysqli_connect($servername, $admin_name_, $password, $dbname);
if ($con) {
    echo "connection ok";
} else {
    echo "connection failed" . mysqli_connect_error();
}
