<?php
include 'userpageformat.php';
//session_start();
$mid = $_SESSION['mid'];

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MAS</title>
    <style>
    
    table {
        width: 100%;
        border-collapse: collapse;
    }
    th, td {
        padding: 8px;
        text-align: left;
        border: 2px solid rgb(22 44 98) ;
        background-color: rgb(227 227 227); 

    }
    th {
        background-color: #bebbf0fe;
        color: black;
    }
    .rm,
    .wm {
        padding: 10px 20px;
        background-color: #100a89;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-weight: bold;

    }
    .table-container {
        overflow-y: scroll;
        max-height: 320px;
    }
    h2{
        margin-top: 0px;
        text-align: center;
        background-color: rgb(103 98 185/48%);
        padding: 4px;
    }

    /* Added CSS for status buttons */
    .status-button {
        padding: 8px;
        border: none;
        border-radius: 4px;
        color: white;
        font-weight: bold;
        text-align: center;
        cursor: pointer;
        width: 100px;
    }

    .status-accepted {
        background-color: #006b21;
    }

    .status-pending {
        background-color: #beac20;
    }

    .status-rejected {
        background-color: #9e1825;
    }
    </style>
</head>
<body>
    <div class="container">
    <h2>Sent List</h2>
        <div class="table-container">
        <table>
            <tr>
                <th>Request To</th>
                <th>Message</th>
                <th>Status</th>
            </tr>
            <?php
            include 'conn.php';
            $request_from=$mid;
            $query = "SELECT group_number, message, r_status FROM requests where request_from='$request_from'";
            $res = mysqli_query($con, $query);
            while ($row = mysqli_fetch_assoc($res)) {
                ?>
                <tr>
                    <td><?php echo $row['group_number']; ?></td>
                    <td><?php echo $row['message']; ?></td>
                    <td>
                        <?php
                        $status = $row['r_status'];
                        if ($status === 'a' || $status === 'ar') {
                            echo '<button class="status-button status-accepted">Accepted</button>';
                        } elseif ($status === 'r' || $status === 'rr') {
                            echo '<button class="status-button status-rejected">Rejected</button>';
                        } elseif ($status === 'p' || $status === 'rm') {
                            echo '<button class="status-button status-pending">Pending</button>';
                        } else {
                            echo $status;
                        }
                        ?>
                    </td>
                </tr>
            <?php } ?>
        </table>
        </div>
    </div>
    <footer>
        <p>MULTIPARTY AUTHENTICATION SYSTEM</p>
    </footer>
</body>
</html>