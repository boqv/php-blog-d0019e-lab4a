<?php
    //make sure a user is set
    if(isset($_GET['user'])){
        $user = $_GET['user'];
    } else {
        header('Location: index.php');
    }
    
    //show image portfolio in the content div
    if(isset($_GET["images"])){
        include 'userImages.php';
    } else {        
            include 'userEntry.php';  //show blog entry in the content div
    }
?>

