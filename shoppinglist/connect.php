<?php
//show errors
if (file_exists('../connection.txt')) {
    $file = fopen('../connection.txt', 'r');
    $conn_params = fread($file, filesize('../connection.txt'));
    fclose($file);
    $conn_params = json_decode($conn_params, true);
    $host = $conn_params['host'];
    $user = $conn_params['user'];
    $password = $conn_params['password'];
    $port = $conn_params['port'];
    $connection = new mysqli($host, $user, $password, '', $port);
    if ($connection->connect_error) {
        unlink('../connection.txt');
    } else {
        $connection->select_db('shoppinglist');
        if ($connection->error) CreateDatabaseShoppingList($connection);
        header('Location: index.php');
        exit();
    }
    header('Location: index.php');
    exit();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $host = $_POST['host'];
    $user = $_POST['user'];
    $password = $_POST['password'];
    $port = $_POST['port'];
    try {
        $connection = new mysqli($host, $user, $password, '', $port);
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
    if (!isset($error)) {
        $data = json_encode([
            'host' => $host,
            'user' => $user,
            'password' => $password,
            'port' => $port
        ]);
        $file = fopen('connection.txt', 'w');
        fwrite($file, $data);
        fclose($file);
        $connection->select_db('shoppinglist');
        if ($connection->error) {
            CreateDatabaseShoppingList($connection);
        }
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
if (isset($error)) echo '<div class="alert alert-danger text-center" role="alert">MySQL Error: ' . $error . '</div>';
echo '<header class="jumbotron text-center mt-lg-5">';
echo '<h1 class="text-center">Enter your MySQL database credentials</h1>';
echo '</header>';
echo '<form method="post" class="container mt-5">';
echo '<div class="mb-3">';
echo '<label for="host" class="form-label">Host</label>';
if (isset($error) && strpos($error, 'php_network_getaddresses') !== false) {
    echo '<input type="text" class="form-control is-invalid" id="host" name="host" value="' . $_POST['host'] . '">';
    echo '<div class="invalid-feedback">Invalid host</div>';
} else {
    echo '<input type="text" class="form-control" id="host" name="host" value="localhost">';
}
echo '</div>';
echo '<div class="mb-3">';
echo '<label for="user" class="form-label">User</label>';
if (isset($error) && strpos($error, 'Access denied') !== false) {
    echo '<input type="text" class="form-control is-invalid" id="user" name="user" value="' . $_POST['user'] . '">';
} else {
    echo '<input type="text" class="form-control" id="user" name="user" value="root">';

}
echo '</div>';
echo '<div class="mb-3">';
echo '<label for="password" class="form-label">Password</label>';
if (isset($error) && strpos($error, 'Access denied') !== false) {
    echo '<input type="password" class="form-control is-invalid" id="password" name="password">';
    echo '<div class="invalid-feedback">Access denied for user ' . $user . '</div>';
} else {
    echo '<input type="password" class="form-control" id="password" name="password">';
}
echo '</div>';
echo '<div class="mb-3">';
echo '<label for="port" class="form-label">Port</label>';
echo '<input type="number" class="form-control" id="port" name="port" value="3306">';
echo '</div>';
echo '<button type="submit" class="btn btn-primary">Submit</button>';

function CreateDatabaseShoppingList(mysqli $conn)
{
    //Note: TBA
}