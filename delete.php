<?php
ini_set('display_errors', 1);
session_start();

if (!isset($_GET['todo']) or !isset($_SESSION['conn_params'])) {
    header('Location: ./index.php');
    exit;
} else {
    try {
    switch ($_GET['todo']) {
        case 'db_estateatlas':
            $conn_params = $_SESSION['conn_params'];
            $conn = new mysqli($conn_params['host'], $conn_params['user'], $conn_params['password'], null, $conn_params['port']);
            $conn->query("drop schema if exists estateatlas;");
            header('Location: ./index.php?status=success_EstateAtlas_Database_was_deleted');
            break;
        case 'db_listease':
            $conn_params = $_SESSION['conn_params'];
            $conn = new mysqli($conn_params['host'], $conn_params['user'], $conn_params['password'], null, $conn_params['port']);
            $conn->query("drop schema if exists listease;");
            header('Location: ./index.php?status=success_ListEase_Database_was_deleted');
            break;
        case 'conn':
            unset($_SESSION['conn_params']);
            if (file_exists(__DIR__ . "/connection.txt")) {
                unlink(__DIR__ . "/connection.txt");
            }
            header('Location: ./index.php?status=success_Database_connection_was_deleted');
            break;
        default:
            header('Location: ./index.php');
            exit;
    }
    } catch (Exception $e) {
        //Replace spaces with underscores
        $e = str_replace(' ', '_', $e);
        header('Location: ./index.php?status=error_'.$e);
        exit;
    }
}
