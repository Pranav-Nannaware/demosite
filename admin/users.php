<?php
// Include config file
require_once '../includes/config.php';

// Check if user is logged in
if (!isLoggedIn()) {
    redirect('index.php');
}

// Set page title
$page_title = 'Manage Users';

// Get all users
$stmt = $db->query("SELECT * FROM users ORDER BY name");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Include admin header
include 'includes/header.php';
?>

<div class="content-container">
    <div class="content-header">
        <h1><?php echo $page_title; ?></h1>
        <div class="content-actions">
            <a href="user-add.php" class="btn"><i class="fas fa-plus"></i> Add New User</a>
        </div>
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
                <h2>All Users</h2>
            </div>
            <div class="card-body">
                <?php if (count($users) > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th width="5%">ID</th>
                                    <th width="20%">Name</th>
                                    <th width="25%">Email</th>
                                    <th width="15%">Role</th>
                                    <th width="15%">Last Login</th>
                                    <th width="10%">Status</th>
                                    <th width="10%">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($users as $user): ?>
                                    <tr>
                                        <td><?php echo $user['id']; ?></td>
                                        <td>
                                            <div style="display: flex; align-items: center;">
                                                <div style="width: 35px; height: 35px; border-radius: 50%; background-color: #f0f0f0; display: flex; justify-content: center; align-items: center; margin-right: 10px; color: #666; font-weight: bold;">
                                                    <?php echo strtoupper(substr($user['name'], 0, 1)); ?>
                                                </div>
                                                <?php echo $user['name']; ?>
                                            </div>
                                        </td>
                                        <td><?php echo $user['email']; ?></td>
                                        <td>
                                            <span class="badge <?php echo $user['role'] === 'admin' ? 'badge-danger' : 'badge-info'; ?>">
                                                <?php echo ucfirst($user['role']); ?>
                                            </span>
                                        </td>
                                        <td><?php echo $user['last_login'] ? formatDate($user['last_login'], 'M d, Y h:i A') : 'Never'; ?></td>
                                        <td>
                                            <span class="badge <?php echo $user['is_active'] ? 'badge-success' : 'badge-danger'; ?>">
                                                <?php echo $user['is_active'] ? 'Active' : 'Inactive'; ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="user-edit.php?id=<?php echo $user['id']; ?>" class="btn btn-sm btn-primary" title="Edit"><i class="fas fa-edit"></i></a>
                                                <?php if ($user['id'] != $_SESSION['user_id']): ?>
                                                    <a href="user-delete.php?id=<?php echo $user['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this user?');" title="Delete"><i class="fas fa-trash"></i></a>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="no-data">
                        <i class="fas fa-users" style="font-size: 48px; color: #ddd; margin-bottom: 15px;"></i>
                        <p>No users found.</p>
                        <a href="user-add.php" class="btn btn-primary mt-3">Add a new user</a>
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