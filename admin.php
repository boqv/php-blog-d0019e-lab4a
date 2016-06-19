<!-- This is the admin page -->
<?php
    session_start();

    //redirect if user is not admin
    if(!isset($_SESSION["user"]["name"]) || $_SESSION["user"]["name"] != 'admin'){
        header('Location: http://utbweb.its.ltu.se/~johboq-7/Lab4a/index.php');
        die();
    }

    require_once('db.php');

    if(isset($_GET["removeUser"])){
       dbRemoveUser($_GET["id"]);   
    }
    if(isset($_GET["removeEntry"])){  
        dbRemoveEntry($_GET["id"], $_GET["date"]);
    }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" type="text/css" href="css/style.css"/>
    <title>Untitled Document</title>
</head>
<body>
    
    <div class="row">
        <div class="col-3"></div>
        <div class="col-6" style="text-align:center; border: 1px solid black">
            <h2>Admin area</h2>
            <a href="index.php">Back to site</a>
        </div>
        <div class="col-3"></div>
    </div>
    
    <!-- LEFT menu -->
    <div class="row" style="border: 1px solid black">
        <div class="col-3" style="text-align:center">
            <h2>Users</h2>

            <?php

                //get and display users
                $query = "SELECT * FROM user";
                $result = dbSelect($query);

                foreach($result as $r){

                    if($r["username"] == 'admin') continue;

                    echo '<a href="admin.php?user=' . $r["username"] . '">' . $r["username"] . '</a><br/>';
                }
            ?>
        </div>

        <!-- Center area, showing a selected user -->
        <div class="col-6" style="text-align:center">
        <?php
                /*show user posts */
                if(isset($_GET["user"])){
                    $query = "SELECT id FROM user WHERE username='" . $_GET["user"] . "'";
                    $id = dbSelect($query);

                    echo '<h2>User: ' . $_GET["user"] . '</h2>';
                    echo '<a href="admin.php?id=' . $id[0]['id'] . '&amp;removeUser=yes">Delete user </a>';

                    $query = "SELECT * FROM entry WHERE id='" . $id[0]['id'] . "'";
                    $result = dbSelect($query);

                    echo '<h3> Posts: </h3>';
                    foreach($result as $r){
                        echo '<a href="index.php?page=user&amp;user=' . $_GET["user"] . '&amp;date=' . $r["date"] .'"> - ' . $r["date"] . ' - ' . $r["title"] . '    |   </a>';

                        echo '<a href="admin.php?user=' . $_GET["user"] . '&amp;id=' . $id[0]['id'] . '&amp;date=' . $r["date"] . '&amp;removeEntry=yes"> removeEntry</a><br/>';
                    }

                }

            ?>
        </div>
        
        <!-- Site stats -->
        <div class="col-3" style="text-align:center">
            <h3>Site stats:</h3>

            <?php
                //get and display numbers of users
                $query = "SELECT * FROM user";
                $result = dbSelect($query);
                $users = count($result) -1;
                echo '<p>'. $users . ' users </p>';

                //get and display number of posts
                $query = "SELECT * FROM entry";
                $result = dbSelect($query);
                $entries = count($result);
                echo '<p>'. $entries . ' total posts </p>';

                //get and display number of images
                $query = "SELECT image FROM entry";
                $result = dbSelect($query);
                $imgs = 0;
                foreach($result as $r){
                    if(!empty($r["image"])){
                        $imgs++;
                    }
                }
                echo '<p>'. $imgs . ' uploaded images </p>';

            ?>
        </div>
    </div>

</body>
</html>