<?php
// Include config file
require_once '../includes/config.php';

// Check if user is logged in
if (!isLoggedIn()) {
    redirect('index.php');
}

// Check if ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    redirect('sliders.php');
}

$slider_id = (int)$_GET['id'];

// Get slider details to get the image path
$stmt = $db->prepare("SELECT image_path FROM sliders WHERE id = ? LIMIT 1");
$stmt->execute([$slider_id]);
$slider = $stmt->fetch(PDO::FETCH_ASSOC);

// If slider not found, redirect
if (!$slider) {
    redirect('sliders.php');
}

// Delete slider from database
$stmt = $db->prepare("DELETE FROM sliders WHERE id = ?");
$result = $stmt->execute([$slider_id]);

if ($result) {
    // Delete image file if it exists
    if (!empty($slider['image_path']) && file_exists('../' . $slider['image_path'])) {
        unlink('../' . $slider['image_path']);
    }
    
    $_SESSION['success_msg'] = 'Slider deleted successfully.';
} else {
    $_SESSION['error_msg'] = 'Error deleting slider.';
}

// Redirect back to sliders page
redirect('sliders.php');
?> 