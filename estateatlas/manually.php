<?php
// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    // Redirect to login page if not logged in
    header("Location: ../");
    exit();
}

// Output HTML document declaration and head section
echo '<!DOCTYPE html>';
echo '<html lang="en">';
echo '<head>';
echo '<meta charset="UTF-8">';
echo '<title>EstateAtlas | Write Manually</title>';
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
echo '<form method="post">';
// Hidden input field for form identifier
echo '<input name="formName" type="hidden" value="dataInsertPicker">';
// Dropdown for selecting table
echo '<label for="table">Select a table:</label>';
echo '<select id="table" name="table">';
echo '<option value="user">User</option>';
echo '<option value="parcel">Parcel</option>';
echo '<option value="company">Company</option>';
echo '<option value="owner">Owner</option>';
echo '<option value="ownership_list">Ownership List</option>';
echo '</select> ';
// Buttons for form submission and returning
echo '<button class="btn btn-primary" type="submit">Select</button> ';
echo '<a class="btn btn-danger" href="./write.php">Return</a> ';
// Button for theme switching
echo '<button id="switch" class="btn btn-secondary" onclick="cycleThemes()" type="button">Switch</button>';
echo '</form>';
echo '</div>';
echo '</body>';
echo '</html>';

// Get connection parameters from session
$conn_params = $_SESSION['conn_params'];
// Connect to the database
$conn = new mysqli($conn_params['host'], $conn_params['user'], $conn_params['password'], 'estateatlas', $conn_params['port']);

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // If the form identifier is "dataInsertPicker", process table selection
    if ($_POST['formName'] == 'dataInsertPicker') {
        $tableName = $_POST['table'] ?? '';
        // Include template functions
        include("./templates.php");
        switch ($tableName) {
            // Call template function based on selected table
            case 'company':
                templateCompany();
                break;
            case 'owner':
                templateOwner();
                break;
            case 'ownership_list':
                // Retrieve data needed for template
                $parcels = $conn->query("SELECT id, number FROM parcel");
                $owners = $conn->query("SELECT id, first_name, last_name FROM owner");
                $companies = $conn->query("SELECT id, name FROM company");
                // Fetch data into associative arrays
                if ($parcels->num_rows > 0) {
                    $parcels = $parcels->fetch_all(MYSQLI_ASSOC);
                } else {
                    $parcels = [];
                }
                if ($owners->num_rows > 0) {
                    $owners = $owners->fetch_all(MYSQLI_ASSOC);
                } else {
                    $owners = [];
                }
                if ($companies->num_rows > 0) {
                    $companies = $companies->fetch_all(MYSQLI_ASSOC);
                } else {
                    $companies = [];
                }
                // Filter parcels to exclude fully owned ones
                $parcels = array_filter($parcels, function ($parcel) use ($conn) {
                    $result = $conn->query("SELECT SUM(stake) FROM ownership_list WHERE id_parcel = " . $parcel['id']);
                    $sum = $result->fetch_row()[0];
                    return $sum < 1;
                });
                // If no parcels available, display error message
                if (empty($parcels)) {
                    displayMessage("Error: All parcels are fully owned", "danger");
                    break;
                } else {
                    // Call template function with data
                    templateOwnershipList($parcels, $owners, $companies);
                    break;
                }
            case 'parcel':
                templateParcels();
                break;
            case 'user':
                templateUser();
                break;
        }
    } else {
        // If form identifier is not "dataInsertPicker", handle other form submissions
        $stmt = null;
        $formName = $_POST['formName'] ?? '';
        switch ($formName) {
            // Call appropriate handler function based on formName
            case 'companyInsertManually':
                $stmt = handleCompanyInsertManually($conn);
                break;
            case 'ownerInsertManually':
                $stmt = handleOwnerInsertManually($conn);
                break;
            case 'userInsertManually':
                $stmt = handleUserInsertManually($conn);
                break;
            case 'ownershipListInsertManually':
                $stmt = handleOwnershipListInsertManually($conn);
                break;
            case 'parcelInsertManually':
                $stmt = handleParcelInsertManually($conn);
            default:
                break;
        }
    }
    // Execute prepared statement if set
    if (isset($stmt)) {
        $conn->begin_transaction();
        if (!$stmt->execute()) {
            // Display error message if execution fails
            displayMessage("Error: " . $conn->error, "danger");
            $conn->rollback();
        } else {
            // Display success message if execution succeeds
            displayMessage("Data has been uploaded successfully", "success");
            $conn->commit();
        }
        $stmt->close();
    }
}

// Handler function for manually inserting user data
function handleUserInsertManually(mysqli $conn): mysqli_stmt|null
{
    // Validate email
    if (!filter_var($_POST['formEmail'], FILTER_VALIDATE_EMAIL)) {
        displayMessage("Error: Invalid email", "danger");
        return null;
    } else {
        $email = filter_input(INPUT_POST, 'formEmail', FILTER_SANITIZE_EMAIL);
    }
    // Hash password
    $password = filter_input(INPUT_POST, 'formPassword', FILTER_SANITIZE_STRING);
    $password = password_hash($conn->real_escape_string($password), PASSWORD_DEFAULT);

    // Prepare and bind parameters for SQL statement
    $stmt = $conn->prepare("INSERT INTO user (email, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $email, $password);

    // Log user action
    $sql_user = "SELECT id FROM user WHERE email = '" . $_SESSION['email'] . "'";
    $id_user = $conn->query($sql_user)->fetch_assoc()['id'];
    $sql_log = "INSERT INTO log (type, id_user, description) VALUES ('insert', '" . $id_user . "', 'Insert data into table user')";
    $conn->query($sql_log);

    return $stmt;
}

// Handler function for manually inserting company data
function handleCompanyInsertManually(mysqli $conn): mysqli_stmt|null
{
    // Sanitize input data
    $companyName = filter_input(INPUT_POST, 'formName', FILTER_SANITIZE_STRING);
    $companyAddress = filter_input(INPUT_POST, 'formAddress', FILTER_SANITIZE_STRING);
    $companyZip = filter_input(INPUT_POST, 'formZip', FILTER_SANITIZE_STRING);
    $companyCity = filter_input(INPUT_POST, 'formCity', FILTER_SANITIZE_STRING);
    $companyCountry = strtoupper(filter_input(INPUT_POST, 'formCountry', FILTER_SANITIZE_STRING));

    // Remove white spaces from zip code and validate
    $companyZip = preg_replace('/\s+/', '', $companyZip);
    if (!is_numeric($companyZip)) {
        displayMessage("Error: Zip must be a number", "danger");
        return null;
    } else {
        $companyZip = (int)$companyZip;
    }

    // Prepare SQL statement
    $sql = "INSERT INTO company (name, address, zip, city, country) VALUES (?,?,?,?,?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssiss", $companyName, $companyAddress, $companyZip, $companyCity, $companyCountry);

    // Log user action
    $sql_user = "SELECT id FROM user WHERE email = '" . $_SESSION['email'] . "'";
    $id_user = $conn->query($sql_user)->fetch_assoc()['id'];
    $sql_log = "INSERT INTO log (type, id_user, description) VALUES ('insert', '" . $id_user . "', 'Insert data into table company')";
    $conn->query($sql_log);

    return $stmt;
}

// Handler function for manually inserting owner data
function handleOwnerInsertManually(mysqli $conn): mysqli_stmt|null
{
    // Sanitize input data
    $firstName = $conn->real_escape_string($_POST['formFirstName']);
    $lastName = $conn->real_escape_string($_POST['formLastName']);
    $phone = $conn->real_escape_string($_POST['formPhone']);

    // Prepare and bind parameters for SQL statement
    $stmt = $conn->prepare("INSERT INTO owner (first_name, last_name, phone) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $firstName, $lastName, $phone);

    // Log user action
    $sql_user = "SELECT id FROM user WHERE email = '" . $_SESSION['email'] . "'";
    $id_user = $conn->query($sql_user)->fetch_assoc()['id'];
    $sql_log = "INSERT INTO log (type, id_user, description) VALUES ('insert', '" . $id_user . "', 'Insert data into table owner')";
    $conn->query($sql_log);

    return $stmt;
}

// Handler function for manually inserting ownership list data
function handleOwnershipListInsertManually(mysqli $conn): mysqli_stmt|null
{
    // Check if total stake exceeds 100%
    $allCurrentStakes = $conn->query("SELECT SUM(stake) FROM ownership_list WHERE id_parcel = " . $conn->real_escape_string($_POST['formParcel']))->fetch_row()[0];
    if ($allCurrentStakes + (float)$_POST['formStake'] > 1) {
        displayMessage("Error: Stake is too high", "danger");
        return null;
    }

    // Sanitize input data
    $parcelId = $conn->real_escape_string($_POST['formParcel']);
    if (!is_numeric($_POST['formStake'])) {
        displayMessage("Error: Stake must be a number", "danger");
        return null;
    } else {
        $stake = (float)$_POST['formStake'];
    }

    // Determine whether owner or company is selected and prepare SQL statement accordingly
    if (str_starts_with($_POST['formOwnerCompany'], 'c')) {
        $companyId = (int)substr($_POST['formOwnerCompany'], 1);
        $stmt = $conn->prepare("INSERT INTO ownership_list (id_parcel, id_company, stake) VALUES (?, ?, ?)");
        $stmt->bind_param("iid", $parcelId, $companyId, $stake);
    } elseif (str_starts_with($_POST['formOwnerCompany'], 'o')) {
        $ownerId = (int)substr($_POST['formOwnerCompany'], 1);
        $stmt = $conn->prepare("INSERT INTO ownership_list (id_parcel, id_owner, stake) VALUES (?, ?, ?)");
        $stmt->bind_param("iid", $parcelId, $ownerId, $stake);
    } else {
        displayMessage("Error: Invalid id", "danger");
        return null;
    }

    // Log user action
    $sql_user = "SELECT id FROM user WHERE email = '" . $_SESSION['email'] . "'";
    $id_user = $conn->query($sql_user)->fetch_assoc()['id'];
    $sql_log = "INSERT INTO log (type, id_user, description) VALUES ('insert', '" . $id_user . "', 'Insert data into table ownership_list')";
    $conn->query($sql_log);

    return $stmt;
}

// Handler function for manually inserting parcel data
function handleParcelInsertManually(mysqli $conn): myslqli_stmt|null
{
    // Sanitize input data
    $number = $conn->real_escape_string($_POST['formNumber']);
    $size = $conn->real_escape_string($_POST['formSize']);
    $latitude = $conn->real_escape_string($_POST['formLatitude']);
    $longitude = $conn->real_escape_string($_POST['formLongitude']);
    $legalState = $conn->real_escape_string($_POST['formLegalState']);
    $type = $conn->real_escape_string($_POST['formType']);
    $address = $conn->real_escape_string($_POST['formAddress']);
    $zip = $conn->real_escape_string($_POST['formZip']);
    $city = $conn->real_escape_string($_POST['formCity']);
    $country = strtoupper($conn->real_escape_string($_POST['formCountry']));

    // Remove white spaces from zip code and validate
    $zip = preg_replace('/\s+/', '', $zip);
    if (!is_numeric($zip)) {
        displayMessage("Error: Zip must be a number", "danger");
        return null;
    } else {
        $zip = (int)$zip;
    }

    // Match legal state and type to corresponding values
    $legalState = match ($legalState) {
        0 => "owned",
        1 => "leased",
        2 => "pledged",
        default => function () {
            displayMessage("Error: Invalid legal state", "danger");
            return null;
        }
    };
    $type = match ($type) {
        0 => 'zastavěné plochy a nádvoří',
        1 => 'zemědělské pozemky',
        2 => 'lesní pozemky',
        3 => 'vodní plochy',
        4 => 'ostatní plochy',
        default => function () {
            displayMessage("Error: Invalid type", "danger");
            return null;
        }
    };

    // Prepare and bind parameters for SQL statement
    $sql = "INSERT INTO parcel (number, size, latitude, longitude, legal_state, type, address, zip, city, country, date_of_ownership) VALUES (?,?,?,?,?,?,?,?,?,?," . GETDATE() . ")";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("idddsssisss", $number, $size, $latitude, $longitude, $legalState, $type, $address, $zip, $city, $country);

    // Log user action
    $sql_user = "SELECT id FROM user WHERE email = '" . $_SESSION['email'] . "'";
    $id_user = $conn->query($sql_user)->fetch_assoc()['id'];
    $sql_log = "INSERT INTO log (type, id_user, description) VALUES ('insert', '" . $id_user . "', 'Insert data into table parcel')";
    $conn->query($sql_log);

    return $stmt;
}

// Function to display alert messages
function displayMessage(string $message, string $type): void
{
    echo "<div class='alert alert-" . $type . "' role='alert' id='errorAlert'>" . $message . "</div>";
    echo "<script>setTimeout(function() { document.getElementById('errorAlert').style.display='none'; }, 3000);</script>";
}

// Include dark mode script
echo '<script src="../scripts/dark-mode.js"></script>';
echo '</div></body></html>';
