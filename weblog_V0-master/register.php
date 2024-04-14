<?php
// session_start();

// Include the database connection file
include('config.php');
include('includes/public/head_section.php');
include('includes/public/registration_login.php')
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    
    <style>
        h2 {
            text-align: center;
            margin-bottom: 15px;
            margin-top: 15px;
        }
        p {
            text-align: center;
        }
        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
            box-sizing: border-box
        }
        button{
            display: block;
            margin: 10px auto;
            width: 15%;
            aspect-ratio: 4/1;
            border: 1px solid #ccc;
            border-radius: 3px;
            box-sizing: border-box;
            font-size: 20px;
            color: #fff;
            background-color: #3E606F;
        }
    </style>

</head>
<body>
    <div class="container">

        <!-- Navbar -->
        <?php include(ROOT_PATH . '/includes/public/navbar.php'); ?>
        <!-- // Navbar -->
        <h2>Register on MyWebSite</h2>
        <?php include(ROOT_PATH . '/includes/public/errors.php') ?>
        <form method="post" action="register.php">
            <input type="text" name="username" placeholder="Username" value="<?php echo $username; ?>">
            <input meotype="email" name="email" placeholder="Email" value="<?php echo $email; ?>">
            <input type="password" name="password1" placeholder="Password">
            <input type="password" name="password2" placeholder="Password confirmation">
            <button type="submit" name="register_btn">Register</button>
        </form>
        <p> Already a member? <a href="login.php">Sign in</a></p>
    </div>
</body>
</html>
