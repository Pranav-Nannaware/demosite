<?php
/**
 * Common Functions
 * 
 * This file contains common functions used throughout the website.
 */

/**
 * Get sliders from database
 * 
 * @return array Array of slider data
 */
function getSliders() {
    global $db;
    
    try {
        $stmt = $db->query("SELECT * FROM sliders WHERE is_active = 1 ORDER BY display_order");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Log error
        error_log("Error fetching sliders: " . $e->getMessage());
        return [];
    }
}

/**
 * Get announcements from database
 * 
 * @return array Array of announcement data
 */
function getAnnouncements() {
    global $db;
    
    try {
        $stmt = $db->query("SELECT * FROM announcements WHERE is_active = 1 
                            AND (start_date IS NULL OR start_date <= CURDATE()) 
                            AND (end_date IS NULL OR end_date >= CURDATE())");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Log error
        error_log("Error fetching announcements: " . $e->getMessage());
        return [];
    }
}

/**
 * Get programs from database
 * 
 * @param int $limit Number of programs to return (0 for all)
 * @return array Array of program data
 */
function getPrograms($limit = 0) {
    global $db;
    
    try {
        $query = "SELECT * FROM programs WHERE is_active = 1 ORDER BY display_order";
        if ($limit > 0) {
            $query .= " LIMIT " . (int)$limit;
        }
        
        $stmt = $db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Log error
        error_log("Error fetching programs: " . $e->getMessage());
        return [];
    }
}

/**
 * Get a single program by ID or slug
 * 
 * @param mixed $identifier Program ID or slug
 * @param string $type Type of identifier ('id' or 'slug')
 * @return array|false Program data or false if not found
 */
function getProgram($identifier, $type = 'id') {
    global $db;
    
    try {
        if ($type == 'id') {
            $stmt = $db->prepare("SELECT * FROM programs WHERE id = ? AND is_active = 1");
            $stmt->execute([(int)$identifier]);
        } else {
            $stmt = $db->prepare("SELECT * FROM programs WHERE slug = ? AND is_active = 1");
            $stmt->execute([$identifier]);
        }
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Log error
        error_log("Error fetching program: " . $e->getMessage());
        return false;
    }
}

/**
 * Get facilities from database
 * 
 * @param int $limit Number of facilities to return (0 for all)
 * @return array Array of facility data
 */
function getFacilities($limit = 0) {
    global $db;
    
    try {
        $query = "SELECT * FROM facilities WHERE is_active = 1 ORDER BY display_order";
        if ($limit > 0) {
            $query .= " LIMIT " . (int)$limit;
        }
        
        $stmt = $db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Log error
        error_log("Error fetching facilities: " . $e->getMessage());
        return [];
    }
}

/**
 * Get achievements from database
 * 
 * @param int $limit Number of achievements to return (0 for all)
 * @return array Array of achievement data
 */
function getAchievements($limit = 0) {
    global $db;
    
    try {
        $query = "SELECT * FROM achievements WHERE is_active = 1 ORDER BY display_order";
        if ($limit > 0) {
            $query .= " LIMIT " . (int)$limit;
        }
        
        $stmt = $db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Log error
        error_log("Error fetching achievements: " . $e->getMessage());
        return [];
    }
}

/**
 * Get testimonials from database
 * 
 * @param int $limit Number of testimonials to return (0 for all)
 * @return array Array of testimonial data
 */
function getTestimonials($limit = 0) {
    global $db;
    
    try {
        $query = "SELECT * FROM testimonials WHERE is_active = 1 ORDER BY display_order";
        if ($limit > 0) {
            $query .= " LIMIT " . (int)$limit;
        }
        
        $stmt = $db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Log error
        error_log("Error fetching testimonials: " . $e->getMessage());
        return [];
    }
}

/**
 * Get site content by key
 * 
 * @param string $key Content key
 * @return string|false Content or false if not found
 */
function getSiteContent($key) {
    global $db;
    
    try {
        $stmt = $db->prepare("SELECT content FROM site_content WHERE content_key = ? LIMIT 1");
        $stmt->execute([$key]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $result ? $result['content'] : false;
    } catch (PDOException $e) {
        // Log error
        error_log("Error fetching site content: " . $e->getMessage());
        return false;
    }
}

/**
 * Save contact message to database
 * 
 * @param array $data Contact form data
 * @return bool Success or failure
 */
function saveContactMessage($data) {
    global $db;
    
    try {
        $stmt = $db->prepare("INSERT INTO contact_messages (name, email, subject, message) VALUES (?, ?, ?, ?)");
        $stmt->execute([
            clean($data['name']),
            clean($data['email']),
            clean($data['subject']),
            clean($data['message'])
        ]);
        
        return true;
    } catch (PDOException $e) {
        // Log error
        error_log("Error saving contact message: " . $e->getMessage());
        return false;
    }
}

/**
 * Check if email is valid
 * 
 * @param string $email Email to validate
 * @return bool Valid or invalid
 */
function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Generate page title
 * 
 * @param string $title Page title
 * @return string Formatted page title
 */
function pageTitle($title = '') {
    if (empty($title)) {
        return SITE_NAME . ' - Top Engineering College in Hyderabad';
    }
    
    return $title . ' - ' . SITE_NAME;
}

/**
 * Truncate text to a certain length
 * 
 * @param string $text Text to truncate
 * @param int $length Maximum length
 * @param string $append Text to append if truncated
 * @return string Truncated text
 */
function truncateText($text, $length = 100, $append = '...') {
    if (strlen($text) <= $length) {
        return $text;
    }
    
    $text = substr($text, 0, $length);
    $text = substr($text, 0, strrpos($text, ' '));
    
    return $text . $append;
}

/**
 * Format date for display
 * 
 * @param string $date Date string
 * @param string $format Date format
 * @return string Formatted date
 */
function formatDisplayDate($date, $format = 'F j, Y') {
    return date($format, strtotime($date));
}
?> 