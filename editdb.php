<?php
include 'serverdb/connectSeller.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $product_id = $_POST['productID'];
    $product_name = $_POST['productName'];
    $product_description = $_POST['productDescription'];
    $price = $_POST['productPrice'];
    $product_category = $_POST['productCategory'];

    try {
        // Fetch existing product details, including the current image path
        $stmt = $db->prepare("SELECT image FROM PRODUCTS WHERE productid = ?");
        $stmt->execute([$product_id]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        $currentImagePath = $product['image'];

        // Check if a new image is uploaded
        $product_image = $currentImagePath; // Default to the existing image
        if (isset($_FILES['productImage']) && $_FILES['productImage']['error'] === UPLOAD_ERR_OK) {
            $file = $_FILES['productImage'];
            $fileName = $file['name'];
            $fileTmpName = $file['tmp_name'];
            $fileSize = $file['size'];
            $fileError = $file['error'];
            $fileType = $file['type'];

            $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $allowed = array('jpg', 'jpeg', 'png');

            if (in_array($fileExt, $allowed)) {
                if ($fileSize < 1000000) { // 1MB limit
                    $fileNameNew = uniqid('', true) . "." . $fileExt;
                    $fileDestination = 'images/' . $fileNameNew;

                    if (move_uploaded_file($fileTmpName, $fileDestination)) {
                        $product_image = $fileDestination; // Update to the new image path
                    } else {
                        echo "Error uploading the new image.";
                        exit();
                    }
                } else {
                    echo "New image file size is too large.";
                    exit();
                }
            } else {
                echo "Invalid file type for the new image.";
                exit();
            }
        }

        // Update the product details in the database
        $updateStmt = $db->prepare(
            "UPDATE PRODUCTS 
            SET productname = ?, description = ?, price = ?, categoryid = ?, image = ? 
            WHERE productid = ?"
        );
        $updateStmt->execute([
            $product_name,
            $product_description,
            $price,
            $product_category,
            $product_image,
            $product_id
        ]);

        // Redirect to the admin page
        header('Location: http://localhost/Final_project-108/seller/dashboard.php');
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    header('Location: http://localhost/Final_project-108/seller/dashboard.php');
    exit();
}
?>
