<?php
session_start();
// Destroy the session
if (session_status() == PHP_SESSION_ACTIVE) {
    session_destroy();
}
// Redirect to the login page
header("Location: login.php");
exit();
?>