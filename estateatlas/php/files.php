<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: ../");
    exit();
}
$conn_params = $_SESSION['conn_params'];
$conn = new mysqli($conn_params['host'], $conn_params['user'], $conn_params['password'], null, $conn_params['port']);
include "../templates/files.php";

