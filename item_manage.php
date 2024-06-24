<?php
session_start();
include 'db.php'; // Include your database connection file

// Check if user is logged in and is an admin or staff
if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== true || ($_SESSION["role"] !== "admin" && $_SESSION["role"] !== "staff")) {
    header("location: login.php");
    exit;
}


// Handle item management actions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add_item'])) {
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $active = isset($_POST['active']) ? 1 : 0;
        $locationID = $_POST['locationID'];
        $imagePath = $_POST['imagePath'];

        $insertItemQuery = "INSERT INTO item (Name, Description, Price, Active, LocationID, imagePath) VALUES ('$name', '$description', '$price', '$active', '$locationID', '$imagePath')";
        if ($conn->query($insertItemQuery) === TRUE) {
            echo "Item added successfully";
        } else {
            echo "Error adding item: " . $conn->error;
        }
    } elseif (isset($_POST['remove_item'])) {
        $itemID = $_POST['itemID'];

        // Delete item entry
        $deleteItemQuery = "DELETE FROM item WHERE ItemID = $itemID";
        if ($conn->query($deleteItemQuery) === TRUE) {
            echo "Item removed successfully";
        } else {
            echo "Error removing item: " . $conn->error;
        }
    }
}

// Fetch locations for dropdown
$locationQuery = "SELECT * FROM location";
$locationResult = $conn->query($locationQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Item Management</title>
    <style>
        /* CSS styles */
        body { font-family: Arial, sans-serif; background-color: #f8f9fa; color: #333; margin: 0; padding: 0; }
        header, footer { background-color: #000; color: #fff; text-align: center; padding: 20px 0; }
        .container { padding: 20px; }
        form { margin-top: 20px; }
        input[type="text"], input[type="number"], textarea, select { width: calc(100% - 22px); padding: 10px; margin: 10px 0; border-radius: 5px; border: 1px solid #ccc; }
        input[type="submit"] { width: 100%; padding: 10px; border: none; border-radius: 5px; color: #fff; background-color: #007bff; cursor: pointer; }
        input[type="submit"]:hover { background-color: #0056b3; }
        input[type="checkbox"] { margin-right: 5px; }
    </style>
</head>
<body>
    <header>
        <h1>Item Management</h1>
    </header>

    <div class="container">
        <!-- Add Item Form -->
        <h2>Add Item</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" required><br>
            <label for="description">Description:</label>
            <textarea name="description" id="description" rows="4"></textarea><br>
            <label for="price">Price:</label>
            <input type="number" name="price" id="price" min="0" step="0.01" required><br>
            <label for="active">Active:</label>
            <input type="checkbox" name="active" id="active" value="1" checked><br>
            <label for="locationID">Select Location:</label>
            <select name="locationID" id="locationID">
                <?php while ($row = $locationResult->fetch_assoc()) { ?>
                    <option value="<?php echo $row['LocationID']; ?>"><?php echo $row['Name']; ?></option>
                <?php } ?>
            </select><br>
            <label for="imagePath">Image Path:</label>
            <input type="text" name="imagePath" id="imagePath"><br>
            <input type="submit" name="add_item" value="Add Item">
        </form>

        <!-- Remove Item Form -->
        <h2>Remove Item</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="itemID">Select Item:</label>
            <select name="itemID" id="itemID">
                <?php
                $itemQuery = "SELECT * FROM item";
                $itemResult = $conn->query($itemQuery);
                while ($row = $itemResult->fetch_assoc()) {
                    echo "<option value='" . $row['ItemID'] . "'>" . $row['Name'] . "</option>";
                }
                ?>
            </select><br>
            <input type="submit" name="remove_item" value="Remove Item">
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
