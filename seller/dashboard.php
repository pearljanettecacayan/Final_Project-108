<?php
include '../serverdb/connectSeller.php';

session_start();

if (!isset($_SESSION['sellerid'])) {
    header('Location: login.php');
    exit();
}

$buyerid=$_SESSION['sellerid'];

// Fetch all categories
$categorySql = "SELECT * FROM categories"; // Assuming you have a categories table
$categoryStmt = $db->prepare($categorySql);
$categoryStmt->execute();
$categories = $categoryStmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch products with categoryid
$productSql = "SELECT * FROM products";
$productStmt = $db->prepare($productSql);
$productStmt->execute();
$products = $productStmt->fetchAll(PDO::FETCH_ASSOC);

// Group products by categoryid
$productsByCategory = [];
foreach ($products as $product) {
    $productsByCategory[$product['categoryid']][] = $product;
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
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
            color: white;
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
            color: #333;
        }

        .welcome-banner p {
            font-family: 'Georgia', serif;
            font-size: 1.1rem;
            line-height: 1.6;
            margin: 0;
        }


        .category {
            margin-bottom: 40px;
        }

        .category h2 {
            color: white;
            text-align: center;
            margin-bottom: 20px;
        }

        .product-card {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            color: #A87676;
        }

        .product-card img {
            width: 100%;
            height: auto;
            border-radius: 8px;
            max-height: 250px;
            object-fit: cover;
        }

        .product-card h3 {
            margin-top: 15px;
        }

        .product-card p {
            font-size: 14px;
            margin: 10px 0;
        }

        .product-card button {
            background-color: #A87676;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            width: 100%;
        }

        .product-card button:hover {
            background-color: #CA8787;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
        }

        .product-card .edit-button{
            background-color: #A87676;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            margin: 5px 0;
            width: 100%;
        }

        .product-card .edit-button:hover {
            background-color: #CA8787;
        }

        .product-card .delete-button {
            background-color: #ccc;
            color: #333;
            border: none;
            padding: 10px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            margin: 5px 0;
            width: 100%;
        }

        .product-card .delete-button:hover {
            background-color: #bbb;
        }

        .price {
            font-size: 18px;
            color: #A87676; 
            font-weight: bold;
            margin-top: 5px;
        }

        #fullscreenImage {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.8);
    justify-content: center;
    align-items: center;
    z-index: 1000;
}

#fullscreenImg {
    max-width: 90%;
    max-height: 90%;
    border-radius: 10px;
    transition: transform 0.3s ease;
}

#fullscreenImg:hover {
    transform: scale(1.05);
}


    </style>
</head>
<body>   
<header class="header">
    <!-- Logo section (on the left) -->
    <div class="logo">
    <img src="../images/logo.png" class="logo-image">
    FitFusion
</div>

    <nav>
        <a href="dashboard.php"><b>Dashboard</b></a>
        <a href="addproducts.php"><b>Add Product</b></a>
        <a href="login.php"><b>Logout</b></a>
    </nav>
</header>

    <div class="dashboard-container">
        <!-- Welcome Banner -->
        <div class="welcome-banner">
        <h1>Welcome, Fashion Seller!</h1>
        <p>Manage your collections and connect with customers to grow your business. Let's make your fashion store shine!</p>
        </div>

        

        <!-- Add a fullscreen image modal -->
        <div id="fullscreenImage" style="display:none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.8); justify-content: center; align-items: center; z-index: 1000;">
            <img id="fullscreenImg" src="" style="max-width: 90%; max-height: 90%; border-radius: 10px;">
        </div>

  <?php foreach ($categories as $category): ?>
    <div class="category" data-category="<?php echo htmlspecialchars($category['categoryname']); ?>">
        <h2><?php echo htmlspecialchars($category['categoryname']); ?></h2>
        <div class="product-grid">
            <?php 
            if (isset($productsByCategory[$category['categoryid']])) {
                foreach ($productsByCategory[$category['categoryid']] as $product):
            ?>
                <div class="product-card" data-product="<?php echo htmlspecialchars($product['productname']); ?>">
                    <img src="../<?php echo htmlspecialchars($product['image']); ?>" alt="Product Image" class="clickable-image">
                    <h3><?php echo htmlspecialchars($product['productname']); ?></h3>
                    <p><?php echo htmlspecialchars($product['description']); ?></p>
                    <h4 class="price"><?php echo number_format($product['price'], 2); ?></h4> 
                    
                    <!-- Buy Now Form -->
                    <form action="edit.php" method="GET">
                        <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['productid']); ?>">
                        <button class="edit-button" type="submit">Edit</button>
                    </form>

                    <form action="delete.php" method="POST">
                        <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['productid']); ?>">
                        <button class="delete-button" type="submit">Delete</button>
                    </form>

                </div>
            <?php endforeach; 
            } else {
                echo "<p>No products available in this category.</p>";
            }
            ?>
        </div>
    </div>
<?php endforeach; ?>

        <script>
        // Select all images with the class 'clickable-image'
        const images = document.querySelectorAll('.clickable-image');
        const fullscreenImage = document.getElementById('fullscreenImage');
        const fullscreenImg = document.getElementById('fullscreenImg');

        // Add click event to each image
        images.forEach(image => {
            image.addEventListener('click', function() {
                fullscreenImg.src = image.src; 
                fullscreenImage.style.display = 'flex'; 
            });
        });

        // Close the modal when clicking outside the image
        fullscreenImage.addEventListener('click', function(e) {
            if (e.target === fullscreenImage) {
                fullscreenImage.style.display = 'none'; 
            }
        });

        </script>
</body>
</html>
