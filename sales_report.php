<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Report</title>
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
        #chart { margin-top: 20px; }
    </style>
    <!-- Add ApexCharts library -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
</head>
<body>

<header>
    <h1>Sales Report</h1>
</header>


<div class="container">
    <h2>Monthly Sales</h2>
    <!-- Monthly sales table -->
    <table>
        <tr>
            <th>Month</th>
            <th>Total Sales</th>
            <th>Number of Orders</th>
        </tr>
        <!-- PHP code to fetch and display monthly sales data -->
        <?php
            include 'db.php'; // Include your database connection file
            
            // Fetch monthly sales data
            $monthlySalesQuery = "SELECT MONTH(SaleDate) AS Month, SUM(TotalSales) AS TotalSales, COUNT(*) AS NumberOfOrders FROM daily_sales GROUP BY MONTH(SaleDate)";
            $monthlySalesResult = $conn->query($monthlySalesQuery);
            
            if ($monthlySalesResult->num_rows > 0) {
                while ($row = $monthlySalesResult->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["Month"] . "</td>";
                    echo "<td>" . $row["TotalSales"] . "</td>";
                    echo "<td>" . $row["NumberOfOrders"] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='3'>No monthly sales data found</td></tr>";
            }
            
            $conn->close();
        ?>
    </table>

    <h2>Yearly Sales</h2>
    <!-- Yearly sales table -->
    <table>
        <tr>
            <th>Year</th>
            <th>Total Sales</th>
            <th>Number of Orders</th>
        </tr>
        <!-- PHP code to fetch and display yearly sales data -->
        <?php
            include 'db.php'; // Include your database connection file
            
            // Fetch yearly sales data
            $yearlySalesQuery = "SELECT YEAR(SaleDate) AS Year, SUM(TotalSales) AS TotalSales, COUNT(*) AS NumberOfOrders FROM daily_sales GROUP BY YEAR(SaleDate)";
            $yearlySalesResult = $conn->query($yearlySalesQuery);
            
            if ($yearlySalesResult->num_rows > 0) {
                while ($row = $yearlySalesResult->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["Year"] . "</td>";
                    echo "<td>" . $row["TotalSales"] . "</td>";
                    echo "<td>" . $row["NumberOfOrders"] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='3'>No yearly sales data found</td></tr>";
            }
            
            $conn->close();
        ?>
    </table>

    <!-- Chart to display sales data -->
    <div id="chart"></div>
</div>

<footer>
    <p>&copy; <?php echo date("Y"); ?> Doner King. All rights reserved.</p>
</footer>

<!-- JavaScript code for ApexCharts -->
<script>
    // Fetch and prepare sales data
    <?php
        include 'db.php'; // Include your database connection file
        
        // Fetch sales data
        $salesQuery = "SELECT SaleDate, TotalSales FROM daily_sales";
        $salesResult = $conn->query($salesQuery);
        
        $dates = array();
        $sales = array();
        
        if ($salesResult->num_rows > 0) {
            while ($row = $salesResult->fetch_assoc()) {
                $dates[] = $row["SaleDate"];
                $sales[] = $row["TotalSales"];
            }
        }
        
        // Close database connection
        $conn->close();
        
        // Convert PHP arrays to JavaScript arrays
        $dates_js = json_encode($dates);
        $sales_js = json_encode($sales);
    ?>

    // JavaScript code to render chart using ApexCharts
    var options = {
        chart: {
            type: 'line',
            height: 350
        },
        series: [{
            name: 'Sales',
            data: <?php echo $sales_js; ?>
        }],
        xaxis: {
            categories: <?php echo $dates_js; ?>,
            title: {
                text: 'Date'
            }
        },
        yaxis: {
            title: {
                text: 'Sales Amount'
            }
        }
    };

    var chart = new ApexCharts(document.querySelector("#chart"), options);
    chart.render();
</script>


</body>
</html>
