<?php
include '../serverdb/connectBuyer.php';
session_start();

if (!isset($_SESSION['buyerid'])) {
    header('Location: login.php');
    exit();
}

$buyerid = $_SESSION['buyerid'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['orderid'])) {
    $orderid = $_POST['orderid'];

    $db->exec("SET app.user_id TO $buyerid");
    $db->exec("SET app.user_type TO 'buyer'");

    // Prepare the SQL query to delete the order
    $sql = "DELETE FROM orders WHERE orderid = :orderid AND buyerid = :buyerid";
    $stmt = $db->prepare($sql);

    // Bind the parameters and execute the query
    $stmt->execute([':orderid' => $orderid, ':buyerid' => $_SESSION['buyerid']]);

    // Redirect back to the orders page
    header('Location: orders.php');
    exit();
}
?>
