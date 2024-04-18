<?php
// Start the session
session_start();

// Redirect to the login page if the user is not authenticated
if (!isset($_SESSION['email'])) {
    header("Location: ../");
    exit();
}

// Retrieve database connection parameters from the session
$conn_params = $_SESSION['conn_params'];

// Establish a MySQLi connection using the stored connection parameters
$conn = new mysqli($conn_params['host'], $conn_params['user'], $conn_params['password'], null, $conn_params['port']);

// HTML document starts here
echo '<!DOCTYPE html>';
echo '<html lang="en">';
echo '<head>';
echo '<meta charset="UTF-8">';
echo '<title>EstateAtlas | Files</title>';
echo '<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">';
echo '<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">';
echo '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">';
echo '<link href="img/favicon/apple-touch-icon.png" rel="apple-touch-icon" sizes="180x180">';
echo '<link href="img/favicon/favicon-32x32.png" rel="icon" sizes="32x32" type="image/png">';
echo '<link href="img/favicon/favicon-16x16.png" rel="icon" sizes="16x16" type="image/png">';
echo '<link href="img/favicon/site.webmanifest" rel="manifest">';
echo '<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">';
echo '<link href="styles/reset.css" rel="stylesheet">';
echo '<link href="styles/index.css" rel="stylesheet">';
echo '<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet"/>';
echo '<link href="styles/google_icons.css" rel="stylesheet">';
echo '</head>';
echo '<body>';
echo '<div class="container" style="height: 89vh;">';
echo '<div class="row">';
echo '<div class="col-md-6">';
echo '<a class="btn btn-warning btn-lg btn-block" href="./download_full_parcel_data.php" role="button">';
echo '<i class="bi bi-file-earmark-arrow-down" style="font-size: 250px;"></i><br>Download full parcel data</a>';
echo '</div>';
echo '<div class="col-md-6">';
echo '<a class="btn btn-warning btn-lg btn-block" href="upload.php" role="button">';
echo '<i class="bi bi-file-earmark-arrow-up" style="font-size: 250px;"></i><br>Upload full parcel data</a>';
echo '</div>';
echo '</div>';
echo '<div class="row" style="margin-top: 30px;">';
echo '<div class="col-md-10">';
echo '<a class="btn btn-danger btn-lg btn-block" href="./write.php" role="button"';
echo 'style="height: 100px; display: flex; align-items: center; justify-content: center;">';
echo '<i class="bi bi-arrow-left m-2" style="font-size:55px;"></i>Return';
echo '</a>';
echo '</div>';
echo '<div class="col-md-2">';
echo '<button id="switch" class="btn btn-lg btn-secondary btn-block" onclick="cycleThemes()" style="font-size:55px;" type="button">Switch</button>';
echo '</div>';
echo '</div>';
echo '</div>';
echo '<script src="../scripts/dark-mode.js"></script>';
echo '</body>';
echo '</html>';