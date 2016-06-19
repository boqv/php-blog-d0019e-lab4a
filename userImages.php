<!-- This file generates the user image portfolio -->
<?php
    echo "<h2>" . $_GET["user"] . "'s image portfolio </h2>";

    //get all the user images
    $imageQuery = "SELECT image FROM entry WHERE id='" . $_GET["user"] . "'";
    dbSelect($imageQuery);

    $colCounter = 0;    //counter used for knowing when to create a new row

    echo "<div class='row'>";

    foreach($result as $r){
        $image = $r["image"];
        if(!empty($image)){
            echo '<div class="col-3" style="border: 1px solid black"><a href="' . "./" . $image . '"> <img src="' . $image . '" width="100%" alt=""></img></a></div>';

            $colCounter++;

            if($colCounter >= 4){           //new row!
                echo "</div><div class='row'>"; 
                $colCounter = 0;
            }
        }    
    }

    echo "</div>";

?>