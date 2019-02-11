<?php
    include_once('Includes/Tweet.php');
    echo $_GET['tweet_id'] . 'Tweet id';
    echo $_GET['user_id']. ' user retweeting';
    $tweet_id = $_GET['tweet_id'];
    $user = $_GET['user_id'];
    Tweet::retweet($tweet_id, $user);
    
?>


