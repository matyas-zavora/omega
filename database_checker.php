<?php
/**
 * This script attempts to establish a connection to a MySQL database using session parameters
 * stored in a file. If the session parameters are not available, it checks for a connection file.
 * If found, it attempts to establish a connection using the parameters from the file.
 * If successful, it stores the connection parameters in the session for future use.
 * Optionally, it allows selecting a specific database.
 */

// Initialize variables
$database_connected = false; // Flag to indicate if the database is connected
$file_location = __DIR__ . "/connection.txt"; // Location of the connection file

// Check if session parameters are available
if (isset($_SESSION['conn_params'])) {
    try {
        // Attempt to establish a connection using session parameters
        $connection = new mysqli($_SESSION['conn_params']['host'], $_SESSION['conn_params']['user'], $_SESSION['conn_params']['password'], '', $_SESSION['conn_params']['port']);
        $database_connected = true; // Set flag to true if connection is successful
    } catch (Exception $e) {
        unset($_SESSION['conn_params']); // Clear session parameters if connection fails
        $database_connected = false; // Set flag to false
    }
}

// Check if connection file exists and session parameters are not set
if (file_exists($file_location) && !isset($_SESSION['conn_params'])) {
    // Read connection parameters from the file
    $file = fopen($file_location, 'r');
    $conn_params = fread($file, filesize($file_location));
    fclose($file);

    // Decode JSON data into an array
    $conn_params = json_decode($conn_params, true);

    // Extract connection parameters
    $host = $conn_params['host'];
    $user = $conn_params['user'];
    $password = $conn_params['password'];
    $port = $conn_params['port'];

    try {
        // Attempt to establish a connection using parameters from the file
        $connection = new mysqli($host, $user, $password, '', $port);
        $database_connected = true; // Set flag to true if connection is successful
    } catch (Exception $e) {
        unlink($file_location); // Remove the connection file if connection fails
    }

    // If connection is successful and no previous session parameters exist, store parameters in session
    if (!isset($connection->connect_error)) {
        $database_connected = true; // Set flag to true
        $_SESSION['conn_params'] = $conn_params; // Store connection parameters in session
    }

    // Optionally select a specific database if 'tool' is provided in GET parameters
    if (isset($_GET['tool'])) {
        try {
            $connection->select_db($_GET['tool']); // Attempt to select the specified database
            $database_connected = true; // Set flag to true if selection is successful
        } catch (Exception $e) {
            $database_connected = false; // Set flag to false if selection fails
        }
    }
}

// If session parameters are available, attempt to establish a connection using them
if (isset($_SESSION['conn_params'])) {
    try {
        $connection = new mysqli($_SESSION['conn_params']['host'], $_SESSION['conn_params']['user'], $_SESSION['conn_params']['password'], '', $_SESSION['conn_params']['port']);
    } catch (Exception $e) {
        unset($_SESSION['conn_params']); // Clear session parameters if connection fails
        $database_connected = false; // Set flag to false
    }
}
