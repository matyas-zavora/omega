<?php
session_start();

// Redirect to the login page if the user is not authenticated
if (!isset($_SESSION['email'])) {
    header("Location: ../");
    exit();
}

// Get database connection parameters from session
$conn_params = $_SESSION['conn_params'];

// Create a new MySQLi connection
$conn = new mysqli($conn_params['host'], $conn_params['user'], $conn_params['password'], 'estateatlas', $conn_params['port']);

// Check if the request method is GET
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Check if the database connection is successful
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // SQL query to retrieve parcel data with ownership and company information
    $sql_data = "SELECT 
                    p.number,
                    p.size,
                    p.latitude,
                    p.longitude,
                    p.date_of_ownership,
                    p.legal_state,
                    p.type,
                    p.address,
                    p.zip,
                    p.city,
                    p.country,
                    ol.stake,
                    ow.first_name,
                    ow.last_name,
                    ow.phone,
                    c.name AS company_name,
                    c.address AS company_address,
                    c.zip AS company_zip,
                    c.city AS company_city,
                    c.country AS company_country
                 FROM parcel p 
                 LEFT JOIN ownership_list ol on ol.id_parcel = p.id 
                 LEFT JOIN owner ow on ol.id_owner = ow.id 
                 LEFT JOIN company c on ol.id_company = c.id;";

    // Execute the SQL query
    $data = $conn->query($sql_data);

    // Open a file pointer for writing the CSV file
    $file = fopen("./output/full_parcel_data.csv", "w");

    // Write the header to the CSV file
    fputcsv($file, array_keys($data->fetch_assoc()));

    // Reset the data pointer back to the beginning
    $data->data_seek(0);

    // Loop through the result set and write each row to the CSV file
    while ($row = $data->fetch_assoc()) {
        // Exclude the ID columns from the output
        unset($row['id'], $row['id_parcel'], $row['id_owner'], $row['id_company']);

        // Write the row to the CSV file
        fputcsv($file, $row);
    }

    // Close the file pointer
    fclose($file);

    // Optionally, you can force download the file
    header("Content-type: text/csv");
    header("Content-Disposition: attachment; filename=full_parcel_data.csv");
    header("Pragma: no-cache");
    header("Expires: 0");
    readfile("./output/full_parcel_data.csv");
    exit();
}