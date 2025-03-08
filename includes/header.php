<?php require_once 'config.php'; ?>
<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?php echo isset($page_title) ? $page_title . ' - ' . SITE_NAME : SITE_NAME . ' - Top Engineering College in Hyderabad'; ?></title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Titillium+Web:wght@400;600;700&family=Lato:wght@400;500;700&family=Roboto:wght@400;500;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <?php if (isset($extra_css)) echo $extra_css; ?>
</head>
<body>
    <!-- Header Section -->
    <header id="header">
        <div class="top-bar">
            <div class="container">
                <div class="contact-info">
                    <span><i class="fas fa-phone"></i> <?php echo SITE_PHONE; ?></span>
                    <span><i class="fas fa-envelope"></i> <?php echo SITE_EMAIL; ?></span>
                </div>
                <div class="social-links">
                    <?php
                    // Get social links from database
                    $stmt = $db->query("SELECT * FROM social_links WHERE is_active = 1 ORDER BY display_order");
                    $social_links = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    
                    if ($social_links) {
                        foreach ($social_links as $link) {
                            echo '<a href="' . $link['url'] . '" target="_blank"><i class="' . $link['icon_class'] . '"></i></a>';
                        }
                    } else {
                        // Fallback if no links in database
                        echo '<a href="#"><i class="fab fa-facebook-f"></i></a>';
                        echo '<a href="#"><i class="fab fa-twitter"></i></a>';
                        echo '<a href="#"><i class="fab fa-instagram"></i></a>';
                        echo '<a href="#"><i class="fab fa-linkedin-in"></i></a>';
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="main-header">
            <div class="container">
                <div class="logo">
                    <a href="index.php">
                        <img src="images/logo.svg" alt="<?php echo SITE_NAME; ?> Logo">
                    </a>
                </div>
                <nav class="main-nav">
                    <ul>
                        <?php
                        // Get menu items from database
                        $stmt = $db->query("SELECT * FROM menu_items WHERE parent_id = 0 AND is_active = 1 ORDER BY display_order");
                        $menu_items = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        
                        if ($menu_items) {
                            $current_page = getCurrentPage();
                            
                            foreach ($menu_items as $item) {
                                $active_class = ($current_page == $item['page_slug']) ? 'class="active"' : '';
                                echo '<li><a href="' . $item['url'] . '" ' . $active_class . '>' . $item['title'] . '</a></li>';
                            }
                        } else {
                            // Fallback navigation if no items in database
                            ?>
                            <li><a href="index.php" <?php echo (getCurrentPage() == 'index') ? 'class="active"' : ''; ?>>Home</a></li>
                            <li><a href="#about">About</a></li>
                            <li><a href="#program">Programs</a></li>
                            <li><a href="#campus">Campus Life</a></li>
                            <li><a href="#research">Research</a></li>
                            <li><a href="#student">Students</a></li>
                            <li><a href="#contact">Contact</a></li>
                            <?php
                        }
                        ?>
                    </ul>
                </nav>
                <div class="mobile-menu-toggle">
                    <i class="fas fa-bars"></i>
                </div>
            </div>
        </div>
    </header>
</body>
</html> 