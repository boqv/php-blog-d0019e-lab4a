<!-- Register form -->
<h2>Register</h2>
<form id="register" method="post" action="">
    <div>
        Username: <br/><input type="text" name="username"/><?php echo " ". $usernameRegError?><br/>
    </div>
    <div>
        Password: <br/><input type="password" name="password"/><?php echo " ". $passwordRegError?><br/>
    </div>
    <div>
        Email: <br/><input type="text" name="email"/><?php echo " ". $emailRegError?><br/><br/>
    </div>
    <div>
        <input type="submit" value="Register" name="register"/>
    </div>
</form>