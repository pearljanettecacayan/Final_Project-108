<?php
include '../serverdb/connectSeller.php';
session_start();

if (!isset($_SESSION['sellerid'])) {
    header('Location: login.php');
    exit();
}

$buyerid = $_SESSION['sellerid'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve product ID from the form
    $product_id = $_POST['product_id'];

    try {
        // Fetch the product's current details, including the image path
        $stmt = $db->prepare("SELECT image FROM PRODUCTS WHERE productid = ?");
        $stmt->execute([$product_id]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($product) {
            // Get the current image path
            $currentImagePath = $product['image'];

            $db->exec("SET app.user_id TO $buyerid");
            $db->exec("SET app.user_type TO 'seller'");
            
            // Delete the product from the database
            $deleteStmt = $db->prepare("DELETE FROM PRODUCTS WHERE productid = ?");
            $deleteStmt->execute([$product_id]);

            // Check if the deletion was successful
            if ($deleteStmt->rowCount() > 0) {
                // If the product had an image, delete it from the server
                if (!empty($currentImagePath) && file_exists($currentImagePath)) {
                    unlink($currentImagePath); // Remove the image file
                }

                // Redirect to the dashboard with a success message
                header('Location: http://localhost/Final_project-108/seller/dashboard.php?message=ProductDeleted');
                exit();
            } else {
                echo "Failed to delete the product.";
            }
        } else {
            echo "Product not found.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    // Redirect to dashboard if accessed without POST method
    header('Location: http://localhost/Final_project-108/seller/dashboard.php');
    exit();
}
?>
