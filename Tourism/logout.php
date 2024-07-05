<?php
session_start();
ob_start(); // Start output buffering

// Destroy all session data
session_unset();
session_destroy();

// Redirect to login page
header("Location: ./login page/login.php");
exit();

ob_end_flush(); // Flush the output buffer
?>
