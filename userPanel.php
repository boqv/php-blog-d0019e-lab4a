<!-- user panel, display instead of login panel when logged in -->
<p>Logged in as <?php echo $_SESSION["user"]["name"]; ?> </p>

    <?php 
if($_SESSION["user"]["name"] == 'admin'){
    echo "<a href='admin.php'>Admin page</a>";   
} else {
    echo "<a href='index.php?page=user&amp;user=" . $_SESSION["user"]["name"] . "'>My page</a>"; 
}

?>
<a href="index.php?logout=true">Log out</a>

