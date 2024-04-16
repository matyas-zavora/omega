<?php
echo "database tested";
//show errors
ini_set('display_errors', 1);
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
    try {
        $connection = new mysqli($host, $user, $password, '', $port);
    } catch (Exception $e) {
        unlink($file_location);
    }
    if (!isset($connection->connect_error)) {
        $database_connected = true;
    }
    if (isset($_GET['tool'])){
        $connection->select_db($_GET['tool']);
    }
    if (isset($relocate) && $relocate) {
        header('Location: index.php');
        exit();
    }
}
