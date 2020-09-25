<?php
include('Classes/header.php');
include('./functions/homepagefunctions.php');


if(isset($_POST['search'])) {
    $search_term = mysqli_real_escape_string ( $conn, strtolower($_POST['search']));
    echo "<script>window.open('search.php?term=$search_term', '_self')</script>";
}
     $term = $_GET['term'];   
?>
<!DOCTYPE html>
<html>
<head>
    <title>Search</title>
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
    
    <div class="search_box">
        
        <div class="profile_search_box_container"> 
        <div id='headercenter' >
            <h2> Search results for <?php echo $term  ?></h2>
        </div>
        
    <?php
        $term = mysqli_real_escape_string ( $conn , $_GET['term']);
        $allusers = $conn->query("SELECT * FROM users");
        foreach ($allusers as $user) {
            $firstName = $user['first_name'];
            $lastName = $user['last_name'];
            $profileImage = $user['profile_img'];
            $userid = $user['user_id'];           
            
                    
            if(preg_match("/{$term}/i", $firstName) || preg_match("/{$term}/i", $lastName)) {
             echo   "<div class='profile_search_box'>"
                    . "<div class='profile_post_poster'>"
                        ."<img style='height:40px; border-radius: 50%;' src='$profileImage'><a href='profile.php?id=$userid'>$firstName $lastName</a>"
                    . "</div>"
                    . "<form action='profile.php?id=$userid' method='post'>"
                    .   " <input class='button' type='submit' name='view' value='View person'>" 
                    . "</form>" 
                . "</div>";
            }
        }       
    ?>
    </div>
    </div>
</body>
