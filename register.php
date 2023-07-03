<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Registeration Window</title>
        <link rel="stylesheet" href="./css/register.css">
        <link rel="stylesheet"href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>

    <body>

        <?php
        
        
        $a = [
            "What is your favorite color?",
            "What was the name of your first school?",
            "What is your favorite food?",
            "What is your father's middle name?",
            "What is your favorite music band/artist?",
            "What is your favorite fictional character?",
            "What is your favorite hobby?",
            "What is the name of your childhood best friend?",
            "What is your favorite season of the year?",
            "What is your favorite TV show?",
            "What was the make and model of your first car?"
        ];

        $randomNumbers = array();
        while (count($randomNumbers) < 3) {
            $randomNumber = mt_rand(0, 10);
            if (!in_array($randomNumber, $randomNumbers)) {
                $randomNumbers[] = $randomNumber;
            }
        }
        $question1 = $a[$randomNumbers[0]];
        $question2 = $a[$randomNumbers[1]];
        $question3 = $a[$randomNumbers[2]];
        ?>


        <div class="container">
            <h1>Registration Form</h1>
            <div class="form-container">
                <form action="" method="post" id="myForm" onsubmit="return form_validation()" enctype="multipart/form-data">



                    <div class="input-name">
                        <i class="fa fa-user lock"></i>
                        <input type="text" placeholder="First Name" class="name" name="fname" id="fname" required>
                        <span>
                            <i class="fa fa-user lock"></i>
                            <input type="text" placeholder="Mid Name(Optional)" class="name" name="midname">
                        </span>
                        <span>
                            <i class="fa fa-user lock"></i>
                            <input type="text" placeholder="Last Name(Optional)" class="name" name="lname">
                        </span>
                        <p id="para_fname"></p>
                    </div>


                    <div class="input-name">
                        <i class="fa fa-user lock"></i>
                        <input type="date" placeholder="DOB" class="text-name" name="dob" id="dob" title="Date Of Birth"
                            required>
                    </div>


                    <div class="input-name">
                        <i class="fa fa-envelope lock"></i>
                        <input type="text" placeholder="E-mail" class="text-name" name="email" id="email"
                            title="E-mail must be in the form name@domainname" required>
                        <p id="para_email"></p>
                    </div>

                    <div class="input-name">
                        <i class="fa fa-envelope lock"></i>
                        <input type="text" placeholder="Alternate E-mail(Optional)" class="text-name" name="emailalt"
                            id="emailalt" title="E-mail must be in the form name@domainname">
                        <p id="para_emailalt"></p>
                    </div>





                    <div class="input-name">
                        <i class="fa fa-address-book lock"></i>
                        <input type="tel" placeholder="Contact" class="text-name" name="contact" id="contact" required
                            title="Contains only digits from 0 to 9 and has a length of exactly 10 digits and can not start with 0">
                        <p id="para_contact"></p>
                    </div>






                    <div class="input-name">
                        <i class="fa fa-user lock"></i>
                        <i class="fa fa-eye" id="togglepassworduserid" style="position:absolute; margin-left:550px; font-size:20px; margin-top:5px;"></i>
                        <input type="password" placeholder="User ID" class="text-name" name="userid" id="userid" required
                            title="Has a minimum length of 8 characters & Can only contain alphabets, numbers, underscores & must conatain an alphabet , number, underscores. Also it must start with an alphabet">
                        <p id="para_userid"></p>
                    </div>





                    <div class="input-name">
                        <i class="fa fa-user lock"></i>
                        <input type="text" id="question1" class="text-name" name="question1"
                            value="<?php echo $question1; ?>" readonly>
                        <input type="text" name="answer1" class="text-name" placeholder="Answer 1" required>

                        <br>
                        <i class="fa fa-user lock"></i>
                        <input type="text" id="question2" class="text-name" name="question2"
                            value="<?php echo $question2; ?>" readonly>
                        <input type="text" name="answer2" class="text-name" placeholder="Answer 2" required>

                        <br>
                        <i class="fa fa-user lock"></i>
                        <input type="text" id="question3" class="text-name" name="question3"
                            value="<?php echo $question3; ?>" readonly>
                        <input type="text" name="answer3" class="text-name" placeholder="Answer 3" required>
                    </div>





                    <div class="input-name">
                        <i class="fa fa-lock lock "></i>
                        <i class="fa fa-eye" id="togglepasswordpassword" style="position:absolute; margin-left:550px; font-size:20px; margin-top:5px;"></i>
                        <input type="password" placeholder="Password" class="text-name" id="password" name="password"
                            required
                            title="Password must contain at least one uppercase letter, one lowercase letter, one numeric digit, one special character, and be at least 8 characters long.">
                        <span>
                       
                        </span>
                        <p id="para_password"></p>
                    </div>




                    <div class="input-name">
                        <i class="fa fa-lock lock"></i>
                        <i class="fa fa-eye" id="togglepasswordcpassword" style="position:absolute; margin-left:550px; font-size:20px; margin-top:5px;"></i>
                        <input type="password" placeholder="Confirm Password" class="text-name" name="cpassword"
                            id="cpassword" required
                            title="Password must contain at least one uppercase letter, one lowercase letter, one numeric digit, one special character, and be at least 8 characters long.">
                        <p id="para_cpassword"></p>
                    </div>



                    <div class="input-name">
                      <label for="file">Upload Your Image</label>
                      <input type="file" name="photo" id="file" required> 
                      <p> FILE MUST BE IN jpeg , jpg or png FORMAT </p>
                      <p id="para_photo"></p> 
                    </div>


                    <div class="input-name">
                        <button type="submit" name="submit" class="last_btn">SUBMIT</button>
                    </div>
                    <p id="last_para"></p>
                    
                    
                </form>
            </div>
        </div>

        <script src="./js/register.js"></script>
    </body>

</html>

<?php

include 'conn.php';

if (isset($_POST['submit'])) 
{

    // $random_number = rand(999,9999);
    $fname = $_POST['fname'];
    $midname = $_POST['midname'];
    $lname = $_POST['lname'];
    $dob = $_POST['dob'];
    $email = $_POST['email'];
    $emailalt = $_POST['emailalt'];
    $contact = $_POST['contact'];

    $userid = $_POST['userid'];
    
    $question1 = $_POST['question1'];
    $question2 = $_POST['question2'];
    $question3 = $_POST['question3'];
    $answer1 = $_POST['answer1'];
    $answer2 = $_POST['answer2'];
    $answer3 = $_POST['answer3'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
     $query1 = "select * from server_parameters ";
    $res1 = mysqli_query($con,$query1);
    $server_parameters = mysqli_fetch_assoc($res1);
    $q = $server_parameters['q'];
    $p = $server_parameters['p'];
    $secret=hash('sha512',$userid.$password);
    function secret($hashpassword,$q,$p)
    {
        $binary=hex2bin($hashpassword);
        //but here binary is large so..use GMP module
        $u=gmp_strval(gmp_import($binary));
        $secret=gmp_strval(gmp_powm($q, $u, $p));
        return $secret;
    }
    $secret=secret($secret,$q,$p);

    $date_of_reg = date("d m Y");


    $photo = $_FILES['photo'];
    $filename = $photo['name'];
    $fileext = explode('.',$filename);
    $filecheck = strtolower(end($fileext));
    $fileextstored = array('jpeg','jpg','png');
    if(in_array($filecheck,$fileextstored))
    {


            $destination = 'images/' . $filename;
            move_uploaded_file($photo['tmp_name'], $destination);


            $query_start_admin = "select * from admin";
            $result_start_admin = mysqli_query($con,$query_start_admin);
            $row_start_admin = mysqli_fetch_assoc($result_start_admin);
            
            $query_start_user = "select * from user";
            $result_start_user = mysqli_query($con,$query_start_user);
            $row_start_user = mysqli_fetch_assoc($result_start_user);

            if(count((array)$row_start_user) == 0 && count((array)$row_start_admin) == 0)
            {

             
                 
                    $insertquery = "INSERT INTO admin (first_name, middle_name, last_name, dob, email, email_alt, contact, user_id, question_1, answer_1, question_2, answer_2, question_3, answer_3, secret, photo_location, doj) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                    
                    $stmt = mysqli_prepare($con, $insertquery);
                    mysqli_stmt_bind_param($stmt, 'sssssssssssssssss', $fname, $midname, $lname, $dob, $email, $emailalt, $contact, $userid, $question1, $answer1, $question2, $answer2, $question3, $answer3, $secret, $destination, $date_of_reg);
                    
                    $res = mysqli_stmt_execute($stmt);
                    
                    
                    if ($res) 
                    {
                        ?>
                        <script>
                            alert("connection done");
                            </script>
                        <?php
                    }
                    else 
                    {
                        ?>
                        <script>
                            alert("connection not done");
                            </script>
                        <?php
                    }
                    ?>
                    <script>
                        // Redirect to another PHP page
                        window.location.href = "index.php";
                        
                        </script>
                    <?php
                    

                 
            }

            else

            {

                
                
                
                    $sql2 = "select * from user where user_id='$userid'";
                    $dd = mysqli_query($con, $sql2);
                    $run = mysqli_fetch_array($dd);


                    $sqladmin = "select * from admin where user_id='$userid'";
                    $dadmin = mysqli_query($con, $sqladmin);
                    $runadmin = mysqli_fetch_array($dadmin);

                    
                    if (count((array)$run) > 0  || count((array)$runadmin) > 0) 
                    {
                        ?>
                        <script>
                            alert("Try Different UserID");
                            </script>
                        <?php
                    } 
                    else 
                    {
                    $insertquery = "INSERT INTO user (first_name, middle_name, last_name, dob, email, email_alt, contact, user_id, question_1, answer_1, question_2, answer_2, question_3, answer_3, secret, photo_location, doj) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                    
                    $stmt = mysqli_prepare($con, $insertquery);
                    mysqli_stmt_bind_param($stmt, 'sssssssssssssssss', $fname, $midname, $lname, $dob, $email, $emailalt, $contact, $userid, $question1, $answer1, $question2, $answer2, $question3, $answer3, $secret, $destination, $date_of_reg);
                    
                    $res = mysqli_stmt_execute($stmt);
                    
                    
                    if ($res) {
                        ?>
                        <script>
                            alert("connection done");
                            </script>
                        <?php
                    }
                    else {
                        ?>
                        <script>
                            alert("connection not done");
                            </script>
                        <?php
                    }
                    ?>
                    <script>
                        // Redirect to another PHP page
                        window.location.href = "index.php";
                        
                        </script>
                    <?php
                    }
                    
            
            }
            
    }
        
    else
    {
        ?>
    <script>alert("Your photo must be in jpeg , jpg or png format ! ")</script>
    <?php
    }

}
?>