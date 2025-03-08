<?php
// Include header
require_once 'includes/config.php';

// Set page title
$page_title = 'Home';

// Get data from database
$sliders = getSliders();
$announcements = getAnnouncements();
$programs = getPrograms();
$facilities = getFacilities();
$achievements = getAchievements();
$testimonials = getTestimonials();
$about_content = getSiteContent('about_section');

// Include header
include 'includes/header.php';
?>

<!-- Hero Slider Section -->
<section class="hero-slider">
    <div class="slider-container">
        <?php if ($sliders): ?>
            <?php foreach ($sliders as $index => $slider): ?>
                <div class="slide <?php echo ($index === 0) ? 'active' : ''; ?>">
                    <img src="<?php echo $slider['image']; ?>" alt="<?php echo $slider['title']; ?>">
                    <div class="slide-content">
                        <h2><?php echo $slider['title']; ?></h2>
                        <p><?php echo $slider['subtitle']; ?></p>
                        <?php if ($slider['button_text'] && $slider['button_url']): ?>
                            <a href="<?php echo $slider['button_url']; ?>" class="btn"><?php echo $slider['button_text']; ?></a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <!-- Fallback slider if no data in database -->
            <div class="slide active">
                <img src="https://picsum.photos/id/1015/1920/800" alt="Campus View">
                <div class="slide-content">
                    <h2>Welcome to CMR Institute of Technology</h2>
                    <p>Shaping the future through quality education and innovation</p>
                    <a href="#about" class="btn">Learn More</a>
                </div>
            </div>
            <div class="slide">
                <img src="https://picsum.photos/id/20/1920/800" alt="Students">
                <div class="slide-content">
                    <h2>Excellence in Education</h2>
                    <p>Providing world-class education and research opportunities</p>
                    <a href="#program" class="btn">Explore Programs</a>
                </div>
            </div>
            <div class="slide">
                <img src="https://picsum.photos/id/180/1920/800" alt="Campus Life">
                <div class="slide-content">
                    <h2>Vibrant Campus Life</h2>
                    <p>Experience a dynamic and enriching campus environment</p>
                    <a href="#campus" class="btn">Campus Tour</a>
                </div>
            </div>
        <?php endif; ?>
        
        <div class="slider-controls">
            <button class="prev-btn"><i class="fas fa-chevron-left"></i></button>
            <button class="next-btn"><i class="fas fa-chevron-right"></i></button>
        </div>
        <div class="slider-dots">
            <?php if ($sliders): ?>
                <?php foreach ($sliders as $index => $slider): ?>
                    <span class="dot <?php echo ($index === 0) ? 'active' : ''; ?>" data-slide="<?php echo $index; ?>"></span>
                <?php endforeach; ?>
            <?php else: ?>
                <span class="dot active" data-slide="0"></span>
                <span class="dot" data-slide="1"></span>
                <span class="dot" data-slide="2"></span>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Announcement Section -->
<section class="announcement" id="about">
    <div class="container">
        <?php if ($announcements): ?>
            <marquee behavior="scroll" onmouseover="this.stop();" onmouseout="this.start();" scrolldelay="100">
                <?php foreach ($announcements as $announcement): ?>
                    <?php if ($announcement['url']): ?>
                        <a href="<?php echo $announcement['url']; ?>"><strong><?php echo $announcement['content']; ?></strong></a>
                    <?php else: ?>
                        <strong><?php echo $announcement['content']; ?></strong>
                    <?php endif; ?>
                    <?php if (next($announcements)): ?> | <?php endif; ?>
                <?php endforeach; ?>
            </marquee>
        <?php else: ?>
            <marquee behavior="scroll" onmouseover="this.stop();" onmouseout="this.start();" scrolldelay="100">
                <a href="#"><strong>6th International conference on Recent Trends in Machine Learning, IOT, Smart Cities & Applications, 28-29 March 2025, Hyderabad, India.</strong></a>
            </marquee>
        <?php endif; ?>
    </div>
</section>

<!-- About Section -->
<section class="about-section" id="about">
    <div class="container">
        <div class="section-title">
            <h2>About <span>CMRIT</span></h2>
        </div>
        <div class="about-content">
            <div class="about-text">
                <?php if ($about_content): ?>
                    <?php 
                    // Split content by newlines and create paragraphs
                    $paragraphs = explode("\r\n\r\n", $about_content);
                    foreach ($paragraphs as $paragraph): 
                    ?>
                        <p><?php echo $paragraph; ?></p>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>CMR Institute of Technology (CMRIT) is one of the premier engineering colleges in Hyderabad, offering undergraduate and postgraduate programs in various disciplines of engineering and technology. Established with a vision to impart quality education, CMRIT has emerged as a center of excellence in technical education.</p>
                    <p>The institute is committed to providing a conducive learning environment with state-of-the-art infrastructure, experienced faculty, and industry-relevant curriculum to prepare students for successful careers in the global marketplace.</p>
                <?php endif; ?>
                <a href="about.php" class="btn">Read More</a>
            </div>
            <div class="about-image">
                <img src="https://picsum.photos/id/513/800/600" alt="CMRIT Campus">
            </div>
        </div>
    </div>
</section>

<!-- Programs Section -->
<section class="programs-section" id="program">
    <div class="container">
        <div class="section-title">
            <h2>Our <span>Programs</span></h2>
        </div>
        <div class="programs-grid">
            <?php if ($programs): ?>
                <?php foreach ($programs as $program): ?>
                    <div class="program-card">
                        <div class="program-icon">
                            <i class="<?php echo $program['icon_class']; ?>"></i>
                        </div>
                        <h3><?php echo $program['title']; ?></h3>
                        <p><?php echo $program['short_description']; ?></p>
                        <a href="program.php?slug=<?php echo $program['slug']; ?>" class="btn-link">Learn More <i class="fas fa-arrow-right"></i></a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Fallback programs if no data in database -->
                <div class="program-card">
                    <div class="program-icon">
                        <i class="fas fa-laptop-code"></i>
                    </div>
                    <h3>Computer Science Engineering</h3>
                    <p>Cutting-edge curriculum covering software development, artificial intelligence, data science, and more.</p>
                    <a href="#" class="btn-link">Learn More <i class="fas fa-arrow-right"></i></a>
                </div>
                <div class="program-card">
                    <div class="program-icon">
                        <i class="fas fa-microchip"></i>
                    </div>
                    <h3>Electronics & Communication</h3>
                    <p>Comprehensive program covering electronic systems, communication networks, signal processing, and more.</p>
                    <a href="#" class="btn-link">Learn More <i class="fas fa-arrow-right"></i></a>
                </div>
                <div class="program-card">
                    <div class="program-icon">
                        <i class="fas fa-cogs"></i>
                    </div>
                    <h3>Mechanical Engineering</h3>
                    <p>Hands-on training in design, manufacturing, thermal engineering, and automation technologies.</p>
                    <a href="#" class="btn-link">Learn More <i class="fas fa-arrow-right"></i></a>
                </div>
                <div class="program-card">
                    <div class="program-icon">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <h3>Electrical Engineering</h3>
                    <p>Comprehensive curriculum covering power systems, control systems, electrical machines, and more.</p>
                    <a href="#" class="btn-link">Learn More <i class="fas fa-arrow-right"></i></a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Campus Facilities Section -->
<section class="facilities-section" id="campus">
    <div class="container">
        <div class="section-title">
            <h2>Campus <span>Facilities</span></h2>
        </div>
        <div class="facilities-grid">
            <?php if ($facilities): ?>
                <?php foreach ($facilities as $facility): ?>
                    <div class="facility-card">
                        <img src="<?php echo $facility['image']; ?>" alt="<?php echo $facility['title']; ?>">
                        <div class="facility-content">
                            <h3><?php echo $facility['title']; ?></h3>
                            <p><?php echo $facility['description']; ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Fallback facilities if no data in database -->
                <div class="facility-card">
                    <img src="https://picsum.photos/id/365/600/400" alt="Library">
                    <div class="facility-content">
                        <h3>Modern Library</h3>
                        <p>Well-stocked library with digital resources and comfortable study spaces.</p>
                    </div>
                </div>
                <div class="facility-card">
                    <img src="https://picsum.photos/id/60/600/400" alt="Laboratory">
                    <div class="facility-content">
                        <h3>Advanced Labs</h3>
                        <p>State-of-the-art laboratories equipped with the latest technology and equipment.</p>
                    </div>
                </div>
                <div class="facility-card">
                    <img src="https://picsum.photos/id/106/600/400" alt="Sports Facilities">
                    <div class="facility-content">
                        <h3>Sports Complex</h3>
                        <p>Comprehensive sports facilities including indoor and outdoor sports arenas.</p>
                    </div>
                </div>
                <div class="facility-card">
                    <img src="https://picsum.photos/id/164/600/400" alt="Hostel">
                    <div class="facility-content">
                        <h3>Hostel Accommodation</h3>
                        <p>Comfortable and secure hostel facilities for boys and girls.</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Achievements Section -->
<section class="achievements-section" id="research">
    <div class="container">
        <div class="section-title">
            <h2>Our <span>Achievements</span></h2>
        </div>
        <div class="achievements-grid">
            <?php if ($achievements): ?>
                <?php foreach ($achievements as $achievement): ?>
                    <div class="achievement-card">
                        <div class="achievement-icon">
                            <i class="<?php echo $achievement['icon_class']; ?>"></i>
                        </div>
                        <div class="achievement-content">
                            <h3><?php echo $achievement['title']; ?></h3>
                            <p><?php echo $achievement['description']; ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Fallback achievements if no data in database -->
                <div class="achievement-card">
                    <div class="achievement-icon">
                        <i class="fas fa-trophy"></i>
                    </div>
                    <div class="achievement-content">
                        <h3>NAAC Accreditation</h3>
                        <p>Accredited with 'A' grade by National Assessment and Accreditation Council.</p>
                    </div>
                </div>
                <div class="achievement-card">
                    <div class="achievement-icon">
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="achievement-content">
                        <h3>NBA Accreditation</h3>
                        <p>Multiple programs accredited by the National Board of Accreditation.</p>
                    </div>
                </div>
                <div class="achievement-card">
                    <div class="achievement-icon">
                        <i class="fas fa-medal"></i>
                    </div>
                    <div class="achievement-content">
                        <h3>Research Excellence</h3>
                        <p>Recognized for outstanding research contributions and publications.</p>
                    </div>
                </div>
                <div class="achievement-card">
                    <div class="achievement-icon">
                        <i class="fas fa-award"></i>
                    </div>
                    <div class="achievement-content">
                        <h3>Industry Partnerships</h3>
                        <p>Strong collaborations with leading industry partners for training and placements.</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="testimonials-section" id="student">
    <div class="container">
        <div class="section-title">
            <h2>Student <span>Testimonials</span></h2>
        </div>
        <div class="testimonials-slider">
            <?php if ($testimonials): ?>
                <?php foreach ($testimonials as $index => $testimonial): ?>
                    <div class="testimonial <?php echo ($index === 0) ? 'active' : ''; ?>">
                        <div class="testimonial-content">
                            <p>"<?php echo $testimonial['content']; ?>"</p>
                            <div class="testimonial-author">
                                <img src="<?php echo $testimonial['image']; ?>" alt="<?php echo $testimonial['name']; ?>">
                                <div class="author-info">
                                    <h4><?php echo $testimonial['name']; ?></h4>
                                    <p><?php echo $testimonial['position']; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Fallback testimonials if no data in database -->
                <div class="testimonial active">
                    <div class="testimonial-content">
                        <p>"My experience at CMRIT has been transformative. The faculty's guidance and the practical exposure have prepared me well for the industry."</p>
                        <div class="testimonial-author">
                            <img src="https://picsum.photos/id/1012/200/200" alt="Student">
                            <div class="author-info">
                                <h4>Rahul Sharma</h4>
                                <p>CSE Graduate, 2023</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="testimonial">
                    <div class="testimonial-content">
                        <p>"The infrastructure and facilities at CMRIT are excellent. The campus provides a perfect environment for learning and overall development."</p>
                        <div class="testimonial-author">
                            <img src="https://picsum.photos/id/1027/200/200" alt="Student">
                            <div class="author-info">
                                <h4>Priya Patel</h4>
                                <p>ECE Graduate, 2022</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="testimonial">
                    <div class="testimonial-content">
                        <p>"The placement support at CMRIT is outstanding. The training programs and industry interactions helped me secure a great job."</p>
                        <div class="testimonial-author">
                            <img src="https://picsum.photos/id/1025/200/200" alt="Student">
                            <div class="author-info">
                                <h4>Arun Kumar</h4>
                                <p>ME Graduate, 2023</p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <div class="testimonial-controls">
            <button class="prev-btn"><i class="fas fa-chevron-left"></i></button>
            <button class="next-btn"><i class="fas fa-chevron-right"></i></button>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="contact-section" id="contact">
    <div class="container">
        <div class="section-title">
            <h2>Contact <span>Us</span></h2>
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
                    $subject = isset($_POST['subject']) ? clean($_POST['subject']) : '';
                    $message = isset($_POST['message']) ? clean($_POST['message']) : '';
                    
                    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
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
                        <p>Thank you for your message! We will get back to you soon.</p>
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
                        <input type="text" name="subject" placeholder="Subject" required value="<?php echo isset($_POST['subject']) ? clean($_POST['subject']) : ''; ?>">
                    </div>
                    <div class="form-group">
                        <textarea name="message" placeholder="Your Message" required><?php echo isset($_POST['message']) ? clean($_POST['message']) : ''; ?></textarea>
                    </div>
                    <button type="submit" name="contact_submit" class="btn">Send Message</button>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Admin Button Section -->
<div class="admin-section">
    <div class="container">
        <div class="admin-button-container">
            <a href="admin/" class="admin-btn">Admin Login</a>
        </div>
    </div>
</div>

<?php
// Include footer
include 'includes/footer.php';
?> 