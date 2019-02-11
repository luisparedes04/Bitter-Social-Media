<?php

class Tweet {
    private $tweetId;
    private $originalTweetId;
    private $tweetText;
    private $replyToTweetId;
    private $userId;
    private $dateAdded;
    
    // This function is working fine. index page is fine
    static function displayTweets($userID){   
    date_default_timezone_set("America/Halifax");
    setlocale(LC_ALL, "en-CA");


    include_once("connect.php");
    
    $con = mysqli_connect(DB_HOST,DB_USER,DB_PASS, DB_NAME);
    
    $sql = "select distinct u.user_id, u.first_name, u.last_name, u.screen_name, u.profile_pic, t.tweet_id, t.tweet_text, t.date_created"
            ." from users u inner join tweets t on u.user_id = t.user_id inner join `follows` f on u.user_id = f.to_id" 
            ." where t.user_id = ".$userID ." or f.from_id = ".$userID 
            ." order by t.date_created desc;";
    
    $resultTweets = mysqli_query($con, $sql);
        
            while($row = mysqli_fetch_assoc($resultTweets)){
                
                $dateTweeted = $row["date_created"];
                $tweetTime = new DateTime($dateTweeted);
                $now = new DateTime(); // default to the current timestamp
                
                $interval = $tweetTime -> diff($now);

                if($interval->y > 1){ $interval = $interval->format("%y years ago"); }
                else if($interval ->y > 0){ $interval = $interval->format("%y year ago"); }
                elseif($interval ->m > 1){ $interval = $interval->format("%m months ago");} 
                elseif($interval->m > 0){ $interval = $interval->format("%m month ago"); }
                elseif($interval ->d > 1){ $interval = $interval-> format("%d days ago"); } 
                elseif($interval->d > 0) {$interval = $interval->format("%d day ago"); }
                elseif($interval ->h > 1){ $interval = $interval-> format("%h hours ago"); } 
                elseif($interval->h > 0) {$interval = $interval->format("%h an hour ago"); }
                elseif($interval ->i > 1){ $interval = $interval-> format("%i minutes ago"); } 
                elseif($interval->i > 0) {$interval = $interval->format("%i minute ago"); }
                elseif($interval ->s > 1){ $interval = $interval->format("%s seconds ago"); } 
                else{$interval = $interval->format(" just now"); }
                
                $tweetID = $row["tweet_id"];
                $replyFlag = isReply($tweetID);
                $rtFlag = isRetweet($tweetID); 
                $user = $row["user_id"];
                if($replyFlag == FALSE){
                if($rtFlag == FALSE){
                    if($row["profile_pic"] != null){
                        echo '<div><div class="bold"><img class="bannericons" src="Images/profilepics/'.$row["profile_pic"].'"><a href="userpage.php?user_id='.$row["user_id"].' ">    '
                                . $row["first_name"] .' '
                                .$row["last_name"] .' @'
                                .$row["screen_name"]
                                . '</a></div><br><br>'
                                .$row["tweet_text"]
                                . '<br><br>'
                                . "Posted: ".$interval
                                //Getting an error when I post but if you refresh the page it works fine
                                .'<br><br>';
                                isLiked($tweetID, $userID);
                                //.'<a href="LikeTweet.php?tweet_id= '.$row["tweet_id"].'&user_id= '.$userID.'"><img class="bannericons" src="Images/like.ico">    '
                                echo '<a href="retweet.php?tweet_id= '.$row["tweet_id"].'&user_id= '.$userID.' "><img class="bannericons" src="Images/retweet.png"></a><br><br>'
                               // .' <h6 id="submit_comment_link"><a href="#" ><img onclick="setTweetID('.$row["tweet_id"].')" class="bannericons" src="Images/reply.png"></a></h6>' 
                                .'<div id="'.$row["tweet_id"].'" class="img-rounded"></div>'
                                .'<p id="replies'.$row["tweet_id"].'"><p>'
                                .'<img onclick="javascript:setTweetID('.$row["tweet_id"].')" class="bannericons" src="Images/reply.png">'
                                .'<HR/></div>';

                    }
                    else{

                         echo '<div><div class="bold"><img class="bannericons" src="Images/profilepics/default.jfif"><a href="userpage.php?user_id='.$row["user_id"].' ">  '
                                . $row["first_name"] .' '
                                .$row["last_name"] .' @'
                                .$row["screen_name"]
                                . '</a></div><br><br>'
                                .$row["tweet_text"]
                                . '<br><br>'
                                . "Posted: ".$interval
                                 //Getting an error when I post but if you refresh the page it works fine
                                .'<br><br>';
                         
                                isLiked($tweetID, $userID);
                                
                                echo '<a href="retweet.php?tweet_id= '.$row["tweet_id"].'&user_id= '.$userID.' "><img class="bannericons" src="Images/retweet.png"></a><br><br>'
                                //.' <h6 id="submit_comment_link"><a href="#" ><img onclick="setTweetID('.$row["tweet_id"].')" class="bannericons" src="Images/reply.png"></a></h6>' 
                                 .'<div id="'.$row["tweet_id"].'" class="img-rounded"></div>'
                                 .'<p id="replies'.$row["tweet_id"].'"><p>'
                                 .'<img onclick="javascript:setTweetID('.$row["tweet_id"].')" class="bannericons" src="Images/reply.png">'
                                 .'<HR/></div>';                
                    }
                    
                }else{
                    displayRT($rtFlag, $row, $userID, $interval);
                }
                }else{
                    addReplyToList($replyFlag, $row, $userID, $interval);
                }
            }
}
    // This function is working fine tweet proc works
    static function postTweet($tweet, $user_id, $originalTweetId, $replyTweetId){
        
    include_once("connect.php");
    
    $con = mysqli_connect(DB_HOST,DB_USER,DB_PASS, DB_NAME);
        $tweet = mysqli_real_escape_string($con, $tweet);
        $sql= "insert into tweets(tweet_text, user_id, original_tweet_id, reply_to_tweet_id, date_created) "
                . "values('$tweet', $user_id, $originalTweetId,$replyTweetId, NOW());";

        mysqli_query($con,$sql);

        if (mysqli_affected_rows($con) ==1) {
            $msg ="Posted";
            header("location:index.php?msg=$msg");
        }
        else {
            echo "an error occurred<BR> " . $sql;
        }
    }
    
    static function getMyTweets($userID){
        date_default_timezone_set("America/Halifax");
        setlocale(LC_ALL, "en-CA");


    include_once("connect.php");
    
    $con = mysqli_connect(DB_HOST,DB_USER,DB_PASS, DB_NAME);
    
    $sql = "select distinct u.user_id, u.first_name, u.last_name, u.screen_name, u.profile_pic, t.tweet_id, t.tweet_text, t.date_created"
            ." from users u inner join tweets t on u.user_id = t.user_id" 
            ." where t.user_id = ".$userID  
            ." order by t.date_created desc;";
    
    $resultTweets = mysqli_query($con, $sql);
        
            while($row = mysqli_fetch_assoc($resultTweets)){
                
                $dateTweeted = $row["date_created"];
                $tweetTime = new DateTime($dateTweeted);
                $now = new DateTime(); // default to the current timestamp
                
                $interval = $tweetTime -> diff($now);

                if($interval->y > 1){ $interval = $interval->format("%y years ago"); }
                else if($interval ->y > 0){ $interval = $interval->format("%y year ago"); }
                elseif($interval ->m > 1){ $interval = $interval->format("%m months ago");} 
                elseif($interval->m > 0){ $interval = $interval->format("%m month ago"); }
                elseif($interval ->d > 1){ $interval = $interval-> format("%d days ago"); } 
                elseif($interval->d > 0) {$interval = $interval->format("%d day ago"); }
                elseif($interval ->h > 1){ $interval = $interval-> format("%h hours ago"); } 
                elseif($interval->h > 0) {$interval = $interval->format("%h an hour ago"); }
                elseif($interval ->i > 1){ $interval = $interval-> format("%i minutes ago"); } 
                elseif($interval->i > 0) {$interval = $interval->format("%i minute ago"); }
                elseif($interval ->s > 1){ $interval = $interval->format("%s seconds ago"); } 
                else{$interval = $interval->format(" just now"); }
                
                $tweetID = $row["tweet_id"];
                $replyFlag = isReply($tweetID);
                $rtFlag = isRetweet($tweetID); 
                $user=$row["user_id"];
                
                if($replyFlag == FALSE){
                if($rtFlag == FALSE){
                    if($row["profile_pic"] != null){
                        echo '<div><div class="bold"><img class="bannericons" src="Images/profilepics/'.$row["profile_pic"].'"><a href="userpage.php?user_id='. $row["user_id"].' ">    '
                                . $row["first_name"] .' '
                                .$row["last_name"] .' @'
                                .$row["screen_name"]
                                . '</a></div><br><br>'
                                .$row["tweet_text"]
                                . '<br><br>'
                                . "Posted: ".$interval
                                //Getting an error when I post but if you refresh the page it works fine
                                .'<br><br>';
                         
                                isLiked($tweetID, $user);
                                
                                echo '<a href="retweet.php?tweet_id= '.$row["tweet_id"].'&user_id= '.$userID.' "><img class="bannericons" src="Images/retweet.png"></a><br><br>'
                               // .' <h6 id="submit_comment_link"><a href="#" ><img onclick="setTweetID('.$row["tweet_id"].')" class="bannericons" src="Images/reply.png"></a></h6>' 
                                .'<div id="'.$row["tweet_id"].'" class="img-rounded"></div>'
                                .'<p id="replies'.$row["tweet_id"].'"><p>'
                                .'<img onclick="javascript:setTweetID('.$row["tweet_id"].')" class="bannericons" src="Images/reply.png">'
                                .'<HR/></div>';

                    }
                    else{

                         echo '<div><div class="bold"><img class="bannericons" src="Images/profilepics/default.jfif"><a href="userpage.php?user_id='. $row["user_id"].' ">  '
                                . $row["first_name"] .' '
                                .$row["last_name"] .' @'
                                .$row["screen_name"]
                                . '</a></div><br><br>'
                                .$row["tweet_text"]
                                . '<br><br>'
                                . "Posted: ".$interval
                                 //Getting an error when I post but if you refresh the page it works fine
                                .'<br><br>';
                         
                                isLiked($tweetID, $user);
                                
                                echo '<a href="retweet.php?tweet_id= '.$row["tweet_id"].'&user_id= '.$userID.' "><img class="bannericons" src="Images/retweet.png"></a><br><br>'
                                //.' <h6 id="submit_comment_link"><a href="#" ><img onclick="setTweetID('.$row["tweet_id"].')" class="bannericons" src="Images/reply.png"></a></h6>' 
                                 .'<div id="'.$row["tweet_id"].'" class="img-rounded"></div>'
                                 .'<p id="replies'.$row["tweet_id"].'"><p>'
                                 .'<img onclick="javascript:setTweetID('.$row["tweet_id"].')" class="bannericons" src="Images/reply.png">'
                                 .'<HR/></div>';                
                    }
                    
                }else{
                    displayRT($rtFlag, $row, $userID, $interval);
                }
                }else{
                    addReplyToList($replyFlag, $row, $userID, $interval);
                }
                
            }        
    }
    static function searchTweet($txtSearch){
    include_once("connect.php");
    
    $con = mysqli_connect(DB_HOST,DB_USER,DB_PASS, DB_NAME);  
    $txtSearch = mysqli_real_escape_string($con, $txtSearch);
    $sql = "select distinct u.user_id, u.first_name, u.last_name, u.screen_name, u.profile_pic, t.tweet_id, t.tweet_text, t.date_created"
            ." from users u inner join tweets t on u.user_id = t.user_id" 
            ." where t.tweet_text like '%".$txtSearch."%'"
            ." order by t.date_created desc;";
    
    $resultTweets = mysqli_query($con, $sql);
        
            while($row = mysqli_fetch_assoc($resultTweets)){
                
                $dateTweeted = $row["date_created"];
                $tweetTime = new DateTime($dateTweeted);
                $now = new DateTime(); // default to the current timestamp
                
                $interval = $tweetTime -> diff($now);

                if($interval->y > 1){ $interval = $interval->format("%y years ago"); }
                else if($interval ->y > 0){ $interval = $interval->format("%y year ago"); }
                elseif($interval ->m > 1){ $interval = $interval->format("%m months ago");} 
                elseif($interval->m > 0){ $interval = $interval->format("%m month ago"); }
                elseif($interval ->d > 1){ $interval = $interval-> format("%d days ago"); } 
                elseif($interval->d > 0) {$interval = $interval->format("%d day ago"); }
                elseif($interval ->h > 1){ $interval = $interval-> format("%h hours ago"); } 
                elseif($interval->h > 0) {$interval = $interval->format("%h an hour ago"); }
                elseif($interval ->i > 1){ $interval = $interval-> format("%i minutes ago"); } 
                elseif($interval->i > 0) {$interval = $interval->format("%i minute ago"); }
                elseif($interval ->s > 1){ $interval = $interval->format("%s seconds ago"); } 
                else{$interval = $interval->format(" just now"); }
                $user = $row["user_id"];
                $tweetID = $row["tweet_id"];
                $replyFlag = isReply($tweetID);
                $rtFlag = isRetweet($tweetID); 
                
                if($replyFlag == FALSE){
                if($rtFlag == FALSE){
                    if($row["profile_pic"] != null){
                        echo '<div><div class="bold"><img class="bannericons" src="Images/profilepics/'.$row["profile_pic"].'"><a href="userpage.php?user_id='.$row["user_id"].' ">    '
                                . $row["first_name"] .' '
                                .$row["last_name"] .' @'
                                .$row["screen_name"]
                                . '</a></div><br><br>'
                                .$row["tweet_text"]
                                . '<br><br>'
                                . "Posted: ".$interval

                                .'<br><br>';
                         
                                isLiked($tweetID, $user);
                                
                                echo '<a href="retweet.php?tweet_id= '.$row["tweet_id"].'&user_id= '.$row["user_id"].' "><img class="bannericons" src="Images/retweet.png"></a><br><br>'
                               // .' <h6 id="submit_comment_link"><a href="#" ><img onclick="setTweetID('.$row["tweet_id"].')" class="bannericons" src="Images/reply.png"></a></h6>' 
                                .'<div id="'.$row["tweet_id"].'" class="img-rounded"></div>'
                                .'<p id="replies'.$row["tweet_id"].'"><p>'
                                .'<img onclick="javascript:setTweetID('.$row["tweet_id"].')" class="bannericons" src="Images/reply.png">'
                                .'<HR/></div>';

                    }
                    else{

                         echo '<div><div class="bold"><img class="bannericons" src="Images/profilepics/default.jfif"><a href="userpage.php?user_id='.$row["user_id"].' ">  '
                                . $row["first_name"] .' '
                                .$row["last_name"] .' @'
                                .$row["screen_name"]
                                . '</a></div><br><br>'
                                .$row["tweet_text"]
                                . '<br><br>'
                                . "Posted: ".$interval
                                 //Getting an error when I post but if you refresh the page it works fine
                                .'<br><br>';
                         
                                isLiked($tweetID, $user);
                                
                                echo '<a href="retweet.php?tweet_id= '.$row["tweet_id"].'&user_id= '.$row["user_id"].' "><img class="bannericons" src="Images/retweet.png"></a><br><br>'
                                //.' <h6 id="submit_comment_link"><a href="#" ><img onclick="setTweetID('.$row["tweet_id"].')" class="bannericons" src="Images/reply.png"></a></h6>' 
                                 .'<div id="'.$row["tweet_id"].'" class="img-rounded"></div>'
                                 .'<p id="replies'.$row["tweet_id"].'"><p>'
                                 .'<img onclick="javascript:setTweetID('.$row["tweet_id"].')" class="bannericons" src="Images/reply.png">'
                                 .'<HR/></div>';                
                    }
                    
                }else{
                    displayRT($rtFlag, $row, $row["user_id"], $interval);
                }
                }else{
                    addReplyToList($replyFlag, $row, $row["user_id"], $interval);
                }
            }
             if(mysqli_num_rows($resultTweets)==0){ echo "No tweets found at this moment";}
    }   
    static function retweet($tweetID, $user_id){
    
        include_once("connect.php");

        $con = mysqli_connect(DB_HOST,DB_USER,DB_PASS, DB_NAME);

        $sql= "select tweet_text, user_id from tweets where tweet_id = ". $tweetID;
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_array($result);
        
        $tweetText = $row["tweet_text"];
        $originalUserID = $row["user_id"];
        $replyTweetId = 0;
        
        $sql = "insert into tweets(tweet_text, user_id, original_tweet_id, reply_to_tweet_id, date_created) "
              . "values('$tweetText', $user_id, $tweetID, $replyTweetId, NOW());";
        
        mysqli_query($con,$sql);

        if (mysqli_affected_rows($con) ==1) {
            $msg ="Retweeted";
            header("location:index.php?msg=$msg");
        }
        else {
            echo "an error occurred<BR> " . $sql;
        }
        
        
    }
    static function likeTweet($tweetId, $user){
       include_once("connect.php");

        $con = mysqli_connect(DB_HOST,DB_USER,DB_PASS, DB_NAME);
        
        $sql = "insert into likes(tweet_id, user_id, date_created) "
              . "values('$tweetId', $user, NOW());";
        
        mysqli_query($con,$sql);

        if (mysqli_affected_rows($con) ==1) {
            $msg ="Liked";
            header("location:index.php?msg=$msg");
        }
        else {
            echo "an error occurred<BR> " . $sql;
        } 
    }
    
    static function GetNotifications($userID){
     date_default_timezone_set("America/Halifax");
    setlocale(LC_ALL, "en-CA");


    include_once("connect.php");
    
    $con = mysqli_connect(DB_HOST,DB_USER,DB_PASS, DB_NAME);
    
    $sql = "select distinct u.user_id, u.first_name, u.last_name, u.screen_name, u.profile_pic, t.tweet_id, t.tweet_text, t.date_created"
            ." from users u inner join tweets t on u.user_id = t.user_id" 
            ." where t.user_id = ".$userID  
            ." order by t.date_created desc;";
    
    $resultTweets = mysqli_query($con, $sql);
        
            while($row = mysqli_fetch_assoc($resultTweets)){     
                
                    GetRT($row);
                    GetLike($row);
                    GetReply($row);
                
            }   
    }
    function __construct($tweetId, $originalTweetId, $tweetText, $replyToTweetId, $userId, $dateAdded) {
        $this->tweetId = $tweetId;
        $this->originalTweetId = $originalTweetId;
        $this->tweetText = $tweetText;
        $this->replyToTweetId = $replyToTweetId;
        $this->userId = $userId;
        $this->dateAdded = $dateAdded;
    }
    function getTweetId() {
        return $this->tweetId;
    }

    function getOriginalTweetId() {
        return $this->originalTweetId;
    }

    function getTweetText() {
        return $this->tweetText;
    }

    function getReplyToTweetId() {
        return $this->replyToTweetId;
    }

    function getUserId() {
        return $this->userId;
    }

    function getDateAdded() {
        return $this->dateAdded;
    }

    function setTweetId($tweetId) {
        $this->tweetId = $tweetId;
    }

    function setOriginalTweetId($originalTweetId) {
        $this->originalTweetId = $originalTweetId;
    }

    function setTweetText($tweetText) {
        $this->tweetText = $tweetText;
    }

    function setReplyToTweetId($replyToTweetId) {
        $this->replyToTweetId = $replyToTweetId;
    }

    function setUserId($userId) {
        $this->userId = $userId;
    }

    function setDateAdded($dateAdded) {
        $this->dateAdded = $dateAdded;
    }
}
function isReply($tweetID){
        include_once("connect.php");

        $con = mysqli_connect(DB_HOST,DB_USER,DB_PASS, DB_NAME);      
        
        $sql = "select reply_to_tweet_id from tweets where tweet_id = ". $tweetID;
        $result = mysqli_query($con,$sql);
        
        $row = mysqli_fetch_array($result);
        
        if($row["reply_to_tweet_id"] == 0){
 //           echo 'not rt';
           return FALSE;
        }else{
           $oTweetID = $row["reply_to_tweet_id"];
           return $oTweetID;
        }
}
function isRetweet($tweetID){
        include_once("connect.php");

        $con = mysqli_connect(DB_HOST,DB_USER,DB_PASS, DB_NAME);      
        
        $sql = "select original_tweet_id from tweets where tweet_id = ". $tweetID;
        $result = mysqli_query($con,$sql);
        
        $row = mysqli_fetch_array($result);
        
        if($row["original_tweet_id"] == 0){
 //           echo 'not rt';
           return FALSE;
        }else{
           $oTweetID = $row["original_tweet_id"];
           return $oTweetID;
        }
    }
function displayRT($rtFlag, $row, $userID, $interval){
        include_once("connect.php");

        $con = mysqli_connect(DB_HOST,DB_USER,DB_PASS, DB_NAME);  
        
            $sqlRT = "select first_name, last_name, screen_name, profile_pic from users where user_id = (select user_id from tweets where tweet_id = ".$rtFlag.")";
            $resultRT = mysqli_query($con,$sqlRT);
            
            $rowRT = mysqli_fetch_array($resultRT);
            
                    if($rowRT["profile_pic"] != null){
                        echo '<div><div class="bold"><img class="bannericons" src="Images/profilepics/'.$rowRT["profile_pic"].'"><a href="userpage.php?user_id='.$row["user_id"].' ">  '
                                .$rowRT["first_name"] .' '
                                .$rowRT["last_name"] .' @'
                                .$rowRT["screen_name"]
                                .'</a> <b> Retweeted from '
                                . $row["first_name"].' '
                                .$row["last_name"]
                                . '</b></div><br><br>'
                                .$row["tweet_text"]
                                . '<br><br>'
                                . "Retweeted: ".$interval
                                //Getting an error when I post but if you refresh the page it works fine
                                .'<br><br>';
                         
                                isLiked($rtFlag, $userID);
                                
                                echo '<a href="retweet.php?tweet_id= '.$row["tweet_id"].'&user_id= '.$userID.' "><img class="bannericons" src="Images/retweet.png"></a><br><br>'
                                //.' <h6 id="submit_comment_link"><a href="#" ><img onclick="setTweetID('.$row["tweet_id"].')" class="bannericons" src="Images/reply.png"></a></h6>'
                                .'<div id="'.$row["tweet_id"].'" class="img-rounded"></div>'
                                .'<p id="replies'.$row["tweet_id"].'"><p>'
                                .'<img onclick="javascript:setTweetID('.$row["tweet_id"].')" class="bannericons" src="Images/reply.png">'
                                .'<HR/></div>';

                    }
                    else{

                         echo '<div>'
                                . '<div class="bold"><img class="bannericons" src="Images/profilepics/default.jfif"><a href="userpage.php?user_id='.$row["user_id"].' ">  '
                                .$rowRT["first_name"] .' '
                                .$rowRT["last_name"] .' @'
                                .$rowRT["screen_name"]
                                .'</a><b> Retweeted from '
                                . $row["first_name"].' '
                                .$row["last_name"]
                                . '</b></div><br><br>'
                                .$row["tweet_text"]
                                . '<br><br>'
                                . "Retweeted: ".$interval
                                 //Getting an error when I post but if you refresh the page it works fine
                                .'<br><br>';
                         
                                isLiked($rtFlag, $userID);
                                
                                echo '<a href="retweet.php?tweet_id= '.$row["tweet_id"].'&user_id= '.$userID.' "><img class="bannericons" src="Images/retweet.png"></a><br><br>'
                                //.' <h6 id="submit_comment_link"><a href="#" ><img onclick="setTweetID('.$row["tweet_id"].')" class="bannericons" src="Images/reply.png"></a></h6>'
                                 .'<div id="'.$row["tweet_id"].'" class="img-rounded"></div>'
                                 .'<p id="replies'.$row["tweet_id"].'"><p>'
                                 .'<img onclick="javascript:setTweetID('.$row["tweet_id"].')" class="bannericons" src="Images/reply.png">'
                                 .'<HR/></div>';                
                    }                
                
}
function addReplyToList($replyFlag, $row, $userID, $intervalR){
 
    include_once("connect.php");

    $con = mysqli_connect(DB_HOST,DB_USER,DB_PASS, DB_NAME);
    
    $originalSql = "select first_name, last_name, screen_name, profile_pic, t.tweet_id, t.tweet_text, t.date_created"
            ." from users u inner join tweets t on u.user_id = t.user_id where t.tweet_id = ".$replyFlag;  
    
    $resultO = mysqli_query($con,$originalSql);
    
    $oTweet = mysqli_fetch_array($resultO);

                $dateTweeted = $oTweet["date_created"];
                $tweetTime = new DateTime($dateTweeted);
                $now = new DateTime(); // default to the current timestamp
                
                $interval = $tweetTime -> diff($now);

                if($interval->y > 1){ $interval = $interval->format("%y years ago"); }
                else if($interval ->y > 0){ $interval = $interval->format("%y year ago"); }
                elseif($interval ->m > 1){ $interval = $interval->format("%m months ago");} 
                elseif($interval->m > 0){ $interval = $interval->format("%m month ago"); }
                elseif($interval ->d > 1){ $interval = $interval-> format("%d days ago"); } 
                elseif($interval->d > 0) {$interval = $interval->format("%d day ago"); }
                elseif($interval ->h > 1){ $interval = $interval-> format("%h hours ago"); } 
                elseif($interval->h > 0) {$interval = $interval->format("%h an hour ago"); }
                elseif($interval ->i > 1){ $interval = $interval-> format("%i minutes ago"); } 
                elseif($interval->i > 0) {$interval = $interval->format("%i minute ago"); }
                elseif($interval ->s > 1){ $interval = $interval->format("%s seconds ago"); } 
                else{$interval = $interval->format(" just now"); }    
                $tweetID = $row["tweet_id"];
                //$user= $user["user_id"];
             if($row["profile_pic"] != null){
                        echo '<div><div class="bold"><img class="bannericons" src="Images/profilepics/'.$row["profile_pic"].'"><a href="userpage.php?user_id='.$row["user_id"].' ">    '
                                .$row["first_name"] .' '
                                .$row["last_name"] .' @'
                                .$row["screen_name"].'</a><b> Replied:</b></div><br>'
                                .$row["tweet_text"]
                                . '<br><br>'
                                . $intervalR
                                .'<br><br><h6>To '
                                .$oTweet["first_name"] .' '
                                .$oTweet["last_name"] .' @'
                                .$oTweet["screen_name"]
                                . ' post: </h6><br>'
                                .$oTweet["tweet_text"]
                                . '<br><br>';
                         
                                isLiked($tweetID, $userID);
                                
                                echo '<a href="retweet.php?tweet_id= '.$row["tweet_id"].'&user_id= '.$userID.' "><img class="bannericons" src="Images/retweet.png"></a><br><br>' 
                                .'<div id="'.$row["tweet_id"].'" class="img-rounded"></div>'
                                .'<p id="replies'.$row["tweet_id"].'"><p>'
                                .'<img onclick="javascript:setTweetID('.$row["tweet_id"].')" class="bannericons" src="Images/reply.png">'
                                .'<HR/></div>';

                    }
                    else{

                        echo '<div><div class="bold"><img class="bannericons" src="Images/profilepics/default.jfif"><a href="userpage.php?user_id='.$row["user_id"].' ">    '
                                .$row["first_name"] .' '
                                .$row["last_name"] .' @'
                                .$row["screen_name"]. '</a><b> Replied:</b><br>'
                                .$row["tweet_text"]
                                . '<br><br>'
                                . $intervalR
                                .'<br><br><h6>To '
                                .$oTweet["first_name"] .' '
                                .$oTweet["last_name"] .' @'
                                .$oTweet["screen_name"]
                                . ' post: </h6><br>'
                                .$oTweet["tweet_text"]
                                . '<br><br>'
                                . 'Posted: '.$interval;
                         
                                isLiked($tweetID, $userID);
                                
                                echo '<a href="retweet.php?tweet_id= '.$row["tweet_id"].'&user_id= '.$userID.' "><img class="bannericons" src="Images/retweet.png"></a><br><br>' 
                                .'<div id="'.$row["tweet_id"].'" class="img-rounded"></div>'
                                .'<p id="replies'.$row["tweet_id"].'"><p>'
                                .'<img onclick="javascript:setTweetID('.$row["tweet_id"].')" class="bannericons" src="Images/reply.png">'
                                .'<HR/></div>';            
                    }    
    
}
function isLiked($tweetID, $user){
        $sql = 'select like_id, tweet_id, user_id, date_created from likes where tweet_id='.$tweetID.' and user_id='.$user;
        include_once("connect.php");
        $con = mysqli_connect(DB_HOST,DB_USER,DB_PASS, DB_NAME);
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_array($result);

        if($row["user_id"] == null){
            echo '<a href="LikeTweet.php?tweet_id= '.$tweetID.'&user_id= '.$user.'"><img class="bannericons" src="Images/like.ico"></a>    ';
        }else{
            echo '<img class="bannericons" src="Images/liked.png">   ';
        }
}
function GetRT($row){
        include_once("connect.php");

        $con = mysqli_connect(DB_HOST,DB_USER,DB_PASS, DB_NAME);  
        
            $sqlRT = "select * from tweets where original_tweet_id =". $row["tweet_id"].";";
            $resultRT = mysqli_query($con,$sqlRT);
            
            
            $set = mysqli_num_rows($resultRT);
            if($set == 0){return true;}
            
            while($rowRT = mysqli_fetch_array($resultRT)){
                $sql = "select user_id, first_name, last_name, screen_name, profile_pic from users where user_id =". $rowRT["user_id"].";";
                $ResultDisplay = mysqli_query($con, $sql);
                $display = mysqli_fetch_array($ResultDisplay);
                $dateTweeted = $rowRT["date_created"];
                $tweetTime = new DateTime($dateTweeted);
                $now = new DateTime(); // default to the current timestamp
                
                $interval = $tweetTime -> diff($now);

                if($interval->y > 1){ $interval = $interval->format("%y years ago"); }
                else if($interval ->y > 0){ $interval = $interval->format("%y year ago"); }
                elseif($interval ->m > 1){ $interval = $interval->format("%m months ago");} 
                elseif($interval->m > 0){ $interval = $interval->format("%m month ago"); }
                elseif($interval ->d > 1){ $interval = $interval-> format("%d days ago"); } 
                elseif($interval->d > 0) {$interval = $interval->format("%d day ago"); }
                elseif($interval ->h > 1){ $interval = $interval-> format("%h hours ago"); } 
                elseif($interval->h > 0) {$interval = $interval->format("%h hour ago"); }
                elseif($interval ->i > 1){ $interval = $interval-> format("%i minutes ago"); } 
                elseif($interval->i > 0) {$interval = $interval->format("%i minute ago"); }
                elseif($interval ->s > 1){ $interval = $interval->format("%s seconds ago"); } 
                else{$interval = $interval->format(" just now"); }
                if($display["profile_pic"] != null){
                        echo '<div><div class="bold"><img class="bannericons" src="Images/profilepics/'.$display["profile_pic"].'"><a href="userpage.php?user_id='.$display["user_id"].' ">  '
                                .$display["first_name"] .' '
                                .$display["last_name"] .'</a> retweeted your tweet '.$interval
                                .'<br> <b> Retweeted from '
                                . $row["first_name"].' '
                                .$row["last_name"]
                                . '</b></div><br><br>'
                                .$row["tweet_text"]
                                .'<br><br>';
                                echo '<HR/></div>';

                    }
                    else{

                         echo '<div>'
                                . '<div class="bold"><img class="bannericons" src="Images/profilepics/default.jfif"><a href="userpage.php?user_id='.$display["user_id"].' ">  '
                                .$display["first_name"] .' '
                                .$display["last_name"] .'</a> retweeted your tweet '.$interval
                                .'<br><b> Retweeted from '
                                . $row["first_name"].' '
                                .$row["last_name"]
                                . '</b></div><br><br>'
                                .$row["tweet_text"]
                                . '<br><br>';
                                echo '<HR/></div>';                
                    }
            }                
                
}
function GetLike($row){
        $sql = 'select like_id, tweet_id, user_id, date_created from likes where tweet_id='.$row["tweet_id"];
        include_once("connect.php");
        $con = mysqli_connect(DB_HOST,DB_USER,DB_PASS, DB_NAME);
        $result = mysqli_query($con, $sql);
        $set = mysqli_num_rows($result);
        if($set == 0){return true;}
        
        while($rowLike = mysqli_fetch_array($result)){
            $sqlLike = "select user_id, first_name, last_name, screen_name, profile_pic from users where user_id =". $rowLike["user_id"].";";
                $ResultDisplay = mysqli_query($con, $sqlLike);
                $display = mysqli_fetch_array($ResultDisplay);
                $dateTweeted = $rowLike["date_created"];
                $tweetTime = new DateTime($dateTweeted);
                $now = new DateTime(); // default to the current timestamp
                
                $interval = $tweetTime -> diff($now);

                if($interval->y > 1){ $interval = $interval->format("%y years ago"); }
                else if($interval ->y > 0){ $interval = $interval->format("%y year ago"); }
                elseif($interval ->m > 1){ $interval = $interval->format("%m months ago");} 
                elseif($interval->m > 0){ $interval = $interval->format("%m month ago"); }
                elseif($interval ->d > 1){ $interval = $interval-> format("%d days ago"); } 
                elseif($interval->d > 0) {$interval = $interval->format("%d day ago"); }
                elseif($interval ->h > 1){ $interval = $interval-> format("%h hours ago"); } 
                elseif($interval->h > 0) {$interval = $interval->format("%h hour ago"); }
                elseif($interval ->i > 1){ $interval = $interval-> format("%i minutes ago"); } 
                elseif($interval->i > 0) {$interval = $interval->format("%i minute ago"); }
                elseif($interval ->s > 1){ $interval = $interval->format("%s seconds ago"); } 
                else{$interval = $interval->format(" just now"); }
                if($display["profile_pic"] != null){
                        echo '<div><div class="bold"><img class="bannericons" src="Images/profilepics/'.$display["profile_pic"].'"><a href="userpage.php?user_id='.$display["user_id"].' ">  '
                                .$display["first_name"] .' '
                                .$display["last_name"] .'</a> liked your tweet '.$interval
                                .'<br> <b> Retweeted from '
                                . $row["first_name"].' '
                                .$row["last_name"]
                                . '</b></div><br><br>'
                                .$row["tweet_text"]
                                .'<br><br>';
                                echo '<HR/></div>';

                    }
                    else{

                         echo '<div>'
                                . '<div class="bold"><img class="bannericons" src="Images/profilepics/default.jfif"><a href="userpage.php?user_id='.$display["user_id"].' ">  '
                                .$display["first_name"] .' '
                                .$display["last_name"] .'</a> liked your tweet '.$interval
                                .'<br><b> Retweeted from '
                                . $row["first_name"].' '
                                .$row["last_name"]
                                . '</b></div><br><br>'
                                .$row["tweet_text"]
                                . '<br><br>';
                                echo '<HR/></div>';                
                    }
        }
}
function GetReply($row){
 
    include_once("connect.php");

    $con = mysqli_connect(DB_HOST,DB_USER,DB_PASS, DB_NAME);
    
    $originalSql = "select * from tweets where reply_to_tweet_id = ". $row["tweet_id"];
    
    $resultO = mysqli_query($con,$originalSql);
    $set = mysqli_num_rows($resultO);
    if($set == 0){return true;}
    
    while($oTweet = mysqli_fetch_array($resultO)){
                $sql = "select user_id, first_name, last_name, screen_name, profile_pic from users where user_id =". $oTweet["user_id"].";";
                $ResultDisplay = mysqli_query($con, $sql);
                $display = mysqli_fetch_array($ResultDisplay);
                $dateTweeted = $oTweet["date_created"];
                $tweetTime = new DateTime($dateTweeted);
                $now = new DateTime(); // default to the current timestamp
                
                $interval = $tweetTime -> diff($now);

                if($interval->y > 1){ $interval = $interval->format("%y years ago"); }
                else if($interval ->y > 0){ $interval = $interval->format("%y year ago"); }
                elseif($interval ->m > 1){ $interval = $interval->format("%m months ago");} 
                elseif($interval->m > 0){ $interval = $interval->format("%m month ago"); }
                elseif($interval ->d > 1){ $interval = $interval-> format("%d days ago"); } 
                elseif($interval->d > 0) {$interval = $interval->format("%d day ago"); }
                elseif($interval ->h > 1){ $interval = $interval-> format("%h hours ago"); } 
                elseif($interval->h > 0) {$interval = $interval->format("%h an hour ago"); }
                elseif($interval ->i > 1){ $interval = $interval-> format("%i minutes ago"); } 
                elseif($interval->i > 0) {$interval = $interval->format("%i minute ago"); }
                elseif($interval ->s > 1){ $interval = $interval->format("%s seconds ago"); } 
                else{$interval = $interval->format(" just now"); }    
                $tweetID = $row["tweet_id"];
                
             if($row["profile_pic"] != null){
                        echo '<div><div class="bold"><img class="bannericons" src="Images/profilepics/'.$display["profile_pic"].'"><a href="userpage.php?user_id='.$display["user_id"].' ">    '
                                .$display["first_name"] .' '
                                .$display["last_name"] .'</a> replied to your tweet '.$interval
                                .'<br><b> Replied:</b></div><br>'
                                .$oTweet["tweet_text"]
                                .'<br><br><h6>To your tweet:'
                                . '</h6><br>'
                                .$row["tweet_text"]
                                . '<br>';
                                echo '<HR/></div>';

                    }
                    else{

                        echo '<div><div class="bold"><img class="bannericons" src="Images/profilepics/default.jfif"><a href="userpage.php?user_id='.$row["user_id"].' ">    '
                                .$display["first_name"] .' '
                                .$display["last_name"] .'</a> replied to your tweet '.$interval
                                .'<br><b> Replied:</b></div><br>'
                                .$oTweet["tweet_text"]
                                .'<br><h6>To your tweet:'
                                . '</h6><br>'
                                .$row["tweet_text"]
                                . '<br>';
                                echo '<HR/></div>';            
                    }
    }    
}