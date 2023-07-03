<?php
include 'pageformat.php';
// session_start();
$mid=$_SESSION['mid'];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ftpHost = "127.0.0.1";
    $ftpUsername = "mohan";
    $ftpPassword = "Mohan@2001";
    $ftpDirectory = "uploads/";

    // // Connect to FTP server
    // $ftpConn = ftp_connect($ftpHost);
    // ftp_login($ftpConn, $ftpUsername, $ftpPassword);
    // ftp_pasv($ftpConn, true);
    // ftp_chdir($ftpConn, $ftpDirectory);
    // Connect to FTP server
    $ftpConn = ftp_connect($ftpHost);
    if (!$ftpConn) {
        echo "Failed to connect to FTP server.";
        exit;
    }

    // Login to FTP server
    $ftpLogin = ftp_login($ftpConn, $ftpUsername, $ftpPassword);
    if (!$ftpLogin) {
        echo "Failed to login to FTP server.";
        exit;
    }

    // Set passive mode (if required) 
    ftp_pasv($ftpConn, true);

    //Allow change directory permissions
    //   if(!ftp_chmod($ftpConn, 0777, $ftpDirectory)) {
    //       echo "Failed to set change directory permissions.";
    //       exit;
    //   }

    // Check if the FTP directory exists, create it if not
    if (!ftp_chdir($ftpConn, $ftpDirectory)) {
        // Directory doesn't exist, create it
        if (ftp_mkdir($ftpConn, $ftpDirectory)) {
            ftp_chdir($ftpConn, $ftpDirectory);
        } else {
            echo "Failed to create directory on the FTP server.";
            exit;
        }
    }



    // Get the uploaded file details
    // global $fileName;
    $fileName = null;
if (isset($_FILES["file"]) && isset($_FILES["file"]["name"])) {
    $fileName = basename($_FILES["file"]["name"]);
}
    $fileTemp = $_FILES["file"]["tmp_name"] ?? null;

    // Upload the file to FTP server
    if (ftp_put($ftpConn, $fileName, $fileTemp, FTP_BINARY)) {
        echo "The file " . $fileName . " has been uploaded to the FTP server.";


        // Get the current working directory (remote directory)
        $current_dir = ftp_pwd($ftpConn);
        if ($current_dir === false) {
            echo "Failed to get current directory on the FTP server.";
        } else {
            // Get the file's location
            $file_location = $current_dir . '/' . $fileName;
            echo "<br>";

            //connecting to the database
            include 'conn.php';
            function random_number_generator($fileName)
            {
                $chars = array(".", "(", ")", "{", "}", "?", "<", ">", "@", "#", "$", "&", "%", "!", "-", "_");
                $rands = '';
                for ($i = 0; $i < 3; $i++) {
                    do {
                        $index = rand(0, strlen($fileName) - 1);
                        $char = $fileName[$index];
                    } while (in_array($char, $chars));

                    $rands .= $char;
                }
                $rands .= rand(100, 999);
                return $rands;
            }
            $rands = random_number_generator($fileName);

            $sql = "select * from files where file_id='$rands'";
            $result = mysqli_query($con, $sql);
            if ($result) {
                $num = mysqli_num_rows($result);
                if ($num == 1) {
                    $rands = random_number_generator($fileName);
                }
            }
            $query = "insert into files(file_id,file_name,file_location) values('$rands','$fileName','$file_location')";
            $res = mysqli_query($con, $query);
            if ($res) {
                echo "<br>";
                echo "data is successfully inserted into the files table ";
            } else {
                echo "<br>";
                echo "data  not inserted";
            }

            // Output the file location
            //echo 'File location: ' . $file_location;
            // echo "random number :".$rands;
        }
    } else {
        echo "Sorry, there was an error uploading your file to the FTP server.";
    }



    // Close FTP connection
    ftp_close($ftpConn);


}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Uploader</title>
    <style>
        
    h2{
            margin-top:0px;
            text-align: center;
            background-color: rgb(103 98 185/48%);
            padding:4px;
        }

        .files {
            /* margin-top: 36px;
            margin-left: 72px;
            /* margin-bottom: 27px; 
            padding: 5px;
            font-weight: bold; */
            margin-top: 18px;
            margin-left: 59px;
            margin-bottom: 27px;
            padding: 5px;
            font-weight: bold;
            /* Styling for "Choose File" button */
            background-color: lightgray;
            color: black;
            border: 2px;
            border-radius: 3px;
            padding: 6px 12px;
            cursor: pointer;
        }

        .caution {
            margin-top: 0px;
            color: red;
        }

        h5 {
            margin-top: 0px;
        }


        .uploads {
            padding: 10px 20px;
            background-color: #100a89;
            color: #fff;
            border: none;
            border-radius: 5px;
            margin-top: 45px;
            margin-left: 260px;
            cursor: pointer;
        }
    </style>
    <script>
        function validateFile() {
            var fileInput = document.getElementById('fileInput');
            var file = fileInput.files[0];
            var allowedExtensions = ['pdf', 'doc', 'png'];
            var fileSizeLimit = 5 * 1024 * 1024; // 5MB

            if (!file) {
                alert("Please select a file to upload.");
                return false;
            }

            var fileName = file.name;
            var fileExtension = fileName.split('.').pop().toLowerCase();

            if (!allowedExtensions.includes(fileExtension)) {
                alert("Error: The selected file format is not supported. Please select a valid file format.");
                return false;
            }

            if (file.size > fileSizeLimit) {
                alert("Error: File size is larger than the allowed limit(5 MB).");
                return false;
            }

            return true;
        }
    </script>
</head>

<body>
    <div class="container">
        <h2>File Uploader</h2>
        <form action="fileupload.php" method="post" enctype="multipart/form-data" onsubmit="return validateFile();">
            <input type="file" name="file" id="fileInput" class="files" />
            <h5><strong class="caution">*Caution: </strong> Only .pdf, .png, and .doc files are supported, and their size is limited to 5MB</h5>

            <div class="button-container">
                <input type="submit" value="Upload" class="uploads" />
            </div>
        </form>
    </div>
        <footer>
        <p>MULTIPARTY AUTHENTICATION SYSTEM</p>
    </footer>
</body>

</html>
