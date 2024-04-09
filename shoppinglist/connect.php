<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $host = $_POST['host'];
    $user = $_POST['user'];
    $password = $_POST['password'];
    $port = $_POST['port'];
    $connection = new mysqli($host, $user, $password, 'null', $port);
    if ($connection->connect_error) {
        die('Connection failed: ' . $connection->connect_error);
    } else {
        $data = json_encode([
            'host' => $host,
            'user' => $user,
            'password' => $password,
            'port' => $port
        ]);
        $file = fopen('connection.txt', 'w');
        fwrite($file, $data);
        fclose($file);
        createDatabaseA3();
        header('Location: index.php');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database connection</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="apple-touch-icon" sizes="180x180" href="img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="img/favicon/favicon-16x16.png">
    <link rel="manifest" href="img/favicon/site.webmanifest">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap"
          rel="stylesheet">
    <link rel="stylesheet" href="./styles/font.css">
</head>
<body>
<?php
echo '<header class="jumbotron text-center mt-lg-5">';
    echo '<h1 class="text-center">Enter your MySQL database credentials</h1>';
    echo '</header>';
echo '<form action="info.php" method="post" class="container mt-5">';
    echo '<div class="mb-3">';
        echo '<label for="host" class="form-label">Host</label>';
        echo '<input type="text" class="form-control" id="host" name="host" value="localhost">';
        echo '</div>';
    echo '<div class="mb-3">';
        echo '<label for="user" class="form-label">User</label>';
        echo '<input type="text" class="form-control" id="user" name="user" value="root">';
        echo '</div>';
    echo '<div class="mb-3">';
        echo '<label for="password" class="form-label">Password</label>';
        echo '<input type="password" class="form-control" id="password" name="password">';
        echo '</div>';
    echo '<div class="mb-3">';
        echo '<label for="port" class="form-label">Port</label>';
        echo '<input type="number" class="form-control" id="port" name="port" value="3306">';
        echo '</div>';
    echo '<button type="submit" class="btn btn-primary">Submit</button>';