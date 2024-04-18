<?php
// Start the session
session_start();

// Check if the 'conn_params' session variable is set and unset 'email' if it is
if (isset($_SESSION['conn_params'])) {
    unset($_SESSION['email']);
}

// Redirect the user to the homepage
header("Location: ../");
exit();