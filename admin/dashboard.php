<?php
// Include config file
require_once '../includes/config.php';

// Check if user is logged in
if (!isLoggedIn()) {
    redirect('index.php');
}

// Get user data
$user_id = $_SESSION['user_id'];
$stmt = $db->prepare("SELECT * FROM users WHERE id = ? LIMIT 1");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Get counts for dashboard
$counts = [
    'programs' => $db->query("SELECT COUNT(*) FROM programs")->fetchColumn(),
    'facilities' => $db->query("SELECT COUNT(*) FROM facilities")->fetchColumn(),
    'achievements' => $db->query("SELECT COUNT(*) FROM achievements")->fetchColumn(),
    'testimonials' => $db->query("SELECT COUNT(*) FROM testimonials")->fetchColumn(),
    'messages' => $db->query("SELECT COUNT(*) FROM contact_messages")->fetchColumn(),
    'unread_messages' => $db->query("SELECT COUNT(*) FROM contact_messages WHERE is_read = 0")->fetchColumn(),
];

// Get recent messages
$stmt = $db->query("SELECT * FROM contact_messages ORDER BY created_at DESC LIMIT 5");
$recent_messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Include admin header
include 'includes/header.php';
?>

<div class="dashboard-container">
    <div class="dashboard-header">
        <h1>Dashboard</h1>
        <p>Welcome back, <?php echo $user['name']; ?>!</p>
    </div>
    
    <div class="dashboard-stats">
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
                <i class="fas fa-envelope"></i>
            </div>
            <div class="stat-content">
                <h3>Messages</h3>
                <p><?php echo $counts['messages']; ?> <span class="badge"><?php echo $counts['unread_messages']; ?> new</span></p>
            </div>
            <a href="messages.php" class="stat-link">View All</a>
        </div>
    </div>
    
    <div class="dashboard-recent">
        <div class="recent-section">
            <h2>Recent Messages</h2>
            
            <?php if ($recent_messages): ?>
                <div class="recent-messages">
                    <?php foreach ($recent_messages as $message): ?>
                        <div class="message-card <?php echo $message['is_read'] ? '' : 'unread'; ?>">
                            <div class="message-header">
                                <h3><?php echo $message['subject']; ?></h3>
                                <span class="message-date"><?php echo formatDate($message['created_at'], 'M d, Y h:i A'); ?></span>
                            </div>
                            <div class="message-sender">
                                <strong><?php echo $message['name']; ?></strong> (<?php echo $message['email']; ?>)
                            </div>
                            <div class="message-content">
                                <?php echo truncateText($message['message'], 150); ?>
                            </div>
                            <a href="message-view.php?id=<?php echo $message['id']; ?>" class="btn-link">Read More</a>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="view-all">
                    <a href="messages.php" class="btn">View All Messages</a>
                </div>
            <?php else: ?>
                <p class="no-data">No messages yet.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
// Include admin footer
include 'includes/footer.php';
?> 