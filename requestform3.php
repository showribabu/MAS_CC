<?php
include 'conn.php';
include 'pageformat.php';
//session_start();
$mid = $_SESSION['mid'];

// Fetch members with privilege 'GM' for dropdown1
$query = "SELECT group_number FROM group_data WHERE user_id = '$mid' AND privilege='member'";
$result = mysqli_query($con, $query);
$memberOptions = '';

// Build dropdown menu options for members
while ($row = mysqli_fetch_assoc($result)) {
    $group_number = $row['group_number'];
    $memberOptions .= "<option value='$group_number'>$group_number</option>";
}

// Fetch group types for the selected member (if any) for dropdown2
$groupNumber = isset($_POST['dropdown']) ? $_POST['dropdown'] : '';

if (!empty($groupNumber)) {
    // Query to retrieve group types for the selected member
    $qu2 = "SELECT user_id, group_type FROM group_data WHERE group_number= '$groupNumber' AND privilege='GM'";
    $groupResult = mysqli_query($con, $qu2);
    $row = mysqli_fetch_assoc($groupResult);
    $request_to = $row['user_id']; // Remove the dollar sign ($) from 'user_id'
    $group_type = $row['group_type'];
}

if (isset($_POST['submit'])) {
    function generateRequestID()
    {
        $char = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $ucase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $lcase = 'abcdefghijklmnopqrstuvwxyz';
        $rands = '';
        $index = rand(0, strlen($char) - 1);
        $rands .= $char[$index];
        $index = rand(0, strlen($ucase) - 1);
        $rands .= $ucase[$index];
        $rands .= rand(100, 999);
        $index = rand(0, strlen($lcase) - 1);
        $rands .= $lcase[$index];

        return $rands;
    }

    $request_id = generateRequestID();
    $message = $_POST['message'];
    $request_to = $row['user_id']; // Remove the dollar sign ($) from 'user_id'
    $request_from = $mid;
    $group_type = $row['group_type'];
    $group_number = $groupNumber;

    $query = "INSERT INTO requests (request_from, request_to, request_id, message, r_status, group_type, group_number) VALUES ('$request_from', '$request_to', '$request_id', '$message', 'rm', '$group_type', '$group_number')";
    $res = mysqli_query($con, $query);
    if ($res) {
        echo "<script>alert('Your request has been sent successfully');</script>";
    } else {
        echo "Problem occurred!";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MAS</title>
    <style>
        .container div {
            flex-direction: column;
            margin-top: 10px;
        }

        h2 {
            margin-top: 0px;
            text-align: center;
            background-color: rgb(103 98 185/48%);
            padding: 4px;
        }

        .details {
            color: black;
            margin-left: 1px;
            cursor: pointer;
        }

        .textbox {
            width: 100%;
            height: 80px;
            margin-top: 5px;
            margin-bottom: 10px;
        }

        .submit-btn {
            padding: 10px 20px;
            background-color: #100a89;
            color: #fff;
            border: none;
            border-radius: 5px;
            margin-top: 30px;
            margin-left: 360px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="container" >
        <h2>Request for Removal</h2>
        <form method="post" enctype="multipart/form-data" onsubmit="return checkSpecialCharacters()">
            <div>
                <label for="dropdown">Group Number:</label>
                <select id="dropdown" name="dropdown">
                    <?php echo $memberOptions; ?>
                </select>
            </div>
            <div>
                <label class="details">Message:</label>
                <textarea class="textbox" name="message" cols="51" rows="5" required
                    placeholder="Enter up to 100 characters without special characters.."
                    oninput="checkSpecialCharacters()" maxlength="200" minlength="5"></textarea>
            </div>
            <input class="submit-btn" type="submit" name="submit" value="Submit">
            <p id="messageWarning" style="color: red; text-align: center; display: none;">Please enter up to 100 characters and  without special characters.</p>

        </form>
    </div>
    <script>
        function checkSpecialCharacters() {
            var messageInput = document.getElementsByName("message")[0];
            var message = messageInput.value;
            var specialCharacters = /[^A-Za-z0-9,. ]/;
            if (specialCharacters.test(message)) {
                document.getElementById("messageWarning").style.display = "block";
                return false;
            } else {
                document.getElementById("messageWarning").style.display = "none";
                return true;
            }
        }
    </script>
    <footer>
        <p>MULTIPARTY AUTHENTICATION SYSTEM</p>
    </footer>
</body>

</html>