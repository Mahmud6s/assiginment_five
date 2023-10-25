<?php
// Start a session
session_start();

// Unset all session variables
session_unset();

// Destroy the session
session_destroy();

// Redirect back to the login form
header('Location: login_form.php');
exit;
?>
