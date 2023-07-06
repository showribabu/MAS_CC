<?php

if(isset($_POST['enter']))
{
    $file_id = $_POST['file_id'];
    $user_id = $_POST['user_id'];
    $group_type = $_POST['group_type'];
    $imgsrc = $_POST['imgsrc'];

    require 'vendor/autoload.php';
    $client = new MongoDB\Client("mongodb://localhost:27017");
    $mas = $client->selectDatabase('mas'); 
    $files = $mas->files;
    $document = $files->findOne([ '_id'=> $file_id ]);
    if($group_type== 'A')
    {
        echo '<script>alert("Data access");</script>';
        echo '<script>window.location.href = "gmsuccess.php";</script>';
    }
    elseif($group_type == 'B')
    {
        if ($imgsrc == 'green.jpg') 
        {
            foreach ($document as $key => $value) 
            {
                if ($key != '_id' && $key != 'userid_first') 
                {
                    $files->updateOne(['_id' => $file_id],['$set' => [$key => 0]]);
                }
                if ($key == 'userid_first') 
                {
                    $files->updateOne(['_id' => $file_id],['$set' => [$key => 'null']]);
                }
            }
            echo '<script>alert("Data access");</script>';
            echo '<script>window.location.href = "gmsuccess.php";</script>';
        }
        
        elseif($imgsrc == 'white.jpg')
        {
            $files->updateOne( ['_id' => $file_id] , ['$set' => [$user_id => 1]]);
            $files->updateOne( ['_id' => $file_id] , ['$set' => ['userid_first' => $user_id]]);
            echo '<script>alert("Wait for the other members to join ");</script>'; 
            echo '<script>window.location.href = "gmsuccess.php";</script>';
        }
        elseif($imgsrc == 'purple.jpg')
        {
            $files->updateOne( ['_id' => $file_id] , ['$set' => [$user_id => 1]]);
            echo '<script>alert("You have given the permissions");</script>';
            echo '<script>window.location.href = "gmsuccess.php";</script>';
         
        } 
    }
    elseif($group_type=='C')
    {
        if ($imgsrc == 'green.jpg') 
        {
            foreach ($document as $key => $value) 
            {
                if ($key != '_id' && $key != 'userid_first' && $key!= 'k') 
                {
                    $files->updateOne(['_id' => $file_id],['$set' => [$key => 0]]);
                }
                if ($key == 'userid_first') 
                {
                    $files->updateOne(['_id' => $file_id],['$set' => [$key => 'null']]);
                }
            }
            echo '<script>alert("Data access");</script>';
            echo '<script>window.location.href = "gmsuccess.php";</script>';
        }
        elseif($imgsrc == 'white.jpg')
        {
            $files->updateOne( ['_id' => $file_id] , ['$set' => ['userid_first' => $user_id]]);
           $files->updateOne(
                            ['_id' => $file_id, $user_id => ['$exists' => true]],
                            ['$set' => [$user_id => 1]]
                            );
            echo '<script>alert("Wait for all authority members to join ");</script>'; 
            echo '<script>window.location.href = "gmsuccess.php";</script>';

        }
        elseif($imgsrc == 'purple.jpg')
        {
            $files->updateOne( ['_id' => $file_id,$user_id => ['$exists'=>true]] , ['$set' => [$user_id => 1]]);
            echo '<script>alert("You have given the permissions");</script>';
            echo '<script>window.location.href = "gmsuccess.php";</script>';
         
        }
    }
    elseif($group_type=='D')
    {
        if ($imgsrc == 'green.jpg') 
        {
            foreach ($document as $key => $value) 
            {
                if ($key != '_id' && $key != 'userid_first' && $key != 'k') 
                {
                    $files->updateOne(['_id' => $file_id],['$set' => [$key => 0]]);
                }
                if ($key == 'userid_first') 
                {
                    $files->updateOne(['_id' => $file_id],['$set' => [$key => 'null']]);
                }
            }
            echo '<script>alert("Data access");</script>';
            echo '<script>window.location.href = "gmsuccess.php";</script>';
        }
        elseif($imgsrc == 'white.jpg')
        {
            $files->updateOne( ['_id' => $file_id] , ['$set' => [$user_id => 1]]);
            $files->updateOne( ['_id' => $file_id] , ['$set' => ['userid_first' => $user_id]]);
            echo '<script>alert("Wait for the other members to join ");</script>'; 
            echo '<script>window.location.href = "gmsuccess.php";</script>';
        }
        elseif($imgsrc == 'purple.jpg')
        {
            $files->updateOne( ['_id' => $file_id] , ['$set' => [$user_id => 1]]);
            echo '<script>alert("You have given the permissions");</script>';
            echo '<script>window.location.href = "gmsuccess.php";</script>';
         
        }
    }

}

?>