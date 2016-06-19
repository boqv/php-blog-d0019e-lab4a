<!-- This is the menu for the current user page. Shows latest entries -->
<?php

    echo "<h2>Latest entries</h2><hr/>"; 

    if(isset($_GET['user'])) {
        $user = $_GET['user'];
    } else {
        $user = $_SESSION['user']['name'];
    }

    /*get user id of current page user */

    $userQuery = "SELECT * FROM user WHERE username = '" . $user . "'";
    $result = dbSelect($userQuery);

    $id = $result[0]["id"];

    /* get list of entries */
    $entryQuery = "SELECT * FROM entry WHERE id = '" . $id . "' ORDER BY date DESC";
    $result = dbSelect($entryQuery);

    if(empty($result)){
        echo "No entries";
        return;
    }
    echo '<ul>';
    /*display entries */
    foreach($result as $r){
        $date = $r["date"];
        $title = $r["title"];
        echo '<li><a href="index.php?page=user&amp;user=' . $user . '&amp;date=' . $date . '"> -'  . $date . ' - ' . $title . '</a></li>'; 
    }
    echo '</ul>';

?>