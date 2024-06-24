<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Locations - 92 Doner King</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Main home page theme */
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
        .hero-section { background: url('doner_hero.jpg') center/cover no-repeat; color: #fff; padding: 150px 20px; text-align: center; position: relative; animation: fadeIn 2s ease-out; }
        .hero-section:before { content: ""; position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0, 0, 0, 0.5); }
        .hero-section h1, .hero-section p { position: relative; z-index: 1; animation: slideInFromLeft 1.5s ease-out; }
        .order-now-btn { background-color: #FFD700; color: #000; padding: 15px 30px; text-decoration: none; font-weight: bold; border-radius: 5px; transition: all 0.3s ease; border: 2px solid transparent; animation: pulse 2s infinite; }
        .discount-offer { background-color: #FFD700; color: #333; padding: 30px; text-align: center; margin: 50px auto; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); width: 80%; max-width: 600px; }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        @keyframes slideInFromLeft { 0% { transform: translateX(-100%); } 100% { transform: translateX(0); } }
        @keyframes pulse { 0% { transform: scale(1); } 50% { transform: scale(1.05); } 100% { transform: scale(1); } }
        @media (max-width: 768px) { .hero-section { padding: 100px 20px; } }

        /* Additional styles for Locations page */
        .location { padding: 50px 0; text-align: center; }
        .location h2 { margin-bottom: 30px; }
        .location-details { display: flex; justify-content: space-around; align-items: center; }
        .location-details .card { width: 45%; }
        .location-details .card-body { padding: 30px; }
    </style>
</head>
<body>
    <header>
        <div class="logo">92 Doner King</div>
    </header>
 <nav>
        <ul>
            <li><a href="main.php">Home</a></li>
            <li><a href="menu.php">Menu</a></li>
            <li><a href="location.php">Locations</a></li>
            <li><a href="aboutus.php">About Us</a></li>
            
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
    <div class="container location">
        <div class="row">
            <div class="col-md-6">
                <h2>Manchester Location</h2>
                <div class="location-details">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Address</h5>
                            <p class="card-text">123 Manchester Street<br>Manchester, M1 1AB<br>United Kingdom</p>
                            <a href="https://maps.google.com/?q=123+Manchester+Street" class="btn btn-primary" target="_blank">View on Map</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <h2>Paris Location</h2>
                <div class="location-details">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Address</h5>
                            <p class="card-text">456 Paris Avenue<br>Paris, 75001<br>France</p>
                            <a href="https://maps.google.com/?q=456+Paris+Avenue" class="btn btn-primary" target="_blank">View on Map</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer>
        <div class="container">
            <p>&copy; 2024 92 Doner King - All Rights Reserved</p>
        </div>
    </footer>
</body>
</html>
