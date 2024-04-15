<?php
ini_set('display_errors', 1);

session_start();
if (!isset($_GET['todo']) or !isset($_SESSION['conn_params'])) {
    header('Location: ./index.php');
    exit;
} else {
    switch ($_GET['todo']) {
        case 'db':
            $conn_params = $_SESSION['conn_params'];
            $conn = new mysqli($conn_params['host'], $conn_params['user'], $conn_params['password'], null, $conn_params['port']);
            $conn->query("drop schema if exists estateatlas;");
            unset($_SESSION['conn_params']);
            unset($_SESSION['email']);
            header('Location: ./index.php?status=db_deleted');
            break;
        case 'conn':
            unset($_SESSION['conn_params']);
            header('Location: ./index.php?status=conn_deleted');
            break;
        default:
            header('Location: ./index.php');
            exit;
    }
}