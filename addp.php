<?php
include 'serverdb/connectSeller.php';

session_start();

if (!isset($_SESSION['sellerid'])) {
    header('Location: ../seller/login.php');
    exit();
}

$sellerid = $_SESSION['sellerid'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $product_name = $_POST['productName'];
    $product_description = $_POST['productDescription'];
    $price = $_POST['productPrice'];
    $product_category = $_POST['productCategory'];
    $is_available = true; 

    // Handle image upload
    if (isset($_FILES['productImage'])) {
        $file = $_FILES['productImage'];

        $fileName = $_FILES['productImage']['name'];
        $fileTmpName = $_FILES['productImage']['tmp_name'];
        $fileSize = $_FILES['productImage']['size'];
        $fileError = $_FILES['productImage']['error'];
        $fileType = $_FILES['productImage']['type'];

        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));

        $allowed = array('jpg', 'jpeg', 'png');

        if (in_array($fileActualExt, $allowed)) {
            if ($fileError === 0) {
                if ($fileSize < 1000000) { // 1MB limit
                    $fileNameNew = uniqid('', true) . "." . $fileActualExt;
                    $fileDestination = 'images/' . $fileNameNew;

                    if (move_uploaded_file($fileTmpName, $fileDestination)) {
                        // Store the image path to be inserted into the database
                        $product_image = $fileDestination;

                        // Insert data into the database

                        $db->exec("SET app.user_id TO $sellerid");
                        $db->exec("SET app.user_type TO 'seller'");

                        $stmt = $db->prepare("INSERT INTO PRODUCTS (productname, description, price, categoryid, image) VALUES (?, ?, ?, ?, ?)");
                        $stmt->execute([$product_name, $product_description, $price, $product_category, $product_image]);

                        // Redirect to the admin page
                        header('Location: http://localhost/Final_project-108/seller/dashboard.php');
                        exit();
                    } else {
                        echo "Sorry, there was an error uploading your file.";
                    }
                } else {
                    echo "Your file is too big.";
                }
            } else {
                echo "Error uploading file.";
            }
        } else {
            echo "Invalid file type for fashion image.";
        }
    }
} else {
    header('Location: http://localhost/Final_project-108/seller/dashboard.php');
    exit();
}
?>
