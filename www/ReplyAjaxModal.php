<?php
    session_start();
    include_once('Includes/Tweet.php');
    $tweetText = $_POST['comment'];
    $replyTweetId = $_POST['tweetID'];
    $user = $_SESSION['SESS_MEMBER_ID'];
    $originalTweetId = 0;
    
    include_once("connect.php");    
    $con = mysqli_connect(DB_HOST,DB_USER,DB_PASS, DB_NAME);
    
        $tweet = mysqli_real_escape_string($con, $tweetText);
        
        $sql= "insert into tweets(tweet_text, user_id, original_tweet_id, reply_to_tweet_id, date_created) "
                . "values('$tweet', $user, $originalTweetId,$replyTweetId, NOW());";

        mysqli_query($con,$sql);

        if (mysqli_affected_rows($con) ==1) {
            
            
            $json_out='{"msg": You Replied: "'.$tweetText.'"}'; 
        }
        else {
             $json_out='{"msg":"Sorry. we couldn\'t get your reply. Try later"}';
        }    
    echo $json_out;         
				
?>