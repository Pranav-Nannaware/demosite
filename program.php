<?php
// Include header
require_once 'includes/config.php';

// Get program slug from URL
$slug = isset($_GET['slug']) ? clean($_GET['slug']) : '';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Get program data
if (!empty($slug)) {
    $program = getProgram($slug, 'slug');
} elseif ($id > 0) {
    $program = getProgram($id, 'id');
} else {
    // Redirect to programs page if no slug or ID provided
    redirect('index.php#program');
}

// Redirect to programs page if program not found
if (!$program) {
    redirect('index.php#program');
}

// Set page title
$page_title = $program['title'];

// Include header
include 'includes/header.php';
?>

<!-- Program Detail Section -->
<section class="program-detail-section">
    <div class="container">
        <div class="section-title">
            <h2><?php echo $program['title']; ?></h2>
        </div>
        
        <div class="program-detail-content">
            <div class="program-icon">
                <i class="<?php echo $program['icon_class']; ?>"></i>
            </div>
            
            <?php if ($program['image']): ?>
                <div class="program-image">
                    <img src="<?php echo $program['image']; ?>" alt="<?php echo $program['title']; ?>">
                </div>
            <?php endif; ?>
            
            <div class="program-description">
                <?php 
                // Split content by newlines and create paragraphs
                $paragraphs = explode("\r\n\r\n", $program['description']);
                foreach ($paragraphs as $paragraph): 
                ?>
                    <p><?php echo $paragraph; ?></p>
                <?php endforeach; ?>
            </div>
            
            <div class="program-actions">
                <a href="index.php#program" class="btn">Back to Programs</a>
                <a href="#contact" class="btn">Enquire Now</a>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="contact-section" id="contact">
    <div class="container">
        <div class="section-title">
            <h2>Enquire About <span><?php echo $program['title']; ?></span></h2>
        </div>
        <div class="contact-content">
            <div class="contact-info">
                <div class="contact-item">
                    <div class="icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div class="details">
                        <h3>Address</h3>
                        <p><?php echo SITE_ADDRESS; ?></p>
                    </div>
                </div>
                <div class="contact-item">
                    <div class="icon">
                        <i class="fas fa-phone"></i>
                    </div>
                    <div class="details">
                        <h3>Phone</h3>
                        <p><?php echo SITE_PHONE; ?></p>
                    </div>
                </div>
                <div class="contact-item">
                    <div class="icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="details">
                        <h3>Email</h3>
                        <p><?php echo SITE_EMAIL; ?></p>
                    </div>
                </div>
            </div>
            <div class="contact-form">
                <?php
                // Process contact form submission
                $form_submitted = false;
                $form_error = '';
                $form_success = false;
                
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['contact_submit'])) {
                    $form_submitted = true;
                    
                    // Validate form data
                    $name = isset($_POST['name']) ? clean($_POST['name']) : '';
                    $email = isset($_POST['email']) ? clean($_POST['email']) : '';
                    $subject = isset($_POST['subject']) ? clean($_POST['subject']) : 'Enquiry about ' . $program['title'];
                    $message = isset($_POST['message']) ? clean($_POST['message']) : '';
                    
                    if (empty($name) || empty($email) || empty($message)) {
                        $form_error = 'All fields are required.';
                    } elseif (!isValidEmail($email)) {
                        $form_error = 'Please enter a valid email address.';
                    } else {
                        // Save message to database
                        $form_success = saveContactMessage([
                            'name' => $name,
                            'email' => $email,
                            'subject' => $subject,
                            'message' => $message
                        ]);
                        
                        if (!$form_success) {
                            $form_error = 'An error occurred while sending your message. Please try again later.';
                        }
                    }
                }
                ?>
                
                <?php if ($form_submitted && $form_success): ?>
                    <div class="alert alert-success">
                        <p>Thank you for your enquiry about <?php echo $program['title']; ?>! We will get back to you soon.</p>
                    </div>
                <?php elseif ($form_submitted && !empty($form_error)): ?>
                    <div class="alert alert-error">
                        <p><?php echo $form_error; ?></p>
                    </div>
                <?php endif; ?>
                
                <form method="post" action="#contact">
                    <div class="form-group">
                        <input type="text" name="name" placeholder="Your Name" required value="<?php echo isset($_POST['name']) ? clean($_POST['name']) : ''; ?>">
                    </div>
                    <div class="form-group">
                        <input type="email" name="email" placeholder="Your Email" required value="<?php echo isset($_POST['email']) ? clean($_POST['email']) : ''; ?>">
                    </div>
                    <div class="form-group">
                        <input type="text" name="subject" placeholder="Subject" value="Enquiry about <?php echo $program['title']; ?>" readonly>
                    </div>
                    <div class="form-group">
                        <textarea name="message" placeholder="Your Message" required><?php echo isset($_POST['message']) ? clean($_POST['message']) : ''; ?></textarea>
                    </div>
                    <button type="submit" name="contact_submit" class="btn">Send Enquiry</button>
                </form>
            </div>
        </div>
    </div>
</section>

<?php
// Include footer
include 'includes/footer.php';
?> 