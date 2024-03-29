<?php
session_start();

//show errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

if (isset($_SESSION['conn'])) {
    header("Location: ./alpha3/index.php");
    exit();
}
// Get the host, user, and password from the form and filter them


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $host = filter_input(INPUT_POST, 'host', FILTER_SANITIZE_STRING);
    $user = filter_input(INPUT_POST, 'user', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    $port = filter_input(INPUT_POST, 'port', FILTER_SANITIZE_NUMBER_INT);
    $conn = new mysqli($host, $user, $password, null, $port);

    if (!$conn->connect_error) {
        $_SESSION['conn'] = $conn;
        createDatabaseA3($conn);
        header('Location: ./alpha3/index.php');
        exit();
    }
}

function createDatabaseA3(mysqli $conn)
{
    $sql = "CREATE DATABASE IF NOT EXISTS `alpha3` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;";
    $conn->query($sql);

    $conn->select_db('alpha3');

    //Create the database acording to /omega/alpha3/alpha3.sql
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

</head>
<body>
<?php
if (isset($conn) and $conn->connect_error): ?>
    <div class="alert alert-danger" role="alert">
        <?= $conn->connect_error ?>
    </div>
<?php endif; ?>
<header class="jumbotron text-center mt-lg-5">
    <h1 class="text-center">Enter your MySQL database credentials</h1>
</header>
<form action="info.php" method="post" class="container mt-5">
    <div class="mb-3">
        <label for="host" class="form-label">Host</label>
        <input type="text" class="form-control" id="host" name="host" value="localhost">
    </div>
    <div class="mb-3">
        <label for="user" class="form-label">User</label>
        <input type="text" class="form-control" id="user" name="user" value="root">
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password">
    </div>
    <div class="mb-3">
        <label for="port" class="form-label">Port</label>
        <input type="number" class="form-control" id="port" name="port" value="3306">
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</body>
</html>