<?php
// Include config file
require_once '../includes/config.php';

// Check if user is logged in
if (!isLoggedIn()) {
    redirect('index.php');
}

// Set page title
$page_title = 'Manage Programs';

// Get all programs
$stmt = $db->query("SELECT * FROM programs ORDER BY display_order");
$programs = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Include admin header
include 'includes/header.php';
?>

<div class="content-container">
    <div class="content-header">
        <h1><?php echo $page_title; ?></h1>
        <div class="content-actions">
            <a href="program-add.php" class="btn"><i class="fas fa-plus"></i> Add New Program</a>
        </div>
    </div>
    
    <div class="content-body">
        <div class="card">
            <div class="card-header">
                <h2>All Programs</h2>
            </div>
            <div class="card-body">
                <?php if (count($programs) > 0): ?>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Duration</th>
                                    <th>Order</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($programs as $program): ?>
                                    <tr>
                                        <td><?php echo $program['id']; ?></td>
                                        <td><?php echo $program['name']; ?></td>
                                        <td><?php echo $program['category']; ?></td>
                                        <td><?php echo $program['duration']; ?></td>
                                        <td><?php echo $program['display_order']; ?></td>
                                        <td>
                                            <span class="badge <?php echo $program['is_active'] ? 'badge-success' : 'badge-danger'; ?>">
                                                <?php echo $program['is_active'] ? 'Active' : 'Inactive'; ?>
                                            </span>
                                        </td>
                                        <td>
                                            <a href="program-edit.php?id=<?php echo $program['id']; ?>" class="btn-link"><i class="fas fa-edit"></i> Edit</a>
                                            <a href="program-delete.php?id=<?php echo $program['id']; ?>" class="btn-link text-danger" onclick="return confirm('Are you sure you want to delete this program?');"><i class="fas fa-trash"></i> Delete</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="no-data">No programs found. <a href="program-add.php">Add a new program</a>.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php
// Include admin footer
include 'includes/footer.php';
?> 