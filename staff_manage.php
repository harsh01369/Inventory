<?php
session_start();
if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== true) {
    header("location: login.php");
    exit;
}

if ($_SESSION["role"] !== "admin") {
    header("location: unauthorized.php");
    exit;
}

include 'db.php'; // Include your database connection file

// Fetch staff members
$sql = "SELECT * FROM staff";
$result = $conn->query($sql);

// Add staff member
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_staff"])) {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $role = $_POST["role"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $adminID = $_SESSION["user_id"]; // Assuming the admin adding the staff is logged in

    $sql = "INSERT INTO staff (Name, Email, Role, PasswordHash, AdminID) VALUES ('$name', '$email', '$role', '$password', '$adminID')";
    if ($conn->query($sql) === TRUE) {
        // Staff member added successfully
        header("Refresh:0");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Remove staff member
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["remove_staff"])) {
    $staffID = $_POST["staff_id"];

    $sql = "DELETE FROM staff WHERE StaffID='$staffID'";
    if ($conn->query($sql) === TRUE) {
        // Staff member removed successfully
        header("Refresh:0");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Management</title>
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

<header>
    <h1>Staff Management</h1>
</header>

<div class="container">
    <table>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Actions</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["Name"] . "</td>";
                echo "<td>" . $row["Email"] . "</td>";
                echo "<td>" . $row["Role"] . "</td>";
                echo "<td><form method='post'><input type='hidden' name='staff_id' value='" . $row["StaffID"] . "'><input type='submit' class='remove-btn' name='remove_staff' value='Remove'></form></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No staff members found</td></tr>";
        }
        ?>
    </table>

    <h2>Add Staff Member</h2>
    <form method="post">
        <input type="text" name="name" placeholder="Name" required><br>
        <input type="email" name="email" placeholder="Email" required><br>
        <select name="role" required>
            <option value="" disabled selected>Select Role</option>
            <option value="Manager">Manager</option>
            <option value="Cashier">Cashier</option>
            <option value="Chef">Chef</option>
        </select><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <input type="submit" name="add_staff" value="Add Staff Member">
    </form>
</div>

<footer>
     <p>&copy; 2024 92 Doner King - All Rights Reserved</p>
</footer>

</body>
</html>
