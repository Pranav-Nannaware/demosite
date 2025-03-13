<?php
// Include config file
require_once '../includes/config.php';

// Check if user is logged in
if (!isLoggedIn()) {
    redirect('index.php');
}

// Check if ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    redirect('messages.php');
}

$message_id = (int)$_GET['id'];

// Get message details
$stmt = $db->prepare("SELECT * FROM contact_messages WHERE id = ? LIMIT 1");
$stmt->execute([$message_id]);
$message = $stmt->fetch(PDO::FETCH_ASSOC);

// If message not found, redirect
if (!$message) {
    redirect('messages.php');
}

// Mark message as read if it's unread
if (!$message['is_read']) {
    $stmt = $db->prepare("UPDATE contact_messages SET is_read = 1 WHERE id = ?");
    $stmt->execute([$message_id]);
    $message['is_read'] = 1;
}

// Set page title
$page_title = 'View Message';

// Include admin header
include 'includes/header.php';
?>

<div class="content-container">
    <div class="content-header">
        <h1><?php echo $page_title; ?></h1>
        <div class="content-actions">
            <a href="messages.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back to Messages</a>
            <a href="message-delete.php?id=<?php echo $message['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this message?');"><i class="fas fa-trash"></i> Delete</a>
        </div>
    </div>
    
    <div class="content-body">
        <div class="card">
            <div class="card-header">
                <h2><?php echo $message['subject']; ?></h2>
                <div class="message-meta">
                    <span class="badge <?php echo $message['is_read'] ? 'badge-secondary' : 'badge-warning'; ?>">
                        <?php echo $message['is_read'] ? 'Read' : 'Unread'; ?>
                    </span>
                    <span class="message-date"><?php echo formatDate($message['created_at'], 'M d, Y h:i A'); ?></span>
                </div>
            </div>
            <div class="card-body">
                <div class="message-info">
                    <p><strong>From:</strong> <?php echo $message['name']; ?> (<?php echo $message['email']; ?>)</p>
                    <?php if (!empty($message['phone'])): ?>
                    <p><strong>Phone:</strong> <?php echo $message['phone']; ?></p>
                    <?php endif; ?>
                </div>
                
                <div class="message-content">
                    <h3>Message:</h3>
                    <div class="message-text">
                        <?php echo nl2br(htmlspecialchars($message['message'])); ?>
                    </div>
                </div>
                
                <div class="message-actions mt-4">
                    <a href="mailto:<?php echo $message['email']; ?>?subject=Re: <?php echo urlencode($message['subject']); ?>" class="btn btn-primary">
                        <i class="fas fa-reply"></i> Reply via Email
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .message-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 10px;
    }
    
    .message-date {
        color: #666;
        font-size: 14px;
    }
    
    .message-info {
        margin-bottom: 20px;
        padding-bottom: 20px;
        border-bottom: 1px solid #eee;
    }
    
    .message-text {
        background-color: #f9f9f9;
        padding: 15px;
        border-radius: 5px;
        margin-top: 10px;
        white-space: pre-line;
    }
</style>

<?php
// Include admin footer
include 'includes/footer.php';
?> 