<?php
/**
 * Common Functions
 * 
 * This file contains common functions used throughout the website.
 */

/**************************************
 * CONTENT RETRIEVAL FUNCTIONS
 **************************************/

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
 * @param int $limit Number of announcements to get (0 for all)
 * @return array Array of announcement data
 */
function getAnnouncements($limit = 0) {
    global $db;
    
    try {
        $query = "SELECT * FROM announcements WHERE is_active = 1 
                 AND (start_date IS NULL OR start_date <= CURDATE()) 
                 AND (end_date IS NULL OR end_date >= CURDATE())
                 ORDER BY created_at DESC";
                 
        if ($limit > 0) {
            $query .= " LIMIT " . (int)$limit;
        }
        
        $stmt = $db->query($query);
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
 * @param string $key The content key
 * @return string The content or empty string if not found
 */
function getSiteContent($key) {
    global $db;
    
    try {
        $stmt = $db->prepare("SELECT content FROM site_content WHERE content_key = ?");
        $stmt->execute([$key]);
        $content = $stmt->fetchColumn();
        
        return $content !== false ? $content : '';
    } catch (PDOException $e) {
        error_log("Error fetching site content: " . $e->getMessage());
        return '';
    }
}

/**
 * Get setting value by key
 * 
 * @param string $key The setting key
 * @param string $default Default value if setting not found
 * @return string The setting value or default if not found
 */
function getSetting($key, $default = '') {
    global $db;
    
    try {
        $stmt = $db->prepare("SELECT setting_value FROM settings WHERE setting_key = ?");
        $stmt->execute([$key]);
        $value = $stmt->fetchColumn();
        
        return $value !== false ? $value : $default;
    } catch (PDOException $e) {
        error_log("Error fetching setting: " . $e->getMessage());
        return $default;
    }
}

/**
 * Count unread messages
 * 
 * @return int Number of unread messages
 */
function countUnreadMessages() {
    global $db;
    
    try {
        return $db->query("SELECT COUNT(*) FROM contact_messages WHERE is_read = 0")->fetchColumn();
    } catch (PDOException $e) {
        error_log("Error counting unread messages: " . $e->getMessage());
        return 0;
    }
}

/**************************************
 * USER MANAGEMENT FUNCTIONS
 **************************************/

/**
 * Check if user is logged in
 * 
 * @return bool True if logged in, false otherwise
 */
function isLoggedIn() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

/**
 * Check if user is admin
 * 
 * @return bool True if admin, false otherwise
 */
function isAdmin() {
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
}

/**
 * Get user info by ID
 * 
 * @param int $user_id User ID
 * @return array|false User data or false if not found
 */
function getUserById($user_id) {
    global $db;
    
    try {
        $stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$user_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error fetching user: " . $e->getMessage());
        return false;
    }
}

/**
 * Update user's last login time
 * 
 * @param int $user_id User ID
 * @return bool Success status
 */
function updateLastLogin($user_id) {
    global $db;
    
    try {
        $stmt = $db->prepare("UPDATE users SET last_login = NOW() WHERE id = ?");
        return $stmt->execute([$user_id]);
    } catch (PDOException $e) {
        error_log("Error updating last login: " . $e->getMessage());
        return false;
    }
}

/**************************************
 * FORM HANDLING FUNCTIONS
 **************************************/

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
 * Upload a file
 * 
 * @param array $file The $_FILES array element
 * @param string $destination The destination directory
 * @param array $allowed_types Allowed file types
 * @param int $max_size Maximum file size in bytes
 * @return array Result with status and message/filename
 */
function uploadFile($file, $destination, $allowed_types = ['jpg', 'jpeg', 'png', 'gif'], $max_size = 5242880) {
    // Check if file was uploaded
    if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
        return ['status' => false, 'message' => 'No file uploaded or upload error.'];
    }
    
    // Check file size
    if ($file['size'] > $max_size) {
        return ['status' => false, 'message' => 'File is too large. Maximum size is ' . ($max_size / 1024 / 1024) . 'MB.'];
    }
    
    // Check file type
    $file_extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($file_extension, $allowed_types)) {
        return ['status' => false, 'message' => 'Invalid file type. Allowed types: ' . implode(', ', $allowed_types)];
    }
    
    // Create destination directory if it doesn't exist
    if (!file_exists($destination)) {
        mkdir($destination, 0755, true);
    }
    
    // Generate unique filename
    $new_filename = generateRandomString() . '_' . time() . '.' . $file_extension;
    $upload_path = $destination . '/' . $new_filename;
    
    // Move uploaded file
    if (move_uploaded_file($file['tmp_name'], $upload_path)) {
        return ['status' => true, 'filename' => $upload_path];
    } else {
        return ['status' => false, 'message' => 'Failed to move uploaded file.'];
    }
}

/**************************************
 * UTILITY FUNCTIONS
 **************************************/

/**
 * Redirect to a URL
 * 
 * @param string $url The URL to redirect to
 * @return void
 */
function redirect($url) {
    header("Location: $url");
    exit;
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
function formatDate($date, $format = 'M d, Y') {
    if (empty($date)) {
        return '';
    }
    
    $timestamp = strtotime($date);
    return date($format, $timestamp);
}

/**
 * Generate a random string
 * 
 * @param int $length Length of the string
 * @return string Random string
 */
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }
    
    return $randomString;
}
?> 