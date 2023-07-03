<!DOCTYPE html>
<html>

<head>
    <title>MultiParty Authentication System</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            font-family: sans-serif;
            background-color: #b8d5ff;
            /* Change font style to sans-serif */
        }

        .container {
            width: 600px;
            height: 360px;
            margin: 50px auto;
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            border-width: 2px;
            border-color: #100a89;
        }

        header {
            background-color: #100a89;
            padding: 12px;
            color: white;
            display: flex;
            justify-content: flex-end;
            /* Aligns the buttons to the right */
        }

        nav ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            overflow: hidden;
        }

        nav li {
            float: left;
        }

        nav li a {
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }

        nav li a:hover {
            background-color: #1f84f7;
        }

        /* Added styling for the sub-menu */
        nav ul ul {
            display: none;
            position: absolute;
            background-color: #100a89;
            padding: 0;
            margin-top: 0;
        }

        nav ul li:hover>ul {
            display: inherit;
        }

        nav ul ul li {
            float: none;
            width: 100%;
        }

        nav ul ul a {
            padding: 10px 16px;
        }

        nav ul ul a:hover {
            text-decoration: underline;
            /* Add underline only on hover */
        }

        footer {
            background-color: #100a89;
            padding: 1px;
            /* Decrease the height of the footer */
            color: white;
            text-align: center;
            margin-top: auto;
        }

        footer p {
            font-weight: bold;
        }
    </style>

</head>

<body>
    <header>
        <nav>
            <ul>
                <li><a href="memberpage1.php">Home</a></li>
                <li><a href="#">Request Membership</a>
                    <ul>
                        <li><a href="requestform1.php">Become Manager</a></li>
                        <li><a href="requestform1.php">Become Member</a></li>
                        <li><a href="requestform1.php">Request for Removal</a></li>
                        <li><a href="moveanothergroup1.php">Move another Group</a></li>
                        <li><a href="joinanothergroup1.php">Join another Group</a></li>
                    </ul>
                </li>
                <li><a href="#">Request Access</a>
                    <ul>
                        <li><a href="fileupload1.php">Upload file</a></li>
                        <li><a href="files1.php">Access file</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#">Requests</a>
                    <ul>
                        <li><a href="sentlist1.php">Sent</a></li>
                        <li><a href="receivedlist1.php">Received</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </header>
</body>

</html>