<?php
session_start();
include("Includes/Header.php");
?>

<html>
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="bitter">
    <meta name="author" content="Luis Paredes">
    <link rel="icon" href="Images/favicon.ico">

    <title>Bitter - edit profile pic</title>

    <link href="includes/bootstrap.min.css" rel="stylesheet">

    <link href="includes/starter-template.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-1.10.2.js" ></script>
    </head>
    
    <body>
        <form action="edit_photo_proc.php" method ="post" enctype="multipart/form-data">
            Select your image:
            <input type="file" name="pic" accept="image/*" required>
            <input id="button" type="submit" value="submit">
        </form>
    </body>
</html>