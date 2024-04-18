<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: ../");
    exit();
}

echo '<!DOCTYPE html>';
echo '<html lang="en">';
echo '<head>';
echo '<meta charset="UTF-8">';
echo '<title>EstateAtlas | Read</title>';
echo '<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">';
echo '<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">';
echo '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">';
echo '<link href="img/favicon/apple-touch-icon.png" rel="apple-touch-icon" sizes="180x180">';
echo '<link href="img/favicon/favicon-32x32.png" rel="icon" sizes="32x32" type="image/png">';
echo '<link href="img/favicon/favicon-16x16.png" rel="icon" sizes="16x16" type="image/png">';
echo '<link href="img/favicon/site.webmanifest" rel="manifest">';
echo '<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">';
echo '<link href="styles/reset.css" rel="stylesheet">';
echo '<link href="styles/index.css" rel="stylesheet">';
echo '<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet"/>';
echo '<link href="styles/google_icons.css" rel="stylesheet">';
echo '</head>';
echo '<body>';
echo '<div class="container">';
echo '<form method="POST">';
echo '<label for="table">Select a table:</label>';
echo '<select id="table" name="table">';
echo '<option value="user">User</option>';
echo '<option value="parcel">Parcel</option>';
echo '<option value="company">Company</option>';
echo '<option value="owner">Owner</option>';
echo '<option value="ownership_list">Ownership List</option>';
echo '<option value="log">Log</option>';
echo '</select>';
echo '<button class="btn btn-primary" type="submit">Read</button>';
echo '<a class="btn btn-danger" href="./">Return</a>';
echo '<button id="switch" class="btn btn-secondary" onclick="cycleThemes()" type="button">Switch</button>';
echo '</form>';
echo '</div>';

$conn_params = $_SESSION['conn_params'];
$conn = new mysqli($conn_params['host'], $conn_params['user'], $conn_params['password'], 'estateatlas', $conn_params['port']);

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['formName'])) {
        if ($_POST['formName'] == 'dataDeletion') {
            $tableName = $_POST['table'] ?? '';
            $id = $_POST['id'] ?? '';
            $sql = "DELETE FROM $tableName WHERE id = $id";

            if ($conn->query($sql)) {
                echo "<div class='alert alert-success' role='alert' id='successAlert'>Data has been deleted successfully</div>";
                echo "<script>setTimeout(function() { document.getElementById('successAlert').style.display='none'; }, 3000);</script>";
            } else {
                echo "<div class='alert alert-danger' role='alert' id='errorAlert'>Error: " . $conn->error . "</div>";
                echo "<script>setTimeout(function() { document.getElementById('errorAlert').style.display='none'; }, 3000);</script>";
            }

            // log
            $sql_user = "SELECT id FROM user WHERE email = '" . $_SESSION['email'] . "'";
            $id_user = $conn->query($sql_user)->fetch_assoc()['id'];
            $sql_log = "INSERT INTO log (type, id_user, description) VALUES ('delete', '" . $id_user . "', 'Delete data from table " . $tableName . "')";
            $conn->query($sql_log);
        }
    }
    // Assuming you have a variable to determine the table, you can set it based on the form submission.
    $tableName = $_POST['table'] ?? ''; // You can change this condition based on your requirements.

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql_user = "SELECT id FROM user WHERE email = '" . $_SESSION['email'] . "'";
    $id_user = $conn->query($sql_user)->fetch_assoc()['id'];
    $sql_log = "INSERT INTO log (type, id_user, description) VALUES ('view', '" . $id_user . "', 'Read table " . $tableName . "')";
    $conn->query($sql_log);

    // SQL query based on the selected table
    $sql_data = "SELECT * FROM $tableName"; // Replace with your specific query.
    $sql_head = "SHOW COLUMNS FROM $tableName";
    $data = $conn->query($sql_data);
    $head = $conn->query($sql_head);

    echo "<table class='table table-striped table-bordered'><caption>" . $tableName . "</caption><thead><tr>";
    while ($row = $head->fetch_assoc()) {
        if ($row['Field'] == 'latitude') {
            echo "<th>Google maps link</th>";
            continue;
        }
        if ($row['Field'] == 'id' || $row['Field'] == 'longitude') {
            continue;
        } else {
            echo "<th>" . $row['Field'] . "</th>";
        }
    }

    if ($tableName != 'log') {
        echo "<th>Action</th></tr></thead><tbody>";
    }
    if ($data->num_rows > 0) {
        while ($row = $data->fetch_assoc()) {
            echo "<tr>";
            $latitude = $row['latitude'] ?? '';
            $longitude = $row['longitude'] ?? '';
            foreach ($row as $key => $value) {
                if ($key == 'id') {
                    continue;
                }
                if ($key == 'latitude') {
                    echo "<td><a class='btn btn-primary' href='https://www.google.com/maps/search/?api=1&query=" . $latitude . "," . $longitude . "' target='_blank' style='width: 100%;'>" . $latitude . " | " . $longitude . "</a></td>";
                    continue;
                }
                if ($key == 'longitude') {
                    continue;
                }
                echo "<td>" . $value . "</td>";
            }
            if ($tableName != 'log') {
                echo "<td><form method='post'><input type='hidden' name='table' value='" . $tableName . "'><input type='hidden' name='formName' value='dataDeletion'><input type='hidden' name='id' value='" . $row['id'] . "'><button type='submit' class='btn btn-danger'>Delete</button></form></td>";
                echo "</tr>";
            }
        }
    } else {
        echo "0 results";
    }
    echo "</tbody></table>";

}
echo '<script src="../scripts/dark-mode.js"></script>';
echo '</div></body></html>';