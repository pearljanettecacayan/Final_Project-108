<?php
include 'connectAdmin.php';

session_start(); 

$a = $_POST['email'];
$b = $_POST['password'];

// Prepare a SQL statement to select user with the given username and password
$stmt = $db->prepare("SELECT * FROM admin WHERE email = :a AND PASSWORD = :b");
$stmt->bindParam(':a', $a);
$stmt->bindParam(':b', $b);
$stmt->execute();

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    // User found, store user information in session
    $_SESSION['adminid'] = $user['adminid'];

    // Redirect to homepage
    header('Location: http://localhost/FINAL_PROJECT-108/admin/dashboard.php');
    exit();
} else {
    // User not found, redirect back to login page with an error message
    header('Location: http://localhost/FINAL_PROJECT-108/admin/login.php?error=1');
    exit();
}
?>
