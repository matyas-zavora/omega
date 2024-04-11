<?php

//Get connection from connection.txt
$file = fopen('connection.txt', 'r');
if (!$file) header('Location: connect.php');
$conn_params = fread($file, filesize('connection.txt'));
fclose($file);
$conn_params = json_decode($conn_params, true);
if ($conn_params) {
    $host = $conn_params['host'];
    $user = $conn_params['user'];
    $password = $conn_params['password'];
    $port = $conn_params['port'];
    $connection = new mysqli($host, $user, $password, 'shoppinglist', $port);
    if ($connection->connect_error) {
        unlink('connection.txt');
        header('Location: connect.php');
    }
} else {
    header('Location: connect.php');
    exit();
}

//Check if the user is logged in
session_start();
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}

//Check if the user wants to change the price
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $price = $_POST['price'];
    $sql = "UPDATE items SET price = $price WHERE id = $id";
    $connection->query($sql);
    if ($connection->error) {
        $_SESSION['error_message'] = 'Error updating price | ' . $connection->error;
    }
}
header('Location: index.php');