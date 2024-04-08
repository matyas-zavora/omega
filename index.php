<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Matyáš Závora</title>
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
<nav class="navbar navbar-expand-lg fixed-top bg" id="navbar">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="#">
            <img src="./img/me.png" alt="Logo" width="30" height="30" class="me-2">
            Matyáš Závora
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
                    <a class="nav-link" href="#projects">Projects</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#experience">Experience</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#education">Education</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<?php
if (isset($_GET['status'])) {
    echo '<div class="alert alert-success text-center" role="alert">';
    switch ($_GET['status']) {
        case 'db_deleted':
            echo '<h4 class="alert-heading">Database was deleted successfully.</h4>';
            break;
        case 'conn_deleted':
            echo '<h4 class="alert-heading">Saved database connection was deleted successfully.</h4>';
            break;
    }
    echo '</div>';
}
?>
<header class="jumbotron text-center mt-4">
    <h1>Hi 👋, I'm <a href="https://www.linkedin.com/in/matyas-zavora/">Matyáš</a></h1>
    <p>A passionate full-stack developer from 🇨🇿 and this is my portfolio</p>
</header>
<div class="container">
    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Random Facts</h5>
                    <ul class="card-text list-unstyled">
                        <li>🏥 I had a broken leg once</li>
                        <li>👪 I have two siblings and both are younger</li>
                        <li>🚗 I have a driver's licence</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Contact Me</h5>
                    <ul class="list-unstyled">
                        <li>Email: <a href="mailto: matyaszavora@outlook.com">matyaszavora@outlook.com</a></li>
                        <li>Phone: <a href="tel:+420604529232">+420 604 529 232</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container" id="projects">
    <h2 class="text-center mb-4">Projects</h2>
    <div class="row">
        <div class="col-lg-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <img src="alpha2/img/favicon/android-chrome-512x512.png" class="card-img-top img-fluid"
                             alt="Project 1" style="height: 5rem; width: auto;">
                        <div class="col">
                            <h5 class="card-title">Alpha 2</h5>
                            <p class="card-text">File shortener</p>
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary" data-bs-toggle="collapse"
                            data-bs-target="#project1Collapse" aria-expanded="false" aria-controls="project1Collapse">
                        Details
                    </button>
                    <a href="./alpha2" class="btn btn-success">View Project</a>
                    <a href="https://github.com/matyas-zavora/aplha-2" class="btn btn-secondary" target="_blank">GitHub
                        Repo</a>
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
        <div class="col-lg-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <img src="alpha3/img/favicon/android-chrome-512x512.png" class="card-img-top img-fluid"
                             alt="Project 1" style="height: 5rem; width: auto;">
                        <div class="col">
                            <h5 class="card-title">Alpha 3</h5>
                            <p class="card-text">Database project</p>
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary" data-bs-toggle="collapse"
                            data-bs-target="#project2Collapse" aria-expanded="false" aria-controls="project2Collapse">
                        Details
                    </button>
                    <a href="./info.php" class="btn btn-success">View project</a>
                    <a href="https://github.com/matyas-zavora/aplha-3" class="btn btn-secondary" target="_blank">GitHub
                        Repo</a>
                    <?php if (isset($_SESSION['conn_params'])): ?>
                        <a href="./delete.php?todo=db" class="btn btn-danger">Delete Database</a>
                        <a href="./delete.php?todo=conn" class="btn btn-danger">Delete Connection</a>
                    <?php endif; ?>
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
        <div class="col-lg-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <img src="./img/light.png" style="height: 5rem; width: auto;" class="card-img-top img-fluid"
                             alt="mojerande logo" id="mojerande-logo">
                        <div class="col">
                            <h5>Moje Rande</h5>
                            <p class="card-text">Backend for dating app</p>
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary" data-bs-toggle="collapse"
                            data-bs-target="#project3Collapse" aria-expanded="false" aria-controls="project3Collapse">
                        Details
                    </button>
                    <a href="http://s-zavora-mojerande.dev.spsejecna.net/" class="btn btn-success">View project</a>
                    <a href="https://github.com/prochyxd/mojerande" class="btn btn-secondary" target="_blank">GitHub
                        Repo</a>
                </div>
                <div class="collapse" id="project3Collapse">
                    <div class="card card-body">
                        This application is used to find a suitable partner for the user.
                        The user can create a profile where he fills in his personal data and can then browse the profil
                        es of other users. If he likes a profile, he can invite that person on a date and chat with them
                        afterward.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container" id="experience">
    <h2 class="text-center mb-4">Experience</h2>
    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="card-title">Junior Web Developer</h5>
                            <p class="card-text"><a href="https://omnicado.com/" target="_blank">Omnicado</a></p>
                            <p class="card-text">Sep 2023 - Present</p>
                            <p class="card-text">Nette, a PHP framework</p>
                        </div>
                        <div class="col">
                            <a href="https://omnicado.com/" target="_blank"><img
                                        src="https://upgates.s60.cdn-upgates.com/_cache/2/c/2c9b94e3c0251cb7e0fc01f306f4e660-omnicado-logo-lightmode-lukas-hunka.png"
                                        class="card-img-top img-fluid" alt="Omnicado logo"
                                        style="max-width: 100%; height: auto;"></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="card-title">Internship</h5>
                            <p class="card-text"><a href="https://www.vinci-construction.cz/en" target="_blank">VINCI
                                    Construction</a></p>
                            <p class="card-text">May 2023</p>
                            <p class="card-text">Inventory and Invoice processing</p>
                        </div>
                        <div class="col">
                            <a href="https://www.vinci-construction.cz/en"><img
                                        src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/67/Vinci_%28Unternehmen%29_logo.svg/1200px-Vinci_%28Unternehmen%29_logo.svg.png"
                                        class="card-img-top img-fluid" alt="Vinci logo"
                                        style="max-width: 100%; max-height: 100px; height: auto;"></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="card-title">Internship</h5>
                            <p class="card-text"><a href="https://stavbymostu.vinci-construction.cz/en" target="_blank">SMP
                                    CZ</a></p>
                            <p class="card-text">May 2022</p>
                            <p class="card-text">Virtual machines and Linux servers</p>
                        </div>
                        <div class="col">
                            <a href="https://stavbymostu.vinci-construction.cz/en" target="_blank"><img
                                        alt="smp logo" class="card-img-top img-fluid"
                                        src="https://stavbymostu.vinci-construction.cz/files/sm-cut.svg"
                                        style="max-width: 100%; height: auto;"></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container" id="education">
    <h2 class="text-center mb-4">Education</h2>
    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="card-title">Maturity Diploma</h5>
                            <p class="card-text"><a href="https://www.spsejecna.cz" target="_blank">SPSE Jecna</a></p>
                            <p class="card-text">May 2024 (Wish me luck!)</p>
                        </div>
                        <div class="col">
                            <a href="https://www.spsejecna.cz" target="_blank"><img
                                        alt="spse logo" class="card-img-top img-fluid inverted-logo"
                                        src="https://www.spsejecna.cz/ci/SPSE-Jecna_Logotyp_Cernobily.svg"
                                        style="max-width: 100%; height: auto;" id="jecna-logo"></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
if (isset($_GET['status'])) {
    echo '<script> setTimeout(() => { window.location.href = "./index.php"; }, 2000); </script>';
}
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="./scripts/dark-mode.js"></script>
</body>
</html>