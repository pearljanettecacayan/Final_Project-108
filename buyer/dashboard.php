<?php
include '../serverdb/connectBuyer.php';

session_start();

if (!isset($_SESSION['buyerid'])) {
    header('Location: login.php');
    exit();
}

$buyerid=$_SESSION['buyerid'];

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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
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

        .search-bar {
            width: 50%;
            margin: 20px auto;
        }

        .search-bar input {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border-radius: 4px;
            border: 1px solid #A87676;
            color: #A87676;
        }

        .search-bar input:focus {
            outline: none;
            border-color: #CA8787;
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
            transition: transform 0.3s ease-in-out;
            cursor: pointer;
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

        .carousel {
        position: relative;
        margin: 0 auto 30px;
        overflow: hidden;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .carousel-inner {
        display: flex;
        transition: transform 0.5s ease-in-out;
    }

    .carousel-item {
    min-width: 100%;
    height: 60vh; 
    object-fit: cover;
}


    .carousel-controls {
        position: absolute;
        top: 50%;
        width: 100%;
        display: flex;
        justify-content: space-between;
        transform: translateY(-50%);
        pointer-events: none;
    }

    .prev, .next {
    display: none; 
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

    <!-- Navigation links (aligned to the right) -->
    <nav>
        <a href="dashboard.php"><b>Dashboard</b></a>
        <a href="orders.php"><b>Orders</b></a>
        <a href="login.php"><b>Logout</b></a>
    </nav>
</header>

<div class="dashboard-container">

    <!-- Carousel Section -->
    <div class="carousel">
        <div class="carousel-inner">
            <img src="../images/image01.png" alt="Slide 1" class="carousel-item active">
            <img src="../images/image2.png" alt="Slide 2" class="carousel-item">
            <img src="../images/image3.png" alt="Slide 3" class="carousel-item">
            <img src="../images/image4.png" alt="Slide 4" class="carousel-item">
            <img src="../images/image5.png" alt="Slide 5" class="carousel-item">
        </div>
        <!-- Carousel Controls -->
        <div class="carousel-controls">
            <span class="prev" onclick="prevSlide()">&#10094;</span>
            <span class="next" onclick="nextSlide()">&#10095;</span>
        </div>
    </div>

    <!-- Search-Bar -->
    <div class="search-bar">
        <div style="position: relative; display: flex; align-items: center;">
            <input type="text" id="searchInput" placeholder="Search products..." onkeyup="filterCategories()" style="padding-left: 40px;">
            <i class="fas fa-search" style="position: absolute; left: 10px; color: #A87676; font-size: 16px;"></i>
            <!-- Clear icon (appears only when there's input) -->
            <i id="clearIcon" class="fas fa-times" style="position: absolute; right: 10px; color: #A87676; font-size: 16px; cursor: pointer; display: none;" onclick="clearSearch()"></i>
        </div>
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
                    <form action="../serverdb/buynow.php" method="POST">
                        <input type="hidden" name="buyer_id" value="<?php echo $buyerid ?>">
                        <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['productid']); ?>">
                        <button type="submit" name="buy_now">Buy Now</button>
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

    <!-- Add a fullscreen image modal -->
    <div id="fullscreenImage" style="display:none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.8); justify-content: center; align-items: center; z-index: 1000;">
            <img id="fullscreenImg" src="" style="max-width: 90%; max-height: 90%; border-radius: 10px;">
        </div>

    <script>
        // Carousel
         let currentSlide = 0;

    function showSlide(index) {
        const slides = document.querySelectorAll('.carousel-item');
        const totalSlides = slides.length;
        if (index >= totalSlides) currentSlide = 0;
        else if (index < 0) currentSlide = totalSlides - 1;
        else currentSlide = index;

        const offset = -currentSlide * 100;
        document.querySelector('.carousel-inner').style.transform = `translateX(${offset}%)`;
    }

    function nextSlide() {
        showSlide(currentSlide + 1);
    }

    function prevSlide() {
        showSlide(currentSlide - 1);
    }

    // Auto-slide every 5 seconds
    setInterval(nextSlide, 4000);

    // Show clear icon when there's text in the input
    const searchInput = document.getElementById('searchInput');
        const clearIcon = document.getElementById('clearIcon');

        searchInput.addEventListener('input', function() {
            if (searchInput.value) {
                clearIcon.style.display = 'block'; 
            } else {
                clearIcon.style.display = 'none'; 
            }
        });

        // Function to clear the search input
        function clearSearch() {
            searchInput.value = ''; 
            clearIcon.style.display = 'none'; 
            filterCategories(); 
        }
        const input = searchInput.value.toLowerCase();
        const categories = document.querySelectorAll('.category');
        categories.forEach(category => {
            const categoryName = category.getAttribute('data-category').toLowerCase();
            const products = category.querySelectorAll('.product-card');
            if (categoryName.includes(input)) {
            category.style.display = 'block';
            } else {
                category.style.display = 'none';
            }
            products.forEach(product => {
                const productName = product.getAttribute('data-product').toLowerCase();
                if (productName.includes(input)) {
                    product.style.display = 'block';
                } else {
                    product.style.display = 'none';
                }
            });
        });

        // Select all images with the class 'clickable-image'
        const images = document.querySelectorAll('.clickable-image');
        const fullscreenImage = document.getElementById('fullscreenImage');
        const fullscreenImg = document.getElementById('fullscreenImg');

        // Add click event to each image
        images.forEach(image => {
            image.addEventListener('click', function() {
                fullscreenImg.src = image.src; // Set the source of the fullscreen image
                fullscreenImage.style.display = 'flex'; // Show the fullscreen modal
            });
        });

        // Close the modal when clicking outside the image
        fullscreenImage.addEventListener('click', function(e) {
            if (e.target === fullscreenImage) {
                fullscreenImage.style.display = 'none'; // Hide the modal
            }
        });


        // Search filtering function
        function filterCategories() {
                const input = document.getElementById('searchInput').value.toLowerCase();
                const categories = document.querySelectorAll('.category');
                categories.forEach(category => {
                    const categoryName = category.getAttribute('data-category').toLowerCase();
                    const products = category.querySelectorAll('.product-card');
                    let categoryVisible = false;

                    products.forEach(product => {
                        const productDescription = product.getAttribute('data-product').toLowerCase();
                        if (categoryName.includes(input) || productDescription.includes(input)) {
                            product.style.display = '';
                            categoryVisible = true;
                        } else {
                            product.style.display = 'none';
                        }
                    });

                    // If no products are matching, hide the category entirely
                    category.style.display = categoryVisible ? '' : 'none';
                });
            }
    </script>

</body>
</html>
