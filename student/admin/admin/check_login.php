<?php
session_start();

// Debugging: Output session data to the error log
error_log("Session data in check_login.php: " . print_r($_SESSION, true));

if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    error_log("Admin is logged in."); // Debugging: Log successful login
    echo json_encode(["status" => "logged_in"]);
} else {
    error_log("Admin is NOT logged in."); // Debugging: Log failed login
    echo json_encode(["status" => "not_logged_in"]);
}
?>