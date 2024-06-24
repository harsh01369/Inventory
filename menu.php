<?php
session_start();
include 'db.php'; // Include your database connection file

// Check if user is logged in
if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== true) {
    header("location: login.php");
    exit;
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['place_order'])) {
    // Retrieve order data
    $orderDate = date("Y-m-d");
    $totalPrice = $_POST["totalPrice"];

    // Insert order data into the orders table
    $insertOrderQuery = "INSERT INTO orders (OrderDate, Status, TotalPrice) VALUES ('$orderDate', 'NEW', '$totalPrice')";
    if ($conn->query($insertOrderQuery) === TRUE) {
        // Update daily sales
        $updateSalesQuery = "INSERT INTO daily_sales (SaleDate, TotalSales, NumberOfOrders) 
                             VALUES ('$orderDate', '$totalPrice', 1) 
                             ON DUPLICATE KEY UPDATE TotalSales = TotalSales + '$totalPrice', NumberOfOrders = NumberOfOrders + 1";
        if ($conn->query($updateSalesQuery) === TRUE) {
            // JavaScript to show popup message and redirect
            echo "<script>alert('Order placed successfully!');</script>";
            echo "<script>window.location = 'main.php';</script>";
            exit;
        } else {
            // Error updating daily sales
            echo "<script>alert('Error updating daily sales. Please try again later.');</script>";
            echo "<script>window.location = 'menu2.php';</script>";
            exit;
        }
    } else {
        // JavaScript to show popup message and redirect
        echo "<script>alert('Error placing order. Please try again later.');</script>";
        echo "<script>window.location = 'menu2.php';</script>";
        exit;
    }
}

// Fetch active items from the database within the specific item ID range
$query = "SELECT * FROM item WHERE Active = 1 AND ItemID BETWEEN 46 AND 60";
$result = $conn->query($query);
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doner Kings - Menu</title>
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
        /* Additional styles for the dynamic menu interaction */
        .menu-item, .meal-deal { transition: transform .2s; /* Animation */ }
        .menu-item:hover, .meal-deal:hover { transform: scale(1.05); /* Slightly enlarge items on hover */ }
        .meal-deal { background-color: #ffe8d6; /* Different background for meal deals */ }
        .price-total { font-weight: bold; margin-top: 20px; }
        .order-button { margin-top: 20px; }
        .btn-remove { margin-top: 10px; background-color: #ff4d4d; color: white; display: none; }
        .menu-item, .meal-deal { margin-bottom: 20px; padding: 15px; border: 1px solid #ccc; border-radius: 5px; }
        .meal-deal { background-color: #ffe8d6; }
        .price-total { font-weight: bold; margin-top: 20px; }
        .order-button { margin-top: 20px; }
        img { max-width: 100%; height: auto; border-radius: 5px; }
    </style>
</head>
<body>
    <header>
        <div class="logo">Doner Kings</div>
    </header>
    <nav>
        <ul>
            <li><a href="main.php">Home</a></li>
            <li><a href="menu.php">Menu</a></li>
            <li><a href="location.php">Locations</a></li>
            <li><a href="aboutus.php">About Us</a></li>
            
            <?php
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
    <div class="container">
        <!-- Your existing container content -->
        <h1 class="text-center mt-5 mb-4">Menu</h1>
        <div class="row">
            <?php if ($result && $result->num_rows > 0): ?>
                <div class="row">
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <div class="col-md-4 menu-item" data-item-id="<?php echo isset($row['itemID']) ? $row['itemID'] : ''; ?>">
                            <img src="<?php echo $row['imagePath']; ?>" alt="<?php echo $row['Name']; ?>" class="img-fluid">
                            <h2><?php echo $row['Name']; ?></h2>
                            <p><?php echo $row['Description']; ?></p>
                            <p>Price: $<span class="item-price" data-price="<?php echo $row['Price']; ?>"><?php echo $row['Price']; ?></span></p>
                            <input type="number" class="quantity-input" value="1" min="1">
							<button class="btn btn-primary add-to-order" <?php if(isset($row['itemID'])) echo 'data-item-id="' . $row['itemID'] . '"'; ?> <?php if(isset($row['Price'])) echo 'data-price="' . $row['Price'] . '"'; ?>>Add to Order</button>

                            <button class="btn btn-remove remove-from-order" style="display: none;">Remove from Order</button>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <p class="text-center">No items found.</p>
            <?php endif; ?>
        </div>
        <div class="price-total">Total: $<span id="totalPrice">0.00</span></div>
        <form id="orderForm" method="post">
            <input type="hidden" name="totalPrice" id="totalPriceInput" value="0.00">
            <input type="hidden" name="items" id="orderItems" value="[]">
            <button class="btn btn-success order-button" type="submit" name="place_order">Place Order</button>
        </form>
    </div>
	<footer>
        <p>&copy; 2024 Doner Kings - All Rights Reserved</p>
    </footer>
	<script>
document.addEventListener("DOMContentLoaded", function() {
    let orderTotal = 0;
    const orderItems = [];

    document.querySelectorAll('.add-to-order').forEach(button => {
        button.addEventListener('click', () => {
            const price = parseFloat(button.getAttribute('data-price'));
            const itemID = parseInt(button.getAttribute('data-item-id'));
            const quantity = parseInt(button.parentElement.querySelector('.quantity-input').value);
            const totalPrice = price * quantity;

            orderTotal += totalPrice;
            document.getElementById('totalPrice').textContent = orderTotal.toFixed(2);

            orderItems.push({ itemID, quantity });

            button.nextElementSibling.style.display = 'inline-block'; // Show remove button
            button.style.display = 'none'; // Hide add button

            updateOrderFormData();
        });
    });

    document.querySelectorAll('.remove-from-order').forEach(button => {
        button.addEventListener('click', () => {
            const price = parseFloat(button.previousElementSibling.getAttribute('data-price'));
            const itemID = parseInt(button.getAttribute('data-item-id'));
            const quantity = parseInt(button.parentElement.querySelector('.quantity-input').value);
            const totalPrice = price * quantity;

            orderTotal -= totalPrice;
            orderTotal = Math.max(0, orderTotal); // Prevent negative total
            document.getElementById('totalPrice').textContent = orderTotal.toFixed(2);

            const index = orderItems.findIndex(item => item.itemID === itemID);
            if (index !== -1) {
                orderItems.splice(index, 1);
            }

            button.style.display = 'none'; // Hide remove button
            button.previousElementSibling.style.display = 'inline-block'; // Show add button

            updateOrderFormData();
        });
    });

    function updateOrderFormData() {
        document.getElementById('totalPriceInput').value = orderTotal.toFixed(2);
        document.getElementById('orderItems').value = JSON.stringify(orderItems);
    }
});
</script>
</body>
</html>



 