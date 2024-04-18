<?php
/**
 * Start the session to allow storing session data.
 */
session_start();

/**
 * Include the database checker script to check database connections.
 */
include('database_checker.php');

/**
 * Start of HTML document.
 */
echo '<!DOCTYPE html>';
echo '<html lang="en">';
echo '<head>';
echo '<meta charset="UTF-8">';
echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
echo '<title>OmniToolBox</title>';
echo '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">';
echo '<link rel="apple-touch-icon" sizes="180x180" href="img/favicon/apple-touch-icon.png">';
echo '<link rel="icon" type="image/png" sizes="32x32" href="img/favicon/favicon-32x32.png">';
echo '<link rel="icon" type="image/png" sizes="16x16" href="img/favicon/favicon-16x16.png">';
echo '<link rel="manifest" href="img/favicon/site.webmanifest">';
echo '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">';
echo '<link rel="preconnect" href="https://fonts.googleapis.com">';
echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>';
echo '<link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">';
echo '<link rel="stylesheet" href="./styles/font.css">';
echo '</head>';
echo '<body>';

/**
 * Navigation Bar.
 */
echo '<nav class="navbar navbar-expand-lg bg" id="navbar">';
echo '<div class="container">';
echo '<a class="navbar-brand d-flex align-items-center" href="#">';
echo 'OmniToolBox';
echo '</a>';
echo '<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">';
echo '<span class="navbar-toggler-icon"></span>';
echo '</button>';
echo '<div class="collapse navbar-collapse" id="navbarNav">';
echo '<ul class="navbar-nav ms-auto">';
echo '<li class="nav-item">';
echo '<button id="switch" class="btn nav-link" onclick="cycleThemes()">Switch</button>';
echo '<li class="nav-item">';
echo '<li class="nav-item">';
echo '<a class="nav-link active" aria-current="page" href="#">Home</a>';
echo '</li>';
echo '<li class="nav-item">';
echo '<a class="nav-link" href="./trimify">Trimify</a>';
echo '</li>';
echo '<li class="nav-item">';
echo '<a class="nav-link" href="./connect.php?tool=estateatlas">EstateAtlas</a>';
echo '</li>';
echo '<li class="nav-item">';
echo '<a class="nav-link" href="./connect.php?tool=listease">ListEase</a>';
echo '</li>';
echo '</ul>';
echo '</div>';
echo '</div>';
echo '</nav>';

/**
 * Projects Section.
 */
echo '<div class="container" id="projects">';
echo '<div class="row">';
echo '<div class="col-lg-12 mb-4">';
echo '<div class="card">';
echo '<div class="card-body">';
echo '<div class="row mb-2">';
echo '<img src="trimify/img/favicon/android-chrome-512x512.png" class="card-img-top img-fluid" alt="Project 1" style="height: 5rem; width: auto;">';
echo '<div class="col">';
echo '<h5 class="card-title">Trimify</h5>';
echo '<p class="card-text">File shortener</p>';
echo '</div>';
echo '</div>';
echo '<button type="button" class="btn btn-primary" data-bs-toggle="collapse" data-bs-target="#project1Collapse" aria-expanded="false" aria-controls="project1Collapse">Details</button> ';
echo '<a href="trimify" class="btn btn-success" target="_blank">View Project</a> ';
echo '<a href="https://github.com/matyas-zavora/aplha-2" class="btn btn-secondary" target="_blank"><i class="bi bi-github"></i></a>';
echo '</div>';
echo '<div class="collapse" id="project1Collapse">';
echo '<div class="card card-body">Website that allows the user to upload a text file and then shorten it (or make it longer) based on user\'s criteria. The processing is done by a backend written in php. The website is written in html, css and javascript.</div>';
echo '</div>';
echo '</div>';
echo '</div>';
echo '<div class="col-lg-12 mb-4">';
echo '<div class="card">';
echo '<div class="card-body">';
echo '<div class="row mb-2">';
echo '<img src="estateatlas/img/favicon/android-chrome-512x512.png" class="card-img-top img-fluid" alt="Project 1" style="height: 5rem; width: auto;">';
echo '<div class="col">';
echo '<h5 class="card-title">EstateAtlas</h5>';
echo '<p class="card-text">Cadastre of Real Estate</p>';
echo '</div>';
echo '</div>';
echo '<button type="button" class="btn btn-primary" data-bs-toggle="collapse" data-bs-target="#project2Collapse" aria-expanded="false" aria-controls="project2Collapse">Details</button>';
echo '<a href="./connect.php?tool=estateatlas" class="btn btn-success" target="_blank">View project</a> ';
echo '<a href="https://github.com/matyas-zavora/aplha-3" class="btn btn-secondary" target="_blank"><i class="bi bi-github"></i></a>';
echo '</div>';
echo '<div class="collapse" id="project2Collapse">';
echo '<div class="card card-body"> A website that allows the user to delete, view and upload data onto a premade database based on Cadastre of Real Estate. The processing is done by a backend written in php. The website is written in html, css and javascript.</div>';
echo '</div>';
echo '</div>';
echo '</div>';
echo '<div class="col-lg-12 mb-4">';
echo '<div class="card">';
echo '<div class="card-body">';
echo '<div class="row mb-2">';
echo '<img src="listease/img/favicon/android-chrome-512x512.png" class="card-img-top img-fluid" alt="Project 1" style="height: 5rem; width: auto;">';
echo '<div class="col">';
echo '<h5 class="card-title">ListEase</h5>';
echo '<p class="card-text">A simple shopping list app</p>';
echo '</div>';
echo '</div>';
echo '<button type="button" class="btn btn-primary" data-bs-toggle="collapse" data-bs-target="#project3Collapse" aria-expanded="false" aria-controls="project3Collapse">Details</button> ';
echo '<a href="./connect.php?tool=listease" class="btn btn-success" target="_blank">View Project</a>';
echo '</div>';
echo '<div class="collapse" id="project3Collapse">';
echo '<div class="card card-body">Shopping list website that allows the user to add, remove and edit items on the list. The processing is done by a backend written in php. The website is written in html, css and javascript.</div>';
echo '</div>';
echo '</div>';
echo '</div>';
echo '</div>';
echo '</div>';

/**
 * Display database management options if the session contains connection parameters.
 */
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
    try {
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

/**
 * Redirect to index.php after a certain time if 'status' is set in the URL.
 */
if (isset($_GET['status'])) {
    echo '<script> setTimeout(() => { window.location.href = "./index.php"; }, 2000); </script>';
}

/**
 * JavaScript and Bootstrap scripts.
 */
echo '<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>';
echo '<script src="./scripts/dark-mode.js"></script>';
echo '</body>';
echo '</html>';
