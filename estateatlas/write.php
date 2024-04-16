<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: ../");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Alpha 3 | Write</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
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
            <a class="btn btn-warning btn-lg btn-block" href="files.php" role="button"><span
                        class="material-symbols-outlined" style="font-size:250px;">home_storage</span><br>Files</a>
        </div>
        <div class="col-md-6">
            <a class="btn btn-warning btn-lg btn-block" href="manually.php" role="button"><span
                        class="material-symbols-outlined" style="font-size:250px;">edit_note</span><br>Manually</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12" style="margin-top: 30px;">
            <a class="btn btn-warning btn-lg btn-block" href="home.php" role="button"><span
                        class="material-symbols-outlined" style="font-size:250px;">arrow_back</span><br>Return</a>
        </div>
    </div>
</div>
</body>
</html>
