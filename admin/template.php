<?php
// Include config file
require_once '../includes/config.php';

// Check if user is logged in
if (!isLoggedIn()) {
    redirect('index.php');
}

// Set page title
$page_title = 'Page Title';

// Include admin header
include 'includes/header.php';
?>

<div class="content-container">
    <div class="content-header">
        <h1><?php echo $page_title; ?></h1>
        <div class="content-actions">
            <a href="#" class="btn"><i class="fas fa-plus"></i> Add New</a>
        </div>
    </div>
    
    <div class="content-body">
        <!-- Main content goes here -->
        <div class="card">
            <div class="card-header">
                <h2>Content Section</h2>
            </div>
            <div class="card-body">
                <p>Content goes here...</p>
            </div>
        </div>
    </div>
</div>

<?php
// Include admin footer
include 'includes/footer.php';
?> 