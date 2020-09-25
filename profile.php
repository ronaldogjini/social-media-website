<?php
include('functions/profilefunctions.php');

?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo $profilename . " " . $profilesurname; ?></title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script src="https://kit.fontawesome.com/cc29cf97b3.js"></script>
</head>
<body>
    
        <div class="navbar">
        <ul>
            <li><a href="homepage.php">Home</a></li>
            <li ><a href="messages.php?id=0">Messages</a></li>
            <li  class="active" ><a href="profile.php?id=<?php echo $loggedID; ?>"><?php echo $loggedName ?></a></li>
            <li><a href="logout.php">Log out</a></li>
                <div class="nav_search">
                    <li>
                        <form action="search.php" method="post" >
                            <input  type="text" name="search"> <input class="search_button" type="submit" name='search_button' value="Search"> 
                        </form>
                    </li>
            </div>
           
        </ul>   
    </div>
    
    <div class="profile_container">
        
        
 <!------------------------------------------------------- Side profile info start ----------------------------------------------------------->
        
        <aside class="profile_side">
            <div class="profile_side_content">
                <div class="about">
                    <div class="title">
                        <p>About</p>
                    </div>
                    
                    <div class="about_group">
                        <div class="icon"><i class="far fa-envelope"></i></div>
                        <div class="info_title">					
                            <div class="title_data">Email:</div>
                            <div class="info"> <?php echo $profileemail; ?>  </div>
                        </div>
                    </div>   
                    <div class="about_group">
                        <div class="icon"><i class="fas fa-birthday-cake"></i></i></div>
                        <div class="info_title">					
                            <div class="title_data">Birthday:</div>
                            <div class="info"> <?php echo $profilebirthday; ?>  </div>
                        </div>
                    </div>   
                    <div class="about_group">
                        <div class="icon"><i class="far fa-flag"></i></div>
                        <div class="info_title">					
                            <div class="title_data">Country:</div>
                            <div class="info"> <?php echo $profilecountry; ?>  </div>
                        </div>
                    </div> 
                    <div class="about_group">
                        <div class="icon"><i class="fas fa-venus-mars"></i></div>
                        <div class="info_title">					
                            <div class="title_data">Gender:</div>
                            <div class="info"> <?php echo $profilegender; ?>  </div>
                        </div>
                    </div>  
                    <div class="about_group">
                        <div class="icon"><i class="far fa-calendar-alt"></i></i></div>
                        <div class="info_title">					
                            <div class="title_data">Joined:</div>
                            <div class="info"> <?php echo $profilejoined; ?>
                            </div>
                        </div>
                    </div>
                </div> 
                
                
                
               <div class="about">
                    <div class="title">
                        <p>Followers</p>
                    </div>
                    
                <?php 
                   $followers = $conn->query("SELECT * FROM followers join users on user_id = follower_id where followed_id = '$profileid'");
                   
                foreach ($followers as $follower) {
                    $followername = $follower['first_name'];
                    $followersurname = $follower['last_name'];
                    $followerimage = $follower['profile_img'];
                    $followerid = $follower['user_id'];

                    echo   "<div class='profile_search_box' style='width: 250px;'>"
                    . "<div class='profile_post_poster'>"
                        ."<img style='height:40px; width: 40px; border-radius: 50%;' src='$followerimage'><a class = 'title_data' style='font-size: 25px;' href='profile.php?id=$followerid'>$followername $followersurname</a>"
                    . "</div>"
                    . "<form action='profile.php?id=$followerid' method='post'>"
                    .   " <input class='button' type='submit' name='view' value='View person'>" 
                    . "</form>" 
                . "</div>";
                    
                }
                   ?>
        
                </div> 
                
                <div class="about">
                    <div class="title">
                        <p>Following</p>
                    </div>
                    
                <?php 
                   $followers = $conn->query("SELECT * FROM followers join users on user_id = followed_id where follower_id = '$profileid'");
                   
                foreach ($followers as $follower) {
                    $followername = $follower['first_name'];
                    $followersurname = $follower['last_name'];
                    $followerimage = $follower['profile_img'];
                    $followerid = $follower['user_id'];

                    echo   "<div class='profile_search_box' style='width: 250px;'>"
                    . "<div class='profile_post_poster'>"
                        ."<img style='height:40px; width: 40px; border-radius: 50%;' src='$followerimage'><a class = 'title_data' style='font-size: 25px;' href='profile.php?id=$followerid'>$followername $followersurname</a>"
                    . "</div>"
                    . "<form action='profile.php?id=$followerid' method='post'>"
                    .   " <input class='button' type='submit' name='view' value='View person'>" 
                    . "</form>" 
                . "</div>";
                    
                }
                   ?>
        
                </div> 
                
                
                
                
                
            </div>  
        </aside>        
 
 
  <!------------------------------------------------------- Side profile info end ----------------------------------------------------------->
     <section class="content_main">
  
   <!------------------------------------------------------- Main profile start ----------------------------------------------------------->

    <section class="profile_header">
	<div class="photo_image"><img src=" <?php echo $profileprofile ?>  "></div>
            <div class="profile_info">
                <div class="fname"><?php echo $profilename ?></div>
		<div class="lname"><?php echo $profilesurname ?></div>			
		<div class="description"><?php echo $profiledescription ?></div>
            </div>
        
        <?php
            if(($loggedID == $_GET['id'])) { 
                echo "<div id='modify_profile_buttons' class='update_button'>"
                        . "<form action='update_profile.php' method='post'>"
                        .       " <input id='button' class='button' type='submit' name='updateButton' value='Update info'>"
                        . " </form>"
                        . " <form action='profile.php?id=$loggedID' enctype='multipart/form-data' method='post'>"
                        .       "<input class='button' style='width: 90px; display: inline;' type='file' name='profileSelector' title='Update profile photo'>"
                        .       "<input class='button' style='display: inline; width: 80px;'  type='submit' name='changePhoto' title='Update profile photo'>"
                        .  "</form>"
                        .  " <form action='change_password.php' method='post'>"
                        .       " <input class='button' type='submit' name='updateButton' value='Change password'>"
                        .  "</form>"
                    . "</div>";
            }
            
            
            if ($loggedID != $profileid) {
                $followStatus = $conn->query("SELECT * from followers where follower_id = '$loggedID' and followed_id = '$profileid'"); 
            
                if(!mysqli_num_rows($followStatus)) {
             
                    echo "<div id='modify_profile_buttons' class='update_button'>"
                    .   " <form action='profile.php?id=$profileid' method='post'>"
                    .       " <input class='button' type='submit' name='followUser' value='Follow'>"
                    .    "</form>"
                    . "</div>";      
                }
                else {
                    echo "<div id='modify_profile_buttons' class='update_button'>"
                    .   " <form action='profile.php?id=$profileid' method='post'>"
                    .       " <input class='button' type='submit' name='unfollowUser' value='Unfollow'>"
                    .    "</form>"
                    . "</div>";
                }
            }
                
        ?>
            
            
        
        
    </section>	
   

<!------------------------------------------------------- Main profile end ----------------------------------------------------------->
<!------------------------------------------------------- Profile posts start ----------------------------------------------------------->

<?php
    if(($loggedID == $_GET['id'])) {
        echo   "<div id='publish_post_profile' >"
   . "<form class='publish_post_profile_form' enctype='multipart/form-data' action='profile.php?id=$loggedID' method='post'>"
    .   " <h2>What's on your mind?</h2>"
   .     "<textarea style='font-size: 20px;' name='postcontent' rows='7' cols='70' placeholder='What is on your mind today $loggedName?'></textarea>"
    .    "<input style='display: block; margin-left: 570px; '  type='submit' name='publishPost' value='Publish'>"
     .   "<input style='display: block; margin-left: 570px; '  type='file' name='uploadimage' value='Add image' value='30' >"
  .  "</form>"
 ."</div> ";
    }
?>

<div id="headercenter">
            <h2><?php echo $profilename?>'s News Feed</h2>
        </div>
<div class="userposts" >
<?php showPostsProfile($profileid); ?>   
 
</div>

</section>
</div>


  
</body>
