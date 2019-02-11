<!DOCTYPE html>
<?php

session_start();

if(!isset($_SESSION["SESS_MEMBER_ID"])){
    header("location:login.php");
}
include("Includes/header.php");

if(!isset($_POST["search"])){
  echo' ';  
}
?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="DESC MISSING">
    <meta name="author" content="Nick Taggart, nick.taggart@nbcc.ca">
    <link rel="icon" href="Images/favicon.ico">

    <title>Bitter - Social Media for Trolls, Narcissists, Bullies and Presidents</title>

    <!-- Bootstrap core CSS -->
    <link href="includes/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="includes/starter-template.css" rel="stylesheet">
	<!-- Bootstrap core JavaScript-->
<!--    <script src="https://code.jquery.com/jquery-1.10.2.js" ></script>-->
<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>    
<script type="text/javascript" src="includes/jquery-3.3.1.min.js"></script>

	
  </head>

  <body>
	<BR><BR>
    <div class="container">

		<div class="row">
			<div class="col-md-3">

				
			</div>
			<div class="col-md-6">
				<div class="img-rounded"><h4>Users found: </h4><br>
                                    <?php
                                        $txtSearch = $_POST["search"];
                                        $cUser = $_SESSION["SESS_MEMBER_ID"];
                                        
                                        User::searchUser($txtSearch, $cUser);
                                    ?>
				</div><br><br>
				<div class="img-rounded"><h4>Tweets found: </h4><br>
                                   <?php
                                        $txtSearch = $_POST["search"];
                                       
                                        Tweet::searchTweet($txtSearch);
                                   ?>
				</div>
			</div>


		</div> <!-- end row -->
                
    </div><!-- /.container -->

	

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->

    <script src="includes/bootstrap.min.js"></script>
    
  </body>
</html>