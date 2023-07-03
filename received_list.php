<?php
include 'userpageformat.php';
//session_start();
$mid = $_SESSION['mid'];


if (isset($_POST['act']) || isset($_POST['rjt'])) {
    include 'conn.php';
    $status = '';

    if (isset($_POST['act'])) {
        $status = 'a';
    } elseif (isset($_POST['rjt'])) {
        $status = 'r';
    }

    $query = "UPDATE requests SET r_status = '$status' WHERE request_to = '$mid'";
    mysqli_query($con, $query);
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
    h2{
        margin-top: 0px;
        text-align: center;
        background-color: rgb(103 98 185/48%);
        padding: 4px;
    }
    table {
        width: 100%;
        border-collapse: collapse;
    }
    th, td {
        padding: 8px;
        text-align: center;
        border: 2px solid rgb(22 44 98);
        background-color: rgb(227 227 227); 
    }
    th {
        background-color:#bebbf0fe;
        color: black;
    }
    .at {
        padding: 10px 20px;
        background-color: #006b21;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-weight: bold;

    }
    .rt {
        padding: 10px 20px;
        background-color: #9e1825;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-weight: bold;
    }
    .table-container {
        overflow-y: scroll;
        max-height: 325px;
    }
    </style>
</head>
<body>
    <div class="container">
        <h2>Received List</h2>
        <div class="table-container">
            <form method="post" action="">
                <table>
                    <tr>
                        <th>Request From</th>
                        <th>Message</th>
                        <th>Status</th>
                    </tr>
                    <?php
                    include 'conn.php';
                    $request_to=$mid;
                    $query = "SELECT group_number, message, r_status FROM requests where request_to='$request_to'";
                    $res = mysqli_query($con, $query);
                    while ($row = mysqli_fetch_assoc($res)) {
                        ?>
                        <tr>
                            <td><?php echo $row['group_number']; ?></td>
                            <td><?php echo $row['message']; ?></td>
                            <td>
                                <button type="submit" name="act" value="<?php echo $row['group_number']; ?>" class="at">Accept</button>
                                <button type="submit" name="rjt" value="<?php echo $row['group_number']; ?>" class="rt">Reject</button>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </form>
        </div>
    </div>
    <footer>
        <p>MULTIPARTY AUTHENTICATION SYSTEM</p>
    </footer>
</body>
</html>