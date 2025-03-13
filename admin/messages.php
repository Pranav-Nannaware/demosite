<?php
// Include config file
require_once '../includes/config.php';

// Check if user is logged in
if (!isLoggedIn()) {
    redirect('index.php');
}

// Set page title
$page_title = 'Contact Messages';

// Get all messages
$stmt = $db->query("SELECT * FROM contact_messages ORDER BY created_at DESC");
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
        
        <div class="card">
            <div class="card-header">
                <h2>All Messages</h2>
            </div>
            <div class="card-body">
                <?php if (count($messages) > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th width="5%">ID</th>
                                    <th width="20%">Name</th>
                                    <th width="20%">Email</th>
                                    <th width="25%">Subject</th>
                                    <th width="15%">Date</th>
                                    <th width="5%">Status</th>
                                    <th width="10%">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($messages as $message): ?>
                                    <tr class="<?php echo $message['is_read'] ? '' : 'table-warning'; ?>">
                                        <td><?php echo $message['id']; ?></td>
                                        <td>
                                            <div style="display: flex; align-items: center;">
                                                <div style="width: 35px; height: 35px; border-radius: 50%; background-color: <?php echo $message['is_read'] ? '#f0f0f0' : '#fff3cd'; ?>; display: flex; justify-content: center; align-items: center; margin-right: 10px; color: #666; font-weight: bold;">
                                                    <?php echo strtoupper(substr($message['name'], 0, 1)); ?>
                                                </div>
                                                <?php echo $message['name']; ?>
                                            </div>
                                        </td>
                                        <td><?php echo $message['email']; ?></td>
                                        <td>
                                            <?php if (!$message['is_read']): ?>
                                                <strong><?php echo $message['subject']; ?></strong>
                                            <?php else: ?>
                                                <?php echo $message['subject']; ?>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo formatDate($message['created_at'], 'M d, Y h:i A'); ?></td>
                                        <td>
                                            <span class="badge <?php echo $message['is_read'] ? 'badge-secondary' : 'badge-warning'; ?>">
                                                <?php echo $message['is_read'] ? 'Read' : 'Unread'; ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="message-view.php?id=<?php echo $message['id']; ?>" class="btn btn-sm btn-primary" title="View"><i class="fas fa-eye"></i></a>
                                                <a href="message-delete.php?id=<?php echo $message['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this message?');" title="Delete"><i class="fas fa-trash"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="no-data">
                        <i class="fas fa-envelope" style="font-size: 48px; color: #ddd; margin-bottom: 15px;"></i>
                        <p>No messages found.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<style>
    .btn-group {
        display: flex;
        gap: 5px;
    }
    
    .btn-sm {
        padding: 5px 10px;
        font-size: 12px;
    }
    
    .no-data {
        text-align: center;
        padding: 50px 20px;
        background-color: #f9f9f9;
        border-radius: 5px;
        border: 1px dashed #ddd;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }
</style>

<?php
// Include admin footer
include 'includes/footer.php';
?> 