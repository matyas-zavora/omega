<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: ../");
    exit();
}
include '../templates/write.php';