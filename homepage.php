<?php
include('Classes/header.php');
include('./functions/homepagefunctions.php');
        
?>
<!DOCTYPE html>
<html>
<head>
    <title>Homepage</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    
       <div class="navbar">
        <ul>
            <li class="active"><a href="homepage.php">Home</a></li>
            <li ><a href="messages.php?id=0">Messages</a></li>
            <li><a href="profile.php?id=<?php echo $loggedID; ?>"><?php echo $loggedName ?></a></li>
            <li><a href="logout.php">Log out</a></li>
                <div class="nav_search">
                    <li>
                        <form action="search.php" method="post" >
                            <input type="text" name="search"> <input class="search_button" type="submit" name='search_button' value="Search"> 
                        </form>
                    </li>
            </div>
           
        </ul>   
    </div>
    
    <div class="homepage_box">
        
    <div id="publish_post_homepage" >
        <form class="publish_post_profile_form" enctype="multipart/form-data" action="homepage.php" method="post">
            <h2>What's on your mind?</h2>
            <textarea style="font-size: 20px;" name="postcontent" rows="7" cols="70" placeholder="What is on your mind today <?php echo $loggedName ?>?"></textarea>
            <input style="display: block; margin-left: 700px; "  type="submit" name="publishPost" value="Publish">
            <input style="display: block; margin-left: 700px; "  type="file" name="uploadimage" value="Add image" value="30" >
        </form>
        
        
        <div id="headercenter">
            <h2>News Feed</h2>
        </div>
       <?php showPostsHomepage(); ?>    

    </div> 

    </div>
</body>
