<?php get_header(); ?>

    <div class="container">
        <!-- Profile Section -->
        <div class="profile-container">
            <div class="profile-image">
            <?php 
            $profile_image = get_theme_mod('fitness_coach_profile_image');
            if ($profile_image) :
            ?>
                <img src="<?php echo esc_url($profile_image); ?>" alt="Profile Picture">
            <?php else : ?>
                <img src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/attachments/gen-images/public/professional-portrait-GZB4Yrq2oxjdqNiK0WbBl2oLbosj0S.png" alt="Profile Picture">
            <?php endif; ?>
            </div>
        <h1 class="name"><?php echo esc_html(get_theme_mod('fitness_coach_name', 'Your Name')); ?></h1>
        </div>

        <!-- Main Tagline -->
    <h2 class="tagline"><?php echo esc_html(get_theme_mod('fitness_coach_tagline', 'Build Consistency And Stop The All Or Nothing Mindset For Good!')); ?></h2>

        <!-- Main CTA Section -->
        <div class="cta-section">
        <h3 class="cta-title"><?php echo esc_html(get_theme_mod('fitness_coach_cta_title', 'Apply for 1-on-1 Online Fitness Coaching')); ?></h3>
        <a href="<?php echo esc_url(get_theme_mod('fitness_coach_cta_url', '#contact')); ?>" class="button primary-button"><?php echo esc_html(get_theme_mod('fitness_coach_cta_button', 'GET STARTED TODAY')); ?></a>
        </div>

        <!-- Two Column Features -->
        <div class="features-container">
            <!-- Feature Box 1 -->
            <div class="feature-box">
                <h3 class="feature-title">Supplements and Clothes</h3>
                <p class="feature-description">Everything I Use!</p>
                <a href="#shop" class="button secondary-button">SHOP APPAREL & SUPS</a>
            </div>

            <!-- Feature Box 2 -->
            <div class="feature-box">
                <h3 class="feature-title">Watch my YouTube Channel</h3>
                <p class="feature-description">Trying to spread fitness/health knowledge</p>
                <a href="#youtube" class="button primary-button">Watch Now</a>
            </div>
        </div>

        <!-- Testimonials Section -->
        <div class="testimonials-section">
            <h2 class="section-title">What My Clients Say</h2>
            
            <div class="testimonials-container">
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
                // Default testimonials if no custom ones exist
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
            </div>
        </div>

        <!-- Contact Form Section -->
        <div id="contact" class="contact-section">
            <h2 class="section-title">Get Started With Coaching</h2>
        <?php fitness_coach_contact_form_messages(); ?>
        <form class="contact-form" method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
            <input type="hidden" name="action" value="fitness_coach_contact_form">
            <?php wp_nonce_field('fitness_coach_contact_form', 'fitness_coach_contact_nonce'); ?>
            <input type="text" name="name" placeholder="Your Name" required>
            <input type="email" name="email" placeholder="Your Email" required>
            <textarea name="message" placeholder="Tell me about your fitness goals" required></textarea>
                <button type="submit" class="button primary-button">SUBMIT APPLICATION</button>
            </form>
        </div>

    </div>

<?php get_footer(); ?>