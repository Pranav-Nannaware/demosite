        <!-- Footer Section -->
    <footer class="footer">
        <div class="footer-top">
            <div class="container">
                <div class="footer-grid">
                    <div class="footer-widget">
                        <h3>About <?php echo SITE_NAME; ?></h3>
                        <?php
                        // Get about text from database
                        $stmt = $db->query("SELECT content FROM site_content WHERE content_key = 'footer_about' LIMIT 1");
                        $about = $stmt->fetch(PDO::FETCH_ASSOC);
                        
                        if ($about) {
                            echo '<p>' . $about['content'] . '</p>';
                        } else {
                            // Fallback if no content in database
                            echo '<p>CMR Institute of Technology is committed to providing quality education and fostering innovation in engineering and technology.</p>';
                        }
                        ?>
                        <div class="social-links">
                            <?php
                            // Reuse social links from header
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
                    <div class="footer-widget">
                        <h3>Quick Links</h3>
                        <ul>
                            <?php
                            // Get quick links from database
                            $stmt = $db->query("SELECT * FROM quick_links WHERE section = 'footer_quick_links' AND is_active = 1 ORDER BY display_order LIMIT 7");
                            $quick_links = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            
                            if ($quick_links) {
                                foreach ($quick_links as $link) {
                                    echo '<li><a href="' . $link['url'] . '">' . $link['title'] . '</a></li>';
                                }
                            } else {
                                // Fallback if no links in database
                                ?>
                                <li><a href="index.php">Home</a></li>
                                <li><a href="#about">About Us</a></li>
                                <li><a href="#program">Academics</a></li>
                                <li><a href="#admissions">Admissions</a></li>
                                <li><a href="#research">Research</a></li>
                                <li><a href="#placements">Placements</a></li>
                                <li><a href="#contact">Contact Us</a></li>
                                <?php
                            }
                            ?>
                        </ul>
                    </div>
                    <div class="footer-widget">
                        <h3>Programs</h3>
                        <ul>
                            <?php
                            // Get programs from database
                            $stmt = $db->query("SELECT * FROM programs WHERE is_active = 1 ORDER BY display_order LIMIT 7");
                            $programs = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            
                            if ($programs) {
                                foreach ($programs as $program) {
                                    echo '<li><a href="program.php?id=' . $program['id'] . '">' . $program['title'] . '</a></li>';
                                }
                            } else {
                                // Fallback if no programs in database
                                ?>
                                <li><a href="#">B.Tech in CSE</a></li>
                                <li><a href="#">B.Tech in ECE</a></li>
                                <li><a href="#">B.Tech in Mechanical</a></li>
                                <li><a href="#">B.Tech in Electrical</a></li>
                                <li><a href="#">M.Tech Programs</a></li>
                                <li><a href="#">MBA</a></li>
                                <li><a href="#">Ph.D Programs</a></li>
                                <?php
                            }
                            ?>
                        </ul>
                    </div>
                    <div class="footer-widget">
                        <h3>Contact Info</h3>
                        <ul class="contact-info">
                            <li><i class="fas fa-map-marker-alt"></i> <?php echo SITE_ADDRESS; ?></li>
                            <li><i class="fas fa-phone"></i> <?php echo SITE_PHONE; ?></li>
                            <li><i class="fas fa-envelope"></i> <?php echo SITE_EMAIL; ?></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container">
                <p>&copy; <?php echo date('Y'); ?> <?php echo SITE_NAME; ?>. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    <!-- JavaScript -->
    <script src="js/script.js"></script>
    <?php if (isset($extra_js)) echo $extra_js; ?>
</body>
</html> 