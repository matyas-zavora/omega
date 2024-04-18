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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $stmt = $connection->prepare('DELETE FROM items WHERE id = ?');
    $stmt->bind_param('i', $id);
    try{
        $stmt->execute();
    } catch (Exception $e){
        echo $e->getMessage();
    }
}
if (isset($e)) {
    $_SESSION['error_message'] = 'Error deleting item | ' . $e;
}
header('Location: index.php');
exit();