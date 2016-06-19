<!-- menu on the start page, shows registered bloggers -->

    <?php 
        echo "<h2>Blogs</h2><hr/>"; 

        /* get and display list of bloggers */
        $userQuery = "SELECT * FROM user";
        $result = dbSelect($userQuery);
        echo "<ul>";
        foreach($result as $r){
                $user = $r["username"];
                if($r["username"] == "admin") continue;
                echo '<li><a href="index.php?page=user&amp;user=' . $user . '">'. $user . '</a></li>'; 
        }
        echo "</ul>";
    ?>  
