# CMR Institute of Technology Website

This is a dynamic website for CMR Institute of Technology, a premier engineering college in Hyderabad. The website is built using PHP, MySQL, HTML, CSS, and JavaScript.

## Features

- Responsive design that works on all devices
- Modern and clean user interface
- Interactive elements like sliders and testimonials
- Mobile-friendly navigation
- Contact form for inquiries
- Admin panel for content management
- Database-driven dynamic content

## Pages/Sections

1. **Home Page**
   - Hero slider with call-to-action buttons
   - About section
   - Programs offered
   - Campus facilities
   - Achievements
   - Student testimonials
   - Contact information

2. **Program Detail Pages**
   - Detailed information about each program
   - Enquiry form

3. **Admin Panel**
   - Dashboard with statistics
   - Content management for all sections
   - User management
   - Message management
   - Settings

## Technologies Used

- PHP 7.4+
- MySQL 5.7+
- HTML5
- CSS3 (with CSS variables for theming)
- JavaScript (ES6+)
- Font Awesome for icons
- Google Fonts

## Setup and Installation

1. **Database Setup**
   - Create a MySQL database named `cmrit_db`
   - Import the database schema from `includes/db_setup.php`
   - Import sample data from `includes/sample_data.php`

2. **Configuration**
   - Update database credentials in `includes/config.php`
   - Update site URL and other settings in `includes/config.php`

3. **Web Server**
   - Configure your web server to point to the `website` directory
   - Ensure PHP and MySQL are properly configured

4. **Admin Access**
   - Access the admin panel at `/admin`
   - Default credentials: username: `admin`, password: `admin123`
   - Change the default password immediately after first login

## Project Structure

```
website/
├── admin/                 # Admin panel
│   ├── includes/          # Admin includes
│   ├── index.php          # Admin login
│   ├── dashboard.php      # Admin dashboard
│   └── ...                # Other admin pages
├── css/
│   └── style.css          # Main stylesheet
├── includes/
│   ├── config.php         # Configuration file
│   ├── functions.php      # Helper functions
│   ├── header.php         # Header include
│   ├── footer.php         # Footer include
│   ├── db_setup.php       # Database setup script
│   └── sample_data.php    # Sample data script
├── js/
│   └── script.js          # JavaScript functionality
├── images/                # Image assets
├── index.php              # Main homepage
├── program.php            # Program detail page
├── .htaccess              # Apache configuration
└── README.md              # Project documentation
```

## Customization

- **Colors**: Update the CSS variables in the `:root` selector in `style.css`
- **Fonts**: Change the Google Fonts import in the `<head>` of `header.php`
- **Content**: Use the admin panel to update content

## Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Opera (latest)

## License

This project is available for use under the MIT License.

## Credits

- Design inspired by the original CMR Institute of Technology website
- Icons from Font Awesome
- Fonts from Google Fonts 