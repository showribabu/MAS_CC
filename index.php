<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>LOG IN</title>
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  </head>
  <script crossorigin="anonymous"></script>
  </head>

  <body>

    <?php
  
  ?>

    <div class="container">
      <div class="form_box">
        <h1 id="title">LOG IN</h1>
        <form action="" method="post">
          <div class="input_group">

            <div class="input_field">
              <i class="fa fa-user lock"></i>
              <input type="password" placeholder="User ID" name="userid" required id="userid">
              <i class="fa fa-eye" id="togglepassworduserid" style="position:absolute; right:60px"></i>
            </div>

            <div class="input_field">
              <i class="fa fa-lock lock"></i>
              <input type="password" placeholder="Password" name="password" required id="password">
              <i class="fa fa-eye" id="togglepasswordpassword" style="position:absolute; right:60px"></i>
            </div>

             <div class="input_field " id="link1">
            Forgot Password?
            <a href="forgot.php">Click Here!</a>
          </div>

          <div class="btn_field" style="position:relative; top:20px;">
            <button type="button" id="signup" name="signup">Sign up</button>
            <button type="submit" id="next" name="next">NEXT</button>
            <!-- <button type="submit" id="login" name="login">LOG IN</button> -->
          </div>

        </form>
        <form action="" method="post" hidden>
          <input type="text" name = "carryuserid" value=<?php ?>>
        </form>
        </div>
        </div>

     <script>let btn = document.getElementById("signup");
      btn.addEventListener('click', function () {
        window.open("register.php");
      })
      
      var userid = document.getElementById('userid');
      var togglepassworduserid = document.getElementById('togglepassworduserid');
      
      togglepassworduserid.addEventListener('click', function() {
        if (userid.type === 'password') {
          userid.type = 'text';
          togglepassworduserid.classList.remove('fa-eye');
          togglepassworduserid.classList.add('fa-eye-slash');
        } else {
          userid.type = 'password';
          togglepassworduserid.classList.remove('fa-eye-slash');
          togglepassworduserid.classList.add('fa-eye');
        }
      });
      var password = document.getElementById('password');
      var togglepasswordpassword = document.getElementById('togglepasswordpassword');
      
      togglepasswordpassword.addEventListener('click', function() {
        if (password.type === 'password') {
          password.type = 'text';
          togglepasswordpassword.classList.remove('fa-eye');
          togglepasswordpassword.classList.add('fa-eye-slash');
        } else {
          password.type = 'password';
          togglepasswordpassword.classList.remove('fa-eye-slash');
          togglepasswordpassword.classList.add('fa-eye');
        }
      });
      
      </script>
      
      <?php
      session_start();
      include 'conn.php';
          if(isset($_POST['next']))
          {
            $userid = $_POST['userid'];
            
            $secret = $_POST['password'];
              $query1 = "select * from server_parameters ";
    $res1 = mysqli_query($con,$query1);
    $server_parameters = mysqli_fetch_assoc($res1);
    $q = $server_parameters['q'];
    $p = $server_parameters['p'];
    
    $secret=hash('sha512',$userid.$secret);
    function secret($hashpassword,$q,$p)
    {
        $binary=hex2bin($hashpassword);
        //but here binary is large so..use GMP module
        $u=gmp_strval(gmp_import($binary));
        $secret=gmp_strval(gmp_powm($q, $u, $p));
        return $secret;
    }
    $secret=secret($secret,$q,$p);
            
            $query2 = "select * from user where user_id='$userid'" ;
            $result = mysqli_query($con,$query2);
            $row = mysqli_fetch_assoc($result);

            $query3 = "select * from admin where user_id='$userid'" ;
            $result3 = mysqli_query($con,$query3);
            $row3 = mysqli_fetch_assoc($result3);

            

            if(mysqli_num_rows($result3)>0)
            {
               if($row3['activity_status']=='active')
              {
                if($secret === $row3['secret'])
                {
                  $_SESSION['user_id']= $userid;
                  header('Location: index2.php');
                  exit;
                  // ?>
                  // <script>
                  // window.location.href = "index2.php";
                  // </script>
                  // <?php
                }
              else
              {
                  ?>
                  <script>alert("Password do not match !")</script>
                  <?php
              }
             }
             else
             {
               ?>
                  <script>alert("Your activity status is set to inactive!")</script>
                  <?php
             }

            }
            elseif(mysqli_num_rows($result)>0)
            { 
              if($row['activity_status']=='active')
              {
                if($secret === $row['secret'])
                {
                  $_SESSION['user_id']= $userid;
                  header('Location: index2.php');
                  exit;
                  // ?>
                  // <script>
                  // window.location.href = "index2.php";
                  // </script>
                  // <?php
                }
              else
              {
                  ?>
                  <script>alert("Password do not match !")</script>
                  <?php
              }
             }
             else
             {
               ?>
                  <script>alert("Your activity status is set to inactive!")</script>
                  <?php
             }

            }
            else
              {
                  ?>
                  <script>alert("UserID do not match !")</script>
                  <?php
              }
          }
      ?>