<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>

body{
            margin:0;
            background: rgb(208, 201, 188);
            padding: 0;

        }
        .containers{
            padding:12px;
            background-color: hsl(0, 40%, 90%);
            border: radius 16px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .wel 
        {
            text-align:center;
            text-shadow: 1px 1px 0.1px black;
            font-size:32px;
            margin-top:25px;
        }
        ul 
        {
            padding:14px 20px;
            text-decoration: None;
            list-style: none;
            


        }
      
        ul li a{
            text-decoration: None;
            text-align: center;
            background-color: #4CAF50;
            color:white;
            font-size: 16px;
            padding: 10px 20px;  
            cursor: pointer;
            float:right; 
            border-radius:8px;
            margin-right:25px;
        }
        .data
        {
            min-width:200px; 
            min-height:600px;
            align-items: center;
            text-align: center;
            background-color:rgb(251, 249, 233);
            box-shadow: 2px 2px 4px black;


            
        }
       
        .tb 
        {

            background-color:white;
            box-shadow: 2px 2px 6px black;
          
            margin-top:30px;
           
        }

        .status {
            padding: 3px;
            border-radius: 1rem;
            text-align: center;
        }

        /* .status.accepted {
    background-color: transparent;
    color: #006b21;
    cursor: pointer;
    border: 1px solid #86e49d;
    padding: 8px 16px;
    transition: background-color 0.3s;
}

.status.accepted:hover {
    background-color: #86e49d;
    color: #fff;
} */
.status {
    padding: 8px 16px;
    border: 1px solid #86e49d;
    border-radius: 4px;
    text-align: center;
    transition: background-color 0.3s;
    cursor: pointer;
}

.status.accepted {
    background-color: transparent;
    color: #006b21;
}

.status.rejected {
    background-color: transparent;
    color: #b30021;
}

.status.pending {
    background-color: transparent;
    color: #fff;
}



        table {
        margin: 0 auto;
        border-collapse: collapse;
        background-color: #f9f9f9;
        border: 2px solid #ddd;
        border-radius:18px;
    }
    
    th, td {
        padding: 10px;
        border-bottom: 2px solid #ddd;
    }
    
    th {
    position: sticky;
    background-color: #d5d1defe;
    cursor: pointer;
    text-transform: capitalize;
}
    
    tr:nth-child(even) {
        background-color: #f8f8f8;
    }
    
    tr:hover {
        background-color: #e0e0e0;
    }
    
    .data table td,th {
        border: 3px solid black; /* Set the desired border color */
        padding: 10px;
        text-align: center;
    }
    td,th {
            border-collapse: collapse;
            padding: 1rem;
            text-align: center;
            }
    .pp
    {
        background-color: rgba(207, 15, 15, 0.267);
        padding:20px;
        margin:8px;
        box-shadow: 2px 2px 4px black;
        
    }

               #req {

    
    letter-spacing: 0.2rem;
    font-weight:bold;
    font-weight:bolder;
    font-size:16px;

    }    
    table {
        border-collapse: collapse;
    }
    #tr1 th,
    #tr1 td {
        border: 3px solid black;
        padding: 18px;
        text-align: center;
        font-size:18px;

    }

    </style>

</head>
<body>

    <div class="data">
        <br>
        <div class="pp"><p id="req">Status Table</p></div> 
    
        <table border="5px" cellpadding="15px" align="center" cellspacing="5px" class="tb" style="height:600px; width:780px;  text-align:center; align-items:center;">
            <tr id="tr1"><th>User ID</th><th>Message</th><th>Status</th></tr>    
            
            <?php
include "conn.php";
if (isset($_GET['user_id'])) {
    $id = $_GET['user_id'];

    $sql = 'SELECT * FROM status WHERE user_id ="'.$id.'"';

    $r=mysqli_query($con, $sql);

    if($r) {
        $udata=$r;
    } else {
        echo"<script>alert('Nodata Found');</script>";
    }
}
            foreach ($udata as $i) {
                echo "<tr><td>$i[user_id]</td>";

                echo "<td>$i[suggestion]</td><td class='btn btn-danger>YES NO</td>";

                //  if ($i['status'] == 'a') {
                //      echo "<td class='status accepted'><a href='upload.php' class='btn btn-success' id='A'>Accepted</a></td>";
                //  } elseif ($i['status'] == 'r') {
                //      echo "<td class='status rejected'><a href='#' class='btn btn-danger' id='R'>$i[status]</a></td>";
                //  } elseif ($i['status'] == 'Pending') {
                //      echo "<td class='status pending'><a href='#' class='btn btn-warning' id='P'>$i[status]</a></td>";
                //  } else {
                //      echo "<td>$i[status]</td>";
                //  }

                echo "</tr>";
            }
            
            ?>
      
        </table>
    </div>
</body>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</html>