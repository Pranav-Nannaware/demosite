<?php
// Include config file
require_once '../includes/config.php';

// Check if user is logged in
if (!isLoggedIn()) {
    redirect('index.php');
}

// Set page title
$page_title = 'Website Settings';

// Get all settings
$stmt = $db->query("SELECT * FROM settings ORDER BY setting_group, setting_key");
$settings = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_settings'])) {
    foreach ($_POST['settings'] as $id => $value) {
        $stmt = $db->prepare("UPDATE settings SET setting_value = ? WHERE id = ?");
        $stmt->execute([$value, $id]);
    }
    
    // Set success message
    $_SESSION['success_msg'] = 'Settings updated successfully.';
    
    // Redirect to refresh the page
    redirect('settings.php');
}

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
        
        <form method="post" action="">
            <?php
            $current_group = '';
            foreach ($settings as $setting):
                if ($current_group !== $setting['setting_group']):
                    if ($current_group !== '') {
                        echo '</div></div>';
                    }
                    $current_group = $setting['setting_group'];
            ?>
                <div class="card mb-4">
                    <div class="card-header">
                        <h2><?php echo ucwords(str_replace('_', ' ', $current_group)); ?> Settings</h2>
                    </div>
                    <div class="card-body">
            <?php endif; ?>
                
                <div class="form-group">
                    <label for="setting_<?php echo $setting['id']; ?>">
                        <?php echo ucwords(str_replace('_', ' ', $setting['setting_key'])); ?>
                    </label>
                    
                    <?php if ($setting['setting_type'] === 'boolean'): ?>
                        <select class="form-control" id="setting_<?php echo $setting['id']; ?>" name="settings[<?php echo $setting['id']; ?>]">
                            <option value="1" <?php echo $setting['setting_value'] == '1' ? 'selected' : ''; ?>>Yes</option>
                            <option value="0" <?php echo $setting['setting_value'] == '0' ? 'selected' : ''; ?>>No</option>
                        </select>
                    <?php elseif ($setting['setting_type'] === 'textarea'): ?>
                        <textarea class="form-control" id="setting_<?php echo $setting['id']; ?>" name="settings[<?php echo $setting['id']; ?>]" rows="5"><?php echo htmlspecialchars($setting['setting_value']); ?></textarea>
                    <?php else: ?>
                        <input type="text" class="form-control" id="setting_<?php echo $setting['id']; ?>" name="settings[<?php echo $setting['id']; ?>]" value="<?php echo htmlspecialchars($setting['setting_value']); ?>">
                    <?php endif; ?>
                    
                    <?php if (!empty($setting['description'])): ?>
                        <small class="form-text text-muted"><?php echo $setting['description']; ?></small>
                    <?php endif; ?>
                </div>
                
            <?php endforeach; ?>
            
            <?php if ($current_group !== ''): ?>
                </div></div>
            <?php endif; ?>
            
            <div class="form-group mt-4">
                <button type="submit" name="update_settings" class="btn btn-primary">Update Settings</button>
            </div>
        </form>
    </div>
</div>

<?php
// Include admin footer
include 'includes/footer.php';
?> 