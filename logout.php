<?php
// Start the session
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process the feedback form
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];
    
    // Send the feedback to the system email address
    $to = "takeawayking92@gmail.com";
    $subject = "Feedback from ".$name;
    $txt = "Name: ".$name."\nEmail: ".$email."\nMessage: ".$message;
    $headers = "From: ".$email;

    mail($to,$subject,$txt,$headers);

    // Destroy the session
    session_destroy();

    // Redirect to the home page
    header("Location: main.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - 92 Doner King</title>
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

        /* Additional styles for Contact Us page */
        .contact-section { padding: 50px 0; text-align: center; }
        .contact-form { max-width: 500px; margin: 0 auto; }
        .contact-form input[type="text"], .contact-form textarea { width: 100%; padding: 10px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 5px; }
        .contact-form textarea { resize: none; }
        .contact-form button { background-color: #007bff; color: #fff; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; transition: background-color 0.3s ease; }
        .contact-form button:hover { background-color: #0056b3; }
    
    </style>
</head>
<body>
    <header>
        <div class="logo">92 Doner King</div>
    </header>
  
    <div class="container contact-section">
        <h2>Contact Us</h2>
        <p>Got any questions or feedback? Fill out the form below.</p>
        <form class="contact-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input type="text" name="name" placeholder="Your Name" required>
            <input type="text" name="email" placeholder="Your Email" required>
            <textarea name="message" rows="5" placeholder="Your Message" required></textarea>
            <button type="submit">Send Message</button>
        </form>
    </div>
    <footer>
        <div class="container">
            <p>&copy; 2024 92 Doner King - All Rights Reserved</p>
        </div>
    </footer>
</body>
</html>
