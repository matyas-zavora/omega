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

// Handle POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the ID of the item to be deleted from the POST data
    $id = $_POST['id'];

    // Prepare and execute the DELETE query
    $stmt = $connection->prepare('DELETE FROM items WHERE id = ?');
    $stmt->bind_param('i', $id);
    try {
        $stmt->execute();
    } catch (Exception $e) {
        // Echo the error message if an exception occurs during execution
        echo $e->getMessage();
    }
}

// Set session error message if $e is set
if (isset($e)) {
    $_SESSION['error_message'] = 'Error deleting item | ' . $e;
}

// Redirect back to the home page after processing the request
header('Location: ./');
exit();