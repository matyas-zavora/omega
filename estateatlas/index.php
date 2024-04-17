<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: ./login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>EstateAtlas</title>
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
<div class="container">
    <div class="container">
        <div class="jumbotron">
            <h1>
                <img alt="Logo" src="img/favicon/android-chrome-512x512.png"
                     style="height: 78px; vertical-align: middle;">
                <span class="text-warning">EstateAtlas</span>
            </h1>
            <p style="text-align: center;" class="text-dark">EstateAtlas is a simple web application that allows you to control a database</p>
            <p style="text-align: center;" class="text-dark">I strongly advise you to read through the <a
                        href="https://github.com/matyas-zavora/aplha-3">documentation</a> first.
            </p>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <a class="btn btn-warning btn-lg btn-block" href="read.php" role="button">
                    <i class="bi bi-book" style="font-size:250px;"></i><br>Read or Delete
                </a>
            </div>
            <div class="col-md-4">
                <a class="btn btn-warning btn-lg btn-block" href="write.php" role="button">
                    <i class="bi bi-pencil" style="font-size:250px;"></i><br>Write
                </a>
            </div>
            <div class="col-md-4">
                <a class="btn btn-primary btn-lg btn-block" href="assignment.php" role="button">
                    <i class="bi bi-clipboard-check" style="font-size:250px;"></i><br>Assignment
                </a>
            </div>
        </div>
        <div class="row" style="margin-top: 30px;">
            <div class="col-md-10">
                <a class="btn btn-danger btn-lg btn-block" href="./logout.php" role="button"
                   style="height: 100px; display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-box-arrow-right m-2" style="font-size:55px;"></i>Logout
                </a>
            </div>
            <div class="col-md-2">
                <button id="switch" class="btn btn-lg btn-secondary btn-block" onclick="cycleThemes()" style="font-size:55px;" type="button">Switch</button>
            </div>
        </div>
    </div>
</div>
<script src="../scripts/dark-mode.js"></script>
</body>
</html>