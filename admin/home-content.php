<?php
// Include config file
require_once '../includes/config.php';

// Check if user is logged in
if (!isLoggedIn()) {
    redirect('index.php');
}

// Set page title
$page_title = 'Edit Home Page Content';

// Process form submission for about section
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_about'])) {
    $about_content = $_POST['about_content'];
    
    // Update about section content
    $stmt = $db->prepare("UPDATE site_content SET content_value = ? WHERE content_key = 'about_section'");
    $result = $stmt->execute([$about_content]);
    
    if ($result) {
        $_SESSION['success_msg'] = 'About section updated successfully.';
    } else {
        $_SESSION['error_msg'] = 'Error updating about section.';
    }
    
    // Redirect to refresh the page
    redirect('home-content.php');
}

// Process form submission for contact info
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_contact'])) {
    $site_address = $_POST['site_address'];
    $site_phone = $_POST['site_phone'];
    $site_email = $_POST['site_email'];
    
    // Update settings in database
    $updates = [
        ['setting_key' => 'site_address', 'value' => $site_address],
        ['setting_key' => 'site_phone', 'value' => $site_phone],
        ['setting_key' => 'site_email', 'value' => $site_email]
    ];
    
    $success = true;
    foreach ($updates as $update) {
        $stmt = $db->prepare("UPDATE settings SET setting_value = ? WHERE setting_key = ?");
        $result = $stmt->execute([$update['value'], $update['setting_key']]);
        if (!$result) {
            $success = false;
        }
    }
    
    if ($success) {
        $_SESSION['success_msg'] = 'Contact information updated successfully.';
    } else {
        $_SESSION['error_msg'] = 'Error updating contact information.';
    }
    
    // Redirect to refresh the page
    redirect('home-content.php');
}

// Get current content
$about_content = getSiteContent('about_section');

// Get current contact info from settings
$stmt = $db->prepare("SELECT setting_key, setting_value FROM settings WHERE setting_key IN ('site_address', 'site_phone', 'site_email')");
$stmt->execute();
$contact_settings = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

// Get counts for dashboard
$counts = [
    'sliders' => $db->query("SELECT COUNT(*) FROM sliders")->fetchColumn(),
    'programs' => $db->query("SELECT COUNT(*) FROM programs")->fetchColumn(),
    'facilities' => $db->query("SELECT COUNT(*) FROM facilities")->fetchColumn(),
    'achievements' => $db->query("SELECT COUNT(*) FROM achievements")->fetchColumn(),
    'testimonials' => $db->query("SELECT COUNT(*) FROM testimonials")->fetchColumn(),
    'announcements' => $db->query("SELECT COUNT(*) FROM announcements")->fetchColumn(),
];

// Include admin header
include 'includes/header.php';
?>

<div class="content-container">
    <div class="content-header">
        <h1><?php echo $page_title; ?></h1>
    </div>
    
    <div class="content-body">
        <?php if (isset($_SESSION['success_msg'])): ?>
            <div class="alert alert-success">
                <?php 
                echo $_SESSION['success_msg']; 
                unset($_SESSION['success_msg']);
                ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['error_msg'])): ?>
            <div class="alert alert-danger">
                <?php 
                echo $_SESSION['error_msg']; 
                unset($_SESSION['error_msg']);
                ?>
            </div>
        <?php endif; ?>
        
        <div class="card mb-4">
            <div class="card-header">
                <h2>Home Page Sections Overview</h2>
            </div>
            <div class="card-body">
                <div class="dashboard-stats">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-images"></i>
                        </div>
                        <div class="stat-content">
                            <h3>Sliders</h3>
                            <p><?php echo $counts['sliders']; ?></p>
                        </div>
                        <a href="sliders.php" class="stat-link">Manage</a>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <div class="stat-content">
                            <h3>Programs</h3>
                            <p><?php echo $counts['programs']; ?></p>
                        </div>
                        <a href="programs.php" class="stat-link">Manage</a>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-building"></i>
                        </div>
                        <div class="stat-content">
                            <h3>Facilities</h3>
                            <p><?php echo $counts['facilities']; ?></p>
                        </div>
                        <a href="facilities.php" class="stat-link">Manage</a>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-trophy"></i>
                        </div>
                        <div class="stat-content">
                            <h3>Achievements</h3>
                            <p><?php echo $counts['achievements']; ?></p>
                        </div>
                        <a href="achievements.php" class="stat-link">Manage</a>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-comment"></i>
                        </div>
                        <div class="stat-content">
                            <h3>Testimonials</h3>
                            <p><?php echo $counts['testimonials']; ?></p>
                        </div>
                        <a href="testimonials.php" class="stat-link">Manage</a>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-bullhorn"></i>
                        </div>
                        <div class="stat-content">
                            <h3>Announcements</h3>
                            <p><?php echo $counts['announcements']; ?></p>
                        </div>
                        <a href="announcements.php" class="stat-link">Manage</a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <h2>Manage Home Page Sections</h2>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="feature-card">
                                    <div class="feature-icon">
                                        <i class="fas fa-images"></i>
                                    </div>
                                    <h3 class="feature-title">Sliders</h3>
                                    <p class="feature-description">Manage hero sliders on the home page</p>
                                    <a href="sliders.php" class="feature-link">Manage Sliders</a>
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-4">
                                <div class="feature-card">
                                    <div class="feature-icon">
                                        <i class="fas fa-bullhorn"></i>
                                    </div>
                                    <h3 class="feature-title">Announcements</h3>
                                    <p class="feature-description">Manage announcements banner</p>
                                    <a href="announcements.php" class="feature-link">Manage Announcements</a>
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-4">
                                <div class="feature-card">
                                    <div class="feature-icon">
                                        <i class="fas fa-graduation-cap"></i>
                                    </div>
                                    <h3 class="feature-title">Programs</h3>
                                    <p class="feature-description">Manage academic programs</p>
                                    <a href="programs.php" class="feature-link">Manage Programs</a>
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-4">
                                <div class="feature-card">
                                    <div class="feature-icon">
                                        <i class="fas fa-building"></i>
                                    </div>
                                    <h3 class="feature-title">Facilities</h3>
                                    <p class="feature-description">Manage campus facilities</p>
                                    <a href="facilities.php" class="feature-link">Manage Facilities</a>
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-4">
                                <div class="feature-card">
                                    <div class="feature-icon">
                                        <i class="fas fa-trophy"></i>
                                    </div>
                                    <h3 class="feature-title">Achievements</h3>
                                    <p class="feature-description">Manage institution achievements</p>
                                    <a href="achievements.php" class="feature-link">Manage Achievements</a>
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-4">
                                <div class="feature-card">
                                    <div class="feature-icon">
                                        <i class="fas fa-comment"></i>
                                    </div>
                                    <h3 class="feature-title">Testimonials</h3>
                                    <p class="feature-description">Manage student testimonials</p>
                                    <a href="testimonials.php" class="feature-link">Manage Testimonials</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <h2>Edit About Section</h2>
                    </div>
                    <div class="card-body">
                        <form method="post" action="">
                            <div class="form-group">
                                <label for="about_content">About Content</label>
                                <textarea class="form-control" id="about_content" name="about_content" rows="10"><?php echo htmlspecialchars($about_content); ?></textarea>
                                <small class="form-text text-muted">This content appears in the About section on the home page. Use double line breaks to create paragraphs.</small>
                            </div>
                            <button type="submit" name="update_about" class="btn btn-primary">Update About Section</button>
                        </form>
                    </div>
                </div>
                
                <div class="card mb-4">
                    <div class="card-header">
                        <h2>Edit Contact Information</h2>
                    </div>
                    <div class="card-body">
                        <form method="post" action="">
                            <div class="form-group">
                                <label for="site_address">Address</label>
                                <textarea class="form-control" id="site_address" name="site_address" rows="3"><?php echo htmlspecialchars($contact_settings['site_address'] ?? ''); ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="site_phone">Phone</label>
                                <input type="text" class="form-control" id="site_phone" name="site_phone" value="<?php echo htmlspecialchars($contact_settings['site_phone'] ?? ''); ?>">
                            </div>
                            <div class="form-group">
                                <label for="site_email">Email</label>
                                <input type="email" class="form-control" id="site_email" name="site_email" value="<?php echo htmlspecialchars($contact_settings['site_email'] ?? ''); ?>">
                            </div>
                            <button type="submit" name="update_contact" class="btn btn-primary">Update Contact Information</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
// Include admin footer
include 'includes/footer.php';
?> 