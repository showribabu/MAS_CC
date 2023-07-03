<?php
include 'pageformat.php';
// session_start();
$mid=$_SESSION['mid'];
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
        text-align: center;
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
        color: #100a89;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }
    </style>
</head>
<body>
    <div class="container">
        <table>
            <tr>
                <th>File ID</th>
                <th>File Name</th>
                <th>Access Mode</th>
            </tr>
            <?php
            include 'conn.php';
            $query = "SELECT file_id, user_filename FROM files";
            $res = mysqli_query($con, $query);
            while ($row = mysqli_fetch_assoc($res)) {
                ?>
                <tr>
                    <td><?php echo $row['file_id']; ?></td>
                    <td><?php echo $row['user_filename']; ?></td>
                    <td><input type="submit" value="Read" name="rmode"  class="rm" />
                    <input type="submit" value="Write" name="wmode"  class="wm" /></td>
                </tr>
            <?php } ?>
        </table>
    </div>
    <footer>
        <p>MULTIPARTY AUTHENTICATION SYSTEM</p>
    </footer>
</body>
</html>
