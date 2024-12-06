<?php 
include '../serverdb/connectSeller.php';

$product_id = $_GET['product_id'];

// Use the product ID to fetch the product details for editing
$productSql = "SELECT * FROM products WHERE productid = ?";
$productStmt = $db->prepare($productSql);
$productStmt->execute([$product_id]);
$product = $productStmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(45deg, #A87676, #A87676, #CA8787, #E1ACAC, #A87676, #E1ACAC, #CA8787, #A87676, #A87676);
            background-size: 400% 400%;
            animation: gradientAnimation 8s ease infinite;
            justify-content: center;
            align-items: flex-start;
            padding-top: 50px;
        }

        @keyframes gradientAnimation {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .edit-form-container {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 10px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 550px;
            margin: 0 auto;
            margin-bottom: 60px;
        }

        h2 {
            text-align: center;
            color: #A87676;
        }

        label {
            font-size: 16px;
            color: #333;
            margin-bottom: 8px;
            display: block;
        }

        input[type="text"], 
        input[type="number"], 
        textarea {
            width: 96%;
            padding: 8px;
            margin-bottom: 20px;
            border-radius: 4px;
            border: 1px solid #ddd;
            font-size: 16px;
            transition: all 0.3s ease; 
        }

        input[type="text"]:hover, 
        input[type="number"]:hover, 
        textarea:hover {
            border-color: #CA8787;  
            box-shadow: 0 0 5px #CA8787; 
        }

        textarea {
            height: 100px;
        }

        input[type="file"] {
            margin-bottom: 20px;
        }

        .form-button {
            background-color: #A87676;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            font-weight: bold;
            cursor: pointer;
            width: 100%;
        }

        .form-button:hover {
            background-color: #CA8787;
        }

        .cancel-button {
            background-color: #ccc;
            color: #333;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            font-weight: bold;
            cursor: pointer;
            width: 100%;
            margin-top: 10px;
        }

        .cancel-button:hover {
            background-color: #bbb;
        }

        .zoomable:active {
            transform: scale(1.5); /* Scale the image by 1.5 times on click */
        }

        /* Zoomable image styles */
        .zoomable {
            cursor: pointer;
            transition: transform 0.4s ease-in-out; /* Smooth zoom effect */
            transform-origin: center center; /* Ensure the zoom starts from the center */
            max-width: 100%;
            height: auto;
        }

    </style>
</head>
<body>

    <div class="edit-form-container">
        <h2>Edit Product</h2>

        <form action="../editdb.php" method="POST" enctype="multipart/form-data" class="edit-form">
            <!-- Image Display -->
            <?php if ($product['image']) { ?>
                <label for="currentImage">Current Image</label>
                <img src="../<?php echo $product['image']; ?>" alt="Product Image" class="zoomable" style="max-width: 100%; height: 20vh; margin-bottom: 10px;">
            <?php } ?>
            
            <label for="productImage">Choose New Image (Optional)</label>
            <input type="file" id="productImage" name="productImage" value="<?php echo htmlspecialchars($product['image']); ?>" accept="image/*">

            <!-- Product Name -->
            <label for="productName">Product Name</label>
            <input type="text" id="productName" name="productName" value="<?php echo htmlspecialchars($product['productname']); ?>" required>

            <!-- Description -->
            <label for="productDescription">Description</label>
            <textarea id="productDescription" name="productDescription" required><?php echo htmlspecialchars($product['description']); ?></textarea>

            <!-- Price -->
            <label for="productPrice">Price</label>
            <input type="number" id="productPrice" name="productPrice" value="<?php echo htmlspecialchars($product['price']); ?>" required>

            <input type="hidden" id="productPrice" name="productID" value="<?php echo htmlspecialchars($product['productid']); ?>" required>
            <input type="hidden" id="productPrice" name="productCategory" value="<?php echo htmlspecialchars($product['categoryid']); ?>" required>

            <!-- Submit Button -->
            <button type="submit" class="form-button">Save Changes</button>

            <!-- Cancel Button -->
            <button type="button" class="cancel-button" onclick="window.location.href='dashboard.php';">Cancel</button>
        </form>
    </div>

 <!-- Optional JavaScript to handle zoom effect -->
<script>
    document.querySelectorAll('.zoomable').forEach(image => {
        image.addEventListener('click', function() {
            // Apply a larger zoom effect, you can adjust the scale factor here (e.g., scale(2) or scale(2.5))
            if (image.style.transform === 'scale(2)') {
                image.style.transform = 'scale(1)'; // Reset zoom
            } else {
                image.style.transform = 'scale(2)'; // Zoom in
            }
        });
    });
</script>


</body>
</html>
