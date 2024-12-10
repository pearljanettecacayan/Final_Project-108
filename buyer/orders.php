<?php
include '../serverdb/connectBuyer.php';

session_start();

if (!isset($_SESSION['buyerid'])) {
    header('Location: login.php');
    exit();
}

$buyerid = $_SESSION['buyerid'];

$sql = "SELECT o.orderid, p.image, p.productname, p.price, o.status, o.orderdate 
        FROM orders o 
        JOIN products p ON o.productid = p.productid
        JOIN buyer b ON b.buyerid = o.buyerid
        WHERE b.buyerid = :buyerid"; 

$stmt = $db->prepare($sql);
$stmt->execute([':buyerid' => $buyerid]);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
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
            padding-top: 20px;
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
            0% { transform: scale(1); }
            50% { transform: scale(1.2); }
            100% { transform: scale(1); }
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

        .cart-container {
            max-width: 800px;
            margin: 0 auto;
            background-color: white;
            padding: 30px 40px; 
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            margin-top: 50px; 
            margin-bottom: 50px;
            min-height: 500px; 
        }

        .cart-title {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
            color: #A87676;
        }

        .cart-table th, .cart-table td {
            padding: 20px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .cart-table img {
            width: 80px;
            height: auto;
            object-fit: cover;
            border-radius: 5px;
        }

        .pending-status {
            color: green;
        }

        .delete-button {
            background-color: #A87676;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
<header class="header">
    <div class="logo">
        <img src="../images/logo.png" class="logo-image">
        FitFusion
    </div>

    <nav>
        <a href="dashboard.php"><b>Dashboard</b></a>
        <a href="orders.php"><b>Orders</b></a>
        <a href="login.php"><b>Logout</b></a>
    </nav>
</header>

<div class="cart-container">
    <div class="cart-title">Your Shopping Cart</div>

    <table class="cart-table">
        <thead>
            <tr>
                <th>Product Image</th>
                <th>Product Name</th>
                <th>Price</th>
                <th>Date</th>
                <th>Status</th>
                <th>Actions</th> 
            </tr>
        </thead>
        <tbody id="cart-items">
            <?php foreach ($products as $product): ?>
                <tr>
                    <td><img src="../<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['productname']); ?>"></td>
                    <td><?php echo htmlspecialchars($product['productname']); ?></td>
                    <td><?php echo htmlspecialchars($product['price']); ?></td>
                    <td><?php echo htmlspecialchars($product['orderdate']); ?></td>
                    <td class="<?php echo $product['status'] == 'pending' ? 'pending-status' : ''; ?>">
                        <?php echo htmlspecialchars($product['status']); ?>
                    </td>
                    <td>
                        <form action="delete_order.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this item?');">
                            <input type="hidden" name="orderid" value="<?php echo htmlspecialchars($product['orderid']); ?>">
                            <button type="submit" class="delete-button">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
