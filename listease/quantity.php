<?php
// Start the session
session_start();

// Redirect to the login page if the user is not logged in
if (!isset($_SESSION['email'])){
    header('Location: login.php');
    exit();
}

// Include the database connection file and select the database
include('../database_checker.php');
$connection->select_db('listease');

// Check if the user wants to change the quantity
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the ID and quantity of the item from the POST data
    $id = $_POST['id'];
    $quantity = $_POST['quantity'];

    // Prepare and execute the UPDATE query to change the quantity
    $stmt = $connection->prepare('UPDATE items SET quantity = ? WHERE id = ?');
    $stmt->bind_param('di', $quantity, $id);
    try {
        $stmt->execute();
    } catch (Exception $e) {
        // Echo the error message if an exception occurs during execution
        echo $e->getMessage();
    }
}

// Set session error message if $e is set
if (isset($e)){
    $_SESSION['error_message'] = 'Error updating quantity | ' . $e;
}

// Redirect back to the home page after processing the request
header('Location: ./');
exit();
?>
