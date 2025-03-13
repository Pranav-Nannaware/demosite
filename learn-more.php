<?php
// Include config file
require_once 'includes/config.php';

// Check if section is provided
if (!isset($_GET['section']) || empty($_GET['section'])) {
    redirect('index.php');
}

$section = clean($_GET['section']);

// Get section content
$section_data = [];
$page_title = 'Learn More';

switch ($section) {
    case 'programs':
        $page_title = 'Our Programs';
        $section_data['title'] = 'Academic Programs';
        $section_data['description'] = getSiteContent('programs_description');
        $section_data['items'] = getPrograms();
        $section_data['view'] = 'programs';
        break;
        
    case 'facilities':
        $page_title = 'Campus Facilities';
        $section_data['title'] = 'Our Facilities';
        $section_data['description'] = getSiteContent('facilities_description');
        $section_data['items'] = getFacilities();
        $section_data['view'] = 'facilities';
        break;
        
    case 'achievements':
        $page_title = 'Our Achievements';
        $section_data['title'] = 'Achievements & Accolades';
        $section_data['description'] = getSiteContent('achievements_description');
        $section_data['items'] = getAchievements();
        $section_data['view'] = 'achievements';
        break;
        
    case 'testimonials':
        $page_title = 'Testimonials';
        $section_data['title'] = 'What Our Students Say';
        $section_data['description'] = getSiteContent('testimonials_description');
        $section_data['items'] = getTestimonials();
        $section_data['view'] = 'testimonials';
        break;
        
    default:
        redirect('index.php');
        break;
}

// Include header
include 'includes/header.php';
?>

<div class="page-banner">
    <div class="container">
        <h1><?php echo $section_data['title']; ?></h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?php echo $section_data['title']; ?></li>
            </ol>
        </nav>
    </div>
</div>

<section class="section-content">
    <div class="container">
        <div class="section-intro text-center mb-5">
            <p class="lead"><?php echo $section_data['description']; ?></p>
        </div>
        
        <?php if ($section_data['view'] === 'programs'): ?>
            <div class="row">
                <?php foreach ($section_data['items'] as $program): ?>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="program-card">
                        <div class="program-header">
                            <h3><?php echo $program['name']; ?></h3>
                            <span class="program-category"><?php echo $program['category']; ?></span>
                        </div>
                        <div class="program-body">
                            <p><?php echo truncateText($program['description'], 150); ?></p>
                            <ul class="program-details">
                                <li><i class="fas fa-clock"></i> Duration: <?php echo $program['duration']; ?></li>
                                <li><i class="fas fa-graduation-cap"></i> Degree: <?php echo $program['degree_type']; ?></li>
                                <?php if (!empty($program['eligibility'])): ?>
                                <li><i class="fas fa-check-circle"></i> Eligibility: <?php echo $program['eligibility']; ?></li>
                                <?php endif; ?>
                            </ul>
                            <a href="program.php?id=<?php echo $program['id']; ?>" class="btn btn-primary">View Details</a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            
        <?php elseif ($section_data['view'] === 'facilities'): ?>
            <div class="row">
                <?php foreach ($section_data['items'] as $facility): ?>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="facility-card">
                        <div class="facility-image">
                            <img src="<?php echo $facility['image_path']; ?>" alt="<?php echo $facility['name']; ?>" class="img-fluid">
                        </div>
                        <div class="facility-content">
                            <h3><?php echo $facility['name']; ?></h3>
                            <p><?php echo $facility['description']; ?></p>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            
        <?php elseif ($section_data['view'] === 'achievements'): ?>
            <div class="achievements-timeline">
                <?php foreach ($section_data['items'] as $index => $achievement): ?>
                <div class="achievement-item <?php echo $index % 2 === 0 ? 'left' : 'right'; ?>">
                    <div class="achievement-content">
                        <div class="achievement-date">
                            <?php echo formatDisplayDate($achievement['achievement_date']); ?>
                        </div>
                        <h3><?php echo $achievement['title']; ?></h3>
                        <p><?php echo $achievement['description']; ?></p>
                        <?php if (!empty($achievement['award_by'])): ?>
                        <div class="achievement-by">
                            Awarded by: <?php echo $achievement['award_by']; ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            
        <?php elseif ($section_data['view'] === 'testimonials'): ?>
            <div class="row">
                <?php foreach ($section_data['items'] as $testimonial): ?>
                <div class="col-lg-6 mb-4">
                    <div class="testimonial-card">
                        <div class="testimonial-content">
                            <p><?php echo $testimonial['content']; ?></p>
                        </div>
                        <div class="testimonial-author">
                            <div class="author-image">
                                <img src="<?php echo $testimonial['photo_path']; ?>" alt="<?php echo $testimonial['name']; ?>">
                            </div>
                            <div class="author-info">
                                <h4><?php echo $testimonial['name']; ?></h4>
                                <p><?php echo $testimonial['role']; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<section class="cta-section bg-primary text-white">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-9">
                <h2>Have questions about our <?php echo strtolower($section_data['title']); ?>?</h2>
                <p>Our team is here to help you with any inquiries you may have.</p>
            </div>
            <div class="col-lg-3 text-lg-end">
                <a href="contact.php" class="btn btn-light btn-lg">Contact Us</a>
            </div>
        </div>
    </div>
</section>

<?php
// Include footer
include 'includes/footer.php';
?> 