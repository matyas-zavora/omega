<?php
session_start();
if (isset($_SESSION['conn_params'])) unset($_SESSION['email']);
header("Location: ../");
exit();
