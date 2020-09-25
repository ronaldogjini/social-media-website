<?php
include('Classes/header.php');

// =======================  Shows information about the user ========================================================== 
if (isset($_GET['id'])) {

    $currentID = $_GET['id'];
    $checkValidUser = $conn->query("select * from users where user_id = '$currentID' ");
    if (mysqli_num_rows($checkValidUser) > 0) {
        $query = mysqli_query($conn, "select * from users where user_id = '$currentID'");
        $user = mysqli_fetch_array($query);
    
        $profilename = $user['first_name'];
        $profileemail = $user['email'];
        $profileid = $user['user_id'];
        $profileusername = $user['username'];
        $profilesurname = $user['last_name'];
        $profilecountry = $user['country'];
        $profilegender = $user['gender'];
        $profilebirthday = $user['birthday'];
        $profilejoined = $user['date_joined'];
        $profileprofile = $user['profile_img'];
        $profiledescription = $user['description'];

    }
    else {
        header("Location:profile.php?id=$loggedID");
    }
  
        if( isset($_POST['followUser']))  {       
            $conn->query("INSERT INTO followers (follower_id, followed_id)  values('$loggedID' , '$profileid')"); 
        }
        
        if( isset($_POST['unfollowUser']))  {       
            $conn->query("DELETE FROM followers WHERE follower_id = '$loggedID' and followed_id = '$profileid'"); 
        }   
}
else {
      echo "<script>window.open('profile.php?id=$loggedID', '_self')</script>";
}

// =======================  likes a post  ========================================================== 
if(isset($_GET['postid'])) {
    if(isset($_POST['like'])) {
        $likedpostid = $_GET['postid'];
                
        $likesquery = $conn->query("SELECT * FROM post_likes_list where user_id='$loggedID' AND post_id = '$likedpostid'");
                
        if (!$likesquery->num_rows > 0) {        
            $conn->query("UPDATE posts SET likes = likes + 1 where post_id = '$likedpostid' "); 
            $conn->query("INSERT INTO post_likes_list (user_id, post_id) values('$loggedID', '$likedpostid')"); 
        }
        else {
            $conn->query("UPDATE posts SET likes = likes - 1 where post_id = '$likedpostid' ");
            $conn->query("DELETE FROM post_likes_list WHERE user_id = '$loggedID' and post_id = '$likedpostid'");
        }
    }         
}

// =======================  changes photo ========================================================== 
if(isset($_POST['changePhoto'])) {
    $uploaded_image = $_FILES['profileSelector']['name'];
    $image_tmp =  $_FILES['profileSelector']['tmp_name'];
    $randnumber = rand(1, 1000);
    
    if (strlen($uploaded_image) >= 1 )  {
        move_uploaded_file($image_tmp, "img/profile/$randnumber.$uploaded_image");
        $conn->query("UPDATE users SET profile_img = 'img/profile/$randnumber.$uploaded_image' where user_id = '$loggedID'");   
    }


}


// =======================  publishing a post ========================================================== 

        if(isset($_POST['publishPost'])) {

            $post_text = mysqli_real_escape_string ( $conn , $_POST ['postcontent']);
            $uploaded_image = $_FILES['uploadimage']['name'];
            $image_tmp =  $_FILES['uploadimage']['tmp_name'];
            $randnumber = rand(1, 1000);           
       
        if (strlen($post_text) < 1 && strlen($uploaded_image) < 1 ) {
                die("NOT WORKING");
            }
        else if (strlen($post_text) >= 1 && strlen($uploaded_image) < 1 ) {
             $conn->query("INSERT INTO posts (user_id, post_text) values('$loggedID', '$post_text')");          
        }
        else if (strlen($post_text) < 1 && strlen($uploaded_image) >= 1 )  {
            move_uploaded_file($image_tmp, "img/posts/$randnumber.$uploaded_image");
             $conn->query("INSERT INTO posts (user_id, post_text, photo) values('$loggedID', ' ', '$randnumber.$uploaded_image')");
        }
        else if (strlen($post_text) >= 1 && strlen($uploaded_image) >= 1 )  {
            move_uploaded_file($image_tmp, "img/posts/$randnumber.$uploaded_image");
            $conn->query("INSERT INTO posts (user_id, post_text, photo) values('$loggedID', '$post_text', '$randnumber.$uploaded_image')");
        }
  
        } 
   
// =======================  commenting on a post ==========================================================       
                
                if(isset($_POST['comment'])) {
                
                $commentpostid = $_GET['postid'];
                $commentcontent = mysqli_real_escape_string ( $conn , $_POST['commentcontent']);
                if ($commentcontent != '') {
                    $conn->query("INSERT INTO comments (user_id, post_id, comment_text) values('$loggedID', '$commentpostid', '$commentcontent')"); 
                }
                
            }

function showPostsProfile($profileid) {
        global $conn;
        $allposts = $conn->query("SELECT * from posts where user_id = '$profileid' ORDER BY published_date DESC");
        
        foreach ($allposts as $post) {
            $content = $post['post_text'];
            $timepublished = $post['published_date'];
            $postimage = $post['photo'];
            $currentpostid = $post['post_id'];
            $postlikes = $post['likes'];
            $posterid = $post['user_id'];
            
            $datapost = $conn->query("SELECT first_name, last_name, profile_img from users where user_id = '$posterid'");
            $poster = $datapost->fetch_assoc();
            $postername = $poster['first_name'];
            $postersurname = $poster['last_name'];
            $posterimage = $poster['profile_img'];
        
        echo "<div class='profile_post_box'>"
                . "<div class='profile_post_poster'>"
                    ."<img style='height:40px; width:40px; border-radius: 50%;' src='$posterimage'>$postername $postersurname"
                . "</div>"
                . "<div class='profile_post_date'>"
                    . "$timepublished"
                . "</div>"
                . "<div class='profile_post_content'>"
                    ."$content"
                . "</div>";

        if ($postimage != null) {
            echo "<div class='profile_post_image'>"
                    . "<img style='height: 300px;' src='img\posts\\$postimage'>"
                . "</div>";
        }  
            
        echo    "<form action='homepage.php?postid=$currentpostid' method='POST'>"
                . "</form>"     
               . "<div class='profile_post_like_button'>"
                    . "<form action='profile.php?id=$posterid&postid=$currentpostid' method='POST'>"
                        . "<input type='submit' name='like' value='Like $postlikes'>"
                    . "</form>"
                . "</div>";
        
            echo "<div>"
                    . "<form class='profile_post_comment_button' action='profile.php?id=$posterid&postid=$currentpostid' method='POST'>"
                        . "<textarea name='commentcontent' rows='3' cols='50' placeholder='Write a comment...'></textarea>"
                        . "<input style='display: block;' type='submit' name='comment' value='Comment'>"
                    ."</form"
               ."</div>";
            
        $allcomments = $conn->query("SELECT * from comments where post_id = '$currentpostid'");
        
        showPostComments($allcomments);
                        
        echo "</div>";    
        echo "</div>";
  
    }
}

function showPostComments($allcomments) {
    global $conn;
           foreach ($allcomments as $comment) {
            $msgcontent = $comment['comment_text'];
            $msgtimepublished = $comment['post_date'];
            $msguserid = $comment['user_id'];
           // $currentpostid = $post['post_id'];
            
            $msgdatapost = $conn->query("SELECT first_name, last_name, profile_img from users where user_id = '$msguserid'");
            $msgposter = $msgdatapost->fetch_assoc();
            $msgpostername = $msgposter['first_name'];
            $msgpostersurname = $msgposter['last_name'];
            $msgposterprofile = $msgposter['profile_img'];
        
     
                echo "<div class='comments'>"
                        ."<div class='commenter_name'><img style='height:20px; border-radius: 50%;' src='$msgposterprofile'>"
                            . "$msgpostername"
                        . "</div>"
                        ."<div class='comment_inside'>"
                            . "$msgcontent"
                        . "</div>"                        
                    . "</div>";
        } 
}
