<?php
include('Classes/header.php');
include('./functions/homepagefunctions.php');


if(isset($_GET['id'])) {
    $personid = $_GET['id'];
    
    if (is_numeric($personid)) {
        if (isset($_POST['send_message'])) {
            $message = mysqli_real_escape_string ( $conn , $_POST['messagecontent']);
            $conn->query("INSERT INTO messages (sender, receiver, message) values ('$loggedID', '$personid', '$message')");
        }
    }
    else {
        echo "<script>window.open('messages.php?id=0', '_self')</script>";
    }

}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Messages</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    
       <div class="navbar">
        <ul>
            <li ><a href="homepage.php">Home</a></li>
            <li class="active"><a href="messages.php?id=0">Messages</a></li>
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
    
    <div class="messages_box">
        
        
            <div id="headercenter">
                <h2>Messages</h2>
            </div>
        <div class="messages_person_list">
         <?php 
         $people = $conn->query("select * from followers join users on user_id = followed_id where follower_id = '$loggedID'");
         
        foreach ($people as $person) {
            $firstName = $person['first_name'];
            $lastName = $person['last_name'];
            $profileImage = $person['profile_img'];
            $userid = $person['user_id']; 
         
         
           echo   "<div class='profile_search_box' style='width: 250px;'>"
           . "<div class='profile_post_poster'>"
                ."<img style='height:40px; width: 40px; border-radius: 50%;' src='$profileImage'><a  style='font-size: 25px;' href='messages.php?id=$userid'>$firstName $lastName</a>"
            . "</div>"
         . "</div>";  
           
        }
         
         
         
         
         ?>               
    </div>
        

    
        <div class="messages_send_box">    
            <?php
            $selectedperson = $_GET['id'];
            
            if ($selectedperson == 0) {
                echo "<div id='headercenter'>"
             .  " <h3>Select a person to start a conversation!</h3>"
         .  " </div>";
            }
            
            else {
   
                $persontomessage = $conn->query("SELECT * FROM users where user_id='$selectedperson'");
                $row = $persontomessage->fetch_assoc();
                $personName = $row['first_name'];
                
                $allmessages = $conn->query("SELECT * FROM messages where sender= '$loggedID' and receiver = '$selectedperson' union SELECT * FROM messages where sender= '$selectedperson' and receiver = '$loggedID' ORDER BY date ASC");
                
                echo "<div class='conversation_box'>";
                
            foreach ($allmessages as $message) {
                $content = $message['message'];
                $sender = $message['sender'];
                $receiver = $message['receiver'];
                
                if ($sender == $loggedID) {
                    echo "<div class='right'>"
                    .       "<p>$content</p>"
                    .   "</div>";
                }
                else {
                  echo "<div class='left'>"
                    .       "<p>$content</p>"
                    .   "</div>";
                }
                
            }
            
            echo "</div >";

                
                echo "<form action='messages.php?id=$selectedperson' method='post' >"
                     . " <textarea style='font-size: 20px;' name='messagecontent' rows='7' cols='45' placeholder='Send a message to $personName'></textarea>"
                     . " <input class='search_button' type='submit' name='send_message' value='send message'> "
              . "  </form>";
            }
            
            ?>
            

            
            
        </div>
        
        
        
    </div>
</body>
