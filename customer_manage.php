<?php
session_start();
include 'db.php'; // Include your database connection file

// Check if user is logged in and is an admin
if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== true || $_SESSION["role"] !== "admin") {
    header("location: login.php");
    exit;
}

// Handle customer management actions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add_customer'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password

        // Check if customer with given email exists
        $checkCustomerQuery = "SELECT * FROM customer WHERE Email = '$email'";
        $customerResult = $conn->query($checkCustomerQuery);
        if ($customerResult->num_rows == 0) {
            // Customer does not exist, insert into customer table
            $insertCustomerQuery = "INSERT INTO customer (Name, Email, Phone, Address, PasswordHash) VALUES ('$name', '$email', '$phone', '$address', '$password')";
            if ($conn->query($insertCustomerQuery) === TRUE) {
                echo "Customer added successfully";
            } else {
                echo "Error adding customer: " . $conn->error;
            }
        } else {
            echo "Customer with email $email already exists";
        }
    } elseif (isset($_POST['remove_customer'])) {
        $customerID = $_POST['customerID'];

        // Delete customer entry
        $deleteCustomerQuery = "DELETE FROM customer WHERE CustomerID = $customerID";
        if ($conn->query($deleteCustomerQuery) === TRUE) {
            echo "Customer removed successfully";
        } else {
            echo "Error removing customer: " . $conn->error;
        }
    }
}

// Fetch customers for display
$customerQuery = "SELECT * FROM customer";
$customerResult = $conn->query($customerQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Management</title>
    <style>
        /* CSS styles */
        body { font-family: Arial, sans-serif; background-color: #f8f9fa; color: #333; margin: 0; padding: 0; }
        header, footer { background-color: #000; color: #fff; text-align: center; padding: 20px 0; }
        .container { padding: 20px; }
        table { width: 100%; border-collapse: collapse; }
        table th, table td { padding: 10px; border: 1px solid #ddd; }
        form { margin-top: 20px; }
        input[type="text"], input[type="email"], input[type="password"], select { width: 100%; padding: 10px; margin: 10px 0; border-radius: 5px; border: 1px solid #ccc; }
        input[type="submit"] { width: 100%; padding: 10px; border: none; border-radius: 5px; color: #fff; background-color: #007bff; cursor: pointer; }
        input[type="submit"]:hover { background-color: #0056b3; }
        .remove-btn { background-color: #dc3545; }
    </style>
</head>
<body>
    <h1>Customer Management</h1>

    <!-- Add Customer Form -->
    <h2>Add Customer</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" required><br>
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required><br>
        <label for="phone">Phone:</label>
        <input type="text" name="phone" id="phone" required><br>
        <label for="address">Address:</label>
        <input type="text" name="address" id="address" required><br>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required><br>
        <input type="submit" name="add_customer" value="Add Customer">
    </form>

    <!-- Remove Customer Form -->
    <h2>Remove Customer</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="customerID">Select Customer:</label>
        <select name="customerID" id="customerID">
            <?php while ($row = $customerResult->fetch_assoc()) { ?>
                <option value="<?php echo $row['CustomerID']; ?>"><?php echo $row['Name']; ?> - <?php echo $row['Email']; ?></option>
            <?php } ?>
        </select><br>
        <input type="submit" name="remove_customer" value="Remove Customer">
    </form>

</body>
</html>

<?php
// Close database connection
$conn->close();
?>
