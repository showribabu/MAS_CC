<?php 
include "./conn.php";

function rprime($blen)
{
    do 
    {
  
       // Generate a random number with the desired bit size
       $rnum = gmp_random_bits($blen);

       // Set the most significant bit to ensure the minimum bit size
       gmp_setbit($rnum, $blen - 1);

       // Test if the number is prime using Miller-Rabin primality test
       $prime = gmp_prob_prime($rnum, 50) > 0;
    }
    while(!$prime);
    $val=strval($rnum);
    return $val;
}

//groupkey and r 
function rnd($len)
{
    // Generate a random number with the desired bit size
    $rnum = gmp_random_bits($len);

    // Set the most significant bit to ensure the minimum bit size
    gmp_setbit($rnum, $len - 1);

    $val=strval($rnum);
    return $val;
}
global $p,$q,$s,$kv,$ix,$spk;
$q=rprime(33);
$p=rprime(166);
$s=rprime(33);
$kv=rprime(64);
$ix=rprime(33);
$spk=rprime(166);

$sql='insert into server_parameters (p,q,s,kv,ix,spk,ac,bc,cc,dc) values("'.$q.'","'.$p.'","'.$s.'","'.$kv.'","'.$ix.'","'.$spk.'","0","0","0","0")';
$r=mysqli_query($con,$sql);
if($r)
{
    $sql2='select * from server_parameters';


    $r2=mysqli_query($con,$sql2);
    if($r2)
    {
        foreach($r2 as $i)
        {
            session_start();
            $_SESSION['p']=$i['p'];
            $_SESSION['q']=$i['q'];
            $_SESSION['kv']=$i['kv'];
            $_SESSION['ix']=$i['ix'];
            $_SESSION['spk']=$i['spk'];
            $_SESSION['s']=$i['s'];
        }
    }


}

?>