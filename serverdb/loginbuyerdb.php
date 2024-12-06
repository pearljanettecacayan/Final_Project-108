<?php
include 'connectBuyer.php';

session_start(); 

$a = $_POST['email'];
$b = $_POST['password'];

// Prepare a SQL statement to select user with the given username and password
$stmt = $db->prepare("SELECT * FROM buyer WHERE email = :a AND PASSWORD = MD5(:b)");
$stmt->bindParam(':a', $a);
$stmt->bindParam(':b', $b);
$stmt->execute();

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    // User found, store user information in session
    $_SESSION['buyerid'] = $user['buyerid'];

    // Redirect to homepage
    header('Location: http://localhost/FINAL_PROJECT-108/buyer/dashboard.php');
    exit(); // Make sure no other code is executed after redirection
} else {
    // User not found, redirect back to login page with an error message
    header('Location: http://localhost/FINAL_PROJECT-108/buyer/login.php?error=1');
    exit();
}
?>
