<!DOCTYPE html>
<?php

session_start();
	header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
	header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); 	// Date in the past
	header("Pragma: no-cache");
        if(!isset($_SESSION["SESS_MEMBER_ID"])){
    header("location:login.php");
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

	
	<script>
	//just a little jquery to make the textbox appear/disappear like the real Twitter website does
	$(document).ready(function() {
		//hide the submit button on page load
		$("#button").hide();
		$("#tweet_form").submit(function() {
			
			$("#button").hide();
		});
		$("#myTweet").click( function() {			
			this.attributes["rows"].nodeValue = 5;
			$("#button").show();
			
		});//end of click event
		$("#myTweet").blur( function() {			
			this.attributes["rows"].nodeValue = 1;
                        //$("#button").hide();

		});//end of click event
                
	});//end of ready event handler
                
	function frmComment_submit(tweetId) {

            $.post("ReplyAjaxModal.php", $("#frmComment"+tweetId).serializeArray(),
                function(data){
                    $("#replies"+tweetId).text(data.msg);
                },
                "json"                    
            );
            closeReply(tweetId);
            return false;
	};
        function closeReply(tweetId){
            
            $("#"+tweetId).hide();

        }
        function setTweetID(tweetId){
            $("#"+tweetId).show();
            document.getElementById(tweetId).innerHTML = '<h5>Reply:</h5>' +
                                    '<form id="frmComment'+tweetId+'" name="frmComment" onsubmit="return frmComment_submit('+tweetId+');">' +
                                           '<textarea class="form-control" id="comment" name="comment" rows="1" placeholder="What do you have to say?"></textarea><br />' +
                                           '<input type="submit" id="ReplySubmit" value="Submit" name="submit" />' +
                                           '<input type="button" id="replyClose" value="Close" onclick="closeReply('+ tweetId + ')"/>' +
                                           '<input type="hidden" id="tweetID" name="tweetID" value="'+ tweetId + '"/>' +
                                    '</form> <br>';
            
            
		$("#comment").click( function() {			
			this.attributes["rows"].nodeValue = 2;
			
		});
        }
	</script>
  </head>

  <body>
<?php
//this is the main page for our Bitter website, 
//it will display all tweets from those we are trolling
//as well as recommend people we should be trolling.
//you can also post a tweet from here

include("Includes/header.php");
    if(isset($_GET["msg"])){
        echo "<script>alert('".$_GET["msg"]."');</script>";
    }


?>
	<BR><BR>
    <div class="container">

		<div class="row">
			<div class="col-md-3">
				<div class="mainprofile img-rounded">
				<div class="bold">
				<?php
                                $userID = $_SESSION["SESS_MEMBER_ID"];  
                                
                                $row = User::checkPicture($userID);
                                
                                if($row != false){
                                    echo '<img class="bannericons" src="'."images/profilepics/".$row.'">  ';
                                }else{
                                    echo '<img class="bannericons" src="images/profilepics/default.jfif">  ';  
                                } 
                                echo '<a href="userpage.php?user_id='.$_SESSION["SESS_MEMBER_ID"].'">'.$_SESSION["SESS_FIRST_NAME"] . ' ' . $_SESSION["SESS_LAST_NAME"].'</a><BR></div>';
                                    $userID = $_SESSION["SESS_MEMBER_ID"];                                    
                                    $row = User::getUser($userID);
                                    echo '<table>'
                                        .'<tr>'
                                        .'<td>tweets</td><td>following</td><td>followers</td>'
                                        .'</tr>'
                                        .'<tr>'
                                        .'<td>'.$row["tweets"].'</td><td>'.$row["following"].'</td><td>'.$row["followers"].'</td>'
                                        .'</tr>'
                                        .'</table>';                                
                                ?>
                                <BR><BR><BR><BR><BR>
				</div><BR><BR>
				<div class="trending img-rounded">
				<div class="bold">Trending</div>
				</div>
				
			</div>
			<div class="col-md-6">
				<div class="img-rounded">
					<form method="post" id="tweet_form" action="tweet_proc.php">
					<div class="form-group">
						<textarea class="form-control" name="myTweet" id="myTweet" rows="1" placeholder="What are you bitter about today?"></textarea>
						<input type="submit" name="button" id="button" value="Send" class="btn btn-primary btn-lg btn-block login-button"/>
						
					</div>
					</form>
				</div>
				<div class="img-rounded">
				<!--display list of tweets here-->
                                    <?php 
                                    $userID = $_SESSION["SESS_MEMBER_ID"];
                                    Tweet::displayTweets($userID); 
                                    //Tweet::displayReplies();
                                    ?>           
				</div>
			</div>
			<div class="col-md-3">
				<div class="whoToTroll img-rounded">
				<div class="bold">Who to Troll?<BR></div>
				<!-- display people you may know here-->
                                <?php
                                    $userID = $_SESSION["SESS_MEMBER_ID"];
                                    User::getSuggestions($userID);
                                 ?>   

				</div><BR>
				<!--don't need this div for now 
				<div class="trending img-rounded">
				© 2018 Bitter
				</div>-->
			</div>

		</div> <!-- end row -->
                
    </div><!-- /.container -->

	

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->

    <script src="includes/bootstrap.min.js"></script>
    
  </body>
</html>
