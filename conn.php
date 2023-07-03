<?php
$host='localhost';
$user='root';
$pass='';
$db='MAS';
$con=mysqli_connect($host,$user,$pass,$db);


//  $db_host        = '10.14.98.204:3306';
// // // $db_host='localhost';
//  $db_user        = 'root';
//  $db_pass        = 'password';
//  $db_database    = 'MAS'; 
 

// $con = mysqli_connect($db_host,$db_user,$db_pass,$db_database);


if(!$con)
{
    echo die('Error:'.mysqli_connect_error());
}



?>