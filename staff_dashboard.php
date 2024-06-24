<?php
session_start();
if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== true) {
    header("location: login.php");
    exit;
}

if ($_SESSION["role"] !== "staff") {
    header("location: unauthorized.php");
    exit;
}

include 'db.php'; // Include your database connection file
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Dashboard</title>
    <style>
        /* CSS styles */
        body { font-family: Arial, sans-serif; background-color: #f8f9fa; color: #333; margin: 0; padding: 0; }
        header, footer { background-color: #000; color: #fff; text-align: center; padding: 20px 0; }
        .logo { font-size: 24px; font-weight: bold; text-transform: uppercase; letter-spacing: 2px; }
        nav { 
    background-color: #FFD700; /* Yellow background color */
    padding: 20px 0; /* Increase padding for better spacing */
    text-align: center;
}
nav ul { 
    list-style: none; 
    padding: 0; 
    margin: 0; 
    display: flex; 
    justify-content: center; 
    flex-wrap: wrap; /* Allow wrapping on smaller screens */
}
nav ul li { 
    margin: 10px; 
}
nav ul li a, .language-select, .login-btn { 
    color: #333; 
    text-decoration: none; 
    font-weight: bold; 
    padding: 10px 20px; /* Increase padding for bigger buttons */
    border-radius: 5px; 
    transition: all 0.3s ease; 
    font-size: 20px; /* Increase font size */
}
nav ul li a:hover, .language-select:hover, .login-btn:hover { 
    color: #fff; 
    background-color: #007bff; 
}
        .container { padding: 20px; }
    </style>
</head>
<body>

<header>
    <h1>Welcome to the Staff Dashboard</h1>
</header>

<nav>
    <ul>
        <li><a href="stock_manage.php">Stock Management</a></li>
        <li><a href="order_manage.php">Orders</a></li>
        <li><a href="item_manage.php">Items</a></li>
		<li>
                <select id="languageSwitcher" class="language-select">
                    <option value="en">English</option>
                    <option value="fr">Français</option>
                    <option value="es">Español</option>
                </select>
        </li>
        <li><a href="main.php">Logout</a></li>
    </ul>
</nav>

<div class="container">
    <!-- Content goes here -->
</div>

<footer>
    <p>&copy; <?php echo date("Y"); ?> Doner King. All rights reserved.</p>
</footer>

</body>
</html>
