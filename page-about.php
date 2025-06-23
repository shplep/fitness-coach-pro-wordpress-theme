<?php
/**
 * Template Name: About Page
 * Description: Custom about page template with ACF fields for images and video
 */

get_header(); ?>

<div class="container about-page">
    <?php
    // About page fields
    $about_headline = get_field('about_headline');
    $about_intro = get_field('about_intro');
    $profile_images_title = get_field('profile_images_title');
    $profile_images_2_title = get_field('profile_images_2_title');
    $profile_images_2_gallery = get_field('profile_images_2_gallery');
    $profile_images_2_layout = get_field('profile_images_2_layout');
    $video_section_title = get_field('video_section_title');
    $youtube_video_url = get_field('youtube_video_url');
    $about_story = get_field('about_story');
    $credentials_title = get_field('credentials_title');
    $credentials_list = get_field('credentials_list');
    $personal_touch_title = get_field('personal_touch_title');
    $personal_touch_text = get_field('personal_touch_text');
    $cta_section = get_field('about_cta_section');
    ?>

    <!-- Hero Section -->
    <div class="about-hero">
        <?php if ($about_headline) : ?>
            <h1 class="about-headline"><?php echo esc_html($about_headline); ?></h1>
        <?php else : ?>
            <h1 class="about-headline">About Me</h1>
        <?php endif; ?>
        
        <?php if ($about_intro) : ?>
            <div class="about-intro">
                <p><?php echo wp_kses_post($about_intro); ?></p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Main Content Section -->
    <div class="about-main-content">
        
        <!-- Profile Images Section -->
        <?php if (have_rows('profile_images')) : ?>
            <div class="profile-images-section">
                <h2 class="section-title"><?php echo esc_html($profile_images_title ?: 'Gallery'); ?></h2>
                <div class="profile-images-grid">
                    <?php while (have_rows('profile_images')) : the_row();
                        $image = get_sub_field('image');
                        $caption = get_sub_field('caption');
                        $size = get_sub_field('image_size');
                        
                        // Debug: Show what we're getting (only for admins)
                        if (current_user_can('edit_posts')) {
                            echo '<!-- DEBUG: Image data: ';
                            var_dump($image);
                            echo ' -->';
                            echo '<!-- DEBUG: Caption: ' . $caption . ' -->';
                            echo '<!-- DEBUG: Size: ' . $size . ' -->';
                        }
                    ?>
                        <div class="profile-image-item <?php echo esc_attr($size ? 'size-' . $size : 'size-medium'); ?>">
                            <?php if ($image) : ?>
                                <?php if (is_array($image) && isset($image['url'])) : ?>
                                    <img src="<?php echo esc_url($image['url']); ?>" 
                                         alt="<?php echo esc_attr($image['alt'] ?: ($caption ?: 'Profile image')); ?>"
                                         loading="lazy">
                                <?php elseif (is_numeric($image)) : ?>
                                    <!-- Image is an ID, get URL -->
                                    <?php $image_url = wp_get_attachment_url($image); ?>
                                    <?php if ($image_url) : ?>
                                        <img src="<?php echo esc_url($image_url); ?>" 
                                             alt="<?php echo esc_attr(get_post_meta($image, '_wp_attachment_image_alt', true) ?: ($caption ?: 'Profile image')); ?>"
                                             loading="lazy">
                                    <?php endif; ?>
                                <?php elseif (is_string($image) && filter_var($image, FILTER_VALIDATE_URL)) : ?>
                                    <!-- Image is a URL string -->
                                    <img src="<?php echo esc_url($image); ?>" 
                                         alt="<?php echo esc_attr($caption ?: 'Profile image'); ?>"
                                         loading="lazy">
                                <?php else : ?>
                                    <!-- Debug: Show what type of data we got -->
                                    <?php if (current_user_can('edit_posts')) : ?>
                                        <div class="debug-info" style="background: #ffeeee; padding: 10px; border: 1px solid #ff0000; margin: 10px 0;">
                                            <strong>Debug Info:</strong><br>
                                            Image data type: <?php echo gettype($image); ?><br>
                                            Image data: <?php echo is_scalar($image) ? $image : 'Non-scalar data'; ?>
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>
                                
                                <?php if ($caption) : ?>
                                    <p class="image-caption"><?php echo esc_html($caption); ?></p>
                                <?php endif; ?>
                            <?php else : ?>
                                <!-- No image data found -->
                                <?php if (current_user_can('edit_posts')) : ?>
                                    <div class="debug-info" style="background: #ffffee; padding: 10px; border: 1px solid #ffaa00; margin: 10px 0;">
                                        <strong>No Image Data Found</strong><br>
                                        This usually means the image field is empty or not properly saved.
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        <?php else : ?>
            <!-- Debug: Show if no profile images repeater found -->
            <?php if (current_user_can('edit_posts')) : ?>
                <div class="profile-images-section">
                    <h2 class="section-title"><?php echo esc_html($profile_images_title ?: 'Gallery'); ?></h2>
                    <div class="debug-info" style="background: #eeeeff; padding: 20px; border: 1px solid #0000ff; margin: 20px 0;">
                        <strong>Admin Debug: No Profile Images Found</strong><br>
                        This means either:<br>
                        1. No images have been added to the Profile Images repeater field<br>
                        2. The ACF field group is not properly assigned to this page<br>
                        3. The field name doesn't match<br><br>
                        Current page template: <?php echo get_page_template_slug(); ?><br>
                        Page ID: <?php echo get_the_ID(); ?>
                    </div>
                </div>
                         <?php endif; ?>
        <?php endif; ?>

        <!-- Profile Images 2 Section (Gallery Field Test) -->
        <?php if ($profile_images_2_gallery) : ?>
            <div class="profile-images-2-section">
                <h2 class="section-title"><?php echo esc_html($profile_images_2_title ?: 'Photo Gallery'); ?></h2>
                
                <?php 
                // Debug: Show what gallery data looks like
                if (current_user_can('edit_posts')) {
                    echo '<!-- DEBUG Gallery Data: ';
                    var_dump($profile_images_2_gallery);
                    echo ' -->';
                    echo '<!-- DEBUG Layout: ' . $profile_images_2_layout . ' -->';
                }
                ?>
                
                <div class="profile-images-2-grid layout-<?php echo esc_attr($profile_images_2_layout ?: 'grid'); ?>">
                    <?php foreach ($profile_images_2_gallery as $image) : ?>
                        <div class="profile-image-2-item">
                            <?php if (is_array($image) && isset($image['url'])) : ?>
                                <img src="<?php echo esc_url($image['url']); ?>" 
                                     alt="<?php echo esc_attr($image['alt'] ?: 'Gallery image'); ?>"
                                     title="<?php echo esc_attr($image['title'] ?: ''); ?>"
                                     loading="lazy">
                                <?php if (!empty($image['caption'])) : ?>
                                    <p class="image-caption"><?php echo esc_html($image['caption']); ?></p>
                                <?php endif; ?>
                            <?php elseif (is_numeric($image)) : ?>
                                <!-- Handle ID format -->
                                <?php 
                                $image_url = wp_get_attachment_url($image);
                                $image_alt = get_post_meta($image, '_wp_attachment_image_alt', true);
                                $image_caption = wp_get_attachment_caption($image);
                                ?>
                                <?php if ($image_url) : ?>
                                    <img src="<?php echo esc_url($image_url); ?>" 
                                         alt="<?php echo esc_attr($image_alt ?: 'Gallery image'); ?>"
                                         loading="lazy">
                                    <?php if ($image_caption) : ?>
                                        <p class="image-caption"><?php echo esc_html($image_caption); ?></p>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php else : ?>
                                <!-- Debug unexpected format -->
                                <?php if (current_user_can('edit_posts')) : ?>
                                    <div class="debug-info" style="background: #ffeeee; padding: 10px; border: 1px solid #ff0000;">
                                        <strong>Gallery Debug:</strong><br>
                                        Image type: <?php echo gettype($image); ?><br>
                                        Image data: <?php echo is_scalar($image) ? $image : 'Complex data'; ?>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php else : ?>
            <!-- Debug: Show if no gallery found -->
            <?php if (current_user_can('edit_posts')) : ?>
                <div class="profile-images-2-section">
                    <h2 class="section-title"><?php echo esc_html($profile_images_2_title ?: 'Photo Gallery'); ?></h2>
                    <div class="debug-info" style="background: #eeffee; padding: 20px; border: 1px solid #00aa00;">
                        <strong>Gallery Field Debug: No Images Found</strong><br>
                        Gallery field is empty or not properly configured.<br>
                        Field name: profile_images_2_gallery<br>
                        Expected: Array of image objects
                    </div>
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <!-- Video Introduction Section (Only show if video URL is provided) -->
        <?php if ($youtube_video_url) : ?>
            <div class="video-introduction-section">
                <h2 class="section-title"><?php echo esc_html($video_section_title ?: 'Meet Your Coach'); ?></h2>
                
                <div class="video-container">
                    <?php
                    // Extract YouTube video ID from URL
                    $video_id = '';
                    if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([^&\n?#]+)/', $youtube_video_url, $matches)) {
                        $video_id = $matches[1];
                    }
                    
                    if ($video_id) :
                    ?>
                        <div class="youtube-embed">
                            <iframe 
                                src="https://www.youtube.com/embed/<?php echo esc_attr($video_id); ?>" 
                                title="Introduction Video" 
                                frameborder="0" 
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                allowfullscreen>
                            </iframe>
                        </div>
                    <?php else : ?>
                        <div class="video-placeholder">
                            <span>⚠️ Invalid YouTube URL</span>
                            <p>Please check your YouTube video URL in the admin panel</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- About Story Section -->
        <?php if ($about_story) : ?>
            <div class="about-story-section">
                <h2 class="section-title">My Story</h2>
                <div class="story-content">
                    <?php echo wp_kses_post($about_story); ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Credentials Section -->
        <div class="credentials-section">
            <?php if ($credentials_title) : ?>
                <h2 class="section-title"><?php echo esc_html($credentials_title); ?></h2>
            <?php else : ?>
                <h2 class="section-title">Qualifications & Experience</h2>
            <?php endif; ?>
            
            <?php if (have_rows('credentials_list')) : ?>
                <div class="credentials-grid">
                    <?php while (have_rows('credentials_list')) : the_row();
                        $credential_title = get_sub_field('credential_title');
                        $credential_description = get_sub_field('credential_description');
                        $credential_year = get_sub_field('credential_year');
                        $credential_icon = get_sub_field('credential_icon');
                    ?>
                        <div class="credential-item">
                            <?php if ($credential_icon) : ?>
                                <div class="credential-icon">
                                    <img src="<?php echo esc_url($credential_icon['url']); ?>" alt="<?php echo esc_attr($credential_icon['alt']); ?>">
                                </div>
                            <?php endif; ?>
                            
                            <div class="credential-content">
                                <?php if ($credential_title) : ?>
                                    <h3 class="credential-title"><?php echo esc_html($credential_title); ?></h3>
                                <?php endif; ?>
                                
                                <?php if ($credential_year) : ?>
                                    <span class="credential-year"><?php echo esc_html($credential_year); ?></span>
                                <?php endif; ?>
                                
                                <?php if ($credential_description) : ?>
                                    <p class="credential-description"><?php echo wp_kses_post($credential_description); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else : ?>
                <!-- Default credentials placeholder -->
                <div class="credentials-grid">
                    <div class="credential-item">
                        <div class="credential-content">
                            <h3 class="credential-title">Certified Personal Trainer</h3>
                            <span class="credential-year">2020</span>
                            <p class="credential-description">NASM Certified Personal Trainer with specialization in corrective exercise.</p>
                        </div>
                    </div>
                    <div class="credential-item">
                        <div class="credential-content">
                            <h3 class="credential-title">Nutrition Coach</h3>
                            <span class="credential-year">2021</span>
                            <p class="credential-description">Precision Nutrition Level 1 Certified Coach.</p>
                        </div>
                    </div>
                    <div class="credential-item">
                        <div class="credential-content">
                            <h3 class="credential-title">5+ Years Experience</h3>
                            <span class="credential-year">2018-Present</span>
                            <p class="credential-description">Helping clients achieve sustainable fitness and nutrition goals.</p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Personal Touch Section -->
        <?php if ($personal_touch_title || $personal_touch_text) : ?>
            <div class="personal-touch-section">
                <?php if ($personal_touch_title) : ?>
                    <h2 class="section-title"><?php echo esc_html($personal_touch_title); ?></h2>
                <?php else : ?>
                    <h2 class="section-title">Beyond Fitness</h2>
                <?php endif; ?>
                
                <?php if ($personal_touch_text) : ?>
                    <div class="personal-content">
                        <?php echo wp_kses_post($personal_touch_text); ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <!-- CTA Section -->
        <?php if ($cta_section) : ?>
            <div class="about-cta-section">
                <div class="cta-content">
                    <?php echo wp_kses_post($cta_section); ?>
                </div>
            </div>
        <?php endif; ?>

    </div>
</div>

<?php get_footer(); ?> 