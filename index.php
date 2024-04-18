<?php
session_start();
include('database_checker.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OmniToolBox</title>
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
<nav class="navbar navbar-expand-lg bg" id="navbar">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="#">
            OmniToolBox
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <button id="switch" class="btn nav-link" onclick="cycleThemes()">Switch</button>
                <li class="nav-item">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./trimify">Trimify</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./connect.php?tool=estateatlas">EstateAtlas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./connect.php?tool=listease">ListEase</a>
                </li>

            </ul>
        </div>
    </div>
</nav>
<?php
if (isset($_GET['status'])) {
    $status = $_GET['status'];
    $status = str_replace('_', ' ', $status);
    if (str_starts_with($status, 'error')) {
        $status = substr($status, 6);
        echo '<div class="alert alert-danger text-center" role="alert">';
        echo '<h4 class="alert-heading">An error occurred: ' . $status . '</h4>';
        echo '</div>';
        echo '<script> setTimeout(() => { document.querySelector(".alert").remove(); }, 2000); </script>';
    } elseif (str_starts_with($status, 'success')){
        echo '<div class="alert alert-success text-center" role="alert">';
        $status = substr($status, 7);
        echo '<h4 class="alert-heading">'.$status.'.</h4>';
        echo '</div>';
        echo '<script> setTimeout(() => { document.querySelector(".alert").remove(); }, 2000); </script>';
    }
}
?>
<div class="container" id="projects">
    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <img src="trimify/img/favicon/android-chrome-512x512.png" class="card-img-top img-fluid"
                             alt="Project 1" style="height: 5rem; width: auto;">
                        <div class="col">
                            <h5 class="card-title">Trimify</h5>
                            <p class="card-text">File shortener</p>
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary" data-bs-toggle="collapse"
                            data-bs-target="#project1Collapse" aria-expanded="false" aria-controls="project1Collapse">
                        Details
                    </button>
                    <a href="trimify" class="btn btn-success" target="_blank">View Project</a>
                    <a href="https://github.com/matyas-zavora/aplha-2" class="btn btn-secondary" target="_blank"><i class="bi bi-github"></i></a>
                </div>
                <div class="collapse" id="project1Collapse">
                    <div class="card card-body">
                        Website that allows the user to upload a text file and then shorten it (or make it longer)
                        based on user's criteria. The processing is done by a backend written in php. The website is
                        written in html, css and javascript.
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <img src="estateatlas/img/favicon/android-chrome-512x512.png" class="card-img-top img-fluid"
                             alt="Project 1" style="height: 5rem; width: auto;">
                        <div class="col">
                            <h5 class="card-title">EstateAtlas</h5>
                            <p class="card-text">Cadastre of Real Estate</p>
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary" data-bs-toggle="collapse"
                            data-bs-target="#project2Collapse" aria-expanded="false" aria-controls="project2Collapse">
                        Details
                    </button>
                    <a href="./connect.php?tool=estateatlas" class="btn btn-success" target="_blank">View project</a>
                    <a href="https://github.com/matyas-zavora/aplha-3" class="btn btn-secondary" target="_blank"><i class="bi bi-github"></i></a>
                </div>
                <div class="collapse" id="project2Collapse">
                    <div class="card card-body">
                        A website that allows the user to delete, view and upload data onto a premade database based on
                        Cadastre of Real Estate. The processing is done by a backend written in php. The website is
                        written
                        in html, css and javascript.
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <img src="listease/img/favicon/android-chrome-512x512.png" class="card-img-top img-fluid"
                             alt="Project 1" style="height: 5rem; width: auto;">
                        <div class="col">
                            <h5 class="card-title">ListEase</h5>
                            <p class="card-text">A simple shopping list app</p>
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary" data-bs-toggle="collapse"
                            data-bs-target="#project3Collapse" aria-expanded="false" aria-controls="project3Collapse">
                        Details
                    </button>
                    <a href="./connect.php?tool=listease" class="btn btn-success" target="_blank">View Project</a>
                </div>
                <div class="collapse" id="project3Collapse">
                    <div class="card card-body">
                        Shopping list website that allows the user to add, remove and edit items on the list. The
                        processing is done by a backend written in php. The website is written in html, css and
                        javascript.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php


if (isset($_SESSION['conn_params'])) {
    echo '<div class="container">';
    echo '<div class="col-lg-12 mb-4">';
    echo '<div class="card">';
    echo '<div class="card-body">';
    try {
        $connection->select_db('estateatlas');
        echo '<a href="./delete.php?todo=db_estateatlas" class="btn btn-danger">Delete EstateAtlas Database</a> ';
    } catch (Exception $e) {
    }
    try{
        $connection->select_db('listease');
        echo '<a href="./delete.php?todo=db_listease" class="btn btn-danger">Delete ListEase Database</a> ';
    } catch (Exception $e) {
    }
    echo '<a href="./delete.php?todo=conn" class="btn btn-danger">Delete Connection</a>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
}

if (isset($_GET['status'])) {
    echo '<script> setTimeout(() => { window.location.href = "./index.php"; }, 2000); </script>';
}
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="./scripts/dark-mode.js"></script>
</body>
</html>