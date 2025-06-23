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
                <h2 class="section-title">Gallery</h2>
                <div class="profile-images-grid">
                    <?php while (have_rows('profile_images')) : the_row();
                        $image = get_sub_field('image');
                        $caption = get_sub_field('caption');
                        $size = get_sub_field('image_size'); // 'large', 'medium', 'small'
                    ?>
                        <div class="profile-image-item <?php echo esc_attr($size ? 'size-' . $size : 'size-medium'); ?>">
                            <?php if ($image && isset($image['url'])) : ?>
                                <img src="<?php echo esc_url($image['url']); ?>" 
                                     alt="<?php echo esc_attr($image['alt'] ? $image['alt'] : ($caption ? $caption : 'Profile image')); ?>"
                                     loading="lazy">
                            <?php else : ?>
                                <!-- Placeholder for missing image -->
                                <div class="image-placeholder">
                                    <span>📷</span>
                                    <p>Image not found</p>
                                </div>
                            <?php endif; ?>
                            <?php if ($caption) : ?>
                                <p class="image-caption"><?php echo esc_html($caption); ?></p>
                            <?php endif; ?>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        <?php else : ?>
            <!-- Debug: Show if no images are found -->
            <?php if (current_user_can('edit_posts')) : ?>
                <div class="profile-images-section">
                    <h2 class="section-title">Gallery</h2>
                    <div class="profile-images-grid">
                        <div class="profile-image-item size-large">
                            <div class="image-placeholder">
                                <span>📷</span>
                                <p><strong>Admin Notice:</strong> No profile images found. Please add images in the About page editor under "Profile Images" section.</p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <!-- Video Introduction Section (Only show if video URL is provided) -->
        <?php if ($youtube_video_url) : ?>
            <div class="video-introduction-section">
                <h2 class="section-title">Meet Your Coach</h2>
                
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