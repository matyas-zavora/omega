<?php
session_start();
if (isset($_SESSION['conn_params'])) {
    header("Location: ./estateatlas/index.php");
    exit();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $host = filter_input(INPUT_POST, 'host', FILTER_SANITIZE_STRING);
    $user = filter_input(INPUT_POST, 'user', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    $port = filter_input(INPUT_POST, 'port', FILTER_SANITIZE_NUMBER_INT);
    $conn = new mysqli($host, $user, $password, null, $port);

    if (!$conn->connect_error) {
        $conn_params = array();
        $conn_params['host'] = $host;
        $conn_params['user'] = $user;
        $conn_params['password'] = $password;
        $conn_params['port'] = $port;
        $_SESSION['conn_params'] = $conn_params;
        createDatabaseA3($conn);
        header('Location: ./estateatlas/index.php');
        exit();
    }
}

/**
 * Creates the database estateatlas with the tables company, log, owner, ownership_list, parcel, user
 * @param mysqli $conn MySQL Database connection
 * @return void
 */

echo '<!doctype html>';
echo '<html lang="en">';
echo '<head>';
    echo '<meta charset="UTF-8">';
    echo '<meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">';
    echo '<meta http-equiv="X-UA-Compatible" content="ie=edge">';
    echo '<title>Document</title>';
    echo '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">';
echo '</head>';
echo '<body>';

if (isset($conn) and $conn->connect_error){
    echo '<div class="alert alert-danger" role="alert">';
        echo $conn->connect_error;
    echo '</div>';
}
echo '<header class="jumbotron text-center mt-lg-5">';
    echo '<h1 class="text-center">Enter your MySQL database credentials</h1>';
echo '</header>';
echo '<form action="info.php" method="post" class="container mt-5">';
    echo '<div class="mb-3">';
        echo '<label for="host" class="form-label">Host</label>';
        echo '<input type="text" class="form-control" id="host" name="host" value="localhost">';
    echo '</div>';
    echo '<div class="mb-3">';
        echo '<label for="user" class="form-label">User</label>';
        echo '<input type="text" class="form-control" id="user" name="user" value="root">';
    echo '</div>';
    echo '<div class="mb-3">';
        echo '<label for="password" class="form-label">Password</label>';
        echo '<input type="password" class="form-control" id="password" name="password">';
    echo '</div>';
    echo '<div class="mb-3">';
        echo '<label for="port" class="form-label">Port</label>';
        echo '<input type="number" class="form-control" id="port" name="port" value="3306">';
    echo '</div>';
    echo '<button type="submit" class="btn btn-primary">Submit</button>';
echo '</body>';
echo '</html>';

function createDatabaseA3(mysqli $conn)
{
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

    $conn->query("INSERT INTO `user` (`id`, `email`, `password`) VALUES
                        (1, 'admin@admin.com', '$2y$10$4bR87TXTrpf1uHj7UbbHIenGaIQkFz5HE2WuijQ6pISCxsZ8eVdlK');");

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