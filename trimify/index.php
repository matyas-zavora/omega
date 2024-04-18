<?php
// Include necessary functions
require_once 'functions.php';

// Define the upload directory
$uploadDir = './input/';

// Check if the form is submitted using POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the file is uploaded
    if (isset($_FILES['fileImport'])) {
        // Get the original file name
        $fileName = $_FILES['fileImport']['name'];

        // Get the desired output file name from the form
        $fileNewName = $_POST['outputFileName'];

        // Flag to track if the file is renamed
        $isFileRenamed = false;

        // If output file name is not provided, use the original file name
        if (empty($fileNewName)) {
            $fileNewName = $fileName;
        } else {
            // If output file name is provided, append ".txt" extension
            $isFileRenamed = true;
            $fileNewName .= ".txt";
        }

        // Check if the file type is text/plain
        if ($_FILES['fileImport']['type'] === 'text/plain') {
            // Move the uploaded file to the specified directory
            if (move_uploaded_file($_FILES['fileImport']['tmp_name'], $uploadDir . $fileNewName)) {
                // Log success message
                _log("success - " . $fileName . " has been uploaded successfully.");

                // Log file renaming information if applicable
                if ($isFileRenamed) _log("info - File " . $fileName . " has been renamed to " . $fileNewName);

                // Process the file
                processFile($fileNewName, $uploadDir, $_POST['input1'], $_POST['input2']);
            } else {
                // Display error message if file upload fails
                writeMessage("There has been an error uploading the file. Please try again.", "error");
            }
        } else {
            // Display error message if the file type is not text/plain
            writeMessage("Sorry, only TXT files are allowed.", "error");
        }
    } else {
        // Display error message if file is not uploaded
        writeMessage("There has been an error uploading the file. Please try again.", "error");
    }
}

echo '<!DOCTYPE html>';
echo '<html lang="en">';
echo '<head>';
echo '<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">';
echo '<meta charset="UTF-8">';
echo '<title>Trimify</title>';
echo '<link rel="preconnect" href="https://fonts.googleapis.com">';
echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>';
echo '<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">';
echo '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">';
echo '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">';
echo '<link href="./img/favicon/apple-touch-icon.png" rel="apple-touch-icon" sizes="180x180">';
echo '<link href="./img/favicon/favicon-32x32.png" rel="icon" sizes="32x32" type="image/png">';
echo '<link href="./img/favicon/favicon-16x16.png" rel="icon" sizes="16x16" type="image/png">';
echo '<link href="./img/favicon/site.webmanifest" rel="manifest">';
echo '<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">';
echo '<link href="./styles/reset.css" rel="stylesheet">';
echo '<link href="./styles/index.css" rel="stylesheet">';
echo '</head>';
echo '<body>';
echo '<div class="container">';
echo '<div class="jumbotron">';
echo '<h1>';
echo '<img alt="Logo" src="./img/favicon/android-chrome-512x512.png" style="height: 78px; vertical-align: middle;">';
echo '<span class="text-info">Trimify</span>';
echo '</h1>';
echo '<p class="text-dark">Trimify is a simple web application that allows you to shorten desired text based on';
echo '<span class="text-info">T</span>he';
echo '<span class="text-info">M</span>ighty';
echo '<span class="text-info">T</span>able';
echo '<span class="text-info">O</span>f';
echo '<span class="text-info">S</span>hortages (<span class="text-info">TMTOS</span>) &#169;</p>';
echo '</div>';
echo '<div class="alert alert-danger" id="fileError" role="alert" style="display: none;">';
echo 'Invalid file format! Please upload a .txt file.';
echo '</div>';
echo '<div class="alert alert-success" id="fileSuccess" role="alert" style="display: none;">';
echo '<span id="fileName"></span> has been successfully uploaded.';
echo '</div>';
echo '<div class="alert alert-danger" id="phpError" role="alert" style="display: none;"></div>';
echo '<div class="alert alert-success" id="phpSuccess" role="alert" style="display: none;"></div>';
echo '<div class="alert alert-info" id="phpInfo" role="alert" style="display: none;"></div>';
echo '</div>';
echo '<form enctype="multipart/form-data" id="shortenForm" method="post">';
echo '<div class="container">';
echo '<div class="form-group">';
echo '<label class="form-label" for="fileImport">Upload a .txt file</label>';
echo '<input class="form-control form-control-lg" id="fileImport" name="fileImport" type="file">';
echo '</div>';
echo '<div class="form-group">';
echo '<label for="outputFileName">Output File Name</label>';
echo '<input class="form-control" id="outputFileName" name="outputFileName" placeholder="Enter output file name" type="text">';
echo '</div>';
echo '<div class="divider"></div>';
echo '<div class="row">';
echo '<h1 class="text-center">';
echo '<span class="text-info">T</span>he';
echo '<span class="text-info">M</span>ighty';
echo '<span class="text-info">T</span>able';
echo '<span class="text-info">O</span>f';
echo '<span class="text-info">S</span>hortages &#169;';
echo '</h1>';
echo '</div>';
echo '<div class="form-group">';
echo '<table class="table table-striped" id="dataTable">';
echo '<thead>';
echo '<tr>';
echo '<th scope="col">I want this...</th>';
echo '<th scope="col">To be replaced with this...</th>';
echo '</tr>';
echo '</thead>';
echo '<tbody>';
echo '<tr>';
echo '<td><input class="form-control" name="input1[]" oninput="addRow(\'dataTable\')" type="text"></td>';
echo '<td><input class="form-control" name="input2[]" oninput="addRow(\'dataTable\')" type="text"></td>';
echo '</tr>';
echo '</tbody>';
echo '</table>';
echo '<div class="btn-group-justified" id="buttonGroup" style="width: 100%;">';
echo '<input class="btn btn-danger btn-block" id="clearBtn" onclick="clearTable()" style="display: none;" type="button" value="Clear Table">';
echo '</div>';
echo '</div>';
echo '</div>';
echo '</div>';
echo '</form>';
echo '<div class="container">';
echo '<button class="btn btn-primary me-2" onclick="window.location.href=\'./assignment.php\'">Assignment</button>';
echo '<a class="btn btn-primary me-2" download href="./log/log.txt">Download Log</a>';
echo '<a class="btn btn-danger me-2" href="../">Return</a>';
echo '<button class="btn btn-secondary me-2" id="switch" onclick="cycleThemes()" type="button">Switch</button>';
echo '</div>';
echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>';
echo '<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>';
echo '<script src="./scripts/index.js"></script>';
echo '<script src="../scripts/dark-mode.js"></script>';
echo '</body>';
echo '</html>';