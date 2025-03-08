<?php
// Check if user is logged in
if (!isLoggedIn() && basename($_SERVER['PHP_SELF']) !== 'index.php') {
    redirect('index.php');
}

// Get current page
$current_page = getCurrentPage();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title . ' - ' : ''; ?><?php echo SITE_NAME; ?> Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #ff6600;
            --secondary-color: #333333;
            --light-color: #ffffff;
            --dark-color: #222222;
            --gray-color: #f5f5f5;
            --border-color: #e0e0e0;
            --success-color: #28a745;
            --danger-color: #dc3545;
            --warning-color: #ffc107;
            --info-color: #17a2b8;
            --font-primary: 'Arial', sans-serif;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: var(--font-primary);
            background-color: var(--gray-color);
            color: var(--secondary-color);
            line-height: 1.6;
        }
        
        a {
            text-decoration: none;
            color: var(--primary-color);
        }
        
        a:hover {
            color: var(--secondary-color);
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }
        
        .btn {
            display: inline-block;
            padding: 8px 15px;
            background-color: var(--primary-color);
            color: var(--light-color);
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        
        .btn:hover {
            background-color: var(--secondary-color);
            color: var(--light-color);
        }
        
        .btn-link {
            color: var(--primary-color);
            font-weight: 600;
        }
        
        .btn-link:hover {
            color: var(--secondary-color);
        }
        
        .badge {
            display: inline-block;
            padding: 3px 7px;
            background-color: var(--danger-color);
            color: var(--light-color);
            border-radius: 10px;
            font-size: 12px;
            font-weight: bold;
        }
        
        /* Admin Layout */
        .admin-wrapper {
            display: flex;
            min-height: 100vh;
        }
        
        .sidebar {
            width: 250px;
            background-color: var(--secondary-color);
            color: var(--light-color);
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            overflow-y: auto;
            z-index: 1000;
        }
        
        .sidebar-header {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .sidebar-header h1 {
            color: var(--primary-color);
            font-size: 20px;
            margin-bottom: 5px;
        }
        
        .sidebar-header p {
            font-size: 14px;
            color: #ccc;
        }
        
        .sidebar-menu {
            padding: 20px 0;
        }
        
        .sidebar-menu ul {
            list-style: none;
        }
        
        .sidebar-menu ul li {
            margin-bottom: 5px;
        }
        
        .sidebar-menu ul li a {
            display: block;
            padding: 10px 20px;
            color: #ccc;
            transition: all 0.3s ease;
        }
        
        .sidebar-menu ul li a:hover,
        .sidebar-menu ul li a.active {
            background-color: rgba(255, 255, 255, 0.1);
            color: var(--light-color);
            padding-left: 25px;
        }
        
        .sidebar-menu ul li a i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }
        
        .main-content {
            flex: 1;
            margin-left: 250px;
            padding: 20px;
        }
        
        .topbar {
            background-color: var(--light-color);
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        
        .topbar-left h2 {
            font-size: 20px;
            color: var(--secondary-color);
        }
        
        .topbar-right .user-dropdown {
            position: relative;
            display: inline-block;
        }
        
        .user-dropdown-toggle {
            display: flex;
            align-items: center;
            cursor: pointer;
        }
        
        .user-dropdown-toggle img {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            margin-right: 10px;
        }
        
        .user-dropdown-toggle span {
            margin-right: 5px;
        }
        
        .user-dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            background-color: var(--light-color);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 4px;
            width: 200px;
            display: none;
            z-index: 1000;
        }
        
        .user-dropdown-menu.show {
            display: block;
        }
        
        .user-dropdown-menu ul {
            list-style: none;
        }
        
        .user-dropdown-menu ul li a {
            display: block;
            padding: 10px 15px;
            color: var(--secondary-color);
            transition: all 0.3s ease;
        }
        
        .user-dropdown-menu ul li a:hover {
            background-color: var(--gray-color);
        }
        
        .user-dropdown-menu ul li a i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }
        
        /* Dashboard Styles */
        .dashboard-container {
            padding: 20px;
        }
        
        .dashboard-header {
            margin-bottom: 30px;
        }
        
        .dashboard-header h1 {
            font-size: 24px;
            color: var(--secondary-color);
            margin-bottom: 10px;
        }
        
        .dashboard-header p {
            color: #666;
        }
        
        .dashboard-stats {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background-color: var(--light-color);
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 20px;
            display: flex;
            align-items: center;
            position: relative;
        }
        
        .stat-icon {
            width: 60px;
            height: 60px;
            background-color: rgba(255, 102, 0, 0.1);
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-right: 15px;
        }
        
        .stat-icon i {
            font-size: 24px;
            color: var(--primary-color);
        }
        
        .stat-content h3 {
            font-size: 16px;
            color: #666;
            margin-bottom: 5px;
        }
        
        .stat-content p {
            font-size: 24px;
            font-weight: bold;
            color: var(--secondary-color);
        }
        
        .stat-link {
            position: absolute;
            top: 20px;
            right: 20px;
            color: var(--primary-color);
            font-weight: 600;
            font-size: 14px;
        }
        
        .dashboard-recent {
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
        }
        
        .recent-section {
            background-color: var(--light-color);
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        
        .recent-section h2 {
            font-size: 18px;
            color: var(--secondary-color);
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid var(--border-color);
        }
        
        .recent-messages {
            display: grid;
            grid-template-columns: 1fr;
            gap: 15px;
            margin-bottom: 20px;
        }
        
        .message-card {
            background-color: var(--gray-color);
            border-radius: 5px;
            padding: 15px;
            border-left: 3px solid var(--secondary-color);
        }
        
        .message-card.unread {
            border-left-color: var(--primary-color);
            background-color: rgba(255, 102, 0, 0.05);
        }
        
        .message-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }
        
        .message-header h3 {
            font-size: 16px;
            color: var(--secondary-color);
        }
        
        .message-date {
            font-size: 12px;
            color: #666;
        }
        
        .message-sender {
            font-size: 14px;
            margin-bottom: 10px;
            color: #666;
        }
        
        .message-content {
            font-size: 14px;
            margin-bottom: 10px;
            color: var(--secondary-color);
        }
        
        .view-all {
            text-align: center;
            margin-top: 20px;
        }
        
        .no-data {
            text-align: center;
            padding: 20px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="admin-wrapper">
        <div class="sidebar">
            <div class="sidebar-header">
                <h1><?php echo SITE_NAME; ?></h1>
                <p>Admin Panel</p>
            </div>
            <div class="sidebar-menu">
                <ul>
                    <li><a href="dashboard.php" class="<?php echo $current_page === 'dashboard' ? 'active' : ''; ?>"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                    <li><a href="sliders.php" class="<?php echo $current_page === 'sliders' ? 'active' : ''; ?>"><i class="fas fa-images"></i> Sliders</a></li>
                    <li><a href="programs.php" class="<?php echo $current_page === 'programs' ? 'active' : ''; ?>"><i class="fas fa-graduation-cap"></i> Programs</a></li>
                    <li><a href="facilities.php" class="<?php echo $current_page === 'facilities' ? 'active' : ''; ?>"><i class="fas fa-building"></i> Facilities</a></li>
                    <li><a href="achievements.php" class="<?php echo $current_page === 'achievements' ? 'active' : ''; ?>"><i class="fas fa-trophy"></i> Achievements</a></li>
                    <li><a href="testimonials.php" class="<?php echo $current_page === 'testimonials' ? 'active' : ''; ?>"><i class="fas fa-comment"></i> Testimonials</a></li>
                    <li><a href="announcements.php" class="<?php echo $current_page === 'announcements' ? 'active' : ''; ?>"><i class="fas fa-bullhorn"></i> Announcements</a></li>
                    <li><a href="content.php" class="<?php echo $current_page === 'content' ? 'active' : ''; ?>"><i class="fas fa-file-alt"></i> Site Content</a></li>
                    <li><a href="messages.php" class="<?php echo $current_page === 'messages' ? 'active' : ''; ?>"><i class="fas fa-envelope"></i> Messages</a></li>
                    <li><a href="users.php" class="<?php echo $current_page === 'users' ? 'active' : ''; ?>"><i class="fas fa-users"></i> Users</a></li>
                    <li><a href="settings.php" class="<?php echo $current_page === 'settings' ? 'active' : ''; ?>"><i class="fas fa-cog"></i> Settings</a></li>
                </ul>
            </div>
        </div>
        
        <div class="main-content">
            <div class="topbar">
                <div class="topbar-left">
                    <h2><?php echo isset($page_title) ? $page_title : 'Dashboard'; ?></h2>
                </div>
                <div class="topbar-right">
                    <div class="user-dropdown">
                        <div class="user-dropdown-toggle" id="userDropdown">
                            <img src="https://via.placeholder.com/35" alt="User">
                            <span><?php echo $_SESSION['name']; ?></span>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <div class="user-dropdown-menu" id="userDropdownMenu">
                            <ul>
                                <li><a href="profile.php"><i class="fas fa-user"></i> Profile</a></li>
                                <li><a href="settings.php"><i class="fas fa-cog"></i> Settings</a></li>
                                <li><a href="../index.php" target="_blank"><i class="fas fa-external-link-alt"></i> View Site</a></li>
                                <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="content-wrapper"> 