<?php


// for my machine
$servername = "localhost";
$password = "";

$username = "root";
$dbname = "mas";

$con = mysqli_connect($servername, $username, $password, $dbname);
if ($con) {
    echo "connection ok";
} else {
    echo "connection failed" . mysqli_connect_error();
}
