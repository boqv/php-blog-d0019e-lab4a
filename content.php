<!-- Start page content space -->
<h2>Latest entries</h2>
<hr/>
<?php

    /* get 5 latest entries from db */
    $query = "SELECT * FROM user JOIN entry ON entry.id = user.id ORDER by date DESC LIMIT 5";
    $result = dbSelect($query);

    /* display the latest entries. */
    foreach($result as $r){
        
        echo "<h3 style='display:inline'>" . $r["title"] . "</h3><p style='display:inline'> - by " . $r["username"] . " - " . $r["date"] . "</p><br/>";
        
        echo substr($r["content"], 0, 50) . "...";
        
        echo "<a href='index.php?page=user&amp;user=" . $r["username"] . "&amp;date=" . $r["date"] . "'> Read more </a><hr/>";
    }

    echo "<br/><br/>";

    /*get and display the newest registered user */
    $queryEntries = "SELECT * FROM user ORDER BY timeRegistered DESC LIMIT 1";
    $result = dbSelect($queryEntries);
    echo "<h3 style='display:inline'> Newest blogger: </h3><p style='display:inline'>Welcome <b>" . $result[0]["username"] . "</b>!!!</p>";
    

?>
