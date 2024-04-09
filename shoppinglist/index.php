<?php
//show errors
ini_set('display_errors', 1);
$file = fopen('connection.txt', 'r');
if (!$file) {
    header('Location: connect.php');
    exit();
}
$data = fread($file, filesize('connection.txt'));
fclose($file);
$connectionData = json_decode($data, true);
if ($connectionData) {
    $host = $connectionData['host'];
    $user = $connectionData['user'];
    $password = $connectionData['password'];
    $port = $connectionData['port'];
    $connection = new mysqli($host, $user, $password, 'shoppinglist', $port);
    if ($connection->connect_error) {
        unlink('connection.txt');
        header('Location: connect.php');
    } else {
        $items = $connection->query('SELECT * FROM items');
        $itemsArray = [];
        while ($item = $items->fetch_assoc()) {
            $itemsArray[] = $item;
        }
    }
} else {
    header('Location: connect.php');
    exit();
}
?>
<!doctype html>
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
    <title>Shopping list</title>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1 class="text-center">Shopping list</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <form action="index.php" method="post">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Add new item" name="item">
                    <button class="btn btn-outline-secondary" type="submit" id="button-addon2"><i
                                class="bi bi-plus-lg"></i></button>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <ul class="list-group list-group-flush">
                <?php foreach ($itemsArray as $item): ?>
                    <li class="list-group-item"><?php echo $item; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
