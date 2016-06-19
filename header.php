<!-- Top header page -->
<!-- Logo left -->
<div class="col-9">
    <h1>
        <a href="index.php">- myBlog - </a>
    </h1>
</div>


<!-- Panel to the right, for login -->
<div class="col-3" style="height:152px">
    <?php
    if(isset($_SESSION["user"])){
        include 'userPanel.php'; 
    } else {
        include 'loginPanel.php';
    }

    ?>
</div>

   


