<?php
// Start the session
session_start();
// Include the database checker file
include('../database_checker.php');

// Select the 'estateatlas' database
$connection->select_db('estateatlas');

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    unset($_SESSION['email']);
    // Sanitize and retrieve email and password from POST data
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

    // Hash the password
    $password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare and execute the SQL statement to insert user data into the 'user' table
    $stmt = $connection->prepare("INSERT INTO user (email, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $email, $password);

    try {
        $stmt->execute();
        // Set the email session variable
        $_SESSION['email'] = $email;
        // Redirect to the homepage
        header('Location: ./');
    } catch (Exception $e) {
        // If an exception occurs, store the error and display it
        $error = $e;
    }
}

// HTML content for the registration form
echo '<!doctype html>';
echo '<html lang="en">';
echo '<head>';
echo '<meta charset="UTF-8">';
echo '<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">';
echo '<meta http-equiv="X-UA-Compatible" content="ie=edge">';
echo '<link rel="apple-touch-icon" sizes="180x180" href="./img/favicon/apple-touch-icon.png">';
echo '<link rel="icon" type="image/png" sizes="32x32" href="./img/favicon/favicon-32x32.png">';
echo '<link rel="icon" type="image/png" sizes="16x16" href="./img/favicon/favicon-16x16.png">';
echo '<link rel="manifest" href="/site.webmanifest">';
echo '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">';
echo '<link rel="preconnect" href="https://fonts.googleapis.com">';
echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>';
echo '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">';
echo '<link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">';
echo '<link rel="stylesheet" href="../styles/font.css">';
echo '<title>EstateAtlas - Registration</title>';
echo '</head>';
echo '<body>';

// Display error message if exists
if (isset($error)) {
    echo '<div class="alert alert-danger" role="alert">';
    echo $error->getMessage();
    echo '</div>';
}

// HTML content for the registration form
echo '<div class="container">';
echo '<div class="row">';
echo '<div class="col-12">';
echo '<h1 class="text-center">Registration</h1>';
echo '</div>';
echo '</div>';
echo '<div class="row">';
echo '<div class="col-12">';
echo '<form action="./register.php" method="post">';
echo '<div class="mb-3">';
echo '<label for="email" class="form-label">Email</label>';
echo '<input type="text" class="form-control" id="email" name="email">';
echo '</div>';
echo '<div class="mb-3">';
echo '<label for="password" class="form-label">Password</label>';
echo '<input type="password" class="form-control" id="password" name="password">';
echo '</div>';
echo '<button type="submit" class="btn btn-success">Register</button>';
echo '<a class="btn btn-info" href="login.php">Login</a>';
echo '<button id="switch" class="btn btn-secondary" onclick="cycleThemes()" type="button">Switch</button>';
echo '</form>';
echo '</div>';
echo '</div>';
echo '</div>';
echo '<script src="../scripts/dark-mode.js"></script>';
echo '</body>';
echo '</html>';