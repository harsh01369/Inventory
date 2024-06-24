<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Assuming PHPMailer is installed via Composer

session_start(); // Start the session at the beginning of the script

// Database connection
include 'db.php'; // Ensure you have the db.php file as previously described

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $check = $conn->query("SELECT * FROM Customer WHERE Email = '$email'");
    if ($check->num_rows > 0) {
        $_SESSION['error'] = "User already exists!";
        header('Location: register_customer.php');
        exit();
    } else {
        $sql = "INSERT INTO Customer (Name, Email, PasswordHash) VALUES ('$name', '$email', '$password')";
        if ($conn->query($sql) === TRUE) {
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'takeawayking92@gmail.com';
                $mail->Password = 'jqtl bfxc jyws rdaw';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom('takeawayking92@gmail.com', 'Doner Kings');
                $mail->addAddress($email, $name);

                $mail->isHTML(true);
                $mail->Subject = 'Registration Confirmation';
                $mail->Body = 'This is a confirmation that you have registered successfully with Doner Kings.';

                $mail->send();
                $_SESSION['message'] = 'Registration successful. Please check your email for confirmation.';
                header('Location: login.php');
                exit();
            } catch (Exception $e) {
                $_SESSION['error'] = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                header('Location: register_customer.php');
                exit();
            }
        } else {
            $_SESSION['error'] = "Error: " . $conn->error;
            header('Location: register_customer.php');
            exit();
        }
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f8f9fa; color: #333; margin: 0; padding: 0; }
        form { max-width: 300px; margin: 50px auto; padding: 20px; background-color: #fff; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); }
        input, button { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ccc; border-radius: 5px; }
        button { background-color: #007bff; color: #fff; cursor: pointer; }
        button:hover { background-color: #0056b3; }
        .error, .success { color: #ff0000; text-align: center; }
    </style>
</head>
<body>

<?php
if (isset($_SESSION['error'])) {
    echo '<div class="error">' . $_SESSION['error'] . '</div>';
    unset($_SESSION['error']);
}
if (isset($_SESSION['message'])) {
    echo '<div class="success">' . $_SESSION['message'] . '</div>';
    unset($_SESSION['message']);
}
?>

<form action="register_customer.php" method="post">
    <input type="text" name="name" placeholder="Your Full Name" required>
    <input type="email" name="email" placeholder="Your Email" required>
    <input type="password" name="password" placeholder="Your Password" required>
    <button type="submit">Register</button>
</form>

<p style="text-align:center">Already have an account? <a href="login.php">Login here</a></p>

</body>
</html>
