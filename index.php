<!-- myBlog index page -->
<?php
error_reporting(E_ALL); ini_set('display_errors', 'On'); 
    require_once('db.php');
    require_once('userActions.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <meta http-equiv="Content-type" content="text/html; charset=UTF-8"/>

        <title>Titel</title>
        <link rel="stylesheet" type="text/css" href="css/style.css"/>
        <link href='https://fonts.googleapis.com/css?family=Slabo+27px' rel='stylesheet' type='text/css'/>
        <script src="js/script.js" type="text/javascript"></script>
    </head>
    <body>
        
        <!-- header div -->
        <div class="row header">
                <?php require_once("header.php"); ?>  
        </div>
        <!-- end header div -->
       
        <div class="row">
            
            <!-- menu div -->
            <div class="col-3 menu">
                <?php
                    if(isset($_GET["user"])){
                        require_once("userMenu.php");
                    } else{
                        require_once("menu.php");
                    }
                ?>
            </div>
            <!-- end menu div -->
            
            
            <!-- content div -->
            <div class="col-5 content">
                <?php
                    if(!isset($_GET['page'])){
                        require_once('content.php');  //if no page is set show index content
                    } else  {
                        $page = $_GET['page'];
                        require_once($page.".php");
                    }
                ?>
            </div>
            <!-- end content div -->
            
            <!-- right div -->
            <div class="col-3 info">
                <?php
                if(isset($_GET["user"])){
                    require_once("userInfo.php");
                } else{
                    require_once("info.php");
                }
                ?>
            </div>
            <!-- end right div -->
        </div>  
                                  
        <div class="footer"></div>

    </body>
    
</html>