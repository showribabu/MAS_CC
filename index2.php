<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>LOG IN</title>
    <link rel="stylesheet" href="css/index2.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  </head>
  <script crossorigin="anonymous"></script>
  </head>

  <body>

    <?php
    session_start();

    $user_id = $_SESSION['user_id'];
    
     include 'conn.php';

     $query1 = "select * from user where user_id = '$user_id'" ;
     $result = mysqli_query($con,$query1);
      if(mysqli_num_rows($result)>0)
      {
        $row = mysqli_fetch_array($result);
        $randomNumber = mt_rand(0, 2);
          if ($randomNumber == 0) 
          {
            $showques = $row['question_1'];
            $showans = $row['answer_1'];
          }

          if ($randomNumber == 1) 
          {
            $showques = $row['question_2'];
            $showans = $row['answer_2'];
          }

          if ($randomNumber == 2)
          {
            $showques = $row['question_3'];
            $showans = $row['answer_3'];
          }
      
      }
     $query2 = "select * from admin where user_id = '$user_id'" ;
     $result2 = mysqli_query($con,$query2);
      if(mysqli_num_rows($result2)>0)
      {
        $row2 = mysqli_fetch_array($result2);
        $randomNumber = mt_rand(0, 2);
          if ($randomNumber == 0) 
          {
            $showques = $row2['question_1'];
            $showans = $row2['answer_1'];
          }

          if ($randomNumber == 1) 
          {
            $showques = $row2['question_2'];
            $showans = $row2['answer_2'];
          }

          if ($randomNumber == 2)
          {
            $showques = $row2['question_3'];
            $showans = $row2['answer_3'];
          }
      
      }

      
    ?>

    
    <div class="container">
      <div class="form_box">
        <h1 id="title">LOG IN</h1>
        <form action="" method="post">
          <div class="input_group">


            
              <div class="input_field">
                <i class="fa fa-lock lock"></i>
                <input type="text" id="qt" value="<?php echo $showques?>" readonly>
              </div>

              <input type="text" name="showans" value="<?php echo $showans?>" hidden>

              <div class="input_field">
                <i class="fa fa-lock lock"></i>
                <input type="text" placeholder="Answer" name="userans" id="userans">
              </div>
              
              
              <div class="btn_field" >
                  <button type="submit" id="login" name="login">LOG IN</button>
                </div>
            </div>

        </form>
      </div>
    </div>

    <?php
   
 
      // session_start();
      include 'conn.php';
      $current_time = date('H:i:s'); // Format: 24-hour time with hours, minutes, and seconds
      $current_date = date('Y-m-d'); // Format: Year-month-day
      $concatenate = $current_time."-".$current_date;
      if(mysqli_num_rows($result)>0)
      {
          if(isset($_POST['login']))
          {
          $query3 = "UPDATE user SET login_time = '$concatenate' WHERE user_id = '$user_id'";
          $result3 = mysqli_query($con,$query3);
          
            $typedpassword = $_POST['userans'];
            $showans = $_POST['showans'];
            if($typedpassword==$showans)
            {
            header('Location:group.php');
                  exit;
            }
            else
            {
              ?>
                  <script>alert("Answer don't match!")</script>
                  <!-- <script>window.location.href="index.php";</script> -->
                  <?php
                  header('Location:index.php');
exit;
            }
          }
      }
      elseif(mysqli_num_rows($result2)>0)
      {
         if(isset($_POST['login']))
          {
          $query4 = "UPDATE admin SET login_time = '$concatenate' WHERE user_id = '$user_id'";
          $result4 = mysqli_query($con,$query4);
          
            $typedpassword = $_POST['userans'];
            $showans = $_POST['showans'];
            if($typedpassword==$showans)
            {
             header('Location:admin_home_page.php');
                  exit;
            }
            else
            {
              ?>
                  <script>alert("Answer don't match!")</script>
                  <!-- <script>window.location.href="index.php";</script> -->
                  <?php
                  header('Location:index.php');
                  exit;
            }
          }
      }

          


    ?>