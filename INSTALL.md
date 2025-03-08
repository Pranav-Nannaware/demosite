# Installation Guide for CMRIT Website

This guide will help you set up the CMRIT website on your server.

## Requirements

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache web server with mod_rewrite enabled
- PDO PHP extension
- GD PHP extension (for image processing)

## Installation Steps

### 1. Database Setup

1. Create a new MySQL database:
   ```sql
   CREATE DATABASE cmrit_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```

2. Create a database user (or use an existing one):
   ```sql
   CREATE USER 'cmrit_user'@'localhost' IDENTIFIED BY 'your_password';
   GRANT ALL PRIVILEGES ON cmrit_db.* TO 'cmrit_user'@'localhost';
   FLUSH PRIVILEGES;
   ```

### 2. File Setup

1. Upload all files to your web server's document root or a subdirectory.

2. Set appropriate permissions:
   ```bash
   chmod 755 -R /path/to/website
   chmod 777 -R /path/to/website/images/uploads
   ```

### 3. Configuration

1. Open `includes/config.php` and update the database connection details:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_USER', 'cmrit_user');
   define('DB_PASS', 'your_password');
   define('DB_NAME', 'cmrit_db');
   ```

2. Update the site URL and other settings in the same file:
   ```php
   define('SITE_URL', 'http://your-domain.com');
   define('SITE_NAME', 'CMR Institute of Technology');
   define('SITE_EMAIL', 'info@your-domain.com');
   define('SITE_PHONE', '+91 1234567890');
   define('SITE_ADDRESS', 'Your address here');
   ```

### 4. Database Initialization

1. Run the database setup script by visiting:
   ```
   http://your-domain.com/includes/db_setup.php
   ```

2. Import sample data (optional) by visiting:
   ```
   http://your-domain.com/includes/sample_data.php
   ```

3. After successful setup, delete or restrict access to these files:
   ```bash
   chmod 000 /path/to/website/includes/db_setup.php
   chmod 000 /path/to/website/includes/sample_data.php
   ```

### 5. Admin Access

1. Access the admin panel at:
   ```
   http://your-domain.com/admin/
   ```

2. Log in with the default credentials:
   - Username: `admin`
   - Password: `admin123`

3. **Important**: Change the default password immediately after first login.

### 6. Testing

1. Visit your website's homepage to ensure everything is working correctly.
2. Test the contact form functionality.
3. Verify that all dynamic content is loading properly.

## Troubleshooting

### Common Issues

1. **500 Internal Server Error**
   - Check if mod_rewrite is enabled
   - Verify .htaccess file permissions (644)
   - Check PHP error logs

2. **Database Connection Error**
   - Verify database credentials
   - Check if MySQL server is running
   - Ensure the database user has proper permissions

3. **Blank Page**
   - Enable PHP error reporting in config.php
   - Check PHP error logs
   - Verify PHP version compatibility

### Getting Help

If you encounter any issues during installation, please:

1. Check the error logs in your server
2. Refer to the documentation
3. Contact support at support@your-domain.com

## Security Recommendations

1. Change the default admin password immediately
2. Keep PHP and MySQL updated
3. Use HTTPS for your website
4. Regularly backup your database
5. Restrict access to the admin directory using IP filtering if possible

## Updating

To update the website to a newer version:

1. Backup your database
2. Backup your configuration files
3. Replace the files with the new version
4. Run any database update scripts if provided
5. Test the website functionality

---

Thank you for installing the CMRIT Website. If you have any questions or need assistance, please contact us. 