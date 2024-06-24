<?php
include 'db.php';
session_start();

// Check if any user is already logged in
if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    // Redirect logged-in users to their respective dashboards
    if(isset($_SESSION['role'])) {
        $role = $_SESSION['role'];
        if($role == 'customer') {
            header("Location: menu.php");
        } elseif($role == 'staff') {
            header("Location: staff_dashboard.php");
        } elseif($role == 'admin') {
            header("Location: admin_dashboard.php");
        }
        exit();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];

    // Attempt to login as Admin
    $adminQuery = "SELECT * FROM Admin WHERE Username = '$username'";
    $adminResult = $conn->query($adminQuery);
    if ($adminResult->num_rows > 0) {
        $adminUser = $adminResult->fetch_assoc();
        if (password_verify($password, $adminUser['PasswordHash'])) {
            // Successful login as Admin
            $_SESSION['logged_in'] = true;
            $_SESSION['user_id'] = $adminUser['AdminID'];
            $_SESSION['role'] = 'admin';
            header("Location: admin_dashboard.php");
            exit();
        }
    }

    // Attempt to login as Customer or Staff
    $queries = [
        "Customer" => "SELECT * FROM Customer WHERE Email = '$username'",
        "Staff" => "SELECT * FROM Staff WHERE Email = '$username'"
    ];

    foreach ($queries as $role => $query) {
        $result = $conn->query($query);
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['PasswordHash'])) {
                // Successful login
                $_SESSION['logged_in'] = true;
                $_SESSION['user_id'] = $user[$role . 'ID'];
                $_SESSION['role'] = strtolower($role);
                if ($role == "Customer") {
                    header("Location: menu.php");
                } else { // Staff
                    header("Location: staff_dashboard.php");
                }
                exit();
            }
        }
    }
    echo "Login failed. Invalid username or password.";
}


   

    
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style>
        /* Your CSS styles here */
        body { font-family: Arial, sans-serif; background-color: #f8f9fa; color: #333; margin: 0; padding: 0; }
        header, footer { background-color: #000; color: #fff; text-align: center; padding: 20px 0; }
        form { max-width: 300px; margin: 50px auto; padding: 20px; background-color: #fff; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); }
        input[type="text"], input[type="password"] { width: 100%; padding: 10px; margin: 10px 0; border-radius: 5px; border: 1px solid #ccc; }
        input[type="submit"] { width: 100%; padding: 10px; border: none; border-radius: 5px; color: #fff; background-color: #007bff; cursor: pointer; }
        input[type="submit"]:hover { background-color: #0056b3; }
        .register-link { text-align: center; margin-top: 20px; }
        .register-link a { color: #007bff; text-decoration: none; }
        .register-link a:hover { text-decoration: underline; }
    </style>
</head>
<body>

<form action="login.php" method="post">
    <label for="username">Username (Email):</label><br>
    <input type="text" id="username" name="username" required><br>
    
    <label for="password">Password:</label><br>
    <input type="password" id="password" name="password" required><br>
    
    <input type="submit" value="Login">
</form>

<div class="register-link">
    <p>Don't have an account? <a href="register_customer.php">Register here</a></p>
</div>

</body>
</html>
