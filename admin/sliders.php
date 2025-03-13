<?php
// Include config file
require_once '../includes/config.php';

// Check if user is logged in
if (!isLoggedIn()) {
    redirect('index.php');
}

// Set page title
$page_title = 'Manage Sliders';

// Get all sliders
$stmt = $db->query("SELECT * FROM sliders ORDER BY display_order");
$sliders = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Include admin header
include 'includes/header.php';
?>

<div class="content-container">
    <div class="content-header">
        <h1><?php echo $page_title; ?></h1>
        <div class="content-actions">
            <a href="slider-add.php" class="btn"><i class="fas fa-plus"></i> Add New Slider</a>
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
                <h2>All Sliders</h2>
            </div>
            <div class="card-body">
                <?php if (count($sliders) > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th width="5%">ID</th>
                                    <th width="20%">Image</th>
                                    <th width="25%">Title</th>
                                    <th width="10%">Button</th>
                                    <th width="10%">Order</th>
                                    <th width="10%">Status</th>
                                    <th width="20%">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($sliders as $slider): ?>
                                    <tr>
                                        <td><?php echo $slider['id']; ?></td>
                                        <td>
                                            <div class="image-preview">
                                                <img src="<?php echo '../' . $slider['image_path']; ?>" alt="<?php echo $slider['title']; ?>">
                                            </div>
                                        </td>
                                        <td>
                                            <strong><?php echo $slider['title']; ?></strong>
                                            <div style="font-size: 12px; color: #666; margin-top: 5px;">
                                                <?php echo $slider['subtitle']; ?>
                                            </div>
                                        </td>
                                        <td>
                                            <?php if (!empty($slider['button_text'])): ?>
                                                <span class="badge badge-info"><?php echo $slider['button_text']; ?></span>
                                            <?php else: ?>
                                                <span class="badge badge-secondary">None</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo $slider['display_order']; ?></td>
                                        <td>
                                            <span class="badge <?php echo $slider['is_active'] ? 'badge-success' : 'badge-danger'; ?>">
                                                <?php echo $slider['is_active'] ? 'Active' : 'Inactive'; ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="slider-edit.php?id=<?php echo $slider['id']; ?>" class="btn btn-sm btn-primary" title="Edit"><i class="fas fa-edit"></i> Edit</a>
                                                <a href="slider-delete.php?id=<?php echo $slider['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this slider?');" title="Delete"><i class="fas fa-trash"></i> Delete</a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="no-data">
                        <i class="fas fa-images" style="font-size: 48px; color: #ddd; margin-bottom: 15px;"></i>
                        <p>No sliders found.</p>
                        <a href="slider-add.php" class="btn btn-primary mt-3">Add a new slider</a>
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
    
    .image-preview {
        width: 100%;
        height: 80px;
        overflow: hidden;
        border-radius: 4px;
        border: 1px solid #ddd;
    }
    
    .image-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
</style>

<?php
// Include admin footer
include 'includes/footer.php';
?> 