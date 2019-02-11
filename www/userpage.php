

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="Images/favicon.ico">

    <title>Bitter - Social Media for Trolls, Narcissists, Bullies and Presidents</title>

    <!-- Bootstrap core CSS -->
    <link href="includes/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="includes/starter-template.css" rel="stylesheet">
	<!-- Bootstrap core JavaScript-->
    <script src="https://code.jquery.com/jquery-1.10.2.js" ></script>
	
	
  </head>

  <body>
<?php
//displays all the details for a particular Bitter user
session_start();
include("Includes/header.php");
if(!isset($_GET["user_id"])){
    header("location:login.php");
}
?>
	<BR><BR>
    <div class="container">
		<div class="row">
			<div class="col-md-3">
				<div class="mainprofile img-rounded">
				<div class="bold">
				<?php
                                //$userID = $_SESSION["SESS_MEMBER_ID"];  
                                $userID = $_GET["user_id"];
                                $row = User::checkPicture($userID);
                                
                                if($row != false){
                                    echo '<img class="bannericons" src="'."images/profilepics/".$row.'">';
                                }else{
                                    echo '<img class="bannericons" src="images/profilepics/default.jfif"';  
                                }?>
				<a href="userpage.php?user_id= "><?php 
                                    $userID = $_GET["user_id"];
                                    $row = User::getUser($userID);
                                            echo "   ".$row["first_name"] . " " . $row["last_name"];?></a><BR></div>
                                <?php
                                    //$userID = $_SESSION["SESS_MEMBER_ID"];  
                                    $userID = $_GET["user_id"];
                                    $row = User::getUser($userID);
                                    $date = new DateTime($row["date_created"]);
                                    $date = $date ->format("F d, Y");
                                    echo '<table>'
                                        .'<tr>'
                                        .'<td>tweets</td><td>following</td><td>followers</td>'
                                        .'</tr>'
                                        .'<tr>'
                                        .'<td>'.$row["tweets"].'</td><td>'.$row["following"].'</td><td>'.$row["followers"].'</td>'
                                        .'</tr>'
                                        .'</table>'
                                        .'<img class="icon" src="images/location_icon.jpg"> '.$row["province"].', '.$row["location"]
                                        .'<div class="bold">Member Since:</div>'
                                        .'<div>'.$date.'</div>';
                                ?>
                                 </div>
                                <BR><BR>
				
				<div class="trending img-rounded">
				<?php
                                        //$userID = $_SESSION["SESS_MEMBER_ID"];
                                        $userID = $_GET["user_id"];
                                        User::getFollowers($userID);
                                ?>
				</div>	
                                
                        </div>    
			<div class="col-md-6">
				<div class="img-rounded">
					
				</div>
				<div class="img-rounded">
                                   <?php 
                                   //$userID = $_SESSION["SESS_MEMBER_ID"];
                                   $userID = $_GET["user_id"];
                                    Tweet::getMyTweets($userID); 
                                    ?>
				</div>
			</div>
			<div class="col-md-3">
				<div class="whoToTroll img-rounded">
				<div class="bold">Who to Troll?<BR></div>
                                    <?php $userID = $_SESSION["SESS_MEMBER_ID"];
                                    //$userID = $_GET["user_id"];
                                    User::getSuggestions($userID);								
                                    ?>
				</div><BR>
				
			</div>
		</div> <!-- end row -->
    </div><!-- /.container -->

	

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
    <script src="includes/bootstrap.min.js"></script>
    
  </body>
</html>
