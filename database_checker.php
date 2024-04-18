<?php
$database_connected = false;
$file_location = __DIR__ . "/connection.txt";
if (isset($_SESSION['conn_params'])) {
    try {
        $connection = new mysqli($_SESSION['conn_params']['host'], $_SESSION['conn_params']['user'], $_SESSION['conn_params']['password'], '', $_SESSION['conn_params']['port']);
        $database_connected = true;
    } catch (Exception $e) {
        unset($_SESSION['conn_params']);
        $database_connected = false;
    }
}
if (file_exists($file_location) && !isset($_SESSION['conn_params'])) {
    $file = fopen($file_location, 'r');
    $conn_params = fread($file, filesize($file_location));
    fclose($file);
    $conn_params = json_decode($conn_params, true);
    $host = $conn_params['host'];
    $user = $conn_params['user'];
    $password = $conn_params['password'];
    $port = $conn_params['port'];
    try {
        $connection = new mysqli($host, $user, $password, '', $port);
        $database_connected = true;
    } catch (Exception $e) {
        unlink($file_location);
    }
    if (!isset($connection->connect_error)) {
        $database_connected = true;
        $_SESSION['conn_params'] = $conn_params;
    }
    if (isset($_GET['tool'])) {
        try {
            $connection->select_db($_GET['tool']);
            $database_connected = true;
        } catch (Exception $e) {
            $database_connected = false;
        }
    }
}
if (isset($_SESSION['conn_params'])) {
    try {
        $connection = new mysqli($_SESSION['conn_params']['host'], $_SESSION['conn_params']['user'], $_SESSION['conn_params']['password'], '', $_SESSION['conn_params']['port']);
    } catch (Exception $e) {
        unset($_SESSION['conn_params']);
        $database_connected = false;
    }
}