<?php
include '../serverdb/connectAdmin.php';

session_start();

// Check if admin is logged in
if (!isset($_SESSION['adminid'])) {
    header('Location: login.php');
    exit();
}

$adminid = $_SESSION['adminid'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(45deg, #A87676, #A87676, #CA8787, #E1ACAC, #A87676, #E1ACAC, #CA8787, #A87676, #A87676);
            background-size: 400% 400%;
            animation: gradientAnimation 8s ease infinite;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            height: 100vh;
            margin: 0;
            padding-top: 50px;
        }

        @keyframes gradientAnimation {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .header .logo {
            font-size: 24px;
            font-weight: bold;
            color: white;
            display: flex; 
            align-items: center; 
        }

        .header .logo .logo-image {
            width: 30px; 
            height: 30px; 
            margin-right: 10px; 
            animation: pumpAnimation 1.5s infinite ease-in-out;
        }

        @keyframes pumpAnimation {
            0% {
                transform: scale(1); 
            }
            50% {
                transform: scale(1.2); 
            }
            100% {
                transform: scale(1); 
            }
        }

        .header {
            width: 100%;
            background-color: #A87676;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
            position: absolute;
            top: 0;
            left: 0;
        }

        .header .logo {
            font-size: 24px;
            font-weight: bold;
            color: white;
        }

        .header nav {
            display: flex;
            justify-content: flex-start; 
            gap: 10px; 
            padding-right: 45px; 
        }


        .header a {
            text-decoration: none;
            color: white;
            font-weight: bold;
            font-size: 16px;
            padding: 10px 10px;
            border-radius: 4px;
        }

        .header a:hover {
            background-color: #CA8787;
        }

        .dashboard-container {
            width: 90%;
            margin-top: 30px;
        }

        .welcome-banner {
            background-color: #A87676;
            color: #343131;
            text-align: center;
            padding: 20px 15px;
            border: 2px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .welcome-banner h1 {
            font-family: 'Arial', sans-serif;
            font-size: 2rem;
            margin-bottom: 10px;
            color: #E5E1DA;
        }

        .welcome-banner p {
            font-family: 'Georgia', serif;
            font-size: 1.1rem;
            line-height: 1.6;
            margin: 0;
        }

        .order-summary-section {
            margin-top: 30px;
            padding: 15px;
            background-color: #E1ACAC;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .order-summary-section h2 {
            color: white;
            text-align: center;
            margin-bottom: 20px;
        }

        
        .table-valued-section {
            margin-top: 30px;
            padding: 15px;
            background-color: #E1ACAC;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .table-valued-section h2 {
            color: white;
            text-align: center;
            margin-bottom: 20px;
        }

        .logs-section {
            margin-top: 30px;
            padding: 15px;
            background-color: #E1ACAC;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .logs-section h2 {
            color: white;
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <header class="header">
        <div class="logo">
            <img src="../images/logo.png" class="logo-image">
            FitFusion
        </div>

        <!--navbar--->
        <nav>
            <a href="dashboard.php">Dashboard</a>
            <a href="login.php"><b>Logout</b></a>
        </nav>
    </header>

    <!-- Dashboard Content -->
<div class="dashboard-container">
     <!-- Welcome Banner -->
    <div class="welcome-banner">
        <h1>Welcome, Admin!</h1>
        <p>Manage the system, view reports, and oversee the operations efficiently. Your dashboard awaits!</p>
    </div>

   <!-- Logs Section -->
   <div class="logs-section">
    <h2>Recent Logs</h2>
    <?php
    // Fetch recent logs including usertype and action date
    $logsStmt = $db->query("SELECT logid, action, changetable, actiondate, usertype, userid FROM LOGS ORDER BY actiondate DESC LIMIT 10");
    $logs = $logsStmt->fetchAll(PDO::FETCH_ASSOC);

    if ($logs): ?>
        <table border="1" style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead>
                <tr>
                    <th style="padding: 8px; background-color: #A87676; color: white;">Usertype</th>
                    <th style="padding: 8px; background-color: #A87676; color: white;">Userid</th>
                    <th style="padding: 8px; background-color: #A87676; color: white;">Action</th>
                    <th style="padding: 8px; background-color: #A87676; color: white;">Table</th>
                    <th style="padding: 8px; background-color: #A87676; color: white;">Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($logs as $log): 
                    // Format ActionDate using DateTime
                    $formattedDate = (new DateTime($log['actiondate']))->format('l, F d, Y H:i:s');
                ?>
                    <tr>
                        <td style="padding: 8px; border: 1px solid #ddd;"><?php echo htmlspecialchars($log['usertype']); ?></td>
                        <td style="padding: 8px; border: 1px solid #ddd;"><?php echo htmlspecialchars($log['userid']); ?></td>
                        <td style="padding: 8px; border: 1px solid #ddd;"><?php echo htmlspecialchars($log['action']); ?></td>
                        <td style="padding: 8px; border: 1px solid #ddd;"><?php echo htmlspecialchars($log['changetable']); ?></td>
                        <td style="padding: 8px; border: 1px solid #ddd;"><?php echo $formattedDate; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No recent logs available.</p>
    <?php endif; ?>
</div>

    <!-- order-summary-section -->
<div class="order-summary-section">
    <h2>Order Summary</h2>
    <?php
    // Fetch data from the OrderSummary view with formatted order date
    try {
        $orderStmt = $db->query("SELECT orderid, buyername, productname, price, TO_CHAR(orderdate, 'FMDay, FMMonth DD, YYYY HH24:MI:SS') AS formatted_orderdate, status FROM OrderSummary");
        $orders = $orderStmt->fetchAll(PDO::FETCH_ASSOC);

        if ($orders): ?>
            <table border="1" style="width: 100%; border-collapse: collapse; text-align: left;">
                <thead>
                    <tr>
                        <th style="padding: 8px; background-color: #A87676; color: white;">Order ID</th>
                        <th style="padding: 8px; background-color: #A87676; color: white;">Buyer Name</th>
                        <th style="padding: 8px; background-color: #A87676; color: white;">Product Name</th>
                        <th style="padding: 8px; background-color: #A87676; color: white;">Price</th>
                        <th style="padding: 8px; background-color: #A87676; color: white;">Order Date</th>
                        <th style="padding: 8px; background-color: #A87676; color: white;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td style="padding: 8px; border: 1px solid #ddd;"><?php echo htmlspecialchars($order['orderid']); ?></td>
                            <td style="padding: 8px; border: 1px solid #ddd;"><?php echo htmlspecialchars($order['buyername']); ?></td>
                            <td style="padding: 8px; border: 1px solid #ddd;"><?php echo htmlspecialchars($order['productname']); ?></td>
                            <td style="padding: 8px; border: 1px solid #ddd;"><?php echo htmlspecialchars($order['price']); ?></td>
                            <td style="padding: 8px; border: 1px solid #ddd;"><?php echo htmlspecialchars($order['formatted_orderdate']); ?></td>
                            <td style="padding: 8px; border: 1px solid #ddd;"><?php echo htmlspecialchars($order['status']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No orders found.</p>
        <?php endif;
    } catch (Exception $e) {
        echo "<p>Error fetching order summary: " . htmlspecialchars($e->getMessage()) . "</p>";
    }
    ?>
</div>


<!-- Most Availed Products Section -->
<div class="table-valued-section">
    <h2>Top Selling Products</h2>
    <?php
    // Fetch top-selling products from the materialized view
    $topSellingStmt = $db->query("SELECT * FROM MostAvailedProducts");
    $MostAvailedProducts = $topSellingStmt->fetchAll(PDO::FETCH_ASSOC);

    if ($MostAvailedProducts): ?>
        <table border="1" style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead>
                <tr>
                    <th style="padding: 8px; background-color: #A87676; color: white;">Product Name</th>
                    <th style="padding: 8px; background-color: #A87676; color: white;">Total Orders</th>
                    <th style="padding: 8px; background-color: #A87676; color: white;">Total Revenue</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($MostAvailedProducts as $product): ?>
                    <tr>
                        <td style="padding: 8px; border: 1px solid #ddd;"><?php echo htmlspecialchars($product['productname']); ?></td>
                        <td style="padding: 8px; border: 1px solid #ddd;"><?php echo htmlspecialchars($product['totalorders']); ?></td>
                        <td style="padding: 8px; border: 1px solid #ddd;"><?php echo htmlspecialchars($product['totalrevenue']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No top-selling products available.</p>
    <?php endif; ?>
</div>

    <!-- Table-Valued Function Section -->
    <div class="table-valued-section">
        <h2>Products by Category</h2>
        <?php
        // Example usage of table-valued function
        $categoryName = 'bags'; // Example category
        $tableStmt = $db->prepare("SELECT * FROM GetProductsByCategory(?)");
        $tableStmt->execute([$categoryName]);
        $products = $tableStmt->fetchAll(PDO::FETCH_ASSOC);

        if ($products): ?>
            <table border="1" style="width: 100%; border-collapse: collapse; text-align: left;">
                <thead>
                    <tr>
                        <th style="padding: 8px; background-color: #A87676; color: white;">Product ID</th>
                        <th style="padding: 8px; background-color: #A87676; color: white;">Product Name</th>
                        <th style="padding: 8px; background-color: #A87676; color: white;">Description</th>
                        <th style="padding: 8px; background-color: #A87676; color: white;">Price</th>
                        <th style="padding: 8px; background-color: #A87676; color: white;">Category</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td style="padding: 8px; border: 1px solid #ddd;"><?php echo htmlspecialchars($product['productid']); ?></td>
                            <td style="padding: 8px; border: 1px solid #ddd;"><?php echo htmlspecialchars($product['productname']); ?></td>
                            <td style="padding: 8px; border: 1px solid #ddd;"><?php echo htmlspecialchars($product['description']); ?></td>
                            <td style="padding: 8px; border: 1px solid #ddd;"><?php echo htmlspecialchars($product['price']); ?></td>
                            <td style="padding: 8px; border: 1px solid #ddd;"><?php echo htmlspecialchars($product['categoryname']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No products found in the "<?php echo htmlspecialchars($categoryName); ?>" category.</p>
        <?php endif; ?>
    </div>


</div>
</body>
</html>
