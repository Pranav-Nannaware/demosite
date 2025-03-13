<?php
/**
 * Sample Data Script
 * 
 * This script populates the database with sample data for the CMRIT website.
 * Run this script after db_setup.php to have a working website with sample content.
 */

require_once 'config.php';

// Array to store SQL queries
$queries = [];

/**************************************
 * WEBSITE CONTENT DATA
 **************************************/

// Sample site content
$queries[] = "INSERT INTO `site_content` (`content_key`, `title`, `content`) VALUES
    ('footer_about', 'About CMRIT', 'CMR Institute of Technology is committed to providing quality education and fostering innovation in engineering and technology.'),
    ('about_section', 'About CMRIT', 'CMR Institute of Technology (CMRIT) is one of the premier engineering colleges in Hyderabad, offering undergraduate and postgraduate programs in various disciplines of engineering and technology. Established with a vision to impart quality education, CMRIT has emerged as a center of excellence in technical education.\r\n\r\nThe institute is committed to providing a conducive learning environment with state-of-the-art infrastructure, experienced faculty, and industry-relevant curriculum to prepare students for successful careers in the global marketplace.');";

// Sample settings
$queries[] = "INSERT INTO `settings` (`setting_key`, `setting_value`, `setting_group`) VALUES
    ('site_title', 'CMR Institute of Technology', 'general'),
    ('site_description', 'CMR Institute of Technology - Shaping the future through quality education and innovation', 'general'),
    ('site_email', 'info@cmrit.edu.in', 'contact'),
    ('site_phone', '+91 40 2726 5656', 'contact'),
    ('site_address', '1-90, Medchal Road, Kandlakoya, Hyderabad, Telangana 501401', 'contact'),
    ('site_logo', 'uploads/logo.png', 'general'),
    ('site_favicon', 'uploads/favicon.ico', 'general'),
    ('footer_copyright', '© 2023 CMR Institute of Technology. All rights reserved.', 'general'),
    ('social_facebook', 'https://facebook.com/cmrit', 'social'),
    ('social_twitter', 'https://twitter.com/cmrit', 'social'),
    ('social_instagram', 'https://instagram.com/cmrit', 'social'),
    ('social_linkedin', 'https://linkedin.com/school/cmrit', 'social');";

// Sample social links
$queries[] = "INSERT INTO `social_links` (`title`, `url`, `icon_class`, `display_order`, `is_active`) VALUES
    ('Facebook', 'https://facebook.com/cmrit', 'fab fa-facebook-f', 1, 1),
    ('Twitter', 'https://twitter.com/cmrit', 'fab fa-twitter', 2, 1),
    ('Instagram', 'https://instagram.com/cmrit', 'fab fa-instagram', 3, 1),
    ('LinkedIn', 'https://linkedin.com/school/cmrit', 'fab fa-linkedin-in', 4, 1);";

// Sample menu items
$queries[] = "INSERT INTO `menu_items` (`title`, `url`, `page_slug`, `parent_id`, `display_order`, `is_active`) VALUES
    ('Home', 'index.php', 'index', 0, 1, 1),
    ('About', '#about', 'about', 0, 2, 1),
    ('Programs', '#program', 'programs', 0, 3, 1),
    ('Campus Life', '#campus', 'campus', 0, 4, 1),
    ('Research', '#research', 'research', 0, 5, 1),
    ('Students', '#student', 'students', 0, 6, 1),
    ('Contact', '#contact', 'contact', 0, 7, 1);";

// Sample quick links
$queries[] = "INSERT INTO `quick_links` (`title`, `url`, `section`, `display_order`, `is_active`) VALUES
    ('Home', 'index.php', 'footer_quick_links', 1, 1),
    ('About Us', '#about', 'footer_quick_links', 2, 1),
    ('Academics', '#program', 'footer_quick_links', 3, 1),
    ('Admissions', '#admissions', 'footer_quick_links', 4, 1),
    ('Research', '#research', 'footer_quick_links', 5, 1),
    ('Placements', '#placements', 'footer_quick_links', 6, 1),
    ('Contact Us', '#contact', 'footer_quick_links', 7, 1);";

/**************************************
 * HOMEPAGE CONTENT DATA
 **************************************/

// Sample sliders
$queries[] = "INSERT INTO `sliders` (`title`, `subtitle`, `button_text`, `button_url`, `image_path`, `display_order`, `is_active`) VALUES
    ('Welcome to CMR Institute of Technology', 'Shaping the future through quality education and innovation', 'Learn More', '#about', 'uploads/sliders/slider1.jpg', 1, 1),
    ('Excellence in Education', 'Providing world-class education and research opportunities', 'Explore Programs', '#program', 'uploads/sliders/slider2.jpg', 2, 1),
    ('Vibrant Campus Life', 'Experience a dynamic and enriching campus environment', 'Campus Tour', '#campus', 'uploads/sliders/slider3.jpg', 3, 1);";

// Sample programs
$queries[] = "INSERT INTO `programs` (`title`, `slug`, `short_description`, `description`, `icon_class`, `display_order`, `is_active`) VALUES
    ('Computer Science Engineering', 'cse', 'Cutting-edge curriculum covering software development, artificial intelligence, data science, and more.', 'The Computer Science Engineering program at CMRIT offers a comprehensive curriculum that covers all aspects of modern computing. From software development to artificial intelligence, data science, and cybersecurity, our program prepares students for successful careers in the rapidly evolving tech industry.\r\n\r\nOur state-of-the-art labs and experienced faculty ensure that students receive both theoretical knowledge and practical skills needed in the industry. The program also includes industry internships and project work to provide real-world experience.', 'fas fa-laptop-code', 1, 1),
    ('Electronics & Communication', 'ece', 'Comprehensive program covering electronic systems, communication networks, signal processing, and more.', 'The Electronics & Communication Engineering program at CMRIT provides students with a strong foundation in electronic systems, communication networks, signal processing, and related fields. Our curriculum is designed to meet the demands of the modern electronics and telecommunications industry.\r\n\r\nStudents gain hands-on experience in our well-equipped laboratories and work on projects that help them apply theoretical concepts to practical problems. The program also includes courses on emerging technologies like IoT, 5G, and embedded systems.', 'fas fa-microchip', 2, 1),
    ('Mechanical Engineering', 'me', 'Hands-on training in design, manufacturing, thermal engineering, and automation technologies.', 'The Mechanical Engineering program at CMRIT offers comprehensive training in design, manufacturing, thermal engineering, and automation technologies. Our curriculum combines theoretical knowledge with practical applications to prepare students for diverse roles in the mechanical engineering field.\r\n\r\nOur well-equipped workshops and laboratories provide students with hands-on experience in areas such as CAD/CAM, fluid mechanics, thermodynamics, and robotics. The program also includes industry visits and internships to expose students to real-world engineering practices.', 'fas fa-cogs', 3, 1),
    ('Electrical Engineering', 'ee', 'Comprehensive curriculum covering power systems, control systems, electrical machines, and more.', 'The Electrical Engineering program at CMRIT offers a comprehensive curriculum covering power systems, control systems, electrical machines, and related areas. Our program is designed to prepare students for careers in power generation, transmission, distribution, and industrial automation.\r\n\r\nStudents work in modern laboratories equipped with the latest software and hardware tools. The program includes courses on renewable energy, smart grids, and electric vehicles to address the evolving needs of the industry. Industrial visits and internships are integral parts of the curriculum.', 'fas fa-bolt', 4, 1);";

// Sample facilities
$queries[] = "INSERT INTO `facilities` (`title`, `description`, `image`, `display_order`, `is_active`) VALUES
    ('Modern Library', 'Well-stocked library with digital resources and comfortable study spaces.', 'uploads/facilities/library.jpg', 1, 1),
    ('Advanced Labs', 'State-of-the-art laboratories equipped with the latest technology and equipment.', 'uploads/facilities/labs.jpg', 2, 1),
    ('Sports Complex', 'Comprehensive sports facilities including indoor and outdoor sports arenas.', 'uploads/facilities/sports.jpg', 3, 1),
    ('Hostel Accommodation', 'Comfortable and secure hostel facilities for boys and girls.', 'uploads/facilities/hostel.jpg', 4, 1);";

// Sample achievements
$queries[] = "INSERT INTO `achievements` (`title`, `description`, `icon_class`, `display_order`, `is_active`) VALUES
    ('NAAC Accreditation', 'Accredited with ''A'' grade by National Assessment and Accreditation Council.', 'fas fa-trophy', 1, 1),
    ('NBA Accreditation', 'Multiple programs accredited by the National Board of Accreditation.', 'fas fa-star', 2, 1),
    ('Research Excellence', 'Recognized for outstanding research contributions and publications.', 'fas fa-medal', 3, 1),
    ('Industry Partnerships', 'Strong collaborations with leading industry partners for training and placements.', 'fas fa-award', 4, 1);";

// Sample testimonials
$queries[] = "INSERT INTO `testimonials` (`name`, `position`, `content`, `image`, `display_order`, `is_active`) VALUES
    ('Rahul Sharma', 'CSE Graduate, 2023', 'My experience at CMRIT has been transformative. The faculty''s guidance and the practical exposure have prepared me well for the industry.', 'uploads/testimonials/student1.jpg', 1, 1),
    ('Priya Patel', 'ECE Graduate, 2022', 'The infrastructure and facilities at CMRIT are excellent. The campus provides a perfect environment for learning and overall development.', 'uploads/testimonials/student2.jpg', 2, 1),
    ('Arun Kumar', 'ME Graduate, 2023', 'The placement support at CMRIT is outstanding. The training programs and industry interactions helped me secure a great job.', 'uploads/testimonials/student3.jpg', 3, 1);";

// Sample announcements
$queries[] = "INSERT INTO `announcements` (`content`, `url`, `start_date`, `end_date`, `is_active`) VALUES
    ('6th International conference on Recent Trends in Machine Learning, IOT, Smart Cities & Applications, 28-29 March 2025, Hyderabad, India.', '#', '2024-10-01', '2025-03-29', 1),
    ('Admissions open for 2024-25 academic year. Apply online before April 30, 2024.', 'admissions.php', '2024-01-01', '2024-04-30', 1),
    ('Campus placement drive by TCS on December 15, 2024. Register at the placement office.', '#', '2024-11-15', '2024-12-15', 1),
    ('Annual Technical Fest 'Technovation 2024' from February 10-12, 2024. Register now!', '#', '2024-01-10', '2024-02-12', 1),
    ('Scholarship applications for meritorious students now open. Last date: November 30, 2024.', '#', '2024-10-01', '2024-11-30', 1);";

/**************************************
 * USER AND INTERACTION DATA
 **************************************/

// Sample contact messages
$queries[] = "INSERT INTO `contact_messages` (`name`, `email`, `subject`, `message`, `is_read`, `created_at`) VALUES
    ('John Doe', 'john.doe@example.com', 'Admission Inquiry', 'I would like to know more about the admission process for B.Tech programs.', 0, NOW() - INTERVAL 2 DAY),
    ('Jane Smith', 'jane.smith@example.com', 'Campus Visit', 'I am interested in visiting your campus. Could you please provide me with the visiting hours?', 1, NOW() - INTERVAL 5 DAY),
    ('Amit Kumar', 'amit.kumar@example.com', 'Placement Opportunities', 'I would like to know about the placement opportunities for ECE students.', 0, NOW() - INTERVAL 1 DAY);";

// Execute all queries
$success = true;
$error_messages = [];

foreach ($queries as $query) {
    try {
        $db->exec($query);
    } catch (PDOException $e) {
        $success = false;
        $error_messages[] = $e->getMessage();
    }
}

// Create sample images
if ($success) {
    try {
        // Create placeholder images for sliders
        $slider_images = [
            '../uploads/sliders/slider1.jpg' => 'https://picsum.photos/id/1015/1920/800',
            '../uploads/sliders/slider2.jpg' => 'https://picsum.photos/id/20/1920/800',
            '../uploads/sliders/slider3.jpg' => 'https://picsum.photos/id/180/1920/800'
        ];
        
        // Create placeholder images for facilities
        $facility_images = [
            '../uploads/facilities/library.jpg' => 'https://picsum.photos/id/365/600/400',
            '../uploads/facilities/labs.jpg' => 'https://picsum.photos/id/60/600/400',
            '../uploads/facilities/sports.jpg' => 'https://picsum.photos/id/106/600/400',
            '../uploads/facilities/hostel.jpg' => 'https://picsum.photos/id/164/600/400'
        ];
        
        // Create placeholder images for testimonials
        $testimonial_images = [
            '../uploads/testimonials/student1.jpg' => 'https://picsum.photos/id/1012/200/200',
            '../uploads/testimonials/student2.jpg' => 'https://picsum.photos/id/1027/200/200',
            '../uploads/testimonials/student3.jpg' => 'https://picsum.photos/id/1025/200/200'
        ];
        
        // Function to download and save image
        function downloadImage($url, $path) {
            if (!file_exists(dirname($path))) {
                mkdir(dirname($path), 0755, true);
            }
            
            if (!file_exists($path)) {
                $image_data = @file_get_contents($url);
                if ($image_data !== false) {
                    file_put_contents($path, $image_data);
                }
            }
        }
        
        // Download all images
        foreach ($slider_images as $path => $url) {
            downloadImage($url, $path);
        }
        
        foreach ($facility_images as $path => $url) {
            downloadImage($url, $path);
        }
        
        foreach ($testimonial_images as $path => $url) {
            downloadImage($url, $path);
        }
    } catch (Exception $e) {
        $error_messages[] = "Warning: Could not download sample images: " . $e->getMessage();
    }
}

// Output result
if ($success) {
    echo "Sample data inserted successfully!";
    echo "<br>You can now view the website with sample content.";
    
    if (!empty($error_messages)) {
        echo "<br><br>Warnings:<br>";
        echo implode("<br>", $error_messages);
    }
} else {
    echo "Error inserting sample data:<br>";
    echo implode("<br>", $error_messages);
}
?> 