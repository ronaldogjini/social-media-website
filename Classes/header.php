<?php
include('Classes/DBConnection.php');
session_start();
    
 if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $query = mysqli_query($conn, "select * from users where email = '$email'");
    $user = mysqli_fetch_array($query);
    
    $loggedID = $user['user_id'];
    $loggedUsername = $user['username'];
    $loggedName = $user['first_name'];
    $loggedSurname = $user['last_name'];
    $loggedCountry = $user['country'];
    $loggedGender = $user['gender'];
    $loggedBirthday = $user['birthday'];
    $loggedJoined = $user['date_joined'];
    $loggedProfile = $user['profile_img'];
    $loggedDescription = $user['description'];
 }
 else {
     header("Location:login.php");
 }
    
?>

