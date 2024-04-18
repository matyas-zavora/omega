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
    $price = filter_input(INPUT_POST, 'price', FILTER_SANITIZE_STRING);
    $stmt = $connection->prepare('UPDATE items SET price = ? WHERE id = ?');
    $stmt->bind_param('di', $price, $id);
    try{
        $stmt->execute();
    } catch (Exception $e){
        echo $e->getMessage();
    }
}
if (isset($e)){
    $_SESSION['error_message'] = 'Error updating price | ' . $e;
}
header('Location: ./');
exit();