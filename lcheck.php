<?php 
include "conn.php";

if($_SERVER['REQUEST_METHOD']=='POST')
{
   
    $user_id=trim($_POST['userid']);
    $password=trim($_POST['password']);
    $hpassword=hash('sha512',$user_id.$password);
   
}

$sql2='select * from user';

$dd=mysqli_query($con, $sql2);

if($dd) 
{
    $f=0;
    foreach($dd as $i) {

        if($i['user_id']==$user_id and $i['password']==$hpassword) {
            $f=1;
            $qualification=$i['privilege'];
            $status=$i['status'];
            $type=$i['type'];
        }
    }

    if($f==0) {
        echo "<script>alert('User not avilable - Please register!!!');</script>";
        include "register.html";
    } else {
        $pp=0;

        if($status=='suspend') {
            $pp=1;

            echo "<script>alert('Your account is suspended. Please contact the administrator.');</script>";
            include "login.html";
        }

        /*check privilege*/

        if($qualification=='admin') {
            $pp=1;

            echo "<script>alert('Admin page');</script>";


        } elseif($qualification=='gm') {
            $pp=1;

            echo "<script>alert('Group Manager page');</script>";

            include "gmsuccess.php";
        } elseif($qualification=='member') {
            $pp=1;

            echo "<script>alert('Member page');</script>";
            include "member.php";


        } elseif($qualification=='NULL') {
            $pp=1;

            echo "<script>alert('You are a member in system but not in any group');</script>";


        }
    }
}
/*
        if($pp==0)
        {
    ?>

        <!DOCTYPE html>
            <html lang='en'>
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <title>Registration</title>
                <style>
                    body {
                        margin: 0;
                        padding: 20px;
                        font-family: Arial, sans-serif;
                        background-color: rgb(232, 236, 237);
                    }
                    
                    form .form-group {
                        width: 400px;
                        margin: 100px auto;
                        background-color: white;
                        padding: 20px;
                        border-radius: 5px;
                        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
                        border-top: 15px solid darkblue;
                    }
                    
                    #lg {
                        padding: 10px 20px;
                        background-color: darkblue;
                        color: #fff;
                        border: none;
                        border-radius: 5px;
                        margin-top: 20px;
                        margin-left: 185px;
                        cursor: pointer;
                    }
                    
                    #id,
                    #pass {
                        padding: 10px 20px;
                        margin-top: 20px;
                        margin-left: 127px;
                    }
                    
                    select {
                        padding: 10px 20px;
                        margin-top: 10px;
                        margin-bottom: 20px;
                        width: 100%;
                    }
                </style>
            </head>
            <body>
                <!-- Registration form -->
                <marquee behavior='scroll' direction='Left'>W E L C O M E TO  L O G I N</marquee>
                <form method='post' id='form_id' action='/MAS_C/selectionf.php'>
                <div class="form-group">
                        <label for="user_id">USER ID:</label>
                        <input type="text" id="id" name="user_id" required>
                        <label for="password">PASSWORD:</label>
                        <input class="form-control" type="password" id="pass" name="password" minlength="8" maxlength="10" required>
                        <br>
                        <?php
                        if ($qualification == 'gmm') {
                            $arr = ['gm', 'member'];
                            echo '<label for="selectedPrivilege">Select Privilege:</label>';
                            echo '<select name="selectedPrivilege" id="selectedPrivilege">';
                            foreach ($arr as $privilege) {
                                echo '<option value="' . $privilege . '">' . $privilege . '</option>';
                            }
                            echo '</select>';
                        } else if ($qualification == 'gmgm') {
                            $arr = ['gm', 'gm'];
                            echo '<label for="selectedPrivilege">Select Privilege:</label>';
                            echo '<select name="selectedPrivilege" id="selectedPrivilege">';
                            foreach ($arr as $privilege) {
                                echo '<option value="' . $privilege . '">' . $privilege . '</option>';
                            }
                            echo '</select>';
                        } else if ($qualification == 'mm') {
                            $arr = ['member', 'member'];
                            echo '<label for="selectedPrivilege">Select Privilege:</label>';
                            echo '<select name="selectedPrivilege" id="selectedPrivilege">';
                            foreach ($arr as $privilege) {
                                echo '<option value="' . $privilege . '">' . $privilege . '</option>';
                            }
                            echo '</select>';
                        }

                        /* Type */

 /*                       if ($type == 'AB') {
                            $arr = ['A', 'B'];
                            echo '<label for="type">Select Type:</label>';
                            echo '<select name="type" id="type">';
                            foreach ($arr as $type) {
                                echo '<option value="' . $type . '">' . $type . '</option>';
                            }
                            echo '</select>';
                        } else if ($type == 'AC') {
                            $arr = ['A', 'c'];
                            echo '<label for="type">Select Type:</label>';
                            echo '<select name="type" id="type">';
                            foreach ($arr as $type) {
                                echo '<option value="' . $type . '">' . $type . '</option>';
                            }
                            echo '</select>';
                        } else if ($type == 'BC') {
                            $arr = ['B', 'c'];
                            echo '<label for="type">Select Type:</label>';
                            echo '<select name="type" id="type">';
                            foreach ($arr as $type) {
                                echo '<option value="' . $type . '">' . $type . '</option>';
                            }
                            echo '</select>';
                        } else if ($type == 'ABC') {
                            $arr = ['A', 'B', 'c'];
                            echo '<label for="type">Select Type:</label>';
                            echo '<select name="type" id="type">';
                            foreach ($arr as $type) {
                                echo '<option value="' . $type . '">' . $type . '</option>';
                            }
                            echo '</select>';
                        }

                        /* Status other than active/suspend */

   /*                     if ($status == 'as') {
                            $arr = ['active', 'suspend'];
                            echo '<label for="status">Select status:</label>';
                            echo '<select name="status" id="status">';
                            foreach ($arr as $privilege) {
                                echo '<option value="' . $privilege . '">' . $privilege . '</option>';
                            }
                            echo '</select>';
                        } else if ($status == 'ss') {
                            $arr = ['suspend', 'suspend'];
                            echo '<label for="status">Select status:</label>';
                            echo '<select name="status" id="status">';
                            foreach ($arr as $privilege) {
                                echo '<option value="' . $privilege . '">' . $privilege . '</option>';
                            }
                            echo '</select>';
                        }
                        ?>
                        <input type="submit" value="Login" id="lg">
                    </div>
           
        </form>
</body>
</html>
<?php
                }
            }
        }

?>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////?>
<?php 
/*
include "conn.php";

if($_SERVER['REQUEST_METHOD']=='POST')
{
   
    $user_id=trim($_POST['user_id']);
    $password=trim($_POST['password']);
    $hpassword=hash('sha512',$user_id.$password);
   
}

$sql2='select * from user';

$dd=mysqli_query($con, $sql2);
if($dd)
{
    $f=0;
    foreach($dd as $i)
    {

        if($i['user_id']==$user_id and $i['password']==$hpassword)
        {
            $f=1;           
            $qualification=$i['privilege'];
            $status=$i['status'];
            $type=$i['type'];
        }
    }

    if($f==0)
    {
        echo "<script>alert('User not avilable - Please register!!!');</script>";
        include "register.html";
    }
    else
    {
        $pp=0;

        if($status=='suspend')
        {
            echo "<script>alert('Your account is suspended. Please contact the administrator.');</script>";
            $pp=1;
            include "login.html";
        }
        include "selection.php";


    }
        
}



?>
*/


