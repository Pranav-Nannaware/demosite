<?php
// Include config file
require_once '../includes/config.php';

// Unset all session variables
$_SESSION = [];

// Destroy the session
session_destroy();

// Redirect to login page
redirect('index.php');
?> 