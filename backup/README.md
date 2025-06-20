# Fitness Coach Pro WordPress Theme

A modern, responsive WordPress theme designed specifically for fitness coaches and personal trainers. Built with a clean design that focuses on conversions and user experience.

## Features

- **Responsive Design**: Looks great on all devices (desktop, tablet, mobile)
- **Navigation**: Fixed header with hamburger menu for mobile
- **Customizable Homepage**: Editable content through WordPress Customizer
- **Testimonials System**: Custom post type for managing client testimonials
- **Contact Form**: Built-in contact form with email notifications
- **Professional Design**: Clean, modern aesthetic that builds trust
- **Performance Optimized**: Fast loading with optimized CSS and JavaScript

## Installation

1. Download the theme files
2. Upload the theme folder to your WordPress `/wp-content/themes/` directory
3. Activate the theme through the WordPress admin panel
4. Go to **Appearance > Customize** to set up your content

## Customization

### Homepage Content

Navigate to **Appearance > Customize > Home Page Settings** to customize:

- **Profile Image**: Upload your professional headshot (recommended: 400x400px, square format)
- **Name**: Your name or business name
- **Main Tagline**: Your main value proposition
- **CTA Title**: Call-to-action heading
- **CTA Button Text**: Button text for your main call-to-action
- **CTA Button URL**: Where the button should link to

### Changing Your Profile Photo

1. Go to **Appearance > Customize**
2. Click **Home Page Settings**
3. Click **Profile Image**
4. Click **Select Image** to upload a new photo or choose from your Media Library
5. Click **Publish** to save your changes

### Navigation Menu

1. Go to **Appearance > Menus**
2. Create a new menu
3. Add pages/links to your menu
4. Assign it to the "Primary Menu" location

### Testimonials

1. In your WordPress admin, go to **Testimonials**
2. Click "Add New"
3. Enter the testimonial content in the main editor
4. Fill in the "Author Name" and "Rating" in the Testimonial Details box
5. Publish the testimonial

## Theme Structure

```
fitness-coach-pro/
├── style.css           # Main stylesheet with theme header
├── functions.php       # Theme functions and WordPress integration
├── index.php          # Homepage template
├── page.php           # General page template
├── header.php         # Header template with navigation
├── footer.php         # Footer template
├── js/
│   └── theme.js       # JavaScript for hamburger menu and interactions
└── README.md          # This file
```

## Contact Form

The theme includes a built-in contact form that:
- Validates user input
- Sends emails to the site administrator
- Shows success/error messages
- Includes security nonces for protection

## License

This theme is released under the GPL v2 or later license. 