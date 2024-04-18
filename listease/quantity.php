<?php
//show errors
ini_set('display_errors', 1);
session_start();
if (!isset($_SESSION['email'])){
    header('Location: login.php');
    exit();
}
include('../database_checker.php');
$connection->select_db('listease');

//Check if the user wants to change the quantity
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $quantity = $_POST['quantity'];
    $stmt = $connection->prepare('UPDATE items SET quantity = ? WHERE id = ?');
    $stmt->bind_param('di', $quantity, $id);
    try{
        $stmt->execute();
    } catch (Exception $e){
        echo $e->getMessage();
    }
}
if (isset($e)){
    $_SESSION['error_message'] = 'Error updating quantity | ' . $e;
}
header('Location: index.php');