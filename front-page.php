<?php
/**
 * Template Name: Homepage
 * Description: Custom homepage template with ACF fields
 */

get_header(); ?>

<div class="container">
    <?php
    // Hero Section
    $hero_headline = get_field('hero_headline');
    $hero_subheadline = get_field('hero_subheadline');
    $profile_image = get_field('profile_image');
    $profile_name = get_field('profile_name');
    ?>
    
    <!-- Hero/Profile Section -->
    <div class="profile-container">
        <div class="profile-image">
            <?php if ($profile_image) : ?>
                <img src="<?php echo esc_url($profile_image['url']); ?>" alt="<?php echo esc_attr($profile_image['alt']); ?>">
            <?php else : ?>
                <img src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/attachments/gen-images/public/professional-portrait-GZB4Yrq2oxjdqNiK0WbBl2oLbosj0S.png" alt="Profile Picture">
            <?php endif; ?>
        </div>
        
        <?php if ($profile_name) : ?>
            <h1 class="name"><?php echo esc_html($profile_name); ?></h1>
        <?php else : ?>
            <h1 class="name"><?php bloginfo('name'); ?></h1>
        <?php endif; ?>
        
        <?php if ($hero_subheadline) : ?>
            <p class="hero-subheadline"><?php echo esc_html($hero_subheadline); ?></p>
        <?php endif; ?>
    </div>

    <?php
    // Main Tagline Section
    $main_tagline = get_field('main_tagline');
    $supporting_text = get_field('supporting_text');
    ?>
    
    <!-- Main Tagline -->
    <?php if ($main_tagline) : ?>
        <h2 class="tagline"><?php echo esc_html($main_tagline); ?></h2>
    <?php endif; ?>
    
    <?php if ($supporting_text) : ?>
        <div class="supporting-text">
            <p><?php echo wp_kses_post($supporting_text); ?></p>
        </div>
    <?php endif; ?>

    <?php
    // Transformation Images Section
    if (have_rows('transformation_images')) :
    ?>
        <div class="transformation-section">
            <div class="transformation-images">
                <?php while (have_rows('transformation_images')) : the_row();
                    $image = get_sub_field('image');
                    $caption = get_sub_field('caption');
                ?>
                    <div class="transformation-item">
                        <?php if ($image) : ?>
                            <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
                        <?php endif; ?>
                        <?php if ($caption) : ?>
                            <p class="transformation-caption"><?php echo esc_html($caption); ?></p>
                        <?php endif; ?>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    <?php endif; ?>

    <?php
    // Main CTA Section
    $cta_headline = get_field('cta_headline');
    $cta_description = get_field('cta_description');
    $cta_button_text = get_field('cta_button_text');
    $cta_button_url = get_field('cta_button_url');
    ?>
    
    <!-- Main CTA Section -->
    <?php if ($cta_headline || $cta_description || $cta_button_text) : ?>
        <div class="cta-section">
            <?php if ($cta_headline) : ?>
                <h3 class="cta-title"><?php echo esc_html($cta_headline); ?></h3>
            <?php endif; ?>
            
            <?php if ($cta_description) : ?>
                <p class="cta-description"><?php echo wp_kses_post($cta_description); ?></p>
            <?php endif; ?>
            
            <?php if ($cta_button_text && $cta_button_url) : ?>
                <a href="<?php echo esc_url($cta_button_url); ?>" class="button primary-button">
                    <?php echo esc_html($cta_button_text); ?>
                </a>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <?php
    // Feature Boxes Section
    if (have_rows('feature_boxes')) :
    ?>
        <!-- Feature Boxes -->
        <div class="features-container">
            <?php while (have_rows('feature_boxes')) : the_row();
                $title = get_sub_field('title');
                $description = get_sub_field('description');
                $button_text = get_sub_field('button_text');
                $button_url = get_sub_field('button_url');
                $button_style = get_sub_field('button_style'); // primary or secondary
                $icon = get_sub_field('icon');
            ?>
                <div class="feature-box">
                    <?php if ($icon) : ?>
                        <div class="feature-icon">
                            <img src="<?php echo esc_url($icon['url']); ?>" alt="<?php echo esc_attr($icon['alt']); ?>">
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($title) : ?>
                        <h3 class="feature-title"><?php echo esc_html($title); ?></h3>
                    <?php endif; ?>
                    
                    <?php if ($description) : ?>
                        <p class="feature-description"><?php echo wp_kses_post($description); ?></p>
                    <?php endif; ?>
                    
                    <?php if ($button_text && $button_url) : ?>
                        <a href="<?php echo esc_url($button_url); ?>" class="button <?php echo esc_attr($button_style ? $button_style . '-button' : 'primary-button'); ?>">
                            <?php echo esc_html($button_text); ?>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
        </div>
    <?php endif; ?>

    <?php
    // Testimonials Section
    $testimonials_title = get_field('testimonials_title');
    $testimonials_source = get_field('testimonials_source'); // 'post_type' or 'custom'
    $show_dots = get_field('testimonials_show_dots');
    $show_arrows = get_field('testimonials_show_arrows');
    $autoplay_speed = get_field('testimonials_autoplay');
    
    // Set defaults if not set
    $show_dots = ($show_dots !== null) ? $show_dots : true;
    $show_arrows = ($show_arrows !== null) ? $show_arrows : true;
    $autoplay_speed = ($autoplay_speed !== null) ? $autoplay_speed : 6;
    ?>
    
    <!-- Testimonials Section -->
    <div class="testimonials-section">
        <?php if ($testimonials_title) : ?>
            <h2 class="section-title"><?php echo esc_html($testimonials_title); ?></h2>
        <?php else : ?>
            <h2 class="section-title">What My Clients Say</h2>
        <?php endif; ?>
        
        <div class="testimonials-carousel-wrapper">
            <?php if ($show_arrows) : ?>
                <button class="carousel-arrow carousel-prev" aria-label="Previous testimonials">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="15,18 9,12 15,6"></polyline>
                    </svg>
                </button>
            <?php endif; ?>
            
            <div class="testimonials-carousel" 
                 data-autoplay="<?php echo esc_attr($autoplay_speed); ?>"
                 data-show-dots="<?php echo $show_dots ? 'true' : 'false'; ?>"
                 data-show-arrows="<?php echo $show_arrows ? 'true' : 'false'; ?>">
                <div class="testimonials-container">
            <?php if ($testimonials_source === 'custom' && have_rows('custom_testimonials')) : ?>
                <!-- Custom Testimonials for Homepage -->
                <?php while (have_rows('custom_testimonials')) : the_row();
                    $testimonial_text = get_sub_field('testimonial_text');
                    $author_name = get_sub_field('author_name');
                    $rating = get_sub_field('rating');
                    $show_rating = get_sub_field('show_rating');
                ?>
                    <div class="testimonial">
                        <div class="quote-icon">"</div>
                        <?php if ($testimonial_text) : ?>
                            <p class="testimonial-text"><?php echo wp_kses_post($testimonial_text); ?></p>
                        <?php endif; ?>
                        <div class="testimonial-author">
                            <?php if ($author_name) : ?>
                                <p class="author-name"><?php echo esc_html($author_name); ?></p>
                            <?php endif; ?>
                            <?php if ($show_rating && $rating) : ?>
                                <?php echo fitness_coach_display_rating(intval($rating), true); ?>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else : ?>
                <!-- Pull from Testimonials Post Type -->
                <?php
                $testimonials = fitness_coach_get_testimonials();
                
                if (!empty($testimonials)) :
                    foreach ($testimonials as $testimonial) :
                        $author_name = get_post_meta($testimonial->ID, '_testimonial_author', true);
                        $rating = get_post_meta($testimonial->ID, '_testimonial_rating', true);
                        $show_rating = get_post_meta($testimonial->ID, '_testimonial_show_rating', true);
                ?>
                        <div class="testimonial">
                            <div class="quote-icon">"</div>
                            <p class="testimonial-text"><?php echo wp_kses_post($testimonial->post_content); ?></p>
                            <div class="testimonial-author">
                                <p class="author-name"><?php echo esc_html($author_name); ?></p>
                                <?php echo fitness_coach_display_rating(intval($rating), $show_rating === '1'); ?>
                            </div>
                        </div>
                <?php
                    endforeach;
                else :
                    // Fallback testimonials
                ?>
                    <div class="testimonial">
                        <div class="quote-icon">"</div>
                        <p class="testimonial-text">Working with this coach completely transformed my approach to fitness. I've lost 30 pounds and finally found a sustainable routine that works for me.</p>
                        <div class="testimonial-author">
                            <p class="author-name">Sarah Johnson</p>
                            <div class="rating">
                                <span class="star">★</span>
                                <span class="star">★</span>
                                <span class="star">★</span>
                                <span class="star">★</span>
                                <span class="star">★</span>
                            </div>
                        </div>
                    </div>

                    <div class="testimonial">
                        <div class="quote-icon">"</div>
                        <p class="testimonial-text">I tried so many fitness programs before, but this is the first one that actually helped me build lasting habits. The personalized approach makes all the difference.</p>
                        <div class="testimonial-author">
                            <p class="author-name">Michael Torres</p>
                            <div class="rating">
                                <span class="star">★</span>
                                <span class="star">★</span>
                                <span class="star">★</span>
                                <span class="star">★</span>
                                <span class="star">★</span>
                            </div>
                        </div>
                    </div>

                    <div class="testimonial">
                        <div class="quote-icon">"</div>
                        <p class="testimonial-text">The coaching program helped me break through plateaus I'd been stuck at for years. The accountability and expert guidance were exactly what I needed.</p>
                        <div class="testimonial-author">
                            <p class="author-name">Jennifer Lee</p>
                            <div class="rating">
                                <span class="star">★</span>
                                <span class="star">★</span>
                                <span class="star">★</span>
                                <span class="star">★</span>
                                <span class="star">★</span>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
                </div>
            </div>
            
            <?php if ($show_arrows) : ?>
                <button class="carousel-arrow carousel-next" aria-label="Next testimonials">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="9,18 15,12 9,6"></polyline>
                    </svg>
                </button>
            <?php endif; ?>
        </div>
        
        <?php if ($show_dots) : ?>
            <div class="carousel-dots"></div>
        <?php endif; ?>
    </div>

    <?php
    // Contact/Application Section
    $contact_headline = get_field('contact_headline');
    $contact_description = get_field('contact_description');
    $contact_form_type = get_field('contact_form_type');
    $contact_button_text = get_field('contact_button_text');
    $gravity_form_id = get_field('gravity_form_id');
    ?>
    
    <!-- Contact/Application Section -->
    <?php if ($contact_headline || $contact_description || ($contact_form_type && $contact_form_type !== 'none')) : ?>
        <div id="contact" class="contact-section">
            <?php if ($contact_headline) : ?>
                <h2 class="section-title"><?php echo esc_html($contact_headline); ?></h2>
            <?php else : ?>
                <h2 class="section-title">Get Started With Coaching</h2>
            <?php endif; ?>
            
            <?php if ($contact_description) : ?>
                <div class="contact-description">
                    <p><?php echo wp_kses_post($contact_description); ?></p>
                </div>
            <?php endif; ?>
            
            <?php if ($contact_form_type === 'built_in') : ?>
                <?php fitness_coach_contact_form_messages(); ?>
                
                <form class="contact-form" method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                    <input type="hidden" name="action" value="fitness_coach_contact_form">
                    <?php wp_nonce_field('fitness_coach_contact_form', 'fitness_coach_contact_nonce'); ?>
                    <input type="text" name="name" placeholder="Your Name" required>
                    <input type="email" name="email" placeholder="Your Email" required>
                    <textarea name="message" placeholder="Tell me about your fitness goals" required></textarea>
                    <button type="submit" class="button primary-button">
                        <?php echo esc_html($contact_button_text ? $contact_button_text : 'SUBMIT APPLICATION'); ?>
                    </button>
                </form>
                
            <?php elseif ($contact_form_type === 'gravity' && $gravity_form_id) : ?>
                <?php
                // Check if Gravity Forms is active and form exists
                if (class_exists('GFForms') && function_exists('gravity_form')) {
                    // Display Gravity Form
                    gravity_form($gravity_form_id, false, true, false, '', true);
                } else {
                    // Fallback message if Gravity Forms is not active
                    echo '<div class="gravity-form-error">';
                    echo '<p><strong>Note:</strong> Gravity Forms plugin is required to display this form.</p>';
                    if (current_user_can('manage_options')) {
                        echo '<p>Please install and activate Gravity Forms, or switch to the built-in contact form.</p>';
                    }
                    echo '</div>';
                }
                ?>
                
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>

<?php get_footer(); ?> 