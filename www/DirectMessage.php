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
<script src="https://code.jquery.com/jquery-3.3.1.js" ></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

        <script>
        $(document).ready(function() {
        //hide the submit button on page load
        $("#button").hide();
        $("#message_form").submit(function() {
        //alert("submit form");
        $("#button").hide();
        });
        $("#message").focus( function() {
        this.attributes["rows"].nodeValue = 5;
        $("#button").show();
        });//end of click event

        $("#to").keyup(//key up event for the user name textbox
        function(e) {

         if (e.keyCode === 13) {
         //don't do anything if the user types the enter key, it might try to submit the form
         return false;
        }
        jQuery.get(
         "UserSearch_AJAX.php",
         $("#message_form").serializeArray(),
         function(data) {//anonymous function
         //uncomment this alert for debugging the directMessage_proc.php page
        //alert(data);
         //clear the users datalist
        $("#dlUsers").empty();
        if (typeof(data.users) === "undefined") {
        $("#dlUsers").append("<option value='NO USERS FOUND' label='NO USERS FOUND'></option>");
        }

         $.each(data.users, function(index, element) {
            // alert("here");
        //this will loop through the JSON array of users and add them to the select box
        $("#dlUsers").append("<option value='" + element.name + "' label='" + element.id +"'></option>");
        //alert(element.id + " " + element.name);
         });

        },
         //change this to "html" for debugging the UserSearch_AJAX.php page
        "json"
        //"html"
        );
        //make sure the focus stays on the textbox so the user can keep typing
        $("#to").focus();
        return false;
        }
        );
        });//end of ready event handler

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
				<?php
                                        //$userID = $_SESSION["SESS_MEMBER_ID"];
                                        $userID = $_SESSION["SESS_MEMBER_ID"];
                                        User::getFollowers($userID);
                                ?>
				</div>
				
			</div>
			<div class="col-md-6">
				<div class="img-rounded">

                                    <form method="post" id="message_form" action="DirectMessage_proc.php">
                                    <div class="form-group">
                                     Send message to: <input type="text" id="to" name="to" list="dlUsers" autocomplete="off"><br>
                                    <datalist id="dlUsers">
                                     <!-- this datalist is empty initially but will hold the list of users to select as the user is typing -->
                                    </datalist>
                                     <input type="hidden" name="userId" value="<?php echo $_SESSION["SESS_MEMBER_ID"];?>">

                                    <textarea class="form-control" name="message" id="message" rows="1" placeholder="Enter your message here"></textarea>
                                    <input type="submit" name="button" id="button" value="Send" class="btn btn-primary btn-lg btn-block login-button"/>
                                    </div>
                                    </form>
				</div>
                            <div class="img-rounded"><h1>Your Messages</h1>
				<!--display list of tweets here-->
                                    <?php 
                                    $userID = $_SESSION["SESS_MEMBER_ID"];
                                    User::GettAllMessages($userID); 
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

