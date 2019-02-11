<?php

    include_once('Includes/Tweet.php');
    
    $tweet_id = $_GET['tweet_id'];
    $user = $_GET['user_id'];
    
    echo $tweet_id . 'Tweet id';
    echo $user. ' user liking';
    
    Tweet::likeTweet($tweet_id, $user);

