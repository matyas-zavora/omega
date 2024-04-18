<?php

session_start();
if (!isset($_SESSION['email'])) {
    header("Location: ../");
    exit();
}
$conn_params = $_SESSION['conn_params'];
$conn = new mysqli($conn_params['host'], $conn_params['user'], $conn_params['password'], null, $conn_params['port']);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>EstateAtlas | Read</title>
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
    <form enctype="multipart/form-data" method="POST">
        <input name="formName" type="hidden" value="fileUpload">
        <label for="fileToUpload">Select a file:</label>
        <input accept=".csv" id="fileToUpload" name="fileToUpload" type="file">
        <button class="btn btn-primary" type="submit">Upload</button>
        <a class="btn btn-danger" href="./files.php">Return</a>
        <button id="switch" class="btn btn-secondary" onclick="cycleThemes()" type="button">Switch</button>

    </form>
</div>
<script src="../scripts/dark-mode.js"></script>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $target_dir = "./input/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if ($fileType != "csv") {
        echo "Sorry, only CSV files are allowed.";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            echo "The file " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

    $file = fopen($target_file, "r");
    $header = fgetcsv($file);
    $data = array();
    while ($row = fgetcsv($file)) {
        $data[] = array_combine($header, $row);
    }
    fclose($file);
    unlink($target_file);

    $header_template = array("number", "size", "latitude", "longitude", "date_of_ownership", "legal_state", "type",
        "address", "zip", "city", "country", "stake", "first_name", "last_name", "phone", "company_name",
        "company_address", "company_zip", "company_city", "company_country");
    if ($header != $header_template) {
        echo "Sorry, the header of your file is not correct.";
        exit();
    } else {
        foreach ($data as $row) {
            $parcel_number = $row['number'];
            $sql = "SELECT * FROM parcel WHERE number = '$parcel_number'";
            $result = $conn->query($sql);
            if ($result->num_rows == 0) {
                $sql = "INSERT INTO parcel (number, size, latitude, longitude, date_of_ownership, legal_state, type,
                     address, zip, city, country) VALUES ('" . $row['number'] . "', '" . $row['size'] . "', '" .
                    $row['latitude'] . "', '" . $row['longitude'] . "', '" . $row['date_of_ownership'] . "', '" .
                    $row['legal_state'] . "', '" . $row['type'] . "', '" . $row['address'] . "', '" . $row['zip'] .
                    "', '" . $row['city'] . "', '" . $row['country'] . "')";

                if ($conn->query($sql) !== TRUE) {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                    exit();
                }
            }
        }

        foreach ($data as $row) {
            $first_name = $row['first_name'];
            $last_name = $row['last_name'];
            $sql = "SELECT * FROM owner WHERE first_name = '$first_name' AND last_name = '$last_name'";
            $result = $conn->query($sql);
            if ($result->num_rows == 0) {
                $sql = "INSERT INTO owner (first_name, last_name, phone) VALUES ('" . $row['first_name'] . "', '" . $row['last_name'] . "', '" .
                    $row['phone'] . "')";

                if ($conn->query($sql) !== TRUE) {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                    exit();
                }
            }
        }

        foreach ($data as $row) {
            $company_name = $row['company_name'];
            $sql = "SELECT * FROM company WHERE name = '$company_name'";
            $result = $conn->query($sql);
            if ($result->num_rows == 0) {
                $sql = "INSERT INTO company (name, address, zip, city, country) VALUES ('" . $row['company_name'] . "', '" . $row['company_address'] . "', '" .
                    $row['company_zip'] . "', '" . $row['company_city'] . "', '" . $row['company_country'] . "')";

                if ($conn->query($sql) !== TRUE) {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                    exit();
                }
            }
        }
        foreach ($data as $row) {
            echo $row['number'] . " " . $row['first_name'] . " " . $row['last_name'] . " " . $row['company_name'] . " " . $row['stake'] . "<br>";
            $parcel_number = $row['number'];
            $sql = "SELECT SUM(stake) FROM ownership_list ol LEFT JOIN parcel p ON ol.id_parcel = p.id WHERE p.number = '" . $parcel_number . "' GROUP BY p.id";
            $result = $conn->query($sql);
            $sql_row = $result->fetch_assoc();
            $sumStake = $sql_row['SUM(stake)'] ?? 0;
            if ($sumStake > 1) {
                echo "Sorry, the stake of parcel number " . $parcel_number . " is more than 1.";
                exit();
            } else {
                $parcel_number = $row['number'];
                $sql = "SELECT id FROM parcel WHERE number = '$parcel_number'";
                $result = $conn->query($sql);
                $id_parcel = $result->fetch_assoc()['id'];
                $id_owner = null;
                $id_company = null;

                $first_name = $row['first_name'] ?? null;
                $last_name = $row['last_name'] ?? null;
                if ($first_name != null && $last_name != null) {
                    $sql = "SELECT id FROM owner WHERE first_name = '$first_name' AND last_name = '$last_name'";
                    $result = $conn->query($sql);
                    $id_owner = $result->fetch_assoc()['id'];
                }

                $company_name = $row['company_name'] ?? null;
                if ($company_name != null) {
                    $sql = "SELECT id FROM company WHERE name = '$company_name'";
                    $result = $conn->query($sql);
                    $id_company = $result->fetch_assoc()['id'];
                }

                if ($id_owner == null && $id_company == null) {
                    continue;
                } elseif ($id_owner == null) {
                    $sql = "INSERT INTO ownership_list (id_parcel, id_company, stake) VALUES ('" . $id_parcel . "', '" . $id_company . "', '" . $row['stake'] . "')";
                } elseif ($id_company == null) {
                    $sql = "INSERT INTO ownership_list (id_parcel, id_owner, stake) VALUES ('" . $id_parcel . "', '" . $id_owner . "', '" . $row['stake'] . "')";
                }
                if ($conn->query($sql) !== TRUE) {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }
        }
    }
}