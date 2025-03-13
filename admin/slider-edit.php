<?php
// Include config file
require_once '../includes/config.php';

// Check if user is logged in
if (!isLoggedIn()) {
    redirect('index.php');
}

// Check if ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    redirect('sliders.php');
}

$slider_id = (int)$_GET['id'];

// Get slider details
$stmt = $db->prepare("SELECT * FROM sliders WHERE id = ? LIMIT 1");
$stmt->execute([$slider_id]);
$slider = $stmt->fetch(PDO::FETCH_ASSOC);

// If slider not found, redirect
if (!$slider) {
    redirect('sliders.php');
}

// Set page title
$page_title = 'Edit Slider';

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_slider'])) {
    // Get form data
    $title = clean($_POST['title']);
    $subtitle = clean($_POST['subtitle']);
    $button_text = clean($_POST['button_text']);
    $button_url = clean($_POST['button_url']);
    $display_order = (int)$_POST['display_order'];
    $is_active = isset($_POST['is_active']) ? 1 : 0;
    
    // Validate form data
    $errors = [];
    
    if (empty($title)) {
        $errors[] = 'Title is required.';
    }
    
    if (empty($subtitle)) {
        $errors[] = 'Subtitle is required.';
    }
    
    // Handle image upload if a new image is provided
    $image_path = $slider['image_path'];
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = '../uploads/sliders/';
        
        // Create directory if it doesn't exist
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        
        $file_name = time() . '_' . basename($_FILES['image']['name']);
        $target_file = $upload_dir . $file_name;
        $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        
        // Check if image file is a actual image
        $check = getimagesize($_FILES['image']['tmp_name']);
        if ($check === false) {
            $errors[] = 'File is not an image.';
        }
        
        // Check file size (limit to 5MB)
        if ($_FILES['image']['size'] > 5000000) {
            $errors[] = 'File is too large. Maximum size is 5MB.';
        }
        
        // Allow certain file formats
        if (!in_array($image_file_type, ['jpg', 'jpeg', 'png', 'gif'])) {
            $errors[] = 'Only JPG, JPEG, PNG & GIF files are allowed.';
        }
        
        // If no errors, try to upload file
        if (empty($errors)) {
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                // Delete old image if it exists
                if (!empty($slider['image_path']) && file_exists('../' . $slider['image_path'])) {
                    unlink('../' . $slider['image_path']);
                }
                
                $image_path = 'uploads/sliders/' . $file_name;
            } else {
                $errors[] = 'Error uploading file.';
            }
        }
    }
    
    // If no errors, update slider in database
    if (empty($errors)) {
        $stmt = $db->prepare("UPDATE sliders SET title = ?, subtitle = ?, button_text = ?, button_url = ?, image_path = ?, display_order = ?, is_active = ?, updated_at = NOW() WHERE id = ?");
        $result = $stmt->execute([$title, $subtitle, $button_text, $button_url, $image_path, $display_order, $is_active, $slider_id]);
        
        if ($result) {
            $_SESSION['success_msg'] = 'Slider updated successfully.';
            redirect('sliders.php');
        } else {
            $errors[] = 'Error updating slider.';
        }
    }
}

// Include admin header
include 'includes/header.php';
?>

<div class="content-container">
    <div class="content-header">
        <h1><?php echo $page_title; ?></h1>
        <div class="content-actions">
            <a href="sliders.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back to Sliders</a>
        </div>
    </div>
    
    <div class="content-body">
        <?php if (isset($errors) && !empty($errors)): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        
        <div class="card">
            <div class="card-header">
                <h2>Slider Details</h2>
            </div>
            <div class="card-body">
                <form method="post" action="" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="title">Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($slider['title']); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="subtitle">Subtitle <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="subtitle" name="subtitle" value="<?php echo htmlspecialchars($slider['subtitle']); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="button_text">Button Text</label>
                        <input type="text" class="form-control" id="button_text" name="button_text" value="<?php echo htmlspecialchars($slider['button_text']); ?>">
                        <small class="form-text text-muted">Leave empty if you don't want to display a button.</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="button_url">Button URL</label>
                        <input type="text" class="form-control" id="button_url" name="button_url" value="<?php echo htmlspecialchars($slider['button_url']); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label>Current Image</label>
                        <div class="mb-3">
                            <img src="<?php echo '../' . $slider['image_path']; ?>" alt="<?php echo $slider['title']; ?>" class="img-thumbnail" style="max-height: 200px;">
                        </div>
                        
                        <label for="image">New Image (Optional)</label>
                        <input type="file" class="form-control-file" id="image" name="image">
                        <small class="form-text text-muted">Recommended size: 1920x800 pixels. Maximum file size: 5MB. Leave empty to keep the current image.</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="display_order">Display Order</label>
                        <input type="number" class="form-control" id="display_order" name="display_order" value="<?php echo (int)$slider['display_order']; ?>" min="0">
                        <small class="form-text text-muted">Lower numbers will be displayed first.</small>
                    </div>
                    
                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="is_active" name="is_active" <?php echo $slider['is_active'] ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="is_active">Active</label>
                    </div>
                    
                    <button type="submit" name="update_slider" class="btn btn-primary">Update Slider</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
// Include admin footer
include 'includes/footer.php';
?> 