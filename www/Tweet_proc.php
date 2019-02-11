<?php 
session_start();
include_once('Includes/Tweet.php');

if(isset($_POST["myTweet"])){
    
    $tweet = $_POST["myTweet"];
    
    $user_id = $_SESSION["SESS_MEMBER_ID"];
    $originalTweetId = 0;
    $replyTweetId = 0;
    
    Tweet::postTweet($tweet, $user_id, $originalTweetId, $replyTweetId);

}
?>