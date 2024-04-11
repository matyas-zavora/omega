<?php
session_start();
//show errors
ini_set('display_errors', 1);
//Load connection data from connection.txt
$file = fopen('../connection.txt', 'r');
if (!$file) header('Location: connect.php');
$conn_params = fread($file, filesize('../connection.txt'));
fclose($file);
$conn_params = json_decode($conn_params, true);
if ($conn_params) {
    $host = $conn_params['host'];
    $user = $conn_params['user'];
    $password = $conn_params['password'];
    $port = $conn_params['port'];
    $connection = new mysqli($host, $user, $password, 'shoppinglist', $port);
    if ($connection->connect_error) {
        unlink('../connection.txt');
        header('Location: connect.php');
    }
} else {
    header('Location: connect.php');
    exit();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $sql = "SELECT id,psw FROM users WHERE email = '$email'";
    $result = $connection->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['psw'])) {
            $_SESSION['email'] = $email;
            $_SESSION['id'] = $row['id'];
            header('Location: index.php');
            exit();
        }
    } else {
        echo '<div class="alert alert-danger" role="alert">Invalid email or password</div>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="apple-touch-icon" sizes="180x180" href="./img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="./img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="./img/favicon/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap"
          rel="stylesheet">
    <link rel="stylesheet" href="./styles/font.css">
    <title>Shopping list - login</title>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1 class="text-center">Login</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <form action="login.php" method="post">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="text" class="form-control" id="email" name="email">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>
                <button type="submit" class="btn btn-primary">Login</button>
            </form>
        </div>
    </div>
</div>
</body>