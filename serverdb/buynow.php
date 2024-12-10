<?php 
include 'connectBuyer.php';

session_start();

if (!isset($_SESSION['buyerid'])) {
    header('Location: login.php');
    exit();
}

$buyerid=$_SESSION['buyerid'];

$a = $_POST['product_id'];
$b = $_POST['buyer_id'];

$db->exec("SET app.user_id TO $buyerid");
$db->exec("SET app.user_type TO 'buyer'");

$stmt = $db->prepare("INSERT INTO ORDERS (PRODUCTID,BUYERID) VALUES (:a, :b)");
$stmt->bindParam(':a', $a);
$stmt->bindParam(':b', $b);
$stmt->execute();

header('Location: http://localhost/FINAL_PROJECT-108/buyer/dashboard.php');
?>
