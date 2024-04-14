<?php

// Admin user variables
$admin_id = 0;
$isEditingUser = false;
$username = "";
$email = "";
$password = "";
$role = "";
// Topics variables
$topic_id = 0;
$isEditingTopic = false;
$topic_name = "";
// general variables
$errors = [];
/* - - - - - - - - - -
- Admin users actions
- - - - - - - - - - -*/
// if user clicks the create admin button
if (isset($_POST['create_admin'])) {
    createAdmin($_POST);
}

if (isset($_POST['update_admin'])) {
    updateAdmin($_POST);
}

if (isset($_GET['edit-admin'])) {
    editAdmin($_GET['edit-admin']);
}

if (isset($_GET['delete-admin'])) {}

if (isset($_POST['update_admin'])) 
    updateAdmin($_POST);

function getAdminRoles() {
    global $conn;
    $sql = "SELECT * FROM roles WHERE name = 'Admin' OR name = 'Author'";
    $result = mysqli_query($conn, $sql);
    $roles = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $roles;
}

function getAdminUsers() {
    global $conn;
    $sql = "SELECT * FROM users WHERE role = 'Admin' OR role = 'Author'";
    $result = mysqli_query($conn, $sql);
    $users = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $users;
}

function createAdmin($request_values) {
    global $conn, $errors, $username, $email;
    
    // Extract values from $request_values array
    $username = mysqli_real_escape_string($conn, $request_values['username']);
    $email = mysqli_real_escape_string($conn, $request_values['email']);
    $password = mysqli_real_escape_string($conn, $request_values['password']);
    $passwordConfirm = mysqli_real_escape_string($conn, $request_values['passwordConfirmation']);
    $role = mysqli_real_escape_string($conn, $request_values['role_id']);
        
    // Check if there are any validation errors
    if (count($errors) === 0) {
        // Hash the password before storing it in the database for security
        $hashed_password = md5($password); // You should use a more secure hashing algorithm
        
        // Insert user data into the database
        $query = "INSERT INTO users (username, email, role, password, created_at, updated_at) 
                  VALUES('$username', '$email', '$role', '$hashed_password', NOW(), NOW())";
        
        if (mysqli_query($conn, $query)) {
            // User creation successful
            $_SESSION['message'] = "Admin user created successfully";
            header('location: users.php');
            exit();
        } else {
            // Error occurred while inserting user data into the database
            array_push($errors, "Error: " . mysqli_error($conn));
        }
    }
}

function editAdmin($admin_id) {
    global $conn, $username, $isEditingUser, $email, $password;
    
    // Query to fetch admin details from the database
    $query = "SELECT * FROM users WHERE id=$admin_id LIMIT 1";
    $result = mysqli_query($conn, $query);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $admin_data = mysqli_fetch_assoc($result);
        
        // Set admin fields for editing
        $username = $admin_data['username'];
        $email = $admin_data['email'];
        $password = $admin_data['password'];
        $role = $admin_data['role'];
        // Set $isEditingUser to true to indicate that we are editing an existing admin
        $isEditingUser = true;
    }
}

function updateAdmin($request_values){
    global $conn, $errors, $username, $isEditingUser, $admin_id, $email;
    // var_dump($request_values);
    // die();
    // Retrieve values from the request
    $username = $request_values['username'];
    $email = $request_values['email'];
    $password = $request_values['password'];
    $passwordConfirm = $request_values['passwordConfirmation'];
    $role = $request_values['role_id'];
    $admin_id = $request_values['admin_id'];
    
    // Check if username or email already exists
    $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
    var_dump($user_check_query);
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
    
    // Update the admin user
    if (count($errors) == 0) {
        $query = "UPDATE users SET password='$password', role='$role_name' WHERE id=$admin_id";        var_dump($query);
        mysqli_query($conn, $query);
        $_SESSION['message'] = "Admin user updated successfully";
        header('location: users.php');
        exit(0);
    } else {
        array_push($errors,'Failed to uapdate admin user');
    }
}

function countUsers() {
    global $conn;
    $sql = "SELECT COUNT(*) FROM users";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result, MYSQLI_NUM);
    return $row[0];
}

function countPosts() {
    global $conn;
    $sql = "SELECT COUNT(*) FROM posts";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result, MYSQLI_NUM);
    return $row[0];
}
?>