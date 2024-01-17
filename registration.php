<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$database = "coffe_database";


$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$error_message = "";


if (isset($_POST['register'])) {
    
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirmPassword = mysqli_real_escape_string($conn, $_POST['confirm_password']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);

    if (empty($name) || empty($email) || empty($password) || empty($confirmPassword) || empty($phone)) {
        $error_message = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Invalid email address.";
    } elseif ($password != $confirmPassword) {
        $error_message = "Passwords do not match.";
    } elseif (strlen($password) < 6) {
        $error_message = "Password must be at least 6 characters long.";
    } elseif (!preg_match("/^[0-9]{10}$/", $phone)) {
        $error_message = "Invalid phone number.";
    } else {
      
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        
        $query = "INSERT INTO users (name, email, password, phone) VALUES ('$name', '$email', '$hashedPassword', '$phone')";

        if (mysqli_query($conn, $query)) {
            $_SESSION['user_registered'] = true;
            header('Location: index.php?message=registration_successful');
            exit();
        } else {
            $error_message = "Error: " . mysqli_error($conn);
        }
    }
}


mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>

    
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            background: linear-gradient(90deg, #fff, transparent 70%), url('images/home-bg.jpg') no-repeat;
            background-size: cover;
            background-position: center;
            overflow-x: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        .registration {
            text-align: center;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            padding: 30px;
            width: 400px;
            max-width: 100%;
        }

        .heading img {
            height: 60px;
        }

        .heading h3 {
            font-size: 24px;
            color: #333;
            font-family: 'Merienda One', cursive;
            margin-top: 10px;
        }

        .box {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #333;
            border-radius: 5px;
            font-size: 16px;
        }

        .btn {
            background-color: #be9c79;
            color: #fff;
            font-size: 18px;
            padding: 10px 20px;
            cursor: pointer;
            border: none;
            border-radius: 5px;
        }

        .btn:hover {
            background-color: #333;
        }
        span{
            color: red;
            font-size: 1.5rem;
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
        }
    </style>
</head>
<body>
    

    <section class="registration">
        <div class="heading">
            <img src="images/heading-img.png" alt="coffe photo">
            <h3>user registration</h3>
        </div>

        <div class="row">
            <form action="" method="POST">
                <input type="text" name="name" required class="box" maxlength="50" placeholder="Enter your name">
                <input type="email" name="email" required class="box" maxlength="50" placeholder="Enter your email">
                <input type="password" name="password" required class="box" minlength="6" maxlength="50" placeholder="Enter your password">
                <input type="password" name="confirm_password" required class="box" minlength="6" maxlength="50" placeholder="Confirm your password">
                 <span class="error-message"><?php if(isset($error_message)) { echo $error_message; } ?></span>
                <input type="tel" name="phone" required class="box" pattern="[0-9]{10}" placeholder="Enter your phone number (10 digits)">
                <input type="submit" name="register" value="Register" class="btn">
            </form>
        </div>
    </section>

</body>
</html>