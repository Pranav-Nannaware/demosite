<?php
// Include config file
require_once '../includes/config.php';

// Check if user is logged in
if (!isLoggedIn()) {
    redirect('index.php');
}

// Set page title
$page_title = 'Manage Site Content';

// Get all site content
$stmt = $db->query("SELECT * FROM site_content ORDER BY section, content_key");
$contents = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_content'])) {
    foreach ($_POST['content'] as $id => $value) {
        $stmt = $db->prepare("UPDATE site_content SET content_value = ? WHERE id = ?");
        $stmt->execute([$value, $id]);
    }
    
    // Set success message
    $_SESSION['success_msg'] = 'Site content updated successfully.';
    
    // Redirect to refresh the page
    redirect('content.php');
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
            $current_section = '';
            foreach ($contents as $content):
                if ($current_section !== $content['section']):
                    if ($current_section !== '') {
                        echo '</div></div>';
                    }
                    $current_section = $content['section'];
            ?>
                <div class="card mb-4">
                    <div class="card-header">
                        <h2><?php echo ucwords(str_replace('_', ' ', $current_section)); ?> Section</h2>
                    </div>
                    <div class="card-body">
            <?php endif; ?>
                
                <div class="form-group">
                    <label for="content_<?php echo $content['id']; ?>">
                        <?php echo ucwords(str_replace('_', ' ', $content['content_key'])); ?>
                    </label>
                    
                    <?php if (strpos($content['content_value'], "\n") !== false || strlen($content['content_value']) > 100): ?>
                        <textarea class="form-control" id="content_<?php echo $content['id']; ?>" name="content[<?php echo $content['id']; ?>]" rows="5"><?php echo htmlspecialchars($content['content_value']); ?></textarea>
                    <?php else: ?>
                        <input type="text" class="form-control" id="content_<?php echo $content['id']; ?>" name="content[<?php echo $content['id']; ?>]" value="<?php echo htmlspecialchars($content['content_value']); ?>">
                    <?php endif; ?>
                    
                    <small class="form-text text-muted">Key: <?php echo $content['content_key']; ?></small>
                </div>
                
            <?php endforeach; ?>
            
            <?php if ($current_section !== ''): ?>
                </div></div>
            <?php endif; ?>
            
            <div class="form-group mt-4">
                <button type="submit" name="update_content" class="btn btn-primary">Update Content</button>
            </div>
        </form>
    </div>
</div>

<?php
// Include admin footer
include 'includes/footer.php';
?> 