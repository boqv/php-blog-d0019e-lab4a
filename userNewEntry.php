<!-- new entry form -->
<a href="#" id="newEntryToggle"><b>Write new entry</b> </a>

<div id="newEntrySpace" style="display:none; padding:4px">
    <form id="entry" action="" method="post" enctype="multipart/form-data">
        <div>
            Title <br/> 
            <input type="text" name="title"/><br/>
        </div>
        <div>
            Image <br/>
            <input type="file" name="fileToUpload"/><br/>
        </div>
        <div>
        Content <br/>
            <textarea id="contentArea" name="content" rows="4" cols="auto" style="width:100%"></textarea><br/>
        </div>
        <div>
            <input type="submit" value="Add entry" name="new"/>
            <p id="count"></p>
        </div>
    </form>
</div>

<script type="application/javascript">
    //<![CDATA[
    
    //this toggles the new entry form on and off
    (function(){
        document.getElementById("newEntryToggle").addEventListener("click", function(){               myBlog.toggle("newEntrySpace")});

        var charCountText = document.getElementById("count");
        
        //set a limit on amounts of characters to use in text area
        var area = document.getElementById("contentArea");
        var limiter = myBlog.limitCharacters(area, 200, function(counter){
            
            //make the character count text red when over the limit
            if(counter < 0) {
                charCountText.setAttribute("style", "color:red");
            } else {
                charCountText.setAttribute("style", "color:black");
            }

            charCountText.innerHTML = "Characters left: "+counter;
        });     
        
        document.getElementById("entry").onsubmit = function(){return limiter.charCheck(); };
    })();
    
    
        
    //]]>
</script>