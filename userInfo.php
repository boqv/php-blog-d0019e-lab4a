<!-- This file is for generating the right hand side user panel, including the bio -->
<?php  

    //image portfolio link
    echo "<h2><a href='index.php?page=" . $_GET["page"] . "&amp;user=" . $_GET["user"] . "&amp;images=show'>Images</a></h2><hr/>"; 

    //if user page is the same as logged in user, add option to edit bio
    if(isset($_SESSION["user"]) && $_GET["user"] == $_SESSION["user"]["name"]){
        echo "<a href='#' id='editBioToggle' style='float:right'> - Edit bio </a>";
    }

    //generate bio
    echo "<h2>Bio</h2>"; 

    $bioQuery = "SELECT bio FROM user where username='" . $_GET["user"] . "'";
    $bioResult = dbSelect($bioQuery);

    echo "<p>" . $bioResult[0]["bio"] . "</p>";

?>

<div id="editBioSpace" style="display:none; padding:4px">
    <form id="editBio" method="post" action="">
        <div>
            <textarea id="bioTextArea" rows="10" cols="auto" style="width:100%" name="bioText"><?php echo $bioResult[0]["bio"] ?></textarea><br/>
        </div>
        <div>
            <input type="submit" value="Submit changes" name="editBio"/>
            <p id="bioCount"></p>
        </div>
    </form>
</div>

<script type="application/javascript">
    //<![CDATA[
    
    (function(){
        //this toggles the new entry form on and off
        document.getElementById("editBioToggle").addEventListener("click", function(){ myBlog.toggle("editBioSpace")});

        //this is for limiting the amount of characters in the text area
        var charCountText = document.getElementById("bioCount");

        var area = document.getElementById("bioTextArea");
        var limiter = myBlog.limitCharacters(area, 300, function(counter){
            
            //make the character count text red when over the limit
            if(counter < 0) {
                charCountText.setAttribute("style", "color:red");
            } else {
                charCountText.setAttribute("style", "color:black");
            }

            charCountText.innerHTML = "Characters left: "+counter;
        });  

        document.getElementById("editBio").onsubmit = function(){return limiter.charCheck(); };

    })();
    //]]>
</script>