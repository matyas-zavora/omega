<?php
/**
 * This script handles database connection and setup based on user input.
 * It allows users to enter MySQL database credentials via a form and stores the credentials in a file.
 * If the database connection fails, it displays error messages to the user.
 * If the connection is successful, it redirects the user to the corresponding tool page.
 * Additionally, it provides functions to create databases and tables for two specific tools: ListEase and EstateAtlas.
 */

// Redirect to index.php if 'tool' parameter is not provided
if (!isset($_GET['tool'])) {
    header('Location: ./');
    exit();
}

// Start session
session_start();

// Unset 'email' session variable if it's set
if (isset($_SESSION['email'])){
    unset($_SESSION['email']);
}

// Include database_checker.php for checking database connection
include('./database_checker.php');

// Check if database is connected and connection object is set
if (isset($database_connected, $connection)) {
    // If database is not connected, attempt to create databases for specific tools
    if (!$database_connected) {
        if ($_GET['tool'] == 'listease') {
            try {
                CreateDatabaseListEase($connection);
            } catch (Exception $e) {
            }
        } else if ($_GET['tool'] == 'estateatlas') {
            try {
                createDatabaseEstateAtlas($connection);
            } catch (Exception $e) {
            }
        }
    }
    // Redirect to the corresponding tool page
    header("Location: ./" . $_GET['tool']);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $host = $_POST['host'];
    $user = $_POST['user'];
    $password = $_POST['password'];
    $port = $_POST['port'];

    // Attempt to establish a new database connection
    try {
        $connection = new mysqli($host, $user, $password, '', $port);
    } catch (Exception $e) {
        $error = $e->getMessage(); // Store error message
    }

    // If no error, store connection parameters in a file and set session parameters
    if (!isset($error)) {
        $data = json_encode([
            'host' => $host,
            'user' => $user,
            'password' => $password,
            'port' => $port
        ]);
        try {
            $file = fopen(__DIR__ . '/connection.txt', 'w');
            fwrite($file, $data);
            fclose($file);
        } catch (TypeError $e) {
            $error = $e->getMessage(); // Store error message
        }
        try {
            $connection->select_db($_GET['tool']); // Select database for the tool
        } catch (Exception $e) {
            // If database connection fails, attempt to create databases for specific tools
            if (isset($database_connected) and !$database_connected){
                if ($_GET['tool'] == 'listease') {
                    CreateDatabaseListEase($connection);
                } else if ($_GET['tool'] == 'estateatlas') {
                    createDatabaseEstateAtlas($connection);
                }
            }
            // Redirect to the corresponding tool page
            header("Location: ./" . $_GET['tool']);
            exit();
        }
        // Set session parameters
        $_SESSION['conn_params'] = [
            'host' => $host,
            'user' => $user,
            'password' => $password,
            'port' => $port
        ];
        // Redirect to the corresponding tool page
        header("Location: ./" . $_GET['tool']);
        exit();
    }
}

// Output HTML content for the form
echo '<!DOCTYPE html>';
echo '<html lang="en">';
echo '<head>';
echo '<meta charset="UTF-8">';
echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
echo '<title>Database connection</title>';
// Include CSS and favicon
echo '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">';
echo '<link rel="apple-touch-icon" sizes="180x180" href="./img/favicon/apple-touch-icon.png">';
echo '<link rel="icon" type="image/png" sizes="32x32" href="./img/favicon/favicon-32x32.png">';
echo '<link rel="icon" type="image/png" sizes="16x16" href="./img/favicon/favicon-16x16.png">';
echo '<link rel="manifest" href="./img/favicon/site.webmanifest">';
echo '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">';
echo '<link rel="preconnect" href="https://fonts.googleapis.com">';
echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>';
echo '<link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">';
echo '<link rel="stylesheet" href="styles/font.css">';
echo '</head>';
echo '<body>';
// Display error message if set
if (isset($error)) echo '<div class="alert alert-danger text-center" role="alert">Error: ' . $error . '</div>';
// Display header
echo '<header class="jumbotron text-center mt-lg-5">';
echo '<h1 class="text-center">Enter your MySQL database credentials</h1>';
echo '</header>';
// Display form
echo '<form method="post" class="container mt-5">';
echo '<div class="mb-3">';
echo '<label for="host" class="form-label">Host</label>';
// Display input field for host with error message if 'php_network_getaddresses' error occurs
if (isset($error) && strpos($error, 'php_network_getaddresses') !== false) {
    echo '<input type="text" class="form-control is-invalid" id="host" required name="host" value="' . $_POST['host'] . '">';
    echo '<div class="invalid-feedback">Invalid host</div>';
} else {
    echo '<input type="text" class="form-control" id="host" name="host" required value="localhost">';
}
echo '</div>';
// Display input field for user with error message if 'Access denied' error occurs
echo '<div class="mb-3">';
echo '<label for="user" class="form-label">User</label>';
if (isset($error) && strpos($error, 'Access denied') !== false) {
    echo '<input type="text" class="form-control is-invalid" id="user" name="user" required value="' . $_POST['user'] . '">';
} else {
    echo '<input type="text" class="form-control" id="user" name="user" value="root" required>';
}
echo '</div>';
// Display input field for password with error message if 'Access denied' error occurs
echo '<div class="mb-3">';
echo '<label for="password" class="form-label">Password</label>';
if (isset($error) && strpos($error, 'Access denied') !== false) {
    echo '<input type="password" class="form-control is-invalid" id="password" name="password">';
    echo '<div class="invalid-feedback">Access denied for user ' . $user . '</div>';
} else {
    echo '<input type="password" class="form-control" id="password" name="password">';
}
echo '</div>';
// Display input field for port
echo '<div class="mb-3">';
echo '<label for="port" class="form-label">Port</label>';
echo '<input type="number" class="form-control" id="port" name="port" value="3306">';
echo '</div>';
// Submit button
echo '<button type="submit" class="btn btn-primary">Submit</button>';
// Dark mode switch button
echo '<button id="switch" class="btn btn-secondary" onclick="cycleThemes()" type="button">Switch</button>';
// Dark mode script
echo '<script src="./scripts/dark-mode.js"></script>';
echo '</form>';
echo '</body>';
echo '</html>';

// Function to create ListEase database
function createDatabaseListEase(mysqli $conn): void
{
    // Create ListEase database tables
    try {
        $sql = 'DROP DATABASE `listease`';
        $conn->query($sql);
    } catch (Exception $e) {
    }
    $conn->query("SET SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO';");
    $conn->query("START TRANSACTION;");
    $conn->query("SET time_zone = '+00:00';");
    $sql = 'CREATE DATABASE `listease` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;';
    $conn->query($sql);
    $sql = 'USE `listease`;';
    $conn->query($sql);
    $sql = 'CREATE TABLE IF NOT EXISTS `items` (
              `id` int NOT NULL AUTO_INCREMENT,
              `name` varchar(100) NOT NULL,
              `quantity` int DEFAULT NULL,
              `price` float(10,2) DEFAULT NULL,
              `user_id` int NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;';
    $conn->query($sql);
    $sql = 'CREATE TABLE IF NOT EXISTS `users` (
              `id` int NOT NULL AUTO_INCREMENT,
              `email` varchar(100) NOT NULL,
              `psw` varchar(100) NOT NULL,
              PRIMARY KEY (`id`),
              UNIQUE KEY `email` (`email`)
            ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;';
    $conn->query($sql);

    $sql = 'ALTER TABLE `items` MODIFY `id` int NOT NULL AUTO_INCREMENT;';
    $conn->query($sql);
    $sql = 'ALTER TABLE `users` MODIFY `id` int NOT NULL AUTO_INCREMENT;';
    $conn->query($sql);
    $conn->query('ALTER TABLE `users` ADD UNIQUE(`email`); ');

}

// Function to create EstateAtlas database
function createDatabaseEstateAtlas(mysqli $conn): void
{
    // Create EstateAtlas database tables
    try{
        $conn->query('DROP DATABASE `estateatlas`');
    } catch (Exception $e) {
    }
    $conn->query("SET SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO';");
    $conn->query("START TRANSACTION;");
    $conn->query("SET time_zone = '+00:00';");
    $conn->query("CREATE DATABASE IF NOT EXISTS `estateatlas` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;");
    $conn->select_db('estateatlas');

    $conn->query("CREATE TABLE IF NOT EXISTS `company` (
                        `id` int(11) NOT NULL,
                          `name` varchar(100) NOT NULL,
                          `address` varchar(100) NOT NULL,
                          `zip` int(11) NOT NULL,
                          `city` varchar(50) NOT NULL,
                          `country` varchar(2) NOT NULL
                        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;");

    $conn->query("CREATE TABLE IF NOT EXISTS `log` (
                          `id` int(11) NOT NULL,
                          `type` enum('insert','delete','view','') NOT NULL,
                          `id_user` int(11) NOT NULL,
                          `occured` datetime DEFAULT current_timestamp(),
                          `description` varchar(100) NOT NULL
                        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;");

    $conn->query("CREATE TABLE IF NOT EXISTS `owner` (
                          `id` int(11) NOT NULL,
                          `first_name` varchar(30) NOT NULL,
                          `last_name` varchar(30) NOT NULL,
                          `phone` int(11) NOT NULL
                        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;");

    $conn->query("CREATE TABLE IF NOT EXISTS `ownership_list` (
                          `id` int(11) NOT NULL,
                          `id_parcel` int(11) NOT NULL,
                          `id_owner` int(11) DEFAULT NULL,
                          `id_company` int(11) DEFAULT NULL,
                          `stake` float(5,2) NOT NULL
                        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;");

    $conn->query("CREATE TABLE IF NOT EXISTS `parcel` (
                      `id` int(11) NOT NULL,
                      `number` int(11) NOT NULL,
                      `size` float(8,2) NOT NULL,
                      `latitude` float(10,2) NOT NULL,
                      `longitude` float(10,2) NOT NULL,
                      `date_of_ownership` datetime NOT NULL DEFAULT current_timestamp(),
                      `legal_state` enum('owned','leased','pledged','') NOT NULL,
                      `type` enum('zastavěné plochy a nádvoří','lesní pozemky','vodní plochy','ostatní plochy','zemědělské pozemky') NOT NULL,
                      `address` varchar(100) NOT NULL,
                      `zip` int(11) NOT NULL,
                      `city` varchar(50) NOT NULL,
                      `country` varchar(2) NOT NULL
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;");

    $conn->query("CREATE TABLE IF NOT EXISTS `user` (
                          `id` int(11) NOT NULL,
                          `email` varchar(100) NOT NULL,
                          `password` varchar(100) NOT NULL
                        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;");

    $conn->query("TRUNCATE TABLE `user`;");
    $conn->query("TRUNCATE TABLE `parcel`;");
    $conn->query("TRUNCATE TABLE `ownership_list`;");
    $conn->query("TRUNCATE TABLE `owner`;");
    $conn->query("TRUNCATE TABLE `log`;");
    $conn->query("TRUNCATE TABLE `company`;");

    $conn->query('INSERT INTO `user` (`id`, `email`, `password`) VALUES
                        (1, \'admin@admin.com\', \'$2y$10$iKO0idnCIiU.tCkrNMjiEOgODufKIRxgqOoBo4Co6DnNq174Q6ZAm\');');

    $conn->query("INSERT INTO `company` (`id`, `name`, `address`, `zip`, `city`, `country`) VALUES
                        (1, 'Company B', '456 Oak St', 56789, 'City B', 'CA'),
                        (3, 'Company C', '789 Maple St', 98765, 'City C', 'UK');");

    $conn->query("INSERT INTO `owner` (`id`, `first_name`, `last_name`, `phone`) VALUES
                        (2, 'Bob', 'Johnson', 555555555);");

    $conn->query("INSERT INTO `ownership_list` (`id`, `id_parcel`, `id_owner`, `id_company`, `stake`) VALUES
                        (5, 4, NULL, 1, 1.00),
                        (6, 5, 2, NULL, 0.70),
                        (7, 5, NULL, 3, 0.30);");

    $conn->query("INSERT INTO `parcel` (`id`, `number`, `size`, `latitude`, `longitude`, `date_of_ownership`, `legal_state`, `type`, `address`, `zip`, `city`, `country`) VALUES
                    (4, 102, 85.30, 34.05, -118.24, '2024-01-26 14:17:24', 'leased', 'zemědělské pozemky', '789 Elm St', 87654, 'City E', 'CA'),
                    (5, 103, 200.00, 51.51, -0.12, '2024-01-26 14:17:24', 'pledged', 'lesní pozemky', '123 Birch St', 13579, 'City F', 'UK'),
                    (6, 101, 120.50, 40.71, -74.01, '2024-01-26 14:17:24', 'owned', 'zastavěné plochy a nádvoří', '456 Pine St', 54321, 'City D', 'US');");

    $conn->query("ALTER TABLE `company` ADD PRIMARY KEY (`id`);");
    $conn->query("ALTER TABLE `log` ADD PRIMARY KEY (`id`), ADD KEY `fk_log_user` (`id_user`);");
    $conn->query("ALTER TABLE `owner` ADD PRIMARY KEY (`id`);");
    $conn->query("ALTER TABLE `ownership_list`
                        ADD PRIMARY KEY (`id`),
                        ADD KEY `fk_ownership_list_owner` (`id_owner`),
                        ADD KEY `fk_ownership_list_parcel` (`id_parcel`), 
                        ADD KEY `fk_ownership_list_company` (`id_company`);");

    $conn->query("ALTER TABLE `parcel` ADD PRIMARY KEY (`id`);");
    $conn->query("ALTER TABLE `user` ADD PRIMARY KEY (`id`);");
    $conn->query("ALTER TABLE `company` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;");
    $conn->query("ALTER TABLE `log` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;");
    $conn->query("ALTER TABLE `owner` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;");
    $conn->query("ALTER TABLE `ownership_list` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT = 8;");
    $conn->query("ALTER TABLE `parcel` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT = 7;");
    $conn->query("ALTER TABLE `user` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT = 2;");
    $conn->query("ALTER TABLE `log` ADD CONSTRAINT `fk_log_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`);");
    $conn->query("ALTER TABLE `ownership_list`
    ADD CONSTRAINT `fk_ownership_list_company` FOREIGN KEY (`id_company`) REFERENCES `company` (`id`) ON DELETE CASCADE,
    ADD CONSTRAINT `fk_ownership_list_owner` FOREIGN KEY (`id_owner`) REFERENCES `owner` (`id`) ON DELETE CASCADE,
    ADD CONSTRAINT `fk_ownership_list_parcel` FOREIGN KEY (`id_parcel`) REFERENCES `parcel` (`id`) ON DELETE CASCADE;");

    $conn->query("COMMIT;");
}