<!-- This file generates a user entry in the content space -->
<?php
    /* if the userpage is the same as the logged in user, add option to add new entry */
    if(isset($_SESSION["user"]) && $user == $_SESSION["user"]["name"]){
        include 'userNewEntry.php';
    }

    echo "<h2>" . $user . "'s" . " BLOGGGG </h2><hr/>";

    /*get user id of current page user */

    $userQuery = "SELECT * FROM user WHERE username = '" . $user . "'";
    $result = dbSelect($userQuery);

    $id = $result[0]["id"];


    //either a date is set or show the latest entry (this also applies to updates)
    if(isset($_GET['date']) && !isset($_POST["new"]) && !isset($_GET["delete"])){
        $d = $_GET['date'];
    } else {
        date_default_timezone_set('Europe/Stockholm');
        $d = date('Y-m-d H:i:s');
    }

    //get the entry
    $entryQuery = "SELECT * FROM entry WHERE id = '" . $id . "' AND date <= '" . $d . "' ORDER BY date DESC LIMIT 1";    
    $result = dbSelect($entryQuery);

    //if there is no entries yet
    if(count($result) == 0) {
        echo "User hasn't posted anything yet!";
        return;
    }

    $date = $result[0]["date"];
    $title = $result[0]["title"];
    $content = $result[0]["content"];
    $image = $result[0]["image"];


    /* create the content page */
    echo '<h3> - ' . $date . ' - ' . $title . '</h3>'; 

    //1,024 x 512
    if(!empty($image)){
        echo '<a href="' . "./" . $image . '"> <img src="' . $image . '" width="50%" alt=""></img></a><br/><br/>';
    }

    echo $content;

    /* if user page is the same as logged in user, add option to edit current entry */
    if(isset($_SESSION["user"]) && $user == $_SESSION["user"]["name"]){
        include 'userEditEntry.php';
    }
    echo "<hr/>";

    
    /* Navigation to older or newer posts */

    //closest newer entry
    $newer = "SELECT date FROM entry WHERE id = '" . $id . "' AND date > '" . $date . "' ORDER BY date LIMIT 1";
    $newerResult = dbSelect($newer);

    //closest older entry
    $older = "SELECT date FROM entry WHERE id = '" . $id . "' AND date < '" . $date . "' ORDER BY date DESC LIMIT 1";
    $olderResult = dbSelect($older);


    /*if there exists a newer entry, create a link */
    if(!empty($newerResult)){
        echo '<a href="index.php?page=user&amp;user=' . $user . '&amp;date=' . $newerResult[0]["date"] . '"> << Newer entries </a> | ';
    }

    /*if there exists an older entry, create a link */
    if(!empty($olderResult)){
        echo '<a href="index.php?page=user&amp;user=' . $user . '&amp;date=' . $olderResult[0]["date"] . '"> Older entries >> </a>';
    }
?>