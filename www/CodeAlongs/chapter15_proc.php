<?php

// Check if the file is empty if not display error
if(empty($_FILES['pic']['name'])){
    
    echo "Error: you must select a file to upload";
    
}else{ // if it is not empty
    
    echo $_FILES['pic']['tmp_name'];
    
    // Check if the file is less than 1 MB
    // by default 1MB is the max file size
    
    // If it is grater than 1 MB, display error and unlik the file
    if($_FILES['pic']['size'] > 1024*1024){
        
        echo "error: file must be under 1MB";
        unlik($_FILES['pic']['tmp_name']);
        
    }else{ // If it is less than 1MB try to move it to the desired location
        
        // if it could not move the file display error and unlink the file
        if(!move_uploaded_file($_FILES['pic']['tmp_name'], "images/".$_FILES['pic']['name'])){
            
            echo "Error: handling uploaded file";
            unlik($_FILES['pic']['tmp_name']);
            
        }else{ // if it does move the file everything is good and a temp name is given to the file and you upload the path (variable) to the database
            
            echo "<br> all good <br>";
            
        }
        // update the profile_pic in the users table of the DB
    }
}
?>
