<?php
session_start();

// Unset all session variables
session_unset();

// Destroy the session
session_destroy();

// Redirect to the index page or any other page you want to redirect to
header("Location: index.php");
exit();
?>
