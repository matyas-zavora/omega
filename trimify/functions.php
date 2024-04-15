<?php
/**
 * Reads the contents of a file.
 *
 * @param string $targetFile The target file name.
 * @param string $uploadDir The directory where the file is located.
 * @return string The contents of the file.
 */
function readFileContents(string $targetFile, string $uploadDir)
{
    $file = fopen($uploadDir . $targetFile, 'r');
    $fileContent = fread($file, filesize($uploadDir . $targetFile));
    fclose($file);
    return $fileContent;
}

/**
 * Shortens the contents of a file based on replacement arrays.
 *
 * @param string $targetFile The target file name.
 * @param string $uploadDir The directory where the file is located.
 * @param array $input1 The array of strings to be replaced.
 * @param array $input2 The array of replacement strings.
 */
function shortenFile(string $targetFile, string $uploadDir, array $input1, array $input2)
{
    if (!empty($input1) && !empty($input2) && count($input1) === count($input2)) {
        $fileContent = readFileContents($targetFile, $uploadDir);

        foreach ($input1 as $index => $search) {
            if (stripos($fileContent, $search) !== false) {
                $fileContent = preg_replace("/\b" . preg_quote($search, '/') . "\b/i", $input2[$index], $fileContent);
            }
        }

        $file = fopen($uploadDir . $targetFile, 'w');
        fwrite($file, $fileContent);
        fclose($file);
    }
}


/**
 * Logs a message to a log file.
 *
 * @param string $message The message to be logged.
 */
function _log(string $message)
{
    $date = getdate()['mday'] . "/" . getdate()['mon'] . "/" . getdate()['year'] . " " . getdate()['hours'] . ":" . getdate()['minutes'] . ":" . getdate()['seconds'] . " - ";
    $message = $date . $message . "\n";
    $logFile = fopen("./log/log.txt", "a");
    fwrite($logFile, $message);
    fclose($logFile);
}

/**
 * Displays a message on the client side and logs it.
 *
 * @param string $message The message to be displayed.
 * @param string $alertType The type of the message (error, info, success).
 */
function writeMessage(string $message, string $alertType)
{
    echo '<script>
            const alert = document.getElementById("phpError");
            const info = document.getElementById("phpInfo");
            const success = document.getElementById("phpSuccess");
            ';

    switch ($alertType) {
        case "error":
            echo "alert.innerHTML = '$message';alert.style.display = 'block';";
            _log($alertType . ": " . $message);
            break;
        case "info":
            echo "info.innerHTML = '$message;info.style.display = 'block';";
            _log($alertType . ": " . $message);
            break;
        case "success":
            echo "success.innerHTML = '$message';success.style.display = 'block';";
            _log($alertType . ": " . $message);
            break;
        default:
            break;
    }
    echo 'setTimeout(function(){alert.style.display = "none";info.style.display = "none";success.style.display = "none";}, 5000);';
    echo '</script>';
}

/**
 * Processes a file by shortening it, initiating download, and logging the deletion.
 *
 * @param string $targetFile The target file name.
 * @param string $uploadDir The directory where the file is located.
 * @param array $input1 The array of strings to be replaced.
 * @param array $input2 The array of replacement strings.
 */
function processFile(string $targetFile, string $uploadDir, array $input1, array $input2)
{
    shortenFile($targetFile, $uploadDir, $input1, $input2);
    downloadFile($targetFile, $uploadDir);
    _log("info - File " . $targetFile . " has been deleted.");
}

/**
 * Initiates download of a file, and deletes it afterwards.
 *
 * @param string $targetFile The target file name.
 * @param string $uploadDir The directory where the file is located.
 */
function downloadFile(string $targetFile, string $uploadDir)
{
    $file = $uploadDir . $targetFile;

    if (file_exists($file)) {
        header('Content-Description: File Transfer');
        header('Content-Type: text/plain');
        header('Content-Disposition: attachment; filename="' . basename($file) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        readfile($file);

        unlink($file);
        _log("info - File " . $targetFile . " has been deleted.");
        exit;
    }
}

?>
