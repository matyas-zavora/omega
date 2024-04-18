<?php
// Start the session
session_start();

// Redirect to the home page if 'todo' parameter or 'conn_params' session variable is not set
if (!isset($_GET['todo']) || !isset($_SESSION['conn_params'])) {
    header('Location: ./');
    exit;
} else {
    try {
        // Handle different 'todo' cases
        switch ($_GET['todo']) {
            case 'db_estateatlas':
                // Drop the 'estateatlas' schema if it exists
                $conn_params = $_SESSION['conn_params'];
                $conn = new mysqli($conn_params['host'], $conn_params['user'], $conn_params['password'], null, $conn_params['port']);
                $conn->query("drop schema if exists estateatlas;");
                // Redirect with success message
                header('Location: ./index.php?status=success_EstateAtlas_Database_was_deleted');
                break;
            case 'db_listease':
                // Drop the 'listease' schema if it exists
                $conn_params = $_SESSION['conn_params'];
                $conn = new mysqli($conn_params['host'], $conn_params['user'], $conn_params['password'], null, $conn_params['port']);
                $conn->query("drop schema if exists listease;");
                // Redirect with success message
                header('Location: ./index.php?status=success_ListEase_Database_was_deleted');
                break;
            case 'conn':
                // Remove the 'conn_params' session variable and the 'connection.txt' file if it exists
                unset($_SESSION['conn_params']);
                if (file_exists(__DIR__ . "/connection.txt")) {
                    unlink(__DIR__ . "/connection.txt");
                }
                // Redirect with success message
                header('Location: ./index.php?status=success_Database_connection_was_deleted');
                break;
            default:
                // Redirect to the home page if 'todo' parameter is invalid
                header('Location: ./');
                exit;
        }
    } catch (Exception $e) {
        // Handle exceptions by redirecting with an error message
        // Replace spaces with underscores in the exception message
        $e = str_replace(' ', '_', $e);
        header('Location: ./index.php?status=error_'.$e);
        exit;
    }
}