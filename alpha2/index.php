<?php
//Make errors visible
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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

// Include the HTML template
include './templates/index.html';
