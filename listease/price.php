<?php
session_start();
if (!isset($_SESSION['email'])){
    header('Location: login.php');
    exit();
}
include('../database_checker.php');
$connection->select_db('listease');

//Check if the user wants to change the price
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $price = filter_input()
    //UPDATE items SET price = $price WHERE id = $id
    $stmt = $connection->prepare('UPDATE items SET price = ? WHERE id = ?');
    $stmt->bind_param('di', $price, $id);
    $connection->query($sql);
    if ($connection->error) {
        $_SESSION['error_message'] = 'Error updating price | ' . $connection->error;
    }
}
header('Location: index.php');