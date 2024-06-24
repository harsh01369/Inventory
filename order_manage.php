<?php
session_start();
if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== true) {
    header("location: login.php");
    exit;
}

// Check if user is logged in and is an admin or staff
if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== true || ($_SESSION["role"] !== "admin" && $_SESSION["role"] !== "staff")) {
    header("location: login.php");
    exit;
}


include 'db.php'; // Include your database connection file

// Fetch orders
$sql = "SELECT * FROM orders";
$result = $conn->query($sql);

// Update order status
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_status"])) {
    $orderID = $_POST["order_id"];
    $status = $_POST["status"];

    $sql = "UPDATE orders SET Status='$status' WHERE OrderID='$orderID'";
    if ($conn->query($sql) === TRUE) {
        // Order status updated successfully
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
    <title>Order Management</title>
    <style>
        /* CSS styles */
        body { font-family: Arial, sans-serif; background-color: #f8f9fa; color: #333; margin: 0; padding: 0; }
        header, footer { background-color: #000; color: #fff; text-align: center; padding: 20px 0; }
        .container { padding: 20px; }
        table { width: 100%; border-collapse: collapse; }
        table th, table td { padding: 10px; border: 1px solid #ddd; }
        form { margin-top: 20px; }
        select { padding: 10px; margin: 10px 0; border-radius: 5px; border: 1px solid #ccc; }
        input[type="submit"] { padding: 10px; border: none; border-radius: 5px; color: #fff; background-color: #007bff; cursor: pointer; }
        input[type="submit"]:hover { background-color: #0056b3; }
    </style>
</head>
<body>

<header>
    <h1>Order Management</h1>
</header>

<div class="container">
    <table>
        <tr>
            <th>Order ID</th>
            <th>Customer ID</th>
            <th>Order Date</th>
            <th>Status</th>
            <th>Total Price</th>
            <th>Action</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["OrderID"] . "</td>";
                echo "<td>" . $row["CustomerID"] . "</td>";
                echo "<td>" . $row["OrderDate"] . "</td>";
                echo "<td>" . $row["Status"] . "</td>";
                echo "<td>" . $row["TotalPrice"] . "</td>";
                echo "<td>";
                echo "<form method='post'>";
                echo "<input type='hidden' name='order_id' value='" . $row["OrderID"] . "'>";
                echo "<select name='status'>";
                echo "<option value='NEW'>NEW</option>";
                echo "<option value='PREPARING'>PREPARING</option>";
                echo "<option value='COMPLETED'>COMPLETED</option>";
                echo "<option value='CANCELLED'>CANCELLED</option>";
                echo "</select>";
                echo "<input type='submit' name='update_status' value='Update'>";
                echo "</form>";
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No orders found</td></tr>";
        }
        ?>
    </table>
</div>

<footer>
     <p>&copy; 2024 92 Doner King - All Rights Reserved</p>
</footer>

</body>
</html>
