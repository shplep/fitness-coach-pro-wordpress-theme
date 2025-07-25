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
    // Enqueue theme stylesheet with cache-busting
    $theme_version = wp_get_theme()->get('Version');
    $stylesheet_path = get_stylesheet_directory() . '/style.css';
    $cache_buster = $theme_version . '.' . filemtime($stylesheet_path);
    wp_enqueue_style('fitness-coach-style', get_stylesheet_uri(), array(), $cache_buster);
    
    // Enqueue theme JavaScript with cache-busting
    $js_path = get_template_directory() . '/js/theme.js';
    $js_cache_buster = $theme_version . '.' . filemtime($js_path);
    wp_enqueue_script('fitness-coach-scripts', get_template_directory_uri() . '/js/theme.js', array(), $js_cache_buster, true);
    
    // Add testimonials carousel JavaScript (only on front page)
    if (is_front_page()) {
        $carousel_js_path = get_template_directory() . '/js/testimonials-carousel.js';
        $carousel_js_cache_buster = $theme_version . '.' . filemtime($carousel_js_path);
        wp_enqueue_script('testimonials-carousel-js', get_template_directory_uri() . '/js/testimonials-carousel.js', array(), $carousel_js_cache_buster, true);
    }
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
 * Load Custom Range Control Class
 */
function fitness_coach_load_customize_controls() {
    /**
     * Custom Range Control with Value Display
     */
    class Fitness_Coach_Range_Control extends WP_Customize_Control {
        public $type = 'range_with_value';
        public $suffix = '';

        public function render_content() {
            $value = $this->value();
            if (empty($value)) {
                $value = $this->setting->default;
            }
            ?>
            <label>
                <?php if (!empty($this->label)) : ?>
                    <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
                <?php endif; ?>
                <?php if (!empty($this->description)) : ?>
                    <span class="description customize-control-description"><?php echo $this->description; ?></span>
                <?php endif; ?>
                <div class="range-slider-container">
                    <input type="range" 
                           <?php $this->input_attrs(); ?> 
                           value="<?php echo esc_attr($value); ?>" 
                           <?php $this->link(); ?>
                           id="<?php echo esc_attr($this->id); ?>"
                           class="range-slider" />
                    <span class="range-value" id="<?php echo esc_attr($this->id); ?>-value">
                        <?php echo esc_html($value . $this->suffix); ?>
                    </span>
                </div>
            </label>
            <script>
            (function($) {
                var slider = $('#<?php echo esc_js($this->id); ?>');
                var valueDisplay = $('#<?php echo esc_js($this->id); ?>-value');
                var suffix = '<?php echo esc_js($this->suffix); ?>';
                
                slider.on('input', function() {
                    valueDisplay.text(this.value + suffix);
                });
            })(jQuery);
            </script>
            <style>
            .range-slider-container {
                display: flex;
                align-items: center;
                gap: 10px;
                margin-top: 5px;
            }
            .range-slider {
                flex: 1;
            }
            .range-value {
                background: #f1f1f1;
                padding: 4px 8px;
                border-radius: 3px;
                font-weight: 600;
                min-width: 45px;
                text-align: center;
                font-size: 12px;
            }
            </style>
            <?php
        }
    }
}
add_action('customize_register', 'fitness_coach_load_customize_controls', 1);

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

    $wp_customize->add_control(new Fitness_Coach_Range_Control($wp_customize, 'fitness_coach_font_size_scale', array(
        'label'       => __('Font Size Scale', 'fitness-coach'),
        'description' => __('Adjust the overall font size (80-150%). Default is 100%.', 'fitness-coach'),
        'section'     => 'fitness_coach_typography',
        'input_attrs' => array(
            'min'  => 80,
            'max'  => 150,
            'step' => 5,
        ),
        'suffix'      => '%',
    )));

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
    
    // Collect all fonts with proper Google Fonts API v2 format
    $font_families = array();
    
    // Add heading font with weights
    if ($heading_font) {
        $heading_weights = array($heading_weight);
        // Add additional common weights for headings
        if (!in_array('400', $heading_weights)) $heading_weights[] = '400';
        if (!in_array('700', $heading_weights)) $heading_weights[] = '700';
        sort($heading_weights);
        
        $font_name = str_replace(' ', '+', $heading_font);
        $font_families[] = $font_name . ':wght@' . implode(';', array_unique($heading_weights));
    }
    
    // Add body font with weights (if different from heading font)
    if ($body_font && $body_font !== $heading_font) {
        $body_weights = array($body_weight);
        // Add additional common weights for body text
        if (!in_array('400', $body_weights)) $body_weights[] = '400';
        if (!in_array('700', $body_weights)) $body_weights[] = '700';
        sort($body_weights);
        
        $font_name = str_replace(' ', '+', $body_font);
        $font_families[] = $font_name . ':wght@' . implode(';', array_unique($body_weights));
    } elseif ($body_font === $heading_font && $body_weight !== $heading_weight) {
        // Same font but different weight, combine weights
        $all_weights = array($heading_weight, $body_weight, '400', '700');
        sort($all_weights);
        
        $font_name = str_replace(' ', '+', $body_font);
        $font_families = array($font_name . ':wght@' . implode(';', array_unique($all_weights)));
    }
    
    if (!empty($font_families)) {
        $fonts_url = 'https://fonts.googleapis.com/css2?family=' . 
                    implode('&family=', $font_families) . 
                    '&display=swap';
        
        wp_enqueue_style('fitness-coach-google-fonts', $fonts_url, array(), null);
        
        // Debug: Add comment to HTML to show what fonts are being loaded
        add_action('wp_head', function() use ($fonts_url, $font_families) {
            echo "\n<!-- Fitness Coach Pro Typography Debug -->\n";
            echo "<!-- Google Fonts URL: " . esc_html($fonts_url) . " -->\n";
            echo "<!-- Font families: " . esc_html(implode(', ', $font_families)) . " -->\n";
            echo "<!-- End Typography Debug -->\n\n";
        });
    }
}
add_action('wp_enqueue_scripts', 'fitness_coach_google_fonts', 5); // Higher priority

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
    
    body.fitness-coach-typography {
        font-family: '{$body_font}', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif !important;
        font-weight: {$body_weight} !important;
        font-size: calc(1rem * var(--font-scale)) !important;
        line-height: calc(1.6 * var(--font-scale)) !important;
    }
    
    /* Also target body without the class for broader compatibility */
    body {
        font-family: '{$body_font}', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif !important;
        font-weight: {$body_weight} !important;
        font-size: calc(1rem * var(--font-scale)) !important;
        line-height: calc(1.6 * var(--font-scale)) !important;
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
    
    // Add debug info
    $heading_font = get_theme_mod('fitness_coach_heading_font', 'Inter');
    $body_font = get_theme_mod('fitness_coach_body_font', 'Inter');
    $font_scale = get_theme_mod('fitness_coach_font_size_scale', 100);
    
    echo "\n<!-- Typography Settings Debug -->\n";
    echo "<!-- Heading Font: " . esc_html($heading_font) . " -->\n";
    echo "<!-- Body Font: " . esc_html($body_font) . " -->\n";
    echo "<!-- Font Scale: " . esc_html($font_scale) . "% -->\n";
    echo "<!-- End Typography Debug -->\n";
    
    echo '<style type="text/css" id="fitness-coach-typography">' . $css . '</style>';
}
add_action('wp_head', 'fitness_coach_typography_styles');

// Add body class for typography
function fitness_coach_body_classes($classes) {
    $classes[] = 'fitness-coach-typography';
    return $classes;
}
add_filter('body_class', 'fitness_coach_body_classes');

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

// Register page templates
function fitness_coach_page_templates($templates) {
    $templates['page-template-how-it-works.php'] = 'How It Works';
    $templates['page-template-image-text-rows.php'] = 'Image and Text Rows';
    return $templates;
}
add_filter('theme_page_templates', 'fitness_coach_page_templates');

// Load page templates  
function fitness_coach_load_page_template($template) {
    global $post;
    
    if ($post) {
        $page_template = get_post_meta($post->ID, '_wp_page_template', true);
        
        if ($page_template == 'page-template-how-it-works.php') {
            $template = get_template_directory() . '/page-template-how-it-works.php';
        } elseif ($page_template == 'page-template-image-text-rows.php') {
            $template = get_template_directory() . '/page-template-image-text-rows.php';
        }
    }
    
    return $template;
}
add_filter('page_template', 'fitness_coach_load_page_template');

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
 * Hide content editor on custom page templates
 */
function fitness_coach_hide_content_editor() {
    // Get current screen
    $screen = get_current_screen();
    
    // Only proceed if we're on a page edit screen
    if (!$screen || $screen->base !== 'post' || $screen->post_type !== 'page') {
        return;
    }
    
    // Get the page ID
    $post_id = isset($_GET['post']) ? $_GET['post'] : (isset($_POST['post_ID']) ? $_POST['post_ID'] : null);
    
    if (!$post_id) {
        return;
    }
    
    // Get the page template
    $template = get_page_template_slug($post_id);
    
    // List of templates where we want to hide the content editor
    $templates_to_hide = array(
        'front-page.php',
        'page-about.php', 
        'page-template-how-it-works.php',
        'page-template-image-text-rows.php'
    );
    
    // Hide content editor if the page uses one of our custom templates
    if (in_array($template, $templates_to_hide)) {
        remove_post_type_support('page', 'editor');
    }
}
add_action('admin_init', 'fitness_coach_hide_content_editor');

/**
 * Alternative method: Hide editor via CSS and JavaScript for custom templates
 */
function fitness_coach_hide_editor_admin_script() {
    $screen = get_current_screen();
    
    // Only on page edit screens
    if (!$screen || $screen->base !== 'post' || $screen->post_type !== 'page') {
        return;
    }
    
    $post_id = isset($_GET['post']) ? $_GET['post'] : null;
    if (!$post_id) {
        return;
    }
    
    $template = get_page_template_slug($post_id);
    
    // List of templates where we want to hide the content editor
    $templates_to_hide = array(
        'front-page.php',
        'page-about.php', 
        'page-template-how-it-works.php',
        'page-template-image-text-rows.php'
    );
    
    if (in_array($template, $templates_to_hide)) {
        ?>
        <style>
            #postdivrich, 
            #wp-content-wrap,
            #wp-content-editor-tools,
            #ed_toolbar {
                display: none !important;
            }
            .acf-postbox {
                margin-top: 20px;
            }
        </style>
        <script>
            jQuery(document).ready(function($) {
                // Hide the content editor
                $('#postdivrich').hide();
                $('#wp-content-wrap').hide();
                $('#wp-content-editor-tools').hide();
                $('#ed_toolbar').hide();
                
                // Also hide any TinyMCE instances
                if (typeof tinymce !== 'undefined') {
                    var editor = tinymce.get('content');
                    if (editor) {
                        $('#wp-content-wrap').hide();
                    }
                }
            });
        </script>
        <?php
    }
}
add_action('admin_head', 'fitness_coach_hide_editor_admin_script');

/**
 * Additional method: Remove editor meta box for custom templates
 */
function fitness_coach_remove_editor_metabox() {
    $post_id = isset($_GET['post']) ? $_GET['post'] : null;
    if (!$post_id) {
        return;
    }
    
    $template = get_page_template_slug($post_id);
    
    // List of templates where we want to hide the content editor
    $templates_to_hide = array(
        'front-page.php',
        'page-about.php', 
        'page-template-how-it-works.php',
        'page-template-image-text-rows.php'
    );
    
    if (in_array($template, $templates_to_hide)) {
        remove_meta_box('postdivrich', 'page', 'normal');
    }
}
add_action('do_meta_boxes', 'fitness_coach_remove_editor_metabox');

/**
 * Add admin notice for custom template pages
 */
function fitness_coach_custom_template_notice() {
    $screen = get_current_screen();
    
    // Only show on page edit screens
    if (!$screen || $screen->base !== 'post' || $screen->post_type !== 'page') {
        return;
    }
    
    $post_id = isset($_GET['post']) ? $_GET['post'] : null;
    if (!$post_id) {
        return;
    }
    
    $template = get_page_template_slug($post_id);
    
    // Show notice for custom templates
    $custom_templates = array(
        'front-page.php' => 'Homepage Template',
        'page-about.php' => 'About Page Template',
        'page-template-how-it-works.php' => 'How It Works Template',
        'page-template-image-text-rows.php' => 'Image and Text Rows Template'
    );
    
    if (array_key_exists($template, $custom_templates)) {
        $template_name = $custom_templates[$template];
        echo '<div class="notice notice-info">';
        echo '<p><strong>' . esc_html($template_name) . '</strong> - Content is managed through the custom fields below. The default content editor is hidden to keep things clean and organized.</p>';
        echo '</div>';
    }
}
add_action('admin_notices', 'fitness_coach_custom_template_notice');

/**
 * Include ACF Field Configurations
 */
if (file_exists(get_template_directory() . '/acf-homepage-fields.php')) {
    include_once get_template_directory() . '/acf-homepage-fields.php';
}

if (file_exists(get_template_directory() . '/acf-about-fields.php')) {
    include_once get_template_directory() . '/acf-about-fields.php';
}

if (file_exists(get_template_directory() . '/acf-how-it-works-fields.php')) {
    include_once get_template_directory() . '/acf-how-it-works-fields.php';
}

if (file_exists(get_template_directory() . '/acf-image-text-rows-fields.php')) {
    include_once get_template_directory() . '/acf-image-text-rows-fields.php';
}

/**
 * Get Step Icon SVG
 */
function fitness_coach_get_step_icon($icon_type) {
    $icons = array(
        'consultation' => '<svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>',
        'planning' => '<svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14,2 14,8 20,8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10,9 9,9 8,9"></polyline></svg>',
        'training' => '<svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 12h-4l-3 9L9 3l-3 9H2"></path></svg>',
        'tracking' => '<svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 3v18h18"></path><path d="M18.7 8l-5.1 5.2-2.8-2.7L7 14.3"></path></svg>',
        'success' => '<svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><path d="M9 12l2 2 4-4"></path></svg>',
        'heart' => '<svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>',
        'star' => '<svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"></polygon></svg>',
        'trophy' => '<svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6"></path><path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18"></path><path d="M4 22h16"></path><path d="M10 14.66V17c0 .55.45 1 1 1h2c.55 0 1-.45 1-1v-2.34"></path><path d="M2 14h20v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2z"></path></svg>',
        'calendar' => '<svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>',
        'clock' => '<svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12,6 12,12 16,14"></polyline></svg>',
    );
    
    return isset($icons[$icon_type]) ? $icons[$icon_type] : $icons['consultation'];
}
?> 