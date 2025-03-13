<?php
// Include config file
require_once 'includes/config.php';

// Set page title
$page_title = 'About Us';

// Get about us content
$about_content = getSiteContent('about_us_content');
$about_mission = getSiteContent('about_mission');
$about_vision = getSiteContent('about_vision');
$about_values = getSiteContent('about_values');

// Get leadership team
$stmt = $db->query("SELECT * FROM leadership_team ORDER BY display_order");
$leadership_team = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Include header
include 'includes/header.php';
?>

<div class="page-banner">
    <div class="container">
        <h1>About Us</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">About Us</li>
            </ol>
        </nav>
    </div>
</div>

<section class="about-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="about-content">
                    <h2>Welcome to CMR Institute of Technology</h2>
                    <?php echo $about_content; ?>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about-image">
                    <img src="images/campus/campus-main.jpg" alt="CMR Institute of Technology Campus" class="img-fluid rounded">
                </div>
            </div>
        </div>
    </div>
</section>

<section class="mission-vision-section bg-light">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="mission-box">
                    <div class="icon">
                        <i class="fas fa-bullseye"></i>
                    </div>
                    <h3>Our Mission</h3>
                    <p><?php echo $about_mission; ?></p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="vision-box">
                    <div class="icon">
                        <i class="fas fa-eye"></i>
                    </div>
                    <h3>Our Vision</h3>
                    <p><?php echo $about_vision; ?></p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="values-box">
                    <div class="icon">
                        <i class="fas fa-heart"></i>
                    </div>
                    <h3>Our Values</h3>
                    <p><?php echo $about_values; ?></p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php if (count($leadership_team) > 0): ?>
<section class="leadership-section">
    <div class="container">
        <div class="section-title text-center">
            <h2>Our Leadership Team</h2>
            <p>Meet the dedicated professionals who lead our institution</p>
        </div>
        
        <div class="row">
            <?php foreach ($leadership_team as $leader): ?>
            <div class="col-lg-3 col-md-6">
                <div class="team-member">
                    <div class="member-img">
                        <img src="<?php echo $leader['photo_path']; ?>" alt="<?php echo $leader['name']; ?>" class="img-fluid">
                    </div>
                    <div class="member-info">
                        <h4><?php echo $leader['name']; ?></h4>
                        <span><?php echo $leader['position']; ?></span>
                        <p><?php echo $leader['bio']; ?></p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<section class="cta-section bg-primary text-white">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-9">
                <h2>Ready to join our community?</h2>
                <p>Take the first step towards a bright future with CMR Institute of Technology.</p>
            </div>
            <div class="col-lg-3 text-lg-end">
                <a href="admission.php" class="btn btn-light btn-lg">Apply Now</a>
            </div>
        </div>
    </div>
</section>

<?php
// Include footer
include 'includes/footer.php';
?> 