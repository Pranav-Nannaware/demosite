<?php
/**
 * Database Configuration
 */
define('DB_HOST', 'localhost');
define('DB_USER', 'cmrit_user');
define('DB_PASS', 'test');
define('DB_NAME', 'cmrit_db');


/**
 * Website Configuration
 */
define('SITE_URL', 'http://localhost/cmrit');
define('SITE_NAME', 'CMR Institute of Technology');
define('SITE_EMAIL', 'info@cmrit.edu.in');
define('SITE_PHONE', '+91 1234567890');
define('SITE_ADDRESS', 'CMR Institute of Technology, Medchal Road, Kandlakoya, Hyderabad, Telangana 501401');

/**
 * Error Reporting
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);

/**
 * Start Session
 */
session_start();

/**
 * Connect to Database
 */
try {
    $db = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8",
        DB_USER,
        DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    // For production, you might want to log this instead of displaying
    die("Database connection failed: " . $e->getMessage());
}

/**
 * Helper Functions
 */

// Clean user input
function clean($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Redirect to a URL
function redirect($url) {
    header("Location: $url");
    exit;
}

// Check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Get current page name
function getCurrentPage() {
    return basename($_SERVER['PHP_SELF'], '.php');
}

// Format date
function formatDate($date, $format = 'd M, Y') {
    return date($format, strtotime($date));
}

// Include functions file
require_once 'functions.php';
?> 