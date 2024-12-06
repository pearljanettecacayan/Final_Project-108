<?php

include '../serverdb/connectBuyer.php';

$a = $_POST['firstname'];
$b = $_POST['lastname'];
$c = $_POST['email'];
$d = $_POST['password'];

$stmt = $db->prepare("INSERT INTO BUYER (FIRSTNAME,LASTNAME, EMAIL, PASSWORD) VALUES (:a, :b, :c, MD5(:d))");
$stmt->bindParam(':a', $a);
$stmt->bindParam(':b', $b);
$stmt->bindParam(':c', $c);
$stmt->bindParam(':d', $d);

$stmt->execute();

header('Location: http://localhost/FINAL_PROJECT-108/buyer/login.php');
?>