<?php
//session_start();

class User {
    private $userId;
    private $userName;
    private $password;
    private $firstName;
    private $lastName;
    private $address;
    private $province;
    private $postalCode;
    private $contactNo;
    private $email;
    private $dateAdded;
    private $profImage;
    private $location;
    private $description;
    private $url;
    
    function __construct($userName, $password, $firstName, $lastName, $address, $provice, $postalCode, $contactNo, $email, $dateAdded, $profImage, $location, $description, $url) {
        
        $this->userName = $userName;
        $this->password = $password;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->address = $address;
        $this->province = $provice;
        $this->postalCode = $postalCode;
        $this->contactNo = $contactNo;
        $this->email = $email;
        $this->dateAdded = $dateAdded;
        $this->profImage = $profImage;
        $this->location = $location;
        $this->description = $description;
        $this->url = $url;
    }
    
    // this function is working propperly signUp proc is DONE
    static function registerNewUser($fname, $lname, $email, $username, $password, $phone, $address, $province, $postalCode, 
            $url, $desc, $location){
        
            include_once("connect.php");
            $con = mysqli_connect(DB_HOST,DB_USER,DB_PASS, DB_NAME);  
            $desc = mysqli_real_escape_string($con, $desc);
            $sql = "INSERT INTO users(`first_name`,`last_name`,`screen_name`,
            `password`,`address`,`province`,`postal_code`,`contact_number`,`email`,`url`,`description`,
            `location`,`date_created`,`profile_pic`)
                    VALUES('$fname', '$lname', '$username', '$password', '$address', '$province', '$postalCode','$phone', "
            . "'$email','$url','$desc', '$location', NOW(),null);";
    
            mysqli_query($con, $sql);
    
            if (mysqli_affected_rows($con) == 1) {

                $msg ="Your Account have been created successfully";
                header("location:login.php?msg=$msg");
            }
            else {
                echo "an error occurred<BR> " . $sql . "<BR>" . mysqli_error($con) ;
            }
    }
    static function getUser($userID){
        
        include_once("connect.php"); 
        $con = mysqli_connect(DB_HOST,DB_USER,DB_PASS, DB_NAME);
        
        $sql = " select first_name, last_name, province, location, date_created, (select count(tweet_id) from tweets t where t.user_id = u.user_id) as tweets, "
                ."(select count(to_id) from follows f where f.from_id = u.user_id) as following, "
                ."(select count(from_id) from follows fo where fo.to_id= u.user_id) as followers from users u where u.user_id = ".$userID;
        
        $result = mysqli_query($con, $sql);
        
        $row = mysqli_fetch_array($result);
        
        return $row;
    }
    static function getFollowers($userID){
        include_once("connect.php"); 
        $con = mysqli_connect(DB_HOST,DB_USER,DB_PASS, DB_NAME);
        
         $sql = 'select u.user_id, u.first_name, u.last_name, u.screen_name, u.profile_pic '
                 .'from users u where u.user_id in (select to_id from follows where from_id = '.$userID.') ORDER BY RAND() LIMIT 3';
         
        $result = mysqli_query($con, $sql);
        $followers = mysqli_num_rows($result);
        
	echo'<div class="bold">'.$followers.' &nbsp;Followers you know<BR></div>';
        
        while($row = mysqli_fetch_array($result)){
                if($row["profile_pic"] != null){
                    echo '<div><img class="bannericons" src="Images/profilepics/'.$row["profile_pic"].'">
                          <a href="userpage.php?user_id='.$row["user_id"].'&fullname='.$row["first_name"].' '.$row["last_name"].'">' 
                                                            .$row["first_name"]
                                                        .' '.$row["last_name"] 
                                                        .' @'.$row["screen_name"]
                                                        . '</a><HR/></div>';
                }
                else{
                    echo'<div><img class="bannericons" src="Images/profilepics/default.jfif">
                          <a href="userpage.php?user_id='.$row["user_id"].'&fullname='.$row["first_name"].' '.$row["last_name"].'">'
                                                            .$row["first_name"]
                                                        .' '.$row["last_name"] 
                                                        .' @'.$row["screen_name"]
                                                        . '</a><HR/></div>';
                }            
        }         
        
    }

    // THIS FUNCTION IS WORKING FINE. LOG IN PROC IS DONE
    static function logInUser($user, $pass){
        
        include_once("connect.php"); 
        $con = mysqli_connect(DB_HOST,DB_USER,DB_PASS, DB_NAME);
        
        $sql = "select * from users where screen_name = '$user';";

        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_array($result);
        
        if(mysqli_num_rows($result) == 1 && password_verify($pass, $row['password'])){
            return $row;
        }else{
            return false;
        }        
    }
    static function searchUser($txtSearch, $cUser){
        include_once("connect.php");
        $con = mysqli_connect(DB_HOST,DB_USER,DB_PASS, DB_NAME);
         $txtSearch = mysqli_real_escape_string($con, $txtSearch);
        $sql= "select user_id, first_name, last_name, screen_name, profile_pic from users where screen_name like '%".$txtSearch."%'";
        
        $result = mysqli_query($con, $sql);
        
        while($row = mysqli_fetch_array($result)){
           $userID = $row["user_id"];
            if($userID != $cUser){ 
            if($row["profile_pic"] != null){               
                echo '<div><img class="bannericons" src="Images/profilepics/'.$row["profile_pic"].'"><a href="userpage.php?user_id='.$row["user_id"].'">   '
                        .$row["first_name"]. ' '
                        .$row["last_name"]. ' '
                        .$row["screen_name"]. '</a>   '
                        .'<a href="Follow_proc.php?user_id='.$row["user_id"].'&fullname='.$row["first_name"].' '.$row["last_name"].'">';
                isFollowed($userID,$cUser);
                        
                isFollower($userID, $cUser);
                       echo '<hr></div>';
            }else{
                echo '<div><img class="bannericons" src="Images/profilepics/default.jfif"><a href="userpage.php?user_id='.$row["user_id"].'">   '
                        .$row["first_name"]. ' '
                        .$row["last_name"]. ' '
                        .$row["screen_name"]. '</a>   '
                        .'<a href="Follow_proc.php?user_id='.$row["user_id"].'&fullname='.$row["first_name"].' '.$row["last_name"].'">';
                isFollowed($userID, $cUser);
                
                isFollower($userID, $cUser);
                        echo'<hr></div>';
            }
          }  
        }
        if(mysqli_num_rows($result)==0){ echo "No users found at this moment";}
    }

    static function updateProfilePic($file, $userID){
        include_once("connect.php");
        $con = mysqli_connect(DB_HOST,DB_USER,DB_PASS, DB_NAME);
              
            $sqlStr = 'UPDATE users SET profile_pic = "' . $file . '" WHERE user_id = "' . $userID . '";';
            $result = mysqli_query($con, $sqlStr);
            header('location:index.php');        
    }
    // THIS FUNCTION IS WORKING 1/2 FOR INDEX PAGE
    static function getSuggestions($userID){
        
        include_once("connect.php");    
        
        $con = mysqli_connect(DB_HOST,DB_USER,DB_PASS, DB_NAME);
        
	$sql = "SELECT user_id,first_name,last_name,screen_name,profile_pic "
        . "FROM users WHERE user_id <> ".$userID." AND user_id NOT IN "
        . "(SELECT to_id FROM follows WHERE from_id = ".$userID.") "
        . "ORDER BY RAND() LIMIT 3";
                                
        $result = mysqli_query($con, $sql);

        
        while($row = mysqli_fetch_array($result)){
            
                if($row["profile_pic"] != null){
                    echo '<div><img class="bannericons" src="Images/profilepics/'.$row["profile_pic"].'">
                          <a href="userpage.php?user_id='.$row["user_id"].'">' 
                                                            .$row["first_name"]
                                                        .' '.$row["last_name"] 
                                                        .' @'.$row["screen_name"]
                                                        .'</a><br><a href="Follow_proc.php?user_id='.$row["user_id"].'&fullname='.$row["first_name"].' '.$row["last_name"].'"><button class="followbutton" id=button>Follow</button>'
                                                        . '</a><HR/></div>';
                }
                else{
                    echo'<div><img class="bannericons" src="Images/profilepics/default.jfif">
                          <a href="userpage.php?user_id='.$row["user_id"].'">'
                                                            .$row["first_name"]
                                                        .' '.$row["last_name"] 
                                                        .' @'.$row["screen_name"]
                                                        .'</a><br><a href="Follow_proc.php?user_id='.$row["user_id"].'&fullname='.$row["first_name"].' '.$row["last_name"].'"><button class="followbutton" id=button>Follow</button>'
                                                        . '</a><HR/></div>';
                }
                
                 }
        
        if(mysqli_num_rows($result)==0){ echo "No users to follow at this time";}
        
    }
    // THIS FUNCTION IS WORKING 2/2 FOR INDEX PAGE
    static function checkPicture($userID){
        include_once("connect.php"); 
        $con = mysqli_connect(DB_HOST,DB_USER,DB_PASS, DB_NAME);

        $sql = "select profile_pic from users where user_id = ".$userID;

        $result = mysqli_query($con, $sql);

        $row = mysqli_fetch_array($result);

        if($row["profile_pic"] == NULL){

            return false;
        }else{

            return $row["profile_pic"];
        }
    }
    // THIS FUNCTION IS WORKING
    static function follow($user, $from, $fullName){
        include("connect.php");

        $sql = 'insert into follows(from_id, to_id) values('.$from. ',' . $user . ');';

        mysqli_query($con, $sql);

        if(mysqli_affected_rows($con) == 1){
            $msg = "Following user ".$fullName;
        }
        else{
            echo "an error occurred<BR> " . $sql . "<BR>" . mysqli_error($con);
        }
        header("location:index.php?msg=$msg");
    }
    
    static function GettAllMessages($user){
       include_once("connect.php"); 
        $con = mysqli_connect(DB_HOST,DB_USER,DB_PASS, DB_NAME);
        
         $sql = "select from_id, message_text, date_sent from messages where to_id = $user order by message_text desc;";
         
        $result = mysqli_query($con, $sql);
        $messages = mysqli_num_rows($result);
        
        if($messages == 0){echo "you don't have any messages at this point";}
        while($row = mysqli_fetch_array($result)){
            $ID = $row["from_id"];
            $sql2 = "select user_id, first_name, last_name, screen_name, profile_pic from users where user_id = $ID;";
            $result2 = mysqli_query($con, $sql2);
            $row2=mysqli_fetch_array($result2);
            
                if($row2["profile_pic"] != null){
                    echo '<div><img class="bannericons" src="Images/profilepics/'.$row2["profile_pic"].'">
                          <a href="userpage.php?user_id='.$row2["user_id"].'&fullname='.$row2["first_name"].' '.$row2["last_name"].'">' 
                                                            .$row2["first_name"]
                                                        .' '.$row2["last_name"] 
                                                        .' @'.$row2["screen_name"]
                                                        .'</a><br><div class="center">'
                                                        .$row["message_text"]
                                                        . '</div><HR/></div>';
                }
                else{
                    echo'<div><img class="bannericons" src="Images/profilepics/default.jfif">
                          <a href="userpage.php?user_id='.$row2["user_id"].'&fullname='.$row2["first_name"].' '.$row2["last_name"].'">'
                                                            .$row2["first_name"]
                                                        .' '.$row2["last_name"] 
                                                        .' @'.$row2["screen_name"]
                                                        .'</a><br><div>'
                                                        .$row["message_text"]
                                                        . '</div><HR/></div>';
                }            
        } 
    }
    static function AddMessage($user, $toUserID, $text){
            include_once("connect.php");
            $con = mysqli_connect(DB_HOST,DB_USER,DB_PASS, DB_NAME);  
            $textEscaped = mysqli_real_escape_string($con, $text);
            $toID = GetUserByScreenName($toUserID);
            echo $toUserID . "<br>";
            echo $toID;
            if($toID !== 0){
            $sql = "INSERT INTO messages(`from_id`,`to_id`, `message_text`,`date_sent`) VALUES($user, $toID,'$textEscaped', NOW());";
            
            mysqli_query($con, $sql);
    
            if (mysqli_affected_rows($con) == 1) {

                $msg ="Your Message was sent";
                header("location:DirectMessage.php?msg=$msg");
            }
            else {
                echo "an error occurred<BR> " . $sql . "<BR>" . mysqli_error($con) ;
            }
            }else{
                $msg ="We could not send your message. Please try again later";
                //header("location:index.php?msg=$msg");
            }
    }

    static function GetUsers($txtScreen, $userID){
        include_once("connect.php"); 
        $con = mysqli_connect(DB_HOST,DB_USER,DB_PASS, DB_NAME);
        
         $sql = "select u.user_id, u.first_name, u.last_name, u.screen_name, u.profile_pic "
                 ."from users u where u.screen_name like '%".$txtScreen."%' and u.user_id in (select to_id from follows where from_id = $userID)";
        
        
        $result = mysqli_query($con, $sql);
        
        $json_out ='{"users":[';
        
        
        
        $i=1;
        $lastRow = mysqli_num_rows($result);
        
        while($row = mysqli_fetch_array($result)){
            
            if($i != $lastRow){
                
                $json_out .= '{"id":'.$row["user_id"].', "name":"'.$row["screen_name"].'"},';
            }
            if($i == $lastRow){
                $json_out .= '{"id":'.$row["user_id"].', "name":"'.$row["screen_name"].'"}';
            }
            $i++;
        }
        
        $json_out .= ']}';
        echo $json_out;
    }
    function __destruct(){
        echo '<p>User class instance destroyed</p>';
    }
    
    function getUserId() {
        return $this->userId;
    }

    function getUserName() {
        return $this->userName;
    }

    function getPassword() {
        return $this->password;
    }

    function getFirstName() {
        return $this->firstName;
    }

    function getLastName() {
        return $this->lastName;
    }

    function getAddress() {
        return $this->address;
    }

    function getProvince() {
        return $this->province;
    }

    function getPostalCode() {
        return $this->postalCode;
    }

    function getContactNo() {
        return $this->contactNo;
    }

    function getEmail() {
        return $this->email;
    }

    function getDateAdded() {
        return $this->dateAdded;
    }

    function getProfImage() {
        return $this->profImage;
    }

    function getLocation() {
        return $this->location;
    }

    function getDescription() {
        return $this->description;
    }

    function getUrl() {
        return $this->url;
    }

    function setUserId($userId) {
        $this->userId = $userId;
    }

    function setUserName($userName) {
        $this->userName = $userName;
    }

    function setPassword($password) {
        $this->password = $password;
    }

    function setFirstName($firstName) {
        $this->firstName = $firstName;
    }

    function setLastName($lastName) {
        $this->lastName = $lastName;
    }

    function setAddress($address) {
        $this->address = $address;
    }

    function setProvice($provice) {
        $this->province = $provice;
    }

    function setPostalCode($postalCode) {
        $this->postalCode = $postalCode;
    }

    function setContactNo($contactNo) {
        $this->contactNo = $contactNo;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setDateAdded($dateAdded) {
        $this->dateAdded = $dateAdded;
    }

    function setProfImage($profImage) {
        $this->profImage = $profImage;
    }

    function setLocation($location) {
        $this->location = $location;
    }

    function setDescription($description) {
        $this->description = $description;
    }

    function setUrl($url) {
        $this->url = $url;
    }


}
function isFollower($userID, $cUser){
    
        $sql = 'select from_id as followers from follows where to_id='.$cUser;
        include_once("connect.php");
        $con = mysqli_connect(DB_HOST,DB_USER,DB_PASS, DB_NAME);
        $result = mysqli_query($con, $sql);
        

        while($row = mysqli_fetch_array($result)){
            if($userID == $row["followers"]){
                echo '  | follows you';                
            }
        }
        
        
}
function isFollowed($userID, $cUser){
        $sql = ' select to_id as following from follows where from_id ='.$cUser;
        
        include_once("connect.php");
        $con = mysqli_connect(DB_HOST,DB_USER,DB_PASS, DB_NAME);
        $result = mysqli_query($con, $sql);
        $found = false;

        while($row = mysqli_fetch_array($result)){
            if($userID == $row["following"]){
                $found = true;
                echo '</a>  | following';                
            }
        }
        if($found == false){
            echo '<button class="followbutton" id=button>Follow</button></a>';
        }
}
function GetUserByScreenName($screenName){
        include_once("connect.php"); 
        $con = mysqli_connect(DB_HOST,DB_USER,DB_PASS, DB_NAME);
        
         $sql = "select u.user_id from users u where u.screen_name = '$screenName'";
         echo $sql;
        $result = mysqli_query($con, $sql);
       // $user = mysqli_num_rows($result);
        
        $row = mysqli_fetch_array($result);
        
        if($row["user_id"] !== null){
            return $row["user_id"];
        }else{
            return 0;
        }
}