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

        .btn-secondary {
            background-color: #6c757d;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }

        .btn-success {
            background-color: var(--success-color);
        }

        .btn-success:hover {
            background-color: #218838;
        }

        .btn-danger {
            background-color: var(--danger-color);
        }

        .btn-danger:hover {
            background-color: #c82333;
        }
        
        .btn-link {
            color: var(--primary-color);
            font-weight: 600;
            padding: 0;
            background: none;
            margin-right: 10px;
        }
        
        .btn-link:hover {
            color: var(--secondary-color);
            background: none;
            text-decoration: underline;
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

        .badge-success {
            background-color: var(--success-color);
        }

        .badge-danger {
            background-color: var(--danger-color);
        }

        .badge-warning {
            background-color: var(--warning-color);
            color: #212529;
        }

        .badge-secondary {
            background-color: #6c757d;
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
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }
        
        .sidebar-header {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            background-color: rgba(0, 0, 0, 0.2);
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
            border-left: 3px solid transparent;
        }
        
        .sidebar-menu ul li a:hover,
        .sidebar-menu ul li a.active {
            background-color: rgba(255, 255, 255, 0.1);
            color: var(--light-color);
            padding-left: 25px;
            border-left: 3px solid var(--primary-color);
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
            border-radius: 5px;
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
            padding: 5px 10px;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }
        
        .user-dropdown-toggle:hover {
            background-color: var(--gray-color);
        }
        
        .user-dropdown-toggle img {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            margin-right: 10px;
            border: 2px solid var(--primary-color);
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
        
        .user-dropdown-menu ul {
            list-style: none;
            padding: 0;
        }
        
        .user-dropdown-menu ul li {
            border-bottom: 1px solid var(--border-color);
        }
        
        .user-dropdown-menu ul li:last-child {
            border-bottom: none;
        }
        
        .user-dropdown-menu ul li a {
            display: block;
            padding: 10px 15px;
            color: var(--secondary-color);
            transition: background-color 0.3s ease;
        }
        
        .user-dropdown-menu ul li a:hover {
            background-color: var(--gray-color);
        }
        
        .user-dropdown-menu ul li a i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }
        
        .user-dropdown-menu.show {
            display: block;
        }
        
        /* Content Styles */
        .content-container {
            background-color: var(--light-color);
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            overflow: hidden;
        }
        
        .content-header {
            padding: 20px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #f8f9fa;
        }
        
        .content-header h1 {
            font-size: 24px;
            color: var(--secondary-color);
            margin: 0;
        }
        
        .content-actions {
            display: flex;
            gap: 10px;
        }
        
        .content-body {
            padding: 20px;
        }
        
        /* Card Styles */
        .card {
            background-color: var(--light-color);
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
            border: 1px solid var(--border-color);
            overflow: hidden;
        }
        
        .card-header {
            padding: 15px 20px;
            border-bottom: 1px solid var(--border-color);
            background-color: #f8f9fa;
        }
        
        .card-header h2 {
            font-size: 18px;
            color: var(--secondary-color);
            margin: 0;
        }
        
        .card-body {
            padding: 20px;
        }
        
        /* Table Styles */
        .table-responsive {
            overflow-x: auto;
        }
        
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .table th,
        .table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid var(--border-color);
        }
        
        .table th {
            background-color: #f8f9fa;
            font-weight: 600;
            color: var(--secondary-color);
        }
        
        .table tr:last-child td {
            border-bottom: none;
        }
        
        .table tr:hover {
            background-color: rgba(0, 0, 0, 0.02);
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.02);
        }

        .table-hover tbody tr:hover {
            background-color: rgba(0, 0, 0, 0.05);
        }
        
        /* Form Styles */
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--secondary-color);
        }
        
        .form-control {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            font-size: 14px;
            transition: border-color 0.3s ease;
        }
        
        .form-control:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(255, 102, 0, 0.1);
        }
        
        .form-control-file {
            display: block;
            width: 100%;
            padding: 10px 0;
        }
        
        .form-text {
            display: block;
            margin-top: 5px;
            font-size: 12px;
            color: #6c757d;
        }
        
        .form-check {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .form-check-input {
            margin-right: 10px;
        }
        
        .form-check-label {
            font-weight: normal;
        }
        
        /* Alert Styles */
        .alert {
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
            border: 1px solid transparent;
        }
        
        .alert-success {
            background-color: #d4edda;
            border-color: #c3e6cb;
            color: #155724;
        }
        
        .alert-danger {
            background-color: #f8d7da;
            border-color: #f5c6cb;
            color: #721c24;
        }
        
        .alert-warning {
            background-color: #fff3cd;
            border-color: #ffeeba;
            color: #856404;
        }
        
        .alert-info {
            background-color: #d1ecf1;
            border-color: #bee5eb;
            color: #0c5460;
        }

        /* Dashboard Styles */
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
            position: relative;
            display: flex;
            align-items: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border-left: 4px solid var(--primary-color);
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
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
            color: var(--primary-color);
            font-size: 24px;
        }
        
        .stat-content h3 {
            font-size: 16px;
            color: #6c757d;
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

        /* List Group */
        .list-group {
            display: flex;
            flex-direction: column;
            padding-left: 0;
            margin-bottom: 0;
            border-radius: 0.25rem;
        }

        .list-group-item {
            position: relative;
            display: block;
            padding: 0.75rem 1.25rem;
            background-color: #fff;
            border: 1px solid rgba(0, 0, 0, 0.125);
        }

        .list-group-item:first-child {
            border-top-left-radius: inherit;
            border-top-right-radius: inherit;
        }

        .list-group-item:last-child {
            border-bottom-right-radius: inherit;
            border-bottom-left-radius: inherit;
        }

        .list-group-item + .list-group-item {
            border-top-width: 0;
        }

        .list-group-item-action {
            width: 100%;
            color: #495057;
            text-align: inherit;
            text-decoration: none;
        }

        .list-group-item-action:hover, .list-group-item-action:focus {
            z-index: 1;
            color: #495057;
            text-decoration: none;
            background-color: #f8f9fa;
        }

        .list-group-item-action:active {
            color: #212529;
            background-color: #e9ecef;
        }

        /* Grid System */
        .row {
            display: flex;
            flex-wrap: wrap;
            margin-right: -15px;
            margin-left: -15px;
        }

        .col, .col-1, .col-2, .col-3, .col-4, .col-5, .col-6, .col-7, .col-8, .col-9, .col-10, .col-11, .col-12, 
        .col-sm, .col-sm-1, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-10, .col-sm-11, .col-sm-12, 
        .col-md, .col-md-1, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-10, .col-md-11, .col-md-12, 
        .col-lg, .col-lg-1, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-lg-10, .col-lg-11, .col-lg-12 {
            position: relative;
            width: 100%;
            padding-right: 15px;
            padding-left: 15px;
        }

        .col-md-6 {
            flex: 0 0 50%;
            max-width: 50%;
        }

        .col-md-4 {
            flex: 0 0 33.333333%;
            max-width: 33.333333%;
        }

        .col-md-8 {
            flex: 0 0 66.666667%;
            max-width: 66.666667%;
        }

        .mb-4 {
            margin-bottom: 1.5rem !important;
        }

        .mt-4 {
            margin-top: 1.5rem !important;
        }

        .mb-3 {
            margin-bottom: 1rem !important;
        }

        .text-center {
            text-align: center !important;
        }

        .text-danger {
            color: var(--danger-color) !important;
        }

        .img-thumbnail {
            padding: 0.25rem;
            background-color: #fff;
            border: 1px solid #dee2e6;
            border-radius: 0.25rem;
            max-width: 100%;
            height: auto;
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
            transition: transform 0.3s ease;
        }
        
        .message-card:hover {
            transform: translateY(-3px);
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
            background-color: #f9f9f9;
            border-radius: 5px;
            border: 1px dashed #ddd;
        }

        /* Image Preview */
        .image-preview {
            max-width: 100%;
            margin-bottom: 15px;
            border-radius: 5px;
            overflow: hidden;
            border: 1px solid #ddd;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .image-preview img {
            width: 100%;
            height: auto;
            display: block;
        }

        /* Feature Cards */
        .feature-card {
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            padding: 20px;
            margin-bottom: 20px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border-top: 3px solid var(--primary-color);
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .feature-icon {
            width: 60px;
            height: 60px;
            background-color: rgba(255, 102, 0, 0.1);
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 auto 15px;
            color: var(--primary-color);
            font-size: 24px;
        }

        .feature-title {
            font-size: 18px;
            color: var(--secondary-color);
            margin-bottom: 10px;
            text-align: center;
        }

        .feature-description {
            font-size: 14px;
            color: #666;
            text-align: center;
            margin-bottom: 15px;
        }

        .feature-link {
            display: block;
            text-align: center;
            color: var(--primary-color);
            font-weight: 600;
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
                    <li><a href="home-content.php" class="<?php echo $current_page === 'home-content' ? 'active' : ''; ?>"><i class="fas fa-home"></i> Home Content</a></li>
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