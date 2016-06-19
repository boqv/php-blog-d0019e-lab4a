<?php
    if (!isset($_SESSION) || !is_array($_SESSION)) {
        session_start();
    }

    clearErrorMessages();
    
    /* user tries to login */
    if(isset($_POST['login'])){
        
       if(emptyRequiredFields()) { 
           return;
        }
     
        $login_sql = "SELECT * FROM user WHERE username = '" . $_POST["username"] . "' AND
        password='" . $_POST["password"] . "'";
        
        //check for match
        $login_result = dbSelect($login_sql);
        
        if(count($login_result) != 0){
        
            $_SESSION["user"]["name"] = $login_result[0]["username"];
            $_SESSION["user"]["id"] = $login_result[0]["id"];

            header('Location: index.php?page=user&amp;user='.$_SESSION["user"]["name"]);
        } else {
            //wrong password or username
            
            $loginError = "Wrong username/password!";
        }
           
    }

    /* user logged out */
    if(isset($_GET['logout'])){
        unset($_SESSION["user"]);
        header('Location: index.php');
    }

    /* user creates a new post */
    if(isset($_POST["new"])){
        date_default_timezone_set('Europe/Stockholm');
        $d = date('Y-m-d H:i:s');
       
        $file = "";
        //if a image file is provided, upload it
        if(!empty($_FILES["fileToUpload"]["name"])){
            include 'upload.php';

            $file = upload($d);
            
            if($file == null){
                return;
            }
        }

        dbInsertEntry($d, $_POST["title"], $_POST["content"], $file);
    }

    /* user registered */
    if(isset($_POST["register"])){
        
        if(emptyRequiredFields()) return;
        
        $username = $_POST["username"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        date_default_timezone_set('Europe/Stockholm');
        $date = date('Y-m-d H:i:s');

        $match = false;
        $success = false;
        $emailRegError = "";
        $usernameRegError = "";
        
        $success = dbInsertUser($username, $password, $email, $date);

        if($success == true){
            header('Location: index.php?success=true');
        }
    }

    /* user deletes a post */
    if(isset($_GET["delete"])){

        if($_GET["delete"] == "yes"){
            $entryDate = $_GET["date"];
            dbRemoveEntry($_SESSION["user"]["id"], $entryDate);
        }
    }


    /* user edits a post */
    if(isset($_POST["edit"])){

        $entryDate = $_POST["date"];
        $path = dbGetEntryImage($entryDate);

        //if user checked the remove current image box
        if(isset($_POST["fileToRemove"]) && $_POST["fileToRemove"] == "remove") {
            $path = dbRemoveEntryImage($path);      
        } 

        //if a new image file is provided
        if(!empty($_FILES["fileToUpload"]["name"])){

            dbRemoveEntryImage($path);
            include 'upload.php';
            $path = upload($entryDate);
        }

        
        dbUpdateEntry($_POST["date"], $_POST["title"], $_POST["content"], $path);
    }

    /* user edits bio */
    if(isset($_POST["editBio"])){
        dbUpdateBio($_POST["bioText"]);
    }

    
    /* checks if the required fields are filled in for login and register forms 
        return true if empty and sets the error message.
    */
    function emptyRequiredFields(){
        
        $empty = false;

        //login
        if(isset($_POST["login"])){
            if(empty($_POST["username"])){
                $GLOBALS["usernameError"] = " *field is required!";
                $empty = true;
            }
            if(empty($_POST["password"])){
                $GLOBALS["passwordError"] = " *field is required!";
                $empty = true;
            }
        }
        
        //register
        if(isset($_POST["register"])){
            if(empty($_POST["username"])){
                $GLOBALS["usernameRegError"] = " *field is required!";
                $empty = true;
            }
            if(empty($_POST["password"])){
                $GLOBALS["passwordRegError"] = " *field is required!";
                $empty = true;
            }
        }

        return $empty;
    }

/*reset the error messages for the forms */
function clearErrorMessages(){
    $GLOBALS["usernameError"] = "";
    $GLOBALS["passwordError"] = "";
    $GLOBALS["emailError"] = "";
    $GLOBALS["loginError"] = "";
    $GLOBALS["usernameRegError"] = "";
    $GLOBALS["passwordRegError"] = "";
    $GLOBALS["emailRegError"] = "";
}

?>