<!-- user login panel, shown when not logged in -->
<form id="login" action="index.php" method="post">
    <div>
        <p>Username:</p>
        <input type="text" name="username"/><span class="error"><?php echo $usernameError ?> </span>
    </div>
    <p>Password:</p>
    <div>
        <input type="password" name="password"/><span class="error"><?php echo $passwordError ?> </span><br/>
    </div>
    <div>
        <input type="submit" name="login" value="Login"/> <a href="index.php?page=register">Register</a>
    </div>
</form>
<span><?php echo $loginError ?></span>

