<?php
include('Classes/DBConnection.php');

session_start();
    if (isset($_POST['loginuser'])) {
        $email = mysqli_real_escape_string( $conn , $_POST['email']);
        $password = mysqli_real_escape_string( $conn , $_POST['password']);
        
        $result = $conn->query("SELECT password from users where email='$email'");
        $hashPass = mysqli_fetch_assoc($result);
        
        if ($conn->query("SELECT email from users where email='$email'") && $hashPass != null) {
            if (password_verify($password,$hashPass['password'])) {   
               $_SESSION['email'] = $email;
               header("Location:homepage.php");
            }
            else {
               $error = "Password is incorrect!";
            }              
        }
        else {
             $error = "Account does not exist!";
        }
    } 
    $error = '';
    function saySuccess($msg) {
        echo "<h3 style='color:white;'>$msg</h3>";   
    } 
?>

<!DOCTYPE html>
<html>
<head>
    <title>Log in</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="css/style.css">

</head>
<body>
        <form class="login_box" action="login.php" method="post">
            <h1>Login to your account!</h1>
            <input class="field" type="text" name="email" placeholder="email">
            <input class="field" type="password" name="password" placeholder="password">   
            <input class="button" type="submit" name="loginuser" value="Login"> 
            <a class="already_registered" title="Register" href="register.php">Register</a>
                <?php
                    if ($error != '') {
                        saySuccess($error);
                    }
                ?>
            </form>   
</body>


