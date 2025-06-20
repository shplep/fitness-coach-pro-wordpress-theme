<?php
/**
 * Fitness Coach Pro Theme Functions
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Theme Setup
 */
function fitness_coach_theme_setup() {
    // Add theme support for title tag
    add_theme_support('title-tag');
    
    // Add theme support for post thumbnails
    add_theme_support('post-thumbnails');
    
    // Add theme support for custom logo
    add_theme_support('custom-logo', array(
        'height'      => 100,
        'width'       => 400,
        'flex-width'  => true,
        'flex-height' => true,
    ));
    
    // Add theme support for HTML5 markup
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
    
    // Register navigation menus
    register_nav_menus(array(
        'primary' => esc_html__('Primary Menu', 'fitness-coach'),
        'mobile'  => esc_html__('Mobile Menu', 'fitness-coach'),
    ));
}
add_action('after_setup_theme', 'fitness_coach_theme_setup');

/**
 * Enqueue Styles and Scripts
 */
function fitness_coach_scripts() {
    // Enqueue Google Fonts
    wp_enqueue_style('fitness-coach-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap', array(), null);
    
    // Enqueue theme stylesheet with cache-busting
    $theme_version = wp_get_theme()->get('Version');
    $stylesheet_path = get_stylesheet_directory() . '/style.css';
    $cache_buster = $theme_version . '.' . filemtime($stylesheet_path);
    wp_enqueue_style('fitness-coach-style', get_stylesheet_uri(), array(), $cache_buster);
    
    // Enqueue theme JavaScript with cache-busting
    $js_path = get_template_directory() . '/js/theme.js';
    $js_cache_buster = $theme_version . '.' . filemtime($js_path);
    wp_enqueue_script('fitness-coach-scripts', get_template_directory_uri() . '/js/theme.js', array(), $js_cache_buster, true);
}
add_action('wp_enqueue_scripts', 'fitness_coach_scripts');

/**
 * Register Widget Areas
 */
function fitness_coach_widgets_init() {
    register_sidebar(array(
        'name'          => esc_html__('Footer', 'fitness-coach'),
        'id'            => 'footer-1',
        'description'   => esc_html__('Add widgets here to appear in your footer.', 'fitness-coach'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
}
add_action('widgets_init', 'fitness_coach_widgets_init');

/**
 * Custom Post Type for Testimonials
 */
function fitness_coach_testimonials_post_type() {
    $labels = array(
        'name'                  => 'Testimonials',
        'singular_name'         => 'Testimonial',
        'menu_name'             => 'Testimonials',
        'name_admin_bar'        => 'Testimonial',
        'add_new'               => 'Add New',
        'add_new_item'          => 'Add New Testimonial',
        'new_item'              => 'New Testimonial',
        'edit_item'             => 'Edit Testimonial',
        'view_item'             => 'View Testimonial',
        'all_items'             => 'All Testimonials',
        'search_items'          => 'Search Testimonials',
        'not_found'             => 'No testimonials found.',
        'not_found_in_trash'    => 'No testimonials found in Trash.',
    );

    $args = array(
        'labels'             => $labels,
        'public'             => false,
        'publicly_queryable' => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'testimonial'),
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => null,
        'menu_icon'          => 'dashicons-format-quote',
        'supports'           => array('title', 'editor', 'thumbnail'),
    );

    register_post_type('testimonial', $args);
}
add_action('init', 'fitness_coach_testimonials_post_type');

/**
 * Add Custom Fields for Testimonials
 */
function fitness_coach_testimonial_meta_boxes() {
    add_meta_box(
        'testimonial-details',
        'Testimonial Details',
        'fitness_coach_testimonial_meta_box_callback',
        'testimonial',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'fitness_coach_testimonial_meta_boxes');

function fitness_coach_testimonial_meta_box_callback($post) {
    wp_nonce_field('save_testimonial_meta', 'testimonial_meta_nonce');
    
    $author_name = get_post_meta($post->ID, '_testimonial_author', true);
    $rating = get_post_meta($post->ID, '_testimonial_rating', true);
    $show_rating = get_post_meta($post->ID, '_testimonial_show_rating', true);
    
    // Default to showing rating if not set
    if ($show_rating === '') {
        $show_rating = '1';
    }
    
    echo '<table class="form-table">';
    echo '<tr>';
    echo '<th><label for="testimonial_author">Author Name</label></th>';
    echo '<td><input type="text" id="testimonial_author" name="testimonial_author" value="' . esc_attr($author_name) . '" size="50" /></td>';
    echo '</tr>';
    echo '<tr>';
    echo '<th><label for="testimonial_show_rating">Show Rating</label></th>';
    echo '<td>';
    echo '<input type="checkbox" id="testimonial_show_rating" name="testimonial_show_rating" value="1"' . checked($show_rating, '1', false) . ' />';
    echo '<label for="testimonial_show_rating"> Display star rating for this testimonial</label>';
    echo '</td>';
    echo '</tr>';
    echo '<tr id="rating_row" style="' . ($show_rating !== '1' ? 'display:none;' : '') . '">';
    echo '<th><label for="testimonial_rating">Rating (1-5)</label></th>';
    echo '<td><select id="testimonial_rating" name="testimonial_rating">';
    echo '<option value="">No Rating</option>';
    for ($i = 1; $i <= 5; $i++) {
        echo '<option value="' . $i . '"' . selected($rating, $i, false) . '>' . $i . ' Star' . ($i > 1 ? 's' : '') . '</option>';
    }
    echo '</select></td>';
    echo '</tr>';
    echo '</table>';
    
    // Add JavaScript to show/hide rating field
    echo '<script>
        document.getElementById("testimonial_show_rating").addEventListener("change", function() {
            var ratingRow = document.getElementById("rating_row");
            if (this.checked) {
                ratingRow.style.display = "table-row";
            } else {
                ratingRow.style.display = "none";
            }
        });
    </script>';
}

function fitness_coach_save_testimonial_meta($post_id) {
    if (!isset($_POST['testimonial_meta_nonce']) || !wp_verify_nonce($_POST['testimonial_meta_nonce'], 'save_testimonial_meta')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['testimonial_author'])) {
        update_post_meta($post_id, '_testimonial_author', sanitize_text_field($_POST['testimonial_author']));
    }

    // Save show rating preference
    if (isset($_POST['testimonial_show_rating'])) {
        update_post_meta($post_id, '_testimonial_show_rating', '1');
    } else {
        update_post_meta($post_id, '_testimonial_show_rating', '0');
    }

    if (isset($_POST['testimonial_rating'])) {
        update_post_meta($post_id, '_testimonial_rating', intval($_POST['testimonial_rating']));
    }
}
add_action('save_post', 'fitness_coach_save_testimonial_meta');

/**
 * Customizer Settings
 */
function fitness_coach_customize_register($wp_customize) {
    // Add Section for Header Settings
    $wp_customize->add_section('fitness_coach_header', array(
        'title'    => __('Header Settings', 'fitness-coach'),
        'priority' => 30,
    ));

    // Site Title Display Setting
    $wp_customize->add_setting('fitness_coach_show_site_title', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));

    $wp_customize->add_control('fitness_coach_show_site_title', array(
        'label'   => __('Display Site Title', 'fitness-coach'),
        'description' => __('Show or hide the site title in the header. If unchecked, only the logo (if set) will be displayed.', 'fitness-coach'),
        'section' => 'fitness_coach_header',
        'type'    => 'checkbox',
    ));

    // Add Section for Social Media Settings
    $wp_customize->add_section('fitness_coach_social_media', array(
        'title'    => __('Social Media Links', 'fitness-coach'),
        'priority' => 35,
        'description' => __('Add your social media links. Icons will appear in the footer above the footer links.', 'fitness-coach'),
    ));

    // Discord URL
    $wp_customize->add_setting('fitness_coach_discord_url', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('fitness_coach_discord_url', array(
        'label'       => __('Discord URL', 'fitness-coach'),
        'description' => __('Enter your Discord server invite URL', 'fitness-coach'),
        'section'     => 'fitness_coach_social_media',
        'type'        => 'url',
    ));

    // YouTube URL
    $wp_customize->add_setting('fitness_coach_youtube_url', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('fitness_coach_youtube_url', array(
        'label'       => __('YouTube URL', 'fitness-coach'),
        'description' => __('Enter your YouTube channel URL', 'fitness-coach'),
        'section'     => 'fitness_coach_social_media',
        'type'        => 'url',
    ));

    // Instagram URL
    $wp_customize->add_setting('fitness_coach_instagram_url', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('fitness_coach_instagram_url', array(
        'label'       => __('Instagram URL', 'fitness-coach'),
        'description' => __('Enter your Instagram profile URL', 'fitness-coach'),
        'section'     => 'fitness_coach_social_media',
        'type'        => 'url',
    ));

    // X (Twitter) URL
    $wp_customize->add_setting('fitness_coach_x_url', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('fitness_coach_x_url', array(
        'label'       => __('X (Twitter) URL', 'fitness-coach'),
        'description' => __('Enter your X (formerly Twitter) profile URL', 'fitness-coach'),
        'section'     => 'fitness_coach_social_media',
        'type'        => 'url',
    ));

    // Add Section for Typography Settings
    $wp_customize->add_section('fitness_coach_typography', array(
        'title'    => __('Typography Settings', 'fitness-coach'),
        'priority' => 40,
        'description' => __('Customize fonts and typography for your website.', 'fitness-coach'),
    ));

    // Primary Font (Headings)
    $wp_customize->add_setting('fitness_coach_heading_font', array(
        'default'           => 'Inter',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('fitness_coach_heading_font', array(
        'label'       => __('Heading Font', 'fitness-coach'),
        'description' => __('Enter a Google Font name for headings (e.g., "Roboto", "Open Sans", "Montserrat")', 'fitness-coach'),
        'section'     => 'fitness_coach_typography',
        'type'        => 'text',
    ));

    // Body Font
    $wp_customize->add_setting('fitness_coach_body_font', array(
        'default'           => 'Inter',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('fitness_coach_body_font', array(
        'label'       => __('Body Font', 'fitness-coach'),
        'description' => __('Enter a Google Font name for body text (e.g., "Open Sans", "Lato", "Source Sans Pro")', 'fitness-coach'),
        'section'     => 'fitness_coach_typography',
        'type'        => 'text',
    ));

    // Font Size Scale
    $wp_customize->add_setting('fitness_coach_font_size_scale', array(
        'default'           => '100',
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control('fitness_coach_font_size_scale', array(
        'label'       => __('Font Size Scale (%)', 'fitness-coach'),
        'description' => __('Adjust the overall font size (80-150%). Default is 100%.', 'fitness-coach'),
        'section'     => 'fitness_coach_typography',
        'type'        => 'range',
        'input_attrs' => array(
            'min'  => 80,
            'max'  => 150,
            'step' => 5,
        ),
    ));

    // Heading Font Weight
    $wp_customize->add_setting('fitness_coach_heading_weight', array(
        'default'           => '600',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('fitness_coach_heading_weight', array(
        'label'   => __('Heading Font Weight', 'fitness-coach'),
        'section' => 'fitness_coach_typography',
        'type'    => 'select',
        'choices' => array(
            '300' => __('Light (300)', 'fitness-coach'),
            '400' => __('Normal (400)', 'fitness-coach'),
            '500' => __('Medium (500)', 'fitness-coach'),
            '600' => __('Semi-Bold (600)', 'fitness-coach'),
            '700' => __('Bold (700)', 'fitness-coach'),
            '800' => __('Extra Bold (800)', 'fitness-coach'),
        ),
    ));

    // Body Font Weight
    $wp_customize->add_setting('fitness_coach_body_weight', array(
        'default'           => '400',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('fitness_coach_body_weight', array(
        'label'   => __('Body Font Weight', 'fitness-coach'),
        'section' => 'fitness_coach_typography',
        'type'    => 'select',
        'choices' => array(
            '300' => __('Light (300)', 'fitness-coach'),
            '400' => __('Normal (400)', 'fitness-coach'),
            '500' => __('Medium (500)', 'fitness-coach'),
            '600' => __('Semi-Bold (600)', 'fitness-coach'),
        ),
    ));
}
add_action('customize_register', 'fitness_coach_customize_register');

// Enqueue Google Fonts
function fitness_coach_google_fonts() {
    $heading_font = get_theme_mod('fitness_coach_heading_font', 'Inter');
    $body_font = get_theme_mod('fitness_coach_body_font', 'Inter');
    $heading_weight = get_theme_mod('fitness_coach_heading_weight', '600');
    $body_weight = get_theme_mod('fitness_coach_body_weight', '400');
    
    $fonts = array();
    $subsets = 'latin,latin-ext';
    
    // Add heading font with weights
    if ($heading_font) {
        $heading_weights = array($heading_weight);
        // Add additional common weights for headings
        if (!in_array('400', $heading_weights)) $heading_weights[] = '400';
        if (!in_array('700', $heading_weights)) $heading_weights[] = '700';
        $fonts[] = $heading_font . ':' . implode(',', array_unique($heading_weights));
    }
    
    // Add body font with weights (if different from heading font)
    if ($body_font && $body_font !== $heading_font) {
        $body_weights = array($body_weight);
        // Add additional common weights for body text
        if (!in_array('400', $body_weights)) $body_weights[] = '400';
        if (!in_array('700', $body_weights)) $body_weights[] = '700';
        $fonts[] = $body_font . ':' . implode(',', array_unique($body_weights));
    } elseif ($body_font === $heading_font && $body_weight !== $heading_weight) {
        // Same font but different weight, combine weights
        $all_weights = array($heading_weight, $body_weight, '400', '700');
        $fonts = array($body_font . ':' . implode(',', array_unique($all_weights)));
    }
    
    if (!empty($fonts)) {
        $fonts_url = add_query_arg(array(
            'family' => urlencode(implode('|', $fonts)),
            'subset' => urlencode($subsets),
            'display' => 'swap',
        ), 'https://fonts.googleapis.com/css2');
        
        wp_enqueue_style('fitness-coach-google-fonts', $fonts_url, array(), null);
    }
}
add_action('wp_enqueue_scripts', 'fitness_coach_google_fonts');

// Generate custom typography CSS
function fitness_coach_typography_css() {
    $heading_font = get_theme_mod('fitness_coach_heading_font', 'Inter');
    $body_font = get_theme_mod('fitness_coach_body_font', 'Inter');
    $heading_weight = get_theme_mod('fitness_coach_heading_weight', '600');
    $body_weight = get_theme_mod('fitness_coach_body_weight', '400');
    $font_scale = get_theme_mod('fitness_coach_font_size_scale', 100);
    
    $scale_factor = $font_scale / 100;
    
    $css = "
    :root {
        --font-scale: {$scale_factor};
    }
    
    body {
        font-family: '{$body_font}', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        font-weight: {$body_weight};
        font-size: calc(1rem * var(--font-scale));
        line-height: calc(1.6 * var(--font-scale));
    }
    
    h1, h2, h3, h4, h5, h6, .site-title {
        font-family: '{$heading_font}', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        font-weight: {$heading_weight};
    }
    
    h1 {
        font-size: calc(2.5rem * var(--font-scale));
        line-height: calc(1.2 * var(--font-scale));
    }
    
    h2 {
        font-size: calc(2rem * var(--font-scale));
        line-height: calc(1.3 * var(--font-scale));
    }
    
    h3 {
        font-size: calc(1.75rem * var(--font-scale));
        line-height: calc(1.4 * var(--font-scale));
    }
    
    h4 {
        font-size: calc(1.5rem * var(--font-scale));
        line-height: calc(1.4 * var(--font-scale));
    }
    
    h5 {
        font-size: calc(1.25rem * var(--font-scale));
        line-height: calc(1.5 * var(--font-scale));
    }
    
    h6 {
        font-size: calc(1.125rem * var(--font-scale));
        line-height: calc(1.5 * var(--font-scale));
    }
    
    .hero h1 {
        font-size: calc(3rem * var(--font-scale));
    }
    
    .btn {
        font-family: '{$heading_font}', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        font-weight: {$heading_weight};
        font-size: calc(1rem * var(--font-scale));
    }
    
    .nav-link {
        font-family: '{$heading_font}', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        font-weight: {$heading_weight};
        font-size: calc(0.95rem * var(--font-scale));
    }
    
    .feature-card h3 {
        font-size: calc(1.5rem * var(--font-scale));
    }
    
    .testimonial-text {
        font-size: calc(1.1rem * var(--font-scale));
        line-height: calc(1.6 * var(--font-scale));
    }
    
    .testimonial-author {
        font-weight: {$heading_weight};
        font-size: calc(1rem * var(--font-scale));
    }
    
    .section-title {
        font-size: calc(2.5rem * var(--font-scale));
    }
    
    @media (max-width: 768px) {
        h1 {
            font-size: calc(2rem * var(--font-scale));
        }
        
        h2 {
            font-size: calc(1.75rem * var(--font-scale));
        }
        
        .hero h1 {
            font-size: calc(2.5rem * var(--font-scale));
        }
        
        .section-title {
            font-size: calc(2rem * var(--font-scale));
        }
    }
    ";
    
    return $css;
}

// Output custom typography CSS
function fitness_coach_typography_styles() {
    $css = fitness_coach_typography_css();
    echo '<style type="text/css" id="fitness-coach-typography">' . $css . '</style>';
}
add_action('wp_head', 'fitness_coach_typography_styles');

// Add live preview support for customizer
function fitness_coach_customize_preview_js() {
    wp_enqueue_script(
        'fitness-coach-customizer-preview',
        get_template_directory_uri() . '/js/customizer-preview.js',
        array('customize-preview'),
        wp_get_theme()->get('Version'),
        true
    );
}
add_action('customize_preview_init', 'fitness_coach_customize_preview_js');

/**
 * Get Testimonials
 */
function fitness_coach_get_testimonials($limit = -1) {
    $testimonials = get_posts(array(
        'post_type'   => 'testimonial',
        'numberposts' => $limit,
        'post_status' => 'publish',
        'orderby'     => 'menu_order',
        'order'       => 'ASC',
    ));

    return $testimonials;
}

/**
 * Display Star Rating
 */
function fitness_coach_display_rating($rating, $show_rating = true) {
    // Return empty string if rating should not be shown or rating is empty/invalid
    if (!$show_rating || empty($rating) || $rating < 1 || $rating > 5) {
        return '';
    }
    
    $output = '<div class="rating">';
    for ($i = 1; $i <= 5; $i++) {
        if ($i <= $rating) {
            $output .= '<span class="star">★</span>';
        } else {
            $output .= '<span class="star empty">☆</span>';
        }
    }
    $output .= '</div>';
    return $output;
}

/**
 * Menu Fallback Function
 */
function fitness_coach_default_menu() {
    if (current_user_can('manage_options')) {
        echo '<ul id="primary-menu" class="menu">';
        echo '<li><a href="' . esc_url(admin_url('nav-menus.php')) . '">Create a Menu</a></li>';
        echo '</ul>';
    } else {
        echo '<ul id="primary-menu" class="menu">';
        echo '<li><a href="' . esc_url(home_url('/')) . '">Home</a></li>';
        echo '</ul>';
    }
}

/**
 * Handle Contact Form Submission
 */
function fitness_coach_handle_contact_form() {
    if (!isset($_POST['fitness_coach_contact_nonce']) || !wp_verify_nonce($_POST['fitness_coach_contact_nonce'], 'fitness_coach_contact_form')) {
        wp_die('Security check failed');
    }

    $name = sanitize_text_field($_POST['name']);
    $email = sanitize_email($_POST['email']);
    $message = sanitize_textarea_field($_POST['message']);

    if (empty($name) || empty($email) || empty($message)) {
        wp_redirect(add_query_arg('contact', 'error', wp_get_referer()));
        exit;
    }

    // Send email to admin
    $to = get_option('admin_email');
    $subject = 'New Coaching Application from ' . $name;
    $body = "New coaching application:\n\n";
    $body .= "Name: " . $name . "\n";
    $body .= "Email: " . $email . "\n";
    $body .= "Message:\n" . $message;
    
    $headers = array('Content-Type: text/html; charset=UTF-8');

    if (wp_mail($to, $subject, nl2br($body), $headers)) {
        wp_redirect(add_query_arg('contact', 'success', wp_get_referer()));
    } else {
        wp_redirect(add_query_arg('contact', 'error', wp_get_referer()));
    }
    exit;
}
add_action('admin_post_fitness_coach_contact_form', 'fitness_coach_handle_contact_form');
add_action('admin_post_nopriv_fitness_coach_contact_form', 'fitness_coach_handle_contact_form');

/**
 * Display Contact Form Messages
 */
function fitness_coach_contact_form_messages() {
    if (isset($_GET['contact'])) {
        if ($_GET['contact'] == 'success') {
            echo '<div class="contact-message success">Thank you for your message! We will get back to you soon.</div>';
        } elseif ($_GET['contact'] == 'error') {
            echo '<div class="contact-message error">There was an error sending your message. Please try again.</div>';
        }
    }
}

/**
 * Add Contact Form Message Styles
 */
function fitness_coach_contact_form_styles() {
    echo '<style>
        .contact-message {
            padding: 1rem;
            margin-bottom: 2rem;
            border-radius: 0.375rem;
            text-align: center;
            font-weight: 600;
        }
        .contact-message.success {
            background-color: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }
        .contact-message.error {
            background-color: #fee2e2;
            color: #991b1b;
            border: 1px solid #fca5a5;
        }
    </style>';
}
add_action('wp_head', 'fitness_coach_contact_form_styles');

/**
 * Display Social Media Icons
 */
function fitness_coach_social_media_icons() {
    $discord_url = get_theme_mod('fitness_coach_discord_url', '');
    $youtube_url = get_theme_mod('fitness_coach_youtube_url', '');
    $instagram_url = get_theme_mod('fitness_coach_instagram_url', '');
    $x_url = get_theme_mod('fitness_coach_x_url', '');
    
    // Check if any social media URLs are set
    if (empty($discord_url) && empty($youtube_url) && empty($instagram_url) && empty($x_url)) {
        return;
    }
    
    echo '<div class="social-media-icons">';
    
    if (!empty($discord_url)) {
        echo '<a href="' . esc_url($discord_url) . '" target="_blank" rel="noopener noreferrer" class="social-icon discord" aria-label="Discord">';
        echo '<svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M20.317 4.37a19.791 19.791 0 0 0-4.885-1.515.074.074 0 0 0-.079.037c-.21.375-.444.864-.608 1.25a18.27 18.27 0 0 0-5.487 0 12.64 12.64 0 0 0-.617-1.25.077.077 0 0 0-.079-.037A19.736 19.736 0 0 0 3.677 4.37a.07.07 0 0 0-.032.027C.533 9.046-.32 13.58.099 18.057a.082.082 0 0 0 .031.057 19.9 19.9 0 0 0 5.993 3.03.078.078 0 0 0 .084-.028 14.09 14.09 0 0 0 1.226-1.994.076.076 0 0 0-.041-.106 13.107 13.107 0 0 1-1.872-.892.077.077 0 0 1-.008-.128 10.2 10.2 0 0 0 .372-.292.074.074 0 0 1 .077-.01c3.928 1.793 8.18 1.793 12.062 0a.074.074 0 0 1 .078.01c.12.098.246.198.373.292a.077.077 0 0 1-.006.127 12.299 12.299 0 0 1-1.873.892.077.077 0 0 0-.041.107c.36.698.772 1.362 1.225 1.993a.076.076 0 0 0 .084.028 19.839 19.839 0 0 0 6.002-3.03.077.077 0 0 0 .032-.054c.5-5.177-.838-9.674-3.549-13.66a.061.061 0 0 0-.031-.03zM8.02 15.33c-1.183 0-2.157-1.085-2.157-2.419 0-1.333.956-2.419 2.157-2.419 1.21 0 2.176 1.096 2.157 2.42 0 1.333-.956 2.418-2.157 2.418zm7.975 0c-1.183 0-2.157-1.085-2.157-2.419 0-1.333.955-2.419 2.157-2.419 1.21 0 2.176 1.096 2.157 2.42 0 1.333-.946 2.418-2.157 2.418z"/></svg>';
        echo '</a>';
    }
    
    if (!empty($youtube_url)) {
        echo '<a href="' . esc_url($youtube_url) . '" target="_blank" rel="noopener noreferrer" class="social-icon youtube" aria-label="YouTube">';
        echo '<svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>';
        echo '</a>';
    }
    
    if (!empty($instagram_url)) {
        echo '<a href="' . esc_url($instagram_url) . '" target="_blank" rel="noopener noreferrer" class="social-icon instagram" aria-label="Instagram">';
        echo '<svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>';
        echo '</a>';
    }
    
    if (!empty($x_url)) {
        echo '<a href="' . esc_url($x_url) . '" target="_blank" rel="noopener noreferrer" class="social-icon x-twitter" aria-label="X (Twitter)">';
        echo '<svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M18.901 1.153h3.68l-8.04 9.19L24 22.846h-7.406l-5.8-7.584-6.638 7.584H.474l8.6-9.83L0 1.154h7.594l5.243 6.932ZM17.61 20.644h2.039L6.486 3.24H4.298Z"/></svg>';
        echo '</a>';
    }
    
    echo '</div>';
}

/**
 * Include ACF Field Configurations
 */
if (file_exists(get_template_directory() . '/acf-homepage-fields.php')) {
    include_once get_template_directory() . '/acf-homepage-fields.php';
}

if (file_exists(get_template_directory() . '/acf-about-fields.php')) {
    include_once get_template_directory() . '/acf-about-fields.php';
}
?> 