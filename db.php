<?php

/* connects to database, keeps a static variable $con with the connection*/
function dbConnect()
{
    
    $dbServer = "utbweb.its.ltu.se:3308";    // Servername:portnumber
    $dbUser = "johboq_7";           // Database username
    $dbPass = "69x75z3M";               // Database password
    $dbName = "D0019E_V16_johboq_7";   

    static $con;

    // Connect to the database only if a connection has not been established yet
    if (!isset($con)) {
        // Create the connection
        $con = mysqli_connect($dbServer, $dbUser, $dbPass, $dbName);
    }
    return $con;
}

/* makes a query to db */
function dbQuery($queryString){
   
    $connection = dbConnect();
    if($result = mysqli_query($connection, $queryString)){
        return $result;
    }

    return null;
}

/*make a select to db */
function dbSelect($queryString){
    
    $rows = array();
    $result = dbQuery($queryString);
    
    while($row = mysqli_fetch_assoc($result)){
        $rows[] = $row;
    }
    
    return $rows;
}

function dbStartTransaction(){
    $connection = dbConnect();
    mysqli_autocommit($connection, false);
}

/*cancels a transaction */
function dbRollback(){
    $connection = dbConnect();
    mysqli_rollback($connection);
}

/*commits a transaction */
function dbCommit(){
    $connection = dbConnect();
    mysqli_commit($connection);
}

/*inserts a post entry into database */
function dbInsertEntry($date, $title, $content, $file){
    
    $connection = dbConnect();
    
    /*get rid of symbols that can break the sql query string */
    $content = substr(mysqli_real_escape_string($connection, $content), 0, 999);
    $title = substr(mysqli_real_escape_string($connection, $title), 0, 44);

    $query = "INSERT INTO entry(id, date, title, content, image)
            VALUES('" . $_SESSION["user"]["id"] . "', '" . $date . "', '" . $_POST["title"] . "', '" . 
        $content . "', '" . $file . "')";

    dbQuery($query);
}

/*updates a post entry in the database, $file can be null if no image*/
function dbUpdateEntry($date, $title, $content, $file){
    $connection = dbConnect();

    /*get rid of symbols that can break the sql query string */
    $content = substr(mysqli_real_escape_string($connection, $content), 0, 999);
    $title = substr(mysqli_real_escape_string($connection, $title), 0, 44);
    
    $query = "UPDATE entry SET title='" . $title . "', 
        content='" . $content . "', image='" . $file . "' WHERE date='" . $date . "' AND
        id='" . $_SESSION["user"]["id"] . "'";

    dbQuery($query);
}

/*updates the biotext in the entry table in db */
function dbUpdateBio($text){
    
    $connection = dbConnect();
    $text = substr(mysqli_real_escape_string($connection, $text), 0, 199);
    
    $query = "UPDATE user SET bio='" . $text . 
        "' WHERE id='" . $_SESSION["user"]["id"] . "'";

    dbQuery($query);
}

/*gets and returns the image path associated with the post entry from db */
function dbGetEntryImage($date){
    $selectQuery = "SELECT image from entry WHERE id='" . $_SESSION["user"]["id"] . "' AND
            date='" . $date . "'";

    $result = dbSelect($selectQuery);
    $path = $result[0]["image"];

    return $path;
}

/*removes the image associated with the post entry from the server */
function dbRemoveEntryImage($path){

    if(!empty($path)){
        unlink($path);
        $path = null; 

    }
    return $path;
}

/*removes a post entry from db*/
function dbRemoveEntry($id, $date){
    
    //remove image associated to entry
    $query = "SELECT image FROM entry WHERE id='" . $id . "' AND date='" . $date . "'";
    $result = dbSelect($query);
    
    if(!empty($result)){
        dbRemoveEntryImage($result[0]["image"]);
    }
    
    $query = "DELETE FROM entry WHERE id='" . $id . "' AND date='" . $date . "'";
    dbQuery($query);
}


/*removes a user and the associated entries and images from the db */
function dbRemoveUser($id){
    $query = "SELECT * FROM entry WHERE id='" . $id ."'";
    $result = dbSelect($query);
    
    foreach($result as $r){
       dbRemoveEntry($r["id"], $r["date"]);
    }
    
    $query = "DELETE FROM user WHERE id='" . $id . "'";
    dbQuery($query); 
    
    echo "user deleted";
}

/*  inserts a user in db, transaction is not really needed... 
    returns true if success. If error, set error message and return false.
*/
function dbInsertUser($username, $password, $email, $date){
    
    dbStartTransaction();

    $query = "SELECT * FROM user WHERE username='" . $username . "'";
    $r = dbSelect($query);

    //user already exists
    if(count($r) != 0){
        $match = true;
        $GLOBALS["usernameRegError"] = "Username has already been taken\n";
        dbRollback();
        return false;
    }

    $query = "SELECT * FROM user WHERE email='" . $email . "'";
    $r = dbSelect($query);

    //email already exists
    if(count($r) != 0 && !empty($email)){
        $emailRegError = "Email has already been taken\n";
        $match = true;
        dbRollback();
        return false;
    }

    //insert user
    $query = "INSERT INTO user (username, email, password, timeRegistered) 
            VALUES ('" . $username . "', '". $email . "', '" . $password . "', '". $date . "')";

    $r = dbQuery($query);

    if($r == null){
        if(!$match) echo "Something went wrong.";
        dbRollback();
    } else {
        dbCommit();         //success!
        return true;
    }
    
    return false;
}
?>