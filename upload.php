<!-- Uploads an image for a specific user and entry date -->
<?php

/* 
returns the filepath $file if OK, null if there is an error.

$date - date of the entry to attach the image to 

filename is generated in the following format: 
    uploads/username_date.extension
*/
function upload($date){
    $dir = "uploads/";
    $file = $dir . $_SESSION["user"]["name"] . "_" . $date;
    $imgType = pathinfo($_FILES["fileToUpload"]["name"], PATHINFO_EXTENSION);
    
    if ($_FILES["fileToUpload"]["size"] > 1000000) {
        echo "<script> alert('file is too big') </script>";
        return null;
    }
    
    if($imgType != "jpg" && $imgType != "png" && $imgType != "jpeg"
       && $imgType != "gif" ) {
        echo "<script> alert('Image must be a JPG, JPEG, PNG or GIF.') </script>";
        return null;
    }
    
    $file = $file . "." . $imgType;
    
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);

    if($check !== false) {
      
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $file)) {
            return $file;
        } else {
            echo "<script> alert('Sorry, there was an error uploading your file.') </script>";
            return null;
        }
        
    } else {
        return null;
    }

}

?>