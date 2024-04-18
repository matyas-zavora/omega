<?php
// Start the session to access session variables
session_start();

// Check if the user is not logged in, redirect to the login page if not
if (!isset($_SESSION['email'])) {
    header("Location: ./login.php");
    exit();
}

// HTML Document
echo '<!DOCTYPE html>';
echo '<html lang="en">';
echo '<head>';
echo '<meta charset="UTF-8">';
echo '<title>EstateAtlas</title>';
// Bootstrap CSS links
echo '<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">';
echo '<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">';
echo '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">';
// Favicon links
echo '<link href="img/favicon/apple-touch-icon.png" rel="apple-touch-icon" sizes="180x180">';
echo '<link href="img/favicon/favicon-32x32.png" rel="icon" sizes="32x32" type="image/png">';
echo '<link href="img/favicon/favicon-16x16.png" rel="icon" sizes="16x16" type="image/png">';
echo '<link href="img/favicon/site.webmanifest" rel="manifest">';
// Google Fonts link
echo '<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">';
// Custom CSS links
echo '<link href="styles/reset.css" rel="stylesheet">';
echo '<link href="styles/index.css" rel="stylesheet">';
echo '<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet"/>';
echo '<link href="styles/google_icons.css" rel="stylesheet">';
echo '</head>';
echo '<body>';
echo '<div class="container">';
echo '<div class="container">';
echo '<div class="jumbotron">';
echo '<h1>';
echo '<img alt="Logo" src="img/favicon/android-chrome-512x512.png" style="height: 78px; vertical-align: middle;">';
echo '<span class="text-warning">EstateAtlas</span>';
echo '</h1>';
echo '<p style="text-align: center;" class="text-dark">EstateAtlas is a simple web application that allows you to control a database</p>';
echo '<p style="text-align: center;" class="text-dark">I strongly advise you to read through the <a href="https://github.com/matyas-zavora/aplha-3">documentation</a> first.</p>';
echo '</div>';
echo '</div>';
echo '<div class="container">';
echo '<div class="row">';
echo '<div class="col-md-4">';
echo '<a class="btn btn-warning btn-lg btn-block" href="read.php" role="button">';
echo '<i class="bi bi-book" style="font-size:250px;"></i><br>Read or Delete';
echo '</a>';
echo '</div>';
echo '<div class="col-md-4">';
echo '<a class="btn btn-warning btn-lg btn-block" href="write.php" role="button">';
echo '<i class="bi bi-pencil" style="font-size:250px;"></i><br>Write';
echo '</a>';
echo '</div>';
echo '<div class="col-md-4">';
echo '<a class="btn btn-primary btn-lg btn-block" href="assignment.php" role="button">';
echo '<i class="bi bi-clipboard-check" style="font-size:250px;"></i><br>Assignment';
echo '</a>';
echo '</div>';
echo '</div>';
echo '<div class="row" style="margin-top: 30px;">';
echo '<div class="col-md-10">';
echo '<a class="btn btn-danger btn-lg btn-block" href="./logout.php" role="button" style="height: 100px; display: flex; align-items: center; justify-content: center;">';
echo '<i class="bi bi-box-arrow-right m-2" style="font-size:55px;"></i>Logout';
echo '</a>';
echo '</div>';
echo '<div class="col-md-2">';
echo '<button id="switch" class="btn btn-lg btn-secondary btn-block" onclick="cycleThemes()" style="font-size:55px;" type="button">Switch</button>';
echo '</div>';
echo '</div>';
echo '</div>';
echo '</div>';
// JavaScript script for theme switching
echo '<script src="../scripts/dark-mode.js"></script>';
echo '</body>';
echo '</html>';