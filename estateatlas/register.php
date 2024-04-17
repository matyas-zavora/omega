<?php
//show errors
ini_set('display_errors', 1);
session_start();
include('../database_checker.php');
$connection->select_db('estateatlas');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    $password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $connection->prepare("INSERT INTO user (email, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $email, $password);
    try {
        $stmt->execute();
        $_SESSION['email'] = $email;
        header('Location: ./');
    } catch (Exception $e) {
        $error = $e;
    }
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
    <title>ListEase - Registration</title>
</head>
<body>
<!-- Alerts based on $error -->
<?php if (isset($error)): ?>
    <div class="alert alert-danger" role="alert">
        <?php echo $error->getMessage(); ?>
    </div>
<?php endif; ?>
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1 class="text-center">Registration</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <form action="register.php" method="post">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="text" class="form-control" id="email" name="email">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>
                <button type="submit" class="btn btn-success">Register</button>
                <a class="btn btn-info" href="login.php">Login</a>
                <button id="switch" class="btn btn-secondary" onclick="cycleThemes()" type="button">Switch</button>
            </form>
        </div>
    </div>
</div>
<script src="../scripts/dark-mode.js"></script>
</body>
</html>