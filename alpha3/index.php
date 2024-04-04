<?php
ini_set('display_errors', 1);

include "./vendor/autoload.php";
session_start();
$conn_params = $_SESSION['conn_params'];
$conn = new mysqli($conn_params['host'], $conn_params['user'], $conn_params['password'], 'alpha3', $conn_params['port']);

if (isset($_SESSION['email'])) {
    header("Location: ./php/home.php");
    exit();
}
include './templates/login.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
    $psw = filter_input(INPUT_POST, "psw", FILTER_SANITIZE_SPECIAL_CHARS);
    $sql = "select * from user where email = '$email'";
    echo $sql;
    if (mysqli_num_rows(mysqli_query($conn, $sql)) == 1) {
        $db_hash = mysqli_fetch_array(mysqli_query($conn, $sql))["password"];
        if (password_verify($psw, $db_hash)) {
            $_SESSION["email"] = $email;
            header("location: ./php/home.php");
        } else {
            echo "<script>document.getElementById('phpPasswordError').style.display = 'block';</script>";
        }
    } else {
        echo "
        <div class='alert alert-danger text-center' role='alert'>
        Chyba!
        </div>";
    }
}
?>