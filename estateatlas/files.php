<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: ../");
    exit();
}
$conn_params = $_SESSION['conn_params'];
$conn = new mysqli($conn_params['host'], $conn_params['user'], $conn_params['password'], null, $conn_params['port']);
include "../templates/files.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>EstateAtlas | Files</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="img/favicon/apple-touch-icon.png" rel="apple-touch-icon" sizes="180x180">
    <link href="img/favicon/favicon-32x32.png" rel="icon" sizes="32x32" type="image/png">
    <link href="img/favicon/favicon-16x16.png" rel="icon" sizes="16x16" type="image/png">
    <link href="img/favicon/site.webmanifest" rel="manifest">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <link href="styles/reset.css" rel="stylesheet">
    <link href="styles/index.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"
          rel="stylesheet"/>
    <link href="styles/google_icons.css" rel="stylesheet">
</head>
<body>
<div class="container" style="height: 89vh;">
    <div class="row">
        <div class="col-md-6">
            <a class="btn btn-warning btn-lg btn-block" href="./download_full_parcel_data.php" role="button">
                <i class="bi bi-file-earmark-arrow-down" style="font-size: 250px;"></i><br>Download full
                parcel
                data</a>
        </div>
        <div class="col-md-6">
            <a class="btn btn-warning btn-lg btn-block" href="upload.php" role="button">
                <i class="bi bi-file-earmark-arrow-up" style="font-size: 250px;"></i><br>Upload full parcel data</a>
        </div>
    </div>
    <div class="row" style="margin-top: 30px;">
        <div class="col-md-10">
            <a class="btn btn-danger btn-lg btn-block" href="./write.php" role="button"
               style="height: 100px; display: flex; align-items: center; justify-content: center;">
                <i class="bi bi-arrow-left m-2" style="font-size:55px;"></i>Return
            </a>
        </div>
        <div class="col-md-2">
            <button id="switch" class="btn btn-lg btn-secondary btn-block" onclick="cycleThemes()" style="font-size:55px;" type="button">Switch</button>
        </div>
    </div>
</div>
<script src="../scripts/dark-mode.js"></script>
</body>
</html>
