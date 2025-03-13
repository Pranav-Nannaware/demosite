<?php
// Include config file
require_once '../includes/config.php';

// Check if user is logged in
if (!isLoggedIn()) {
    redirect('index.php');
}

// Set page title
$page_title = 'Manage Facilities';

// Get all facilities
$stmt = $db->query("SELECT * FROM facilities ORDER BY display_order");
$facilities = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Include admin header
include 'includes/header.php';
?>

<div class="content-container">
    <div class="content-header">
        <h1><?php echo $page_title; ?></h1>
        <div class="content-actions">
            <a href="facility-add.php" class="btn"><i class="fas fa-plus"></i> Add New Facility</a>
        </div>
    </div>
    
    <div class="content-body">
        <div class="card">
            <div class="card-header">
                <h2>All Facilities</h2>
            </div>
            <div class="card-body">
                <?php if (count($facilities) > 0): ?>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Order</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($facilities as $facility): ?>
                                    <tr>
                                        <td><?php echo $facility['id']; ?></td>
                                        <td>
                                            <img src="<?php echo '../' . $facility['image_path']; ?>" alt="<?php echo $facility['name']; ?>" width="100">
                                        </td>
                                        <td><?php echo $facility['name']; ?></td>
                                        <td><?php echo $facility['display_order']; ?></td>
                                        <td>
                                            <span class="badge <?php echo $facility['is_active'] ? 'badge-success' : 'badge-danger'; ?>">
                                                <?php echo $facility['is_active'] ? 'Active' : 'Inactive'; ?>
                                            </span>
                                        </td>
                                        <td>
                                            <a href="facility-edit.php?id=<?php echo $facility['id']; ?>" class="btn-link"><i class="fas fa-edit"></i> Edit</a>
                                            <a href="facility-delete.php?id=<?php echo $facility['id']; ?>" class="btn-link text-danger" onclick="return confirm('Are you sure you want to delete this facility?');"><i class="fas fa-trash"></i> Delete</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="no-data">No facilities found. <a href="facility-add.php">Add a new facility</a>.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php
// Include admin footer
include 'includes/footer.php';
?> 