<?php
//show errors
ini_set('display_errors', 1);
session_start(); // Start the session to manage user sessions
include('../database_checker.php'); // Include the file for database connection
$connection->select_db('listease'); // Select the database named 'listease'

// Check if the form is submitted via POST method
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve email and password from the POST data
    $email = $_POST['email'];
    $password = $_POST['password'];

    // SQL query to fetch user data based on the provided email
    $sql = "SELECT id,psw FROM users WHERE email = '$email'";

    // Execute the query
    $result = $connection->query($sql);

    // Check if any rows are returned
    if ($result->num_rows > 0) {
        // Fetch the first row from the result set
        $row = $result->fetch_assoc();

        // Verify the password using password_verify function
        if (password_verify($password, $row['psw'])) {
            // Set session variables for email and user id
            $_SESSION['email'] = $email;
            $_SESSION['id'] = $row['id'];

            // Redirect the user to the homepage after successful login
            header('Location: ./');
            exit(); // Terminate script execution
        }
    } else {
        // Display error message for invalid email or password
        echo '<div class="alert alert-danger" role="alert">Invalid email or password</div>';
    }
}

// Output the HTML content for the login form
echo '<!DOCTYPE html>';
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
echo '<link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap"';
echo 'rel="stylesheet">';
echo '<link rel="stylesheet" href="../styles/font.css">';
echo '<title>ListEase - login</title>';
echo '</head>';
echo '<body>';
echo '<div class="container">';
echo '<div class="row">';
echo '<div class="col-12">';
echo '<h1 class="text-center">Login</h1>';
echo '</div>';
echo '</div>';
echo '<div class="row">';
echo '<div class="col-12">';
echo '<form action="./login.php" method="post">';
echo '<div class="mb-3">';
echo '<label for="email" class="form-label">Email</label>';
echo '<input type="text" class="form-control" id="email" name="email">';
echo '</div>';
echo '<div class="mb-3">';
echo '<label for="password" class="form-label">Password</label>';
echo '<input type="password" class="form-control" id="password" name="password">';
echo '</div>';
echo '<button type="submit" class="btn btn-success">Login</button> ';
echo '<a class="btn btn-info" href="register.php">Register</a> ';
echo '<button id="switch" class="btn btn-secondary" onclick="cycleThemes()" type="button">Switch</button>';
echo '</form>';
echo '</div>';
echo '</div>';
echo '</div>';
echo '<script src="../scripts/dark-mode.js"></script>';
echo '</body>';
echo '</html>';
