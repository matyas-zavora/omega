<?php
$database_connected = false;
$file_location = __DIR__ . "/connection.txt";
if (file_exists($file_location)) {
    $file = fopen($file_location, 'r');
    $conn_params = fread($file, filesize($file_location));
    fclose($file);
    $conn_params = json_decode($conn_params, true);
    $host = $conn_params['host'];
    $user = $conn_params['user'];
    $password = $conn_params['password'];
    $port = $conn_params['port'];

    $connection = new mysqli($host, $user, $password, '', $port);
    if ($connection->connect_error) {
        unlink($file_location);
    } else{
        $database_connected = true;
    }
    if (isset($relocate) && $relocate) {
        header('Location: index.php');
        exit();
    }
}