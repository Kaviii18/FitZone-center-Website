<?php
session_start();

// Destroy all session variables
session_unset();

// Destroy the session
session_destroy();

// Redirect the user back to the login page
header("Location: login.php");
exit();
?>
