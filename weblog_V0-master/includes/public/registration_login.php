<?php
// variable declaration
$username = "";
$email = "";
$errors = array();

//REGISTER USER

if (isset($_POST['register_btn'])) {
    // Get form inputs
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password1 = $_POST['password1'];
    $password2 = $_POST['password2'];

    // Validate form inputs
    if (empty($username)) { array_push($errors, "Username is required"); }
    if (empty($email)) { array_push($errors, "Email is required"); }
    if (empty($password1)) { array_push($errors, "Password is required"); }
    if ($password1 != $password2) { array_push($errors, "Passwords do not match"); }

    // Check if username or email already exists
    $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
    $result = mysqli_query($conn, $user_check_query);
    $user = mysqli_fetch_assoc($result);

    if ($user) { // If user exists
        if ($user['username'] === $username) {
            array_push($errors, "Username already exists");
        }
        if ($user['email'] === $email) {
            array_push($errors, "Email already exists");
        }
    }

    // If no errors, register user
    if (empty($errors)) {
        $password = md5($password1); // Encrypt password before saving in database

        $query = "INSERT INTO users (username, email, role, password) VALUES('$username', '$email', 'Author', '$password')";
        mysqli_query($conn, $query);

        // Get the ID of the newly registered user
        $reg_id = mysqli_insert_id($conn);

        // Set user information in session
        $_SESSION['user'] = getUserById($reg_id);

        // Redirect user based on role
        if ($_SESSION['user']['role'] == "Admin") {
            header('location: dashboard.php');
        } else {
            header('location: index.php');
        }
        exit();
    }
}


// LOG USER IN
if (isset($_POST['login_btn'])) {
    $username = esc($_POST['username']);
    $password = esc($_POST['password']);
    if (empty($username)) {
        array_push($errors, "Username required");
    }
    if (empty($password)) {
        array_push($errors, "Password required");
    }
    if (empty($errors)) {
        $password = md5($password); // encrypt password
        $sql = "SELECT * FROM users WHERE username='$username' and password='$password' LIMIT 1";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            // get id of created user
            $reg_user_id = mysqli_fetch_assoc($result)['id'];
            //var_dump(getUserById($reg_user_id)); die();
            // put logged in user into session array
            $_SESSION['user'] = getUserById($reg_user_id);
            // if user is admin, redirect to admin area
            if (in_array($_SESSION['user']['role'], ["Admin", "Author"])) {
                $_SESSION['message'] = "You are now logged in";
                // redirect to admin area
                header('location: ' . BASE_URL . '/admin/dashboard.php');
                exit(0);
            } else {
                $_SESSION['message'] = "You are now logged in";
                // redirect to public area
                header('location: index.php');
                exit(0);
            }
        } else {
            array_push($errors, 'Wrong credentials');
        }
    }
}

function getUserById($id)
{
    global $conn; //rendre disponible, à cette fonction, la variable de connexion $conn
    $sql = "SELECT * FROM users WHERE id='$id' LIMIT 1"; //requête qui récupère le user et son rôle
    $result = mysqli_query($conn, $sql) ;//la fonction php-mysql
    $user = mysqli_fetch_assoc($result) ;//je met $result au format associatif
    return $user;
}

function esc($id) {
    return $id;
}
