<?php
// Include config file
require_once '../includes/config.php';

// Check if user is logged in
if (!isLoggedIn()) {
    redirect('index.php');
}

// Set page title
$page_title = 'Manage Achievements';

// Get all achievements
$stmt = $db->query("SELECT * FROM achievements ORDER BY display_order");
$achievements = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Include admin header
include 'includes/header.php';
?>

<div class="content-container">
    <div class="content-header">
        <h1><?php echo $page_title; ?></h1>
        <div class="content-actions">
            <a href="achievement-add.php" class="btn"><i class="fas fa-plus"></i> Add New Achievement</a>
        </div>
    </div>
    
    <div class="content-body">
        <div class="card">
            <div class="card-header">
                <h2>All Achievements</h2>
            </div>
            <div class="card-body">
                <?php if (count($achievements) > 0): ?>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Date</th>
                                    <th>Order</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($achievements as $achievement): ?>
                                    <tr>
                                        <td><?php echo $achievement['id']; ?></td>
                                        <td><?php echo $achievement['title']; ?></td>
                                        <td><?php echo $achievement['category']; ?></td>
                                        <td><?php echo formatDate($achievement['achievement_date']); ?></td>
                                        <td><?php echo $achievement['display_order']; ?></td>
                                        <td>
                                            <span class="badge <?php echo $achievement['is_active'] ? 'badge-success' : 'badge-danger'; ?>">
                                                <?php echo $achievement['is_active'] ? 'Active' : 'Inactive'; ?>
                                            </span>
                                        </td>
                                        <td>
                                            <a href="achievement-edit.php?id=<?php echo $achievement['id']; ?>" class="btn-link"><i class="fas fa-edit"></i> Edit</a>
                                            <a href="achievement-delete.php?id=<?php echo $achievement['id']; ?>" class="btn-link text-danger" onclick="return confirm('Are you sure you want to delete this achievement?');"><i class="fas fa-trash"></i> Delete</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="no-data">No achievements found. <a href="achievement-add.php">Add a new achievement</a>.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php
// Include admin footer
include 'includes/footer.php';
?> 