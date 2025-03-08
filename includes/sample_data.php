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

// Sample site content
$queries[] = "INSERT INTO `site_content` (`content_key`, `title`, `content`) VALUES
    ('footer_about', 'About CMRIT', 'CMR Institute of Technology is committed to providing quality education and fostering innovation in engineering and technology.'),
    ('about_section', 'About CMRIT', 'CMR Institute of Technology (CMRIT) is one of the premier engineering colleges in Hyderabad, offering undergraduate and postgraduate programs in various disciplines of engineering and technology. Established with a vision to impart quality education, CMRIT has emerged as a center of excellence in technical education.\r\n\r\nThe institute is committed to providing a conducive learning environment with state-of-the-art infrastructure, experienced faculty, and industry-relevant curriculum to prepare students for successful careers in the global marketplace.');";

// Sample quick links
$queries[] = "INSERT INTO `quick_links` (`title`, `url`, `section`, `display_order`, `is_active`) VALUES
    ('Home', 'index.php', 'footer_quick_links', 1, 1),
    ('About Us', '#about', 'footer_quick_links', 2, 1),
    ('Academics', '#program', 'footer_quick_links', 3, 1),
    ('Admissions', '#admissions', 'footer_quick_links', 4, 1),
    ('Research', '#research', 'footer_quick_links', 5, 1),
    ('Placements', '#placements', 'footer_quick_links', 6, 1),
    ('Contact Us', '#contact', 'footer_quick_links', 7, 1);";

// Sample programs
$queries[] = "INSERT INTO `programs` (`title`, `slug`, `short_description`, `description`, `icon_class`, `display_order`, `is_active`) VALUES
    ('Computer Science Engineering', 'cse', 'Cutting-edge curriculum covering software development, artificial intelligence, data science, and more.', 'The Computer Science Engineering program at CMRIT offers a comprehensive curriculum that covers all aspects of modern computing. From software development to artificial intelligence, data science, and cybersecurity, our program prepares students for successful careers in the rapidly evolving tech industry.\r\n\r\nOur state-of-the-art labs and experienced faculty ensure that students receive both theoretical knowledge and practical skills needed in the industry. The program also includes industry internships and project work to provide real-world experience.', 'fas fa-laptop-code', 1, 1),
    ('Electronics & Communication', 'ece', 'Comprehensive program covering electronic systems, communication networks, signal processing, and more.', 'The Electronics & Communication Engineering program at CMRIT provides students with a strong foundation in electronic systems, communication networks, signal processing, and related fields. Our curriculum is designed to meet the demands of the modern electronics and telecommunications industry.\r\n\r\nStudents gain hands-on experience in our well-equipped laboratories and work on projects that help them apply theoretical concepts to practical problems. The program also includes courses on emerging technologies like IoT, 5G, and embedded systems.', 'fas fa-microchip', 2, 1),
    ('Mechanical Engineering', 'me', 'Hands-on training in design, manufacturing, thermal engineering, and automation technologies.', 'The Mechanical Engineering program at CMRIT offers comprehensive training in design, manufacturing, thermal engineering, and automation technologies. Our curriculum combines theoretical knowledge with practical applications to prepare students for diverse roles in the mechanical engineering field.\r\n\r\nOur well-equipped workshops and laboratories provide students with hands-on experience in areas such as CAD/CAM, fluid mechanics, thermodynamics, and robotics. The program also includes industry visits and internships to expose students to real-world engineering practices.', 'fas fa-cogs', 3, 1),
    ('Electrical Engineering', 'ee', 'Comprehensive curriculum covering power systems, control systems, electrical machines, and more.', 'The Electrical Engineering program at CMRIT offers a comprehensive curriculum covering power systems, control systems, electrical machines, and related areas. Our program is designed to prepare students for careers in power generation, transmission, distribution, and industrial automation.\r\n\r\nStudents work in modern laboratories equipped with the latest software and hardware tools. The program includes courses on renewable energy, smart grids, and electric vehicles to address the evolving needs of the industry. Industrial visits and internships are integral parts of the curriculum.', 'fas fa-bolt', 4, 1);";

// Sample facilities
$queries[] = "INSERT INTO `facilities` (`title`, `description`, `image`, `display_order`, `is_active`) VALUES
    ('Modern Library', 'Well-stocked library with digital resources and comfortable study spaces.', 'https://picsum.photos/id/365/600/400', 1, 1),
    ('Advanced Labs', 'State-of-the-art laboratories equipped with the latest technology and equipment.', 'https://picsum.photos/id/60/600/400', 2, 1),
    ('Sports Complex', 'Comprehensive sports facilities including indoor and outdoor sports arenas.', 'https://picsum.photos/id/106/600/400', 3, 1),
    ('Hostel Accommodation', 'Comfortable and secure hostel facilities for boys and girls.', 'https://picsum.photos/id/164/600/400', 4, 1);";

// Sample achievements
$queries[] = "INSERT INTO `achievements` (`title`, `description`, `icon_class`, `display_order`, `is_active`) VALUES
    ('NAAC Accreditation', 'Accredited with ''A'' grade by National Assessment and Accreditation Council.', 'fas fa-trophy', 1, 1),
    ('NBA Accreditation', 'Multiple programs accredited by the National Board of Accreditation.', 'fas fa-star', 2, 1),
    ('Research Excellence', 'Recognized for outstanding research contributions and publications.', 'fas fa-medal', 3, 1),
    ('Industry Partnerships', 'Strong collaborations with leading industry partners for training and placements.', 'fas fa-award', 4, 1);";

// Sample testimonials
$queries[] = "INSERT INTO `testimonials` (`name`, `position`, `content`, `image`, `display_order`, `is_active`) VALUES
    ('Rahul Sharma', 'CSE Graduate, 2023', 'My experience at CMRIT has been transformative. The faculty''s guidance and the practical exposure have prepared me well for the industry.', 'https://picsum.photos/id/1012/200/200', 1, 1),
    ('Priya Patel', 'ECE Graduate, 2022', 'The infrastructure and facilities at CMRIT are excellent. The campus provides a perfect environment for learning and overall development.', 'https://picsum.photos/id/1027/200/200', 2, 1),
    ('Arun Kumar', 'ME Graduate, 2023', 'The placement support at CMRIT is outstanding. The training programs and industry interactions helped me secure a great job.', 'https://picsum.photos/id/1025/200/200', 3, 1);";

// Sample sliders
$queries[] = "INSERT INTO `sliders` (`title`, `subtitle`, `button_text`, `button_url`, `image`, `display_order`, `is_active`) VALUES
    ('Welcome to CMR Institute of Technology', 'Shaping the future through quality education and innovation', 'Learn More', '#about', 'https://picsum.photos/id/1015/1920/800', 1, 1),
    ('Excellence in Education', 'Providing world-class education and research opportunities', 'Explore Programs', '#program', 'https://picsum.photos/id/20/1920/800', 2, 1),
    ('Vibrant Campus Life', 'Experience a dynamic and enriching campus environment', 'Campus Tour', '#campus', 'https://picsum.photos/id/180/1920/800', 3, 1);";

// Sample announcements
$queries[] = "INSERT INTO `announcements` (`content`, `url`, `is_active`) VALUES
    ('6th International conference on Recent Trends in Machine Learning, IOT, Smart Cities & Applications, 28-29 March 2025, Hyderabad, India.', '#', 1);";

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

// Output result
if ($success) {
    echo "Sample data inserted successfully!";
    echo "<br>You can now view the website with sample content.";
} else {
    echo "Error inserting sample data:<br>";
    echo implode("<br>", $error_messages);
}
?> 