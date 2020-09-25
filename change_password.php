<?php
include('Classes/header.php');
include('Classes/DBConnection.php');

    if (isset($_POST['changepassword'])) {
        $oldpassword = $_POST['oldpassword'];
        $newpassword = $_POST['newpassword'];
        $newpasswordconfirm = $_POST['newpasswordconfirm'];
       
        $result = $conn->query("SELECT password from users where user_id='$loggedID'");
        $hashPass = mysqli_fetch_assoc($result);

            if (password_verify($oldpassword,$hashPass['password'])) {   
                if($newpassword == $newpasswordconfirm){
                    $passEnc = password_hash($newpassword, PASSWORD_BCRYPT);
                        $conn->query("UPDATE users SET password = '$passEnc' where user_id = '$loggedID'");
                        echo "Password updated";
                }
                else {
                   echo "Passwords do not match!";
                }              
            }
            else {
               echo "Old password is incorrect!";
            }              
        }
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo 'Update info' ?></title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script src="https://kit.fontawesome.com/cc29cf97b3.js"></script>
</head>
<body>
            <div class="navbar">
        <ul>
            <li><a href="homepage.php">Home</a></li>
            <li ><a href="messages.php">Messages</a></li>
            <li><a href="#contact">Contact</a></li>
            <li  class="active" ><a href="profile.php?id=<?php echo $loggedID; ?>"><?php echo $loggedName ?></a></li>
            <li><a href="logout.php">Log out</a></li>
                <div class="nav_search">
                    <li>
                        <form action="login.php" method="post" >
                            <input type="text" name="search"> <input type="submit" name='search_button' value="Search"> 
                        </form>
                    </li>
            </div>
           
        </ul>   
    </div>

    <form class="change_password_box" action="change_password.php" method="post">
            <h1>Change password!</h1>
            <input class="field" type="password" name="oldpassword" placeholder="Old password">
            <input class="field" type="password" name="newpassword" placeholder="New password"> 
            <input class="field" type="password" name="newpasswordconfirm" placeholder="Confirm new password">   
            <input class="button" type="submit" name="changepassword" value="Login"> 
    </form>  
    
</body>
