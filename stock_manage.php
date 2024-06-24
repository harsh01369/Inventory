<?php
session_start();
include 'db.php'; // Include your database connection file


// Check if user is logged in and is an admin or staff
if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== true || ($_SESSION["role"] !== "admin" && $_SESSION["role"] !== "staff")) {
    header("location: login.php");
    exit;
}


// Handle stock management actions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add_stock'])) {
        $itemID = $_POST['itemID'];
        $locationID = $_POST['locationID'];
        $quantity = $_POST['quantity'];

        // Check if item with given ID exists
        $checkItemQuery = "SELECT * FROM item WHERE ItemID = $itemID";
        $itemResult = $conn->query($checkItemQuery);
        if ($itemResult->num_rows > 0) {
            // Item exists, insert into stock table
            $insertStockQuery = "INSERT INTO stock (ItemID, LocationID, Quantity) VALUES ('$itemID', '$locationID', '$quantity')";
            if ($conn->query($insertStockQuery) === TRUE) {
                echo "Stock added successfully";
            } else {
                echo "Error adding stock: " . $conn->error;
            }
        } else {
            echo "Item with ID $itemID does not exist";
        }
    } elseif (isset($_POST['remove_stock'])) {
        $stockID = $_POST['stockID'];

        // Delete stock entry
        $deleteStockQuery = "DELETE FROM stock WHERE StockID = $stockID";
        if ($conn->query($deleteStockQuery) === TRUE) {
            echo "Stock removed successfully";
        } else {
            echo "Error removing stock: " . $conn->error;
        }
    }
}

// Fetch items and locations for dropdowns
$itemQuery = "SELECT * FROM item";
$locationQuery = "SELECT * FROM location";
$itemResult = $conn->query($itemQuery);
$locationResult = $conn->query($locationQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Management</title>
    <style>
        /* CSS styles */
        body { font-family: Arial, sans-serif; background-color: #f8f9fa; color: #333; margin: 0; padding: 0; }
        header, footer { background-color: #000; color: #fff; text-align: center; padding: 20px 0; }
        .container { padding: 20px; }
        table { width: 100%; border-collapse: collapse; }
        table th, table td { padding: 10px; border: 1px solid #ddd; }
        form { margin-top: 20px; }
        input[type="text"], input[type="email"], input[type="password"], select { width: calc(100% - 22px); padding: 10px; margin: 10px 0; border-radius: 5px; border: 1px solid #ccc; }
        input[type="submit"] { width: 100%; padding: 10px; border: none; border-radius: 5px; color: #fff; background-color: #007bff; cursor: pointer; }
        input[type="submit"]:hover { background-color: #0056b3; }
        .remove-btn { background-color: #dc3545; }
    </style>
</head>
<body>
    <header>
        <h1>Stock Management</h1>
    </header>

    <div class="container">
        <!-- Add Stock Form -->
        <h2>Add Stock</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="itemID">Select Item:</label>
            <select name="itemID" id="itemID">
                <?php while ($row = $itemResult->fetch_assoc()) { ?>
                    <option value="<?php echo $row['ItemID']; ?>"><?php echo $row['Name']; ?></option>
                <?php } ?>
            </select><br>
            <label for="locationID">Select Location:</label>
            <select name="locationID" id="locationID">
                <?php while ($row = $locationResult->fetch_assoc()) { ?>
                    <option value="<?php echo $row['LocationID']; ?>"><?php echo $row['Name']; ?></option>
                <?php } ?>
            </select><br>
            <label for="quantity">Quantity:</label>
            <input type="number" name="quantity" id="quantity" min="1" required><br>
            <input type="submit" name="add_stock" value="Add Stock">
        </form>

        <!-- Remove Stock Form -->
        <h2>Remove Stock</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="stockID">Select Stock:</label>
            <select name="stockID" id="stockID">
                <?php
                $stockQuery = "SELECT * FROM stock";
                $stockResult = $conn->query($stockQuery);
                while ($row = $stockResult->fetch_assoc()) {
                    echo "<option value='" . $row['StockID'] . "'>" . $row['StockID'] . " - Item: " . $row['ItemID'] . ", Location: " . $row['LocationID'] . ", Quantity: " . $row['Quantity'] . "</option>";
                }
                ?>
            </select><br>
            <input type="submit" name="remove_stock" value="Remove Stock">
        </form>
    </div>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Your Company Name. All rights reserved.</p>
    </footer>

</body>
</html>

<?php
// Close database connection
$conn->close();
?>
