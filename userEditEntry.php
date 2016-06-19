<!-- edit entry form -->
<br/><br/>
<a href="#editEntrySpace" id="editEntryToggle">Edit entry</a> | 

<?php 
    echo "<a href='index.php?page=deleteConfirm&amp;user=".$_GET["user"]. "&amp;date=" . $date . "' >Delete entry </a>";
?>

<div id="editEntrySpace" style="display:none; padding:4px">
    <form id="editEntry" method="post" action="" enctype="multipart/form-data">
        <div>
            Title <br/> 
            <input type="text" name="title" value="<?php echo $title?>"/><br/>
        </div>
        <div>
            Change image <br/>
            <input type="file" name="fileToUpload"/>
            <input type="checkbox" name="fileToRemove" value="remove"/> Remove current image<br/>
            <br/>
        </div>
        <div>
            Content <br/>
            <textarea id="editContentArea" rows="4" cols="auto" style="width:100%" name="content"><?php echo $content ?></textarea><br/>
        </div>
        <div>
            <input type="hidden" name="date" value="<?php echo $date?>" />
            <input type="submit" value="Submit changes" name="edit"/>
            <p id="editCount"></p>
        </div>
    </form>
</div>

<script type="application/javascript">
    //<![CDATA[
    //this toggles the new entry form on and off
    (function(){
        document.getElementById("editEntryToggle").addEventListener("click", function(){ myBlog.toggle("editEntrySpace")});

        //this is for limiting the amount of characters in the text area
        var charCountText = document.getElementById("editCount");
        
        var area = document.getElementById("editContentArea");
        var limiter = myBlog.limitCharacters(area, 200, function(counter){
            
            //make the character count text red when over the limit
            if(counter < 0) {
                charCountText.setAttribute("style", "color:red");
            } else {
                charCountText.setAttribute("style", "color:black");
            }

            charCountText.innerHTML = "Characters left: "+counter;
        });  
        
        document.getElementById("editEntry").onsubmit = function(){return limiter.charCheck(); };
        
    })();

    //]]>
</script>