<?php
// error_reporting(0);
function generateRandomPrime($minBits)
{
    do {
        // Generate a random number with the desired bit size
        $number = gmp_random_bits($minBits);

        // Set the most significant bit to ensure the minimum bit size
        gmp_setbit($number, $minBits - 1);

        // Test if the number is prime using Miller-Rabin primality test
        $isPrime = gmp_prob_prime($number, 50) > 0;
    } while (!$isPrime);

    return $number;
}

// system parameters
$p = generateRandomPrime(166);
$q = generateRandomPrime(33);
$s = generateRandomPrime(33);
$spk = generateRandomPrime(166);
$gpk = generateRandomPrime(166);
$kv = generateRandomPrime(64);
$ix = generateRandomPrime(33);
$r = generateRandomPrime(64);


echo "server parameter values has been added to server_param database";


// echo gettype($q); -> to get data type
//  return type of generateRandomPrime() is gmp 
// till now we don't have central server so what we  have done we have auto generated
// hashed secret value for both admin and users
// $xtemp  = gmp_strval(generateRandomPrime(33));

// $x = hash('sha512', $xtemp);
// $x_hexVal = hexdec($x);

// hash takes string type, so we are converting gmp type to hashvalue
// $utemp = gmp_strval(generateRandomPrime(33));
// $u = hash('sha512', $utemp);
// since we have to find a ^ b so we are converting  back to decimal value
// $u_hexVal = hexdec($u);

include("../connection.php");

$sql = "INSERT INTO server_parameters (p,q,s,gpk,kv,r,spk,ix) VALUES ('$p', '$q','$s','$gpk','$kv','$r','$spk','$ix')";
$result = mysqli_query($con, $sql) or die("Query Unsuccessful");
// inserting into group data repository
// $sq2 = "INSERT INTO groupdata (user_id) VALUES ('$u_hexVal')";
// $resul2 = mysqli_query($con, $sq2) or die("Query Unsuccessful");


mysqli_close($con);

// echo pow($q, $p);



// echo "q(33bit):- " . $q;
// echo "<br>";
// echo "p(33bit):- " . $q;


// echo "<br><br>";
// print($q);
// // $u = bindec($h1);

// $u = gmp_import($h1);
// echo $u;
// $u = gmp_strval($u);
// echo "<br>Decimal u:<br>" . $u;
// $secret = gmp_powm($q, $u, $p);