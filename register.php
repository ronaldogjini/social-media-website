<?php
include('Classes/DBConnection.php');

    
    if (isset($_POST['registeraccount'])) {
        $username = mysqli_real_escape_string ( $conn , $_POST['username']);
        $email = mysqli_real_escape_string ( $conn , $_POST['email']);
        $password = mysqli_real_escape_string ( $conn , $_POST['password']);
        $firstName = mysqli_real_escape_string ( $conn , $_POST['fname']);
        $lastName = mysqli_real_escape_string ( $conn , $_POST['lname']);
        $country = mysqli_real_escape_string ( $conn , $_POST['country']);
        $gender = mysqli_real_escape_string ( $conn , $_POST['gender']);
        $birthday = mysqli_real_escape_string ( $conn , $_POST['birthday']);       
        
        $sql = "SELECT username FROM users WHERE username= '$username'";
        $result = mysqli_query($conn, $sql) or die ("Error executing the query");
        $rowNumber = mysqli_num_rows($result);
        $passEnc = password_hash($password, PASSWORD_BCRYPT);
        
        if($rowNumber==0) {     
                if(strlen($username) >= 3 && strlen($username) <= 32) {
                    if(preg_match('/[a-zA-Z0-9_]+/', $username)) {
                        if(strlen($password) >=6 && strlen($password) <= 32) {
                            if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
                                $conn->query("INSERT INTO users (username, email, password, first_name, last_name, country, gender, birthday, profile_img) values('$username', '$email', '$passEnc', '$firstName', '$lastName', '$country', '$gender', '$birthday', 'img/profile/default.png')");
                                header("location:login.php");
                            }
                            else {
                                echo "Invalid email format! Try again!";
                            }
                        }
                        else {
                            echo 'The password should be longer than 5 characters!';
                        }                                         
                    }           
                }
                else {
                    echo "Invalid username! Please adhere to our guidelines!";
                }        
        }
        else {
            echo 'User already exists!';
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
            <center><h1>Ronaldo's Social Media</h1></center>
            
            <form class="register_box" action="register.php" method="post">  
                <h1>Create your account!</h1>
                <div class="left_box" >
                   <input class="field" type="text" name="username" placeholder="Username" required="required">  
                   <input class="field" type="text" name="fname" placeholder="First name" required="required">
                   <input class="field" type="text" name="lname" placeholder="Last name" required="required">
                    <input class="field" type="text" name="email" placeholder="Email" required="required">                
                </div>
                <div class="right_box">
                   <input class="field" type="password" name="password" placeholder="Password" required="required">
                   <select class="field"  name="country" required="required">
                                    <option disabled>Choose your country</option>
                                    <option>Albania</option>
                                    <option>Kosovo</option>
                                    <option>Macedonia</option>
                                    <option>North Montenegro</option>
                                    <option>Italy</option>
                                    <option>Greece</option>
                                    <option>Germany</option>
                                    <option>United Kingdom</option>
                                    <option>France</option>
                                    <option>USA</option>
		    </select>
                    <select class="field" name="gender" required="required">
                                    <option disabled>Gender</option>
                                    <option>Male</option>
                                    <option>Female</option>
                    </select>
                    <input class="field" type="date" name="birthday" required="required" placeholder="Birthday">                      
                </div>
                <div class="center">
                    <input class="button" type="submit" name="registeraccount" value="Create account">                        
                </div>
                 <a class="already_registered" title="Login" href="login.php">Already registered?</a>
            </form>            
</body>