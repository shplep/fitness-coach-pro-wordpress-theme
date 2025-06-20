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
    
    // Enqueue theme stylesheet
    wp_enqueue_style('fitness-coach-style', get_stylesheet_uri(), array(), wp_get_theme()->get('Version'));
    
    // Enqueue theme JavaScript
    wp_enqueue_script('fitness-coach-scripts', get_template_directory_uri() . '/js/theme.js', array(), wp_get_theme()->get('Version'), true);
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
    
    echo '<table class="form-table">';
    echo '<tr>';
    echo '<th><label for="testimonial_author">Author Name</label></th>';
    echo '<td><input type="text" id="testimonial_author" name="testimonial_author" value="' . esc_attr($author_name) . '" size="50" /></td>';
    echo '</tr>';
    echo '<tr>';
    echo '<th><label for="testimonial_rating">Rating (1-5)</label></th>';
    echo '<td><select id="testimonial_rating" name="testimonial_rating">';
    for ($i = 1; $i <= 5; $i++) {
        echo '<option value="' . $i . '"' . selected($rating, $i, false) . '>' . $i . ' Star' . ($i > 1 ? 's' : '') . '</option>';
    }
    echo '</select></td>';
    echo '</tr>';
    echo '</table>';
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
}
add_action('customize_register', 'fitness_coach_customize_register');

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
function fitness_coach_display_rating($rating) {
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
 * Include ACF Field Configurations
 */
if (file_exists(get_template_directory() . '/acf-homepage-fields.php')) {
    include_once get_template_directory() . '/acf-homepage-fields.php';
}

if (file_exists(get_template_directory() . '/acf-about-fields.php')) {
    include_once get_template_directory() . '/acf-about-fields.php';
}
?> 