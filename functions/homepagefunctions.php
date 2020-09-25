<?php

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
            echo "<script>window.open('homepage.php', '_self')</script>";
        }
    }
    
// =======================  liking a post ==========================================================       
                
      if(isset($_POST['like'])) {
        $likedpostid = $_GET['postid'];
                
        $likesquery = $conn->query("SELECT * FROM post_likes_list where user_id='$loggedID' AND post_id = '$likedpostid'");
                
        if (!$likesquery->num_rows > 0) {        
            $conn->query("UPDATE posts SET likes = likes + 1 where post_id = '$likedpostid' "); 
            $conn->query("INSERT INTO post_likes_list (user_id, post_id) values('$loggedID', '$likedpostid')"); 
            echo "<script>window.open('homepage.php', '_self')</script>";
        }
        else {
            $conn->query("UPDATE posts SET likes = likes - 1 where post_id = '$likedpostid' ");
            $conn->query("DELETE FROM post_likes_list WHERE user_id = '$loggedID' and post_id = '$likedpostid'");
            echo "<script>window.open('homepage.php', '_self')</script>";
        }
    }



            
function showPostsHomepage(){
    
    global $conn;
    global $loggedID;
    $allposts = $conn->query("SELECT  post_text, published_date, photo, post_id, likes, user_id from posts join followers on user_id = followed_id where follower_id = '$loggedID' union select  post_text, published_date, photo, post_id, likes, user_id from posts where user_id ='$loggedID' ORDER BY published_date DESC");
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
        $profileprofile = $poster['profile_img'];

        
        echo "<div class='profile_post_box'>"
                . "<div class='profile_post_poster'>"
                    ."<img style='height:40px; width: 40px; border-radius: 50%;' src='$profileprofile'><a href='profile.php?id=$posterid'>$postername $postersurname</a>"
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
        
        echo      "<form action='homepage.php?postid=$currentpostid' method='POST'>"
                    . "</form>"     
       . "<div class='profile_post_like_button'>"
                    . "<form action='homepage.php?postid=$currentpostid' method='POST'>"
                        . "<input type='submit' name='like' value='Like $postlikes'>"
                    . "</form>"
                . "</div>";
            echo "<div>"
                    . "<form class='profile_post_comment_button' action='homepage.php?postid=$currentpostid' method='post'>"
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


