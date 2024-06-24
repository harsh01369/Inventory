<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doner Kings</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        /* CSS styles */
body { 
    font-family: Arial, sans-serif; 
    background-color: #f8f9fa; 
    color: #333; 
    margin: 0; 
    padding: 0; 
}
header, footer { 
    background-color: #000; 
    color: #fff; 
    text-align: center; 
    padding: 20px 0; 
}
.logo { 
    font-size: 24px; 
    font-weight: bold; 
    text-transform: uppercase; 
    letter-spacing: 2px; 
}
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
.hero-section { 
    position: relative;
    color: #fff; 
    padding: 150px 20px; 
    text-align: center; 
    animation: fadeIn 2s ease-out; 
    overflow: hidden; /* Ensure the blurred image doesn't overflow */
}
.hero-section:before { 
    content: ""; 
    position: absolute; 
    top: 0; 
    left: 0; 
    right: 0; 
    bottom: 0; 
    background: url('images/doner.jpg') center/cover no-repeat; /* Background image */
    filter: blur(10px); /* Blur effect */
    z-index: -1; /* Place it behind other content */
}
.hero-section h1, .hero-section p { 
    position: relative; 
    z-index: 1; 
    font-size: 48px;
}
.order-now-btn { 
    background-color: #FFD700; 
    color: #000; 
    padding: 15px 30px; 
    text-decoration: none; 
    font-weight: bold; 
    border-radius: 5px; 
    transition: all 0.3s ease; 
    border: 2px solid transparent; 
    animation: pulse 2s infinite; 
}
.discount-offer { 
    background-color: #FFD700; 
    color: #333; 
    padding: 30px; 
    text-align: center; 
    margin: 50px auto; 
    border-radius: 10px; 
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); 
    width: 80%; 
    max-width: 600px; 
}
@keyframes fadeIn { 
    from { opacity: 0; } 
    to { opacity: 1; } 
}
@keyframes pulse { 
    0% { transform: scale(1); } 
    50% { transform: scale(1.05); } 
    100% { transform: scale(1); } 
}
@media (max-width: 768px) { 
    .hero-section { padding: 100px 20px; } 
}

		
    </style>
</head>
<body>
    <header>
       <div class="logo">92 Doner King</div>
    </header>
    <nav>
        <ul>
            <li><a href="main.php"data-translate="home">Home</a></li>
            <li><a href="menu.php"data-translate="menu">Menu</a></li>
            <li><a href="location.php"data-translate="locations">Locations</a></li>
            <li><a href="aboutus.php" data-translate="about_us">About Us</a></li>
            
            <?php
            session_start();
            if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
                // User is logged in, display the logout button
                echo '<li><a href="logout.php" class="logout-btn">Logout</a></li>';
            } else {
                // User is not logged in, display the login button
                echo '<li><a href="login.php" class="login-btn">Login</a></li>';
            }
            ?>
            <li>
                <select id="languageSwitcher" class="language-select">
                    <option value="en">English</option>
                    <option value="fr">Français</option>
                    <option value="es">Español</option>
                </select>
            </li>
        </ul>
    </nav>
	
    <div class="hero-section">
        <h1 data-translate="experience_the_flavor">Experience the Flavor</h1>
        <p data-translate="discover">Discover the finest doner kebabs in town</p>
        <a href="menu.php" class="order-now-btn" data-translate="order_now">Order Now</a>
    </div>
    <div class="discount-offer">
        <h2 data-translate="special_offer">Special Offer!</h2>
        <p data-translate="get_20_off">Get 20% off on your first order. Use code <strong>DK20</strong>.</p>
    </div>
    <footer>
        <p data-translate="footer_rights">&copy; 2024 Doner Kings - All Rights Reserved</p>
    </footer>
    <script src="translator.js"></script>
</body>

</body>
</html>



