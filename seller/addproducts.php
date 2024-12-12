<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
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

        .edit-form-container {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 10px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 550px;
            margin: 0 auto;
            margin-bottom: 60px;
            margin-top: 20px;
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
        textarea, 
        select {
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
        textarea:hover, 
        select:hover {
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
    <div class="edit-form-container">
        <h2>Add Product</h2>

        <form action="../addp.php" method="POST" enctype="multipart/form-data" class="edit-form">
            <!-- Image Upload -->
            <label for="productImage">Product Image</label>
            <input type="file" id="productImage" name="productImage" accept="image/*" required>

            <!-- Product Category -->
            <label for="productCategory">Category</label>
            <select id="productCategory" name="productCategory" required>
                <option value="">Select a category</option>
                <option value="1">Bags</option>
                <option value="2">Hair Clips</option>
                <option value="3">Heels</option>
                <option value="4">Headbands</option>
                <option value="5">OOTD</option>
            </select>

            <!-- Product Name -->
            <label for="productName">Product Name</label>
            <input type="text" id="productName" name="productName" required>

            <!-- Description -->
            <label for="productDescription">Description</label>
            <textarea id="productDescription" name="productDescription" required></textarea>

            <!-- Price -->
            <label for="productPrice">Price</label>
            <input type="number" id="productPrice" name="productPrice" required>

            <!-- Submit Button -->
            <button type="submit" class="form-button">Add Product</button>

            <!-- Cancel Button -->
            <button type="button" class="cancel-button" onclick="window.location.href='dashboard.php';">Cancel</button>
        </form>
    </div>

</body>
</html>
