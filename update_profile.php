<?php
include('Classes/header.php');
include('Classes/DBConnection.php');

    if (isset($_POST['updateuser'])) {
        $name = mysqli_real_escape_string( $conn , $_POST['first_name']);
        $surname = mysqli_real_escape_string( $conn , $_POST['last_name']);
        $country = mysqli_real_escape_string( $conn , $_POST['country']);
        $gender =  mysqli_real_escape_string( $conn ,$_POST['gender']);
        $birthday = mysqli_real_escape_string( $conn , $_POST['birthday']);
        $description =mysqli_real_escape_string( $conn , $_POST['description']);
    
        $conn->query("UPDATE users SET first_name = '$name',last_name = '$surname',country = '$country',gender = '$gender', birthday = '$birthday', description = '$description' where user_id = '$loggedID'"); 
    }  

    if (isset($_POST['goback'])) {
        header("Location:profile.php?id=$loggedID");
    }
    
    function saySuccess($msg) {
        echo "<h3 style='color:white;'>$msg</h3>";   
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
<!----------------------------------------navbar-------------------------------------------------------------->
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
    
<!----------------------------------------navbar-------------------------------------------------------------->  
             
            <form class="update_info_box" action="update_profile.php" method="post">
                <h1>Update info</h1>
                <!--<input class="field" type="text" name="username" value="<?php echo $loggusername ?>" placeholder="Username">-->
                <input class="field" type="text" name="first_name" value="<?php echo $loggedName ?>" placeholder="First name">
                <input class="field" type="text" name="last_name" value="<?php echo $loggedSurname ?>" placeholder="Last name">
                <select class="field"  name="country" value="<?php echo $loggedCountry ?>" required="required">
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
                <select class="field" name="gender" value="<?php echo $loggedGender ?>" required="required">
                    <option disabled>Gender</option>
                    <option>Male</option>
                    <option>Female</option>
		</select>
                <input class="field" type="date" name="birthday" value="<?php echo $loggedBirthday ?>" required="required" placeholder="Birthday"> 
                <input class="field" type="text" name="description" value="<?php echo $loggedDescription ?>" placeholder="Profile description">
                <input class="button" type="submit" name="updateuser" value="Update">
                <input class="button" type="submit" name="goback" value="Go back">
                        <?php
                            if (isset($_POST['updateuser'])) {
                                saySuccess("Updated");
                            }
                        ?>
            </form>  
</body>
