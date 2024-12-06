<?php 


include 'connectBuyer.php';

$a = $_POST['product_id'];
$b = $_POST['buyer_id'];


$stmt = $db->prepare("INSERT INTO ORDERS (PRODUCTID,BUYERID) VALUES (:a, :b)");
$stmt->bindParam(':a', $a);
$stmt->bindParam(':b', $b);
$stmt->execute();

header('Location: http://localhost/FINAL_PROJECT-108/buyer/dashboard.php');
?>
