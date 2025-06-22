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
    $testimonials_per_slide = get_field('testimonials_per_slide');
    
    // Set defaults if not set
    $show_dots = ($show_dots !== null) ? $show_dots : true;
    $show_arrows = ($show_arrows !== null) ? $show_arrows : true;
    $autoplay_speed = ($autoplay_speed !== null) ? $autoplay_speed : 6;
    $testimonials_per_slide = ($testimonials_per_slide !== null) ? $testimonials_per_slide : 2;
    ?>
    
    <!-- Testimonials Section - Using Working Debug Carousel Structure -->
    <div class="testimonials-section">
        <?php if ($testimonials_title) : ?>
            <h2 class="section-title"><?php echo esc_html($testimonials_title); ?></h2>
        <?php else : ?>
            <h2 class="section-title">What My Clients Say</h2>
        <?php endif; ?>
        
        <?php 
        // Collect all testimonials into an array for the carousel
        $carousel_testimonials = array();
        
        if ($testimonials_source === 'custom' && have_rows('custom_testimonials')) {
            // Custom Testimonials for Homepage
            while (have_rows('custom_testimonials')) {
                the_row();
                $carousel_testimonials[] = array(
                    'text' => get_sub_field('testimonial_text'),
                    'author' => get_sub_field('author_name'),
                    'rating' => get_sub_field('rating'),
                    'show_rating' => get_sub_field('show_rating')
                );
            }
        } else {
            // Pull from Testimonials Post Type
            $testimonials = fitness_coach_get_testimonials();
            
            if (!empty($testimonials)) {
                foreach ($testimonials as $testimonial) {
                    $author_name = get_post_meta($testimonial->ID, '_testimonial_author', true);
                    $rating = get_post_meta($testimonial->ID, '_testimonial_rating', true);
                    $show_rating = get_post_meta($testimonial->ID, '_testimonial_show_rating', true);
                    
                    $carousel_testimonials[] = array(
                        'text' => $testimonial->post_content,
                        'author' => $author_name,
                        'rating' => $rating,
                        'show_rating' => $show_rating === '1'
                    );
                }
            } else {
                // Fallback testimonials
                $carousel_testimonials = array(
                    array(
                        'text' => 'Working with this coach completely transformed my approach to fitness. I\'ve lost 30 pounds and finally found a sustainable routine that works for me.',
                        'author' => 'Sarah Johnson',
                        'rating' => 5,
                        'show_rating' => true
                    ),
                    array(
                        'text' => 'I tried so many fitness programs before, but this is the first one that actually helped me build lasting habits. The personalized approach makes all the difference.',
                        'author' => 'Michael Torres', 
                        'rating' => 5,
                        'show_rating' => true
                    ),
                    array(
                        'text' => 'The coaching program helped me break through plateaus I\'d been stuck at for years. The accountability and expert guidance were exactly what I needed.',
                        'author' => 'Jennifer Lee',
                        'rating' => 5,
                        'show_rating' => true
                    )
                );
            }
        }
        
        $total_testimonials = count($carousel_testimonials);
        $total_slides = ceil($total_testimonials / $testimonials_per_slide);
        
        // Dynamic styling based on testimonials per slide
        $max_width = $testimonials_per_slide == 1 ? '800px' : ($testimonials_per_slide == 2 ? '1200px' : '1400px');
        $carousel_height = $testimonials_per_slide == 3 ? '350px' : '320px';
        $quote_size = $testimonials_per_slide == 3 ? '2rem' : ($testimonials_per_slide == 2 ? '2.5rem' : '3rem');
        $font_size = $testimonials_per_slide == 3 ? '0.9rem' : ($testimonials_per_slide == 2 ? '1rem' : '1.125rem');
        $padding = $testimonials_per_slide == 3 ? '1.25rem' : ($testimonials_per_slide == 2 ? '1.5rem' : '2rem');
        ?>
        
        <div class="working-carousel-wrapper" style="position: relative; max-width: <?php echo $max_width; ?>; margin: 0 auto; padding: 0 60px;">
            <?php if ($show_arrows && $total_testimonials > $testimonials_per_slide) : ?>
                <button class="working-prev" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); background: rgba(255, 255, 255, 0.9); border: 2px solid #ddd; border-radius: 50%; width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; cursor: pointer; z-index: 10; color: #333; transition: all 0.3s ease;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="15,18 9,12 15,6"></polyline>
                    </svg>
                </button>
            <?php endif; ?>
            
            <div class="working-carousel" style="overflow: hidden; position: relative; height: <?php echo $carousel_height; ?>;">
                <?php 
                // Group testimonials based on testimonials_per_slide setting
                $testimonial_groups = array_chunk($carousel_testimonials, $testimonials_per_slide);
                foreach ($testimonial_groups as $slide_index => $group) : 
                ?>
                    <div class="working-slide <?php echo $slide_index === 0 ? 'working-slide-active' : ''; ?>" style="position: absolute; width: 100%; height: 100%; display: <?php echo $testimonials_per_slide == 1 ? 'block' : 'flex'; ?>; gap: 1.5rem; transition: transform 0.5s ease; transform: translateX(<?php echo $slide_index * 100; ?>%);">
                        <?php foreach ($group as $testimonial) : ?>
                            <div style="<?php echo $testimonials_per_slide == 1 ? 'width: 100%;' : 'flex: 1;'; ?> background: #f9f9f9; border-radius: 10px; padding: <?php echo $padding; ?>; box-sizing: border-box; display: flex; flex-direction: column; justify-content: space-between; min-height: <?php echo $testimonials_per_slide == 3 ? '300px' : '280px'; ?>;">
                                <div>
                                    <div style="font-size: <?php echo $quote_size; ?>; color: #e5e5e5; font-family: Georgia, serif; line-height: 0.8; margin-bottom: 0.75rem;">"</div>
                                    <p style="font-size: <?php echo $font_size; ?>; line-height: 1.5; margin-bottom: 1rem; font-style: italic; color: #333;">
                                        <?php echo wp_kses_post($testimonial['text']); ?>
                                    </p>
                                </div>
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: auto;">
                                    <p style="font-weight: 600; color: #1a1a1a; margin: 0; font-size: <?php echo $testimonials_per_slide == 3 ? '0.8rem' : '0.9rem'; ?>;">
                                        <?php echo esc_html($testimonial['author']); ?>
                                    </p>
                                    <?php if ($testimonial['show_rating'] && $testimonial['rating']) : ?>
                                        <div style="color: #fbbf24; letter-spacing: 0.05rem;">
                                            <?php for ($i = 1; $i <= 5; $i++) : ?>
                                                <span style="font-size: <?php echo $testimonials_per_slide == 3 ? '0.9rem' : '1rem'; ?>;"><?php echo $i <= $testimonial['rating'] ? '★' : '☆'; ?></span>
                                            <?php endfor; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        
                        <?php if ($testimonials_per_slide > 1 && count($group) < $testimonials_per_slide) : ?>
                            <!-- Add empty spaces if not enough testimonials to fill the slide -->
                            <?php for ($i = count($group); $i < $testimonials_per_slide; $i++) : ?>
                                <div style="flex: 1;"></div>
                            <?php endfor; ?>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <?php if ($show_arrows && $total_testimonials > $testimonials_per_slide) : ?>
                <button class="working-next" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: rgba(255, 255, 255, 0.9); border: 2px solid #ddd; border-radius: 50%; width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; cursor: pointer; z-index: 10; color: #333; transition: all 0.3s ease;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="9,18 15,12 9,6"></polyline>
                    </svg>
                </button>
            <?php endif; ?>
        </div>
        
        <?php if ($show_dots && $total_slides > 1) : ?>
            <div class="working-dots" style="display: flex; justify-content: center; gap: 0.5rem; margin-top: 2rem;">
                <?php for ($i = 0; $i < $total_slides; $i++) : ?>
                    <button class="working-dot <?php echo $i === 0 ? 'working-dot-active' : ''; ?>" data-slide="<?php echo $i; ?>" style="width: 12px; height: 12px; border-radius: 50%; border: none; background: <?php echo $i === 0 ? '#333' : '#ddd'; ?>; cursor: pointer; transition: all 0.3s ease;"></button>
                <?php endfor; ?>
            </div>
        <?php endif; ?>
        
        <script>
        // Working carousel JavaScript for dynamic testimonials per slide with mobile responsiveness
        (function() {
            let currentSlide = 0;
            const totalTestimonials = <?php echo $total_testimonials; ?>;
            const desktopTestimonialsPerSlide = <?php echo $testimonials_per_slide; ?>;
            const autoplaySpeed = <?php echo $autoplay_speed * 1000; ?>; // Convert to milliseconds
            let autoplayTimer = null;
            let isMobile = window.innerWidth <= 768;
            let currentTestimonialsPerSlide = isMobile ? 1 : desktopTestimonialsPerSlide;
            let totalSlides = Math.ceil(totalTestimonials / currentTestimonialsPerSlide);
            
            // Get elements
            const carousel = document.querySelector('.working-carousel');
            const wrapper = document.querySelector('.working-carousel-wrapper');
            const dotsContainer = document.querySelector('.working-dots');
            let slides, dots, prevBtn, nextBtn;
            
            // Get all individual testimonials data
            const testimonialsData = [
                <?php foreach ($carousel_testimonials as $index => $testimonial) : ?>
                {
                    text: <?php echo json_encode(wp_kses_post($testimonial['text'])); ?>,
                    author: <?php echo json_encode(esc_html($testimonial['author'])); ?>,
                    rating: <?php echo intval($testimonial['rating']); ?>,
                    showRating: <?php echo $testimonial['show_rating'] ? 'true' : 'false'; ?>
                }<?php echo $index < count($carousel_testimonials) - 1 ? ',' : ''; ?>
                <?php endforeach; ?>
            ];
            
            function createTestimonialHTML(testimonial) {
                const quoteFontSize = isMobile ? '2.5rem' : (currentTestimonialsPerSlide == 3 ? '2rem' : (currentTestimonialsPerSlide == 2 ? '2.5rem' : '3rem'));
                const textFontSize = isMobile ? '1rem' : (currentTestimonialsPerSlide == 3 ? '0.9rem' : (currentTestimonialsPerSlide == 2 ? '1rem' : '1.125rem'));
                const authorFontSize = isMobile ? '0.9rem' : (currentTestimonialsPerSlide == 3 ? '0.8rem' : '0.9rem');
                const starFontSize = isMobile ? '1rem' : (currentTestimonialsPerSlide == 3 ? '0.9rem' : '1rem');
                const padding = isMobile ? '1.5rem' : (currentTestimonialsPerSlide == 3 ? '1.25rem' : (currentTestimonialsPerSlide == 2 ? '1.5rem' : '2rem'));
                const minHeight = isMobile ? '280px' : (currentTestimonialsPerSlide == 3 ? '300px' : '280px');
                const flexBasis = isMobile ? '100%' : 'flex: 1';
                
                let starsHTML = '';
                if (testimonial.showRating && testimonial.rating > 0) {
                    starsHTML = '<div style="color: #fbbf24; letter-spacing: 0.05rem;">';
                    for (let i = 1; i <= 5; i++) {
                        starsHTML += `<span style="font-size: ${starFontSize};">${i <= testimonial.rating ? '★' : '☆'}</span>`;
                    }
                    starsHTML += '</div>';
                }
                
                return `
                    <div style="${flexBasis}; background: #f9f9f9; border-radius: 10px; padding: ${padding}; box-sizing: border-box; display: flex; flex-direction: column; justify-content: space-between; min-height: ${minHeight};">
                        <div>
                            <div style="font-size: ${quoteFontSize}; color: #e5e5e5; font-family: Georgia, serif; line-height: 0.8; margin-bottom: 0.75rem;">"</div>
                            <p style="font-size: ${textFontSize}; line-height: 1.5; margin-bottom: 1rem; font-style: italic; color: #333;">
                                ${testimonial.text}
                            </p>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: auto;">
                            <p style="font-weight: 600; color: #1a1a1a; margin: 0; font-size: ${authorFontSize};">
                                ${testimonial.author}
                            </p>
                            ${starsHTML}
                        </div>
                    </div>
                `;
            }
            
            function rebuildCarousel() {
                // Clear existing slides
                carousel.innerHTML = '';
                
                // Group testimonials based on current setting
                const groups = [];
                for (let i = 0; i < testimonialsData.length; i += currentTestimonialsPerSlide) {
                    groups.push(testimonialsData.slice(i, i + currentTestimonialsPerSlide));
                }
                
                // Create new slides
                groups.forEach((group, slideIndex) => {
                    const slideDiv = document.createElement('div');
                    slideDiv.className = `working-slide ${slideIndex === 0 ? 'working-slide-active' : ''}`;
                    slideDiv.style.cssText = `
                        position: absolute; 
                        width: 100%; 
                        height: 100%; 
                        display: ${currentTestimonialsPerSlide == 1 ? 'block' : 'flex'}; 
                        gap: 1.5rem; 
                        transition: transform 0.5s ease; 
                        transform: translateX(${slideIndex * 100}%);
                    `;
                    
                    // Add testimonials to slide
                    group.forEach(testimonial => {
                        slideDiv.innerHTML += createTestimonialHTML(testimonial);
                    });
                    
                    // Add empty spaces if needed
                    if (currentTestimonialsPerSlide > 1 && group.length < currentTestimonialsPerSlide) {
                        for (let i = group.length; i < currentTestimonialsPerSlide; i++) {
                            slideDiv.innerHTML += '<div style="flex: 1;"></div>';
                        }
                    }
                    
                    carousel.appendChild(slideDiv);
                });
                
                // Update total slides
                totalSlides = groups.length;
                currentSlide = Math.min(currentSlide, totalSlides - 1);
                
                // Rebuild dots
                if (dotsContainer) {
                    dotsContainer.innerHTML = '';
                    if (totalSlides > 1) {
                        for (let i = 0; i < totalSlides; i++) {
                            const dot = document.createElement('button');
                            dot.className = `working-dot ${i === currentSlide ? 'working-dot-active' : ''}`;
                            dot.setAttribute('data-slide', i);
                            dot.style.cssText = `
                                width: 12px; 
                                height: 12px; 
                                border-radius: 50%; 
                                border: none; 
                                background: ${i === currentSlide ? '#333' : '#ddd'}; 
                                cursor: pointer; 
                                transition: all 0.3s ease;
                            `;
                            dotsContainer.appendChild(dot);
                        }
                    }
                }
                
                // Update navigation visibility
                updateNavigationVisibility();
                
                // Re-get elements and add event listeners
                refreshElements();
                addEventListeners();
            }
            
            function updateNavigationVisibility() {
                const showNavigation = totalTestimonials > currentTestimonialsPerSlide && totalSlides > 1;
                
                // Update arrows
                prevBtn = wrapper.querySelector('.working-prev');
                nextBtn = wrapper.querySelector('.working-next');
                
                if (prevBtn) prevBtn.style.display = showNavigation ? 'flex' : 'none';
                if (nextBtn) nextBtn.style.display = showNavigation ? 'flex' : 'none';
                
                // Update dots container
                if (dotsContainer) {
                    dotsContainer.style.display = (totalSlides > 1) ? 'flex' : 'none';
                }
            }
            
            function refreshElements() {
                slides = document.querySelectorAll('.working-slide');
                dots = document.querySelectorAll('.working-dot');
                prevBtn = document.querySelector('.working-prev');
                nextBtn = document.querySelector('.working-next');
            }
            
            function updateCarousel() {
                slides.forEach((slide, index) => {
                    slide.style.transform = `translateX(${(index - currentSlide) * 100}%)`;
                    slide.classList.toggle('working-slide-active', index === currentSlide);
                });
                
                dots.forEach((dot, index) => {
                    dot.style.background = index === currentSlide ? '#333' : '#ddd';
                    dot.classList.toggle('working-dot-active', index === currentSlide);
                });
            }
            
            function nextSlide() {
                currentSlide = (currentSlide + 1) % totalSlides;
                updateCarousel();
            }
            
            function prevSlide() {
                currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
                updateCarousel();
            }
            
            function goToSlide(index) {
                currentSlide = index;
                updateCarousel();
            }
            
            function startAutoplay() {
                if (autoplaySpeed > 0 && totalSlides > 1) {
                    autoplayTimer = setInterval(nextSlide, autoplaySpeed);
                }
            }
            
            function stopAutoplay() {
                if (autoplayTimer) {
                    clearInterval(autoplayTimer);
                    autoplayTimer = null;
                }
            }
            
            function addEventListeners() {
                // Arrow click events
                if (nextBtn) nextBtn.addEventListener('click', () => {
                    nextSlide();
                    stopAutoplay();
                    startAutoplay();
                });
                
                if (prevBtn) prevBtn.addEventListener('click', () => {
                    prevSlide();
                    stopAutoplay();
                    startAutoplay();
                });
                
                // Dot click events
                dots.forEach((dot, index) => {
                    dot.addEventListener('click', () => {
                        goToSlide(index);
                        stopAutoplay();
                        startAutoplay();
                    });
                });
                
                // Hover effects for wrapper
                if (wrapper) {
                    wrapper.addEventListener('mouseenter', stopAutoplay);
                    wrapper.addEventListener('mouseleave', startAutoplay);
                }
                
                // Arrow hover effects
                if (prevBtn) {
                    prevBtn.addEventListener('mouseenter', function() {
                        this.style.background = 'white';
                        this.style.borderColor = '#333';
                        this.style.transform = 'translateY(-50%) scale(1.1)';
                    });
                    prevBtn.addEventListener('mouseleave', function() {
                        this.style.background = 'rgba(255, 255, 255, 0.9)';
                        this.style.borderColor = '#ddd';
                        this.style.transform = 'translateY(-50%) scale(1)';
                    });
                }
                
                if (nextBtn) {
                    nextBtn.addEventListener('mouseenter', function() {
                        this.style.background = 'white';
                        this.style.borderColor = '#333';
                        this.style.transform = 'translateY(-50%) scale(1.1)';
                    });
                    nextBtn.addEventListener('mouseleave', function() {
                        this.style.background = 'rgba(255, 255, 255, 0.9)';
                        this.style.borderColor = '#ddd';
                        this.style.transform = 'translateY(-50%) scale(1)';
                    });
                }
                
                // Dot hover effects
                dots.forEach((dot) => {
                    dot.addEventListener('mouseenter', function() {
                        if (!this.classList.contains('working-dot-active')) {
                            this.style.background = '#bbb';
                            this.style.transform = 'scale(1.2)';
                        }
                    });
                    dot.addEventListener('mouseleave', function() {
                        if (!this.classList.contains('working-dot-active')) {
                            this.style.background = '#ddd';
                            this.style.transform = 'scale(1)';
                        }
                    });
                });
            }
            
            // Handle window resize
            function handleResize() {
                const wasIsMobile = isMobile;
                isMobile = window.innerWidth <= 768;
                const newTestimonialsPerSlide = isMobile ? 1 : desktopTestimonialsPerSlide;
                
                if (newTestimonialsPerSlide !== currentTestimonialsPerSlide) {
                    stopAutoplay();
                    currentTestimonialsPerSlide = newTestimonialsPerSlide;
                    rebuildCarousel();
                    updateCarousel();
                    startAutoplay();
                }
            }
            
            // Initialize
            rebuildCarousel();
            updateCarousel();
            startAutoplay();
            
            // Add resize listener
            window.addEventListener('resize', handleResize);
            
            console.log('Responsive testimonials carousel initialized with', totalSlides, 'slides (' + currentTestimonialsPerSlide + ' testimonials per slide), autoplay:', autoplaySpeed + 'ms');
        })();
        </script>
    </div>

    <!-- TEMPORARY DEBUG CAROUSEL - Simple 5-slide test -->
    <div class="debug-carousel-section" style="margin: 4rem 0; padding: 2rem; background: #f0f0f0; border-radius: 10px;">
        <h2 style="text-align: center; margin-bottom: 2rem; color: #333;">🔧 DEBUG: Simple Test Carousel</h2>
        
        <div class="debug-carousel-wrapper" style="position: relative; max-width: 800px; margin: 0 auto; padding: 0 50px;">
            <button class="debug-prev" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); background: white; border: 2px solid #333; border-radius: 50%; width: 40px; height: 40px; cursor: pointer; z-index: 10;">‹</button>
            
            <div class="debug-carousel" style="overflow: hidden; position: relative; height: 200px;">
                <div class="debug-slide debug-slide-active" style="position: absolute; width: 100%; height: 100%; background: #e8f4f8; border-radius: 8px; padding: 2rem; box-sizing: border-box; display: flex; align-items: center; justify-content: center; transition: transform 0.5s ease;">
                    <div style="text-align: center;">
                        <h3 style="margin: 0 0 1rem 0; color: #2c5282;">Slide 1</h3>
                        <p style="margin: 0; color: #4a5568;">This is the first test slide with some sample content to verify the carousel is working properly.</p>
                    </div>
                </div>
                
                <div class="debug-slide" style="position: absolute; width: 100%; height: 100%; background: #f0fff4; border-radius: 8px; padding: 2rem; box-sizing: border-box; display: flex; align-items: center; justify-content: center; transform: translateX(100%); transition: transform 0.5s ease;">
                    <div style="text-align: center;">
                        <h3 style="margin: 0 0 1rem 0; color: #2d5016;">Slide 2</h3>
                        <p style="margin: 0; color: #4a5568;">This is the second test slide. If you can see this, the carousel navigation is working!</p>
                    </div>
                </div>
                
                <div class="debug-slide" style="position: absolute; width: 100%; height: 100%; background: #fff5f5; border-radius: 8px; padding: 2rem; box-sizing: border-box; display: flex; align-items: center; justify-content: center; transform: translateX(200%); transition: transform 0.5s ease;">
                    <div style="text-align: center;">
                        <h3 style="margin: 0 0 1rem 0; color: #742a2a;">Slide 3</h3>
                        <p style="margin: 0; color: #4a5568;">Third slide here! The carousel should smoothly transition between slides.</p>
                    </div>
                </div>
                
                <div class="debug-slide" style="position: absolute; width: 100%; height: 100%; background: #fefcbf; border-radius: 8px; padding: 2rem; box-sizing: border-box; display: flex; align-items: center; justify-content: center; transform: translateX(300%); transition: transform 0.5s ease;">
                    <div style="text-align: center;">
                        <h3 style="margin: 0 0 1rem 0; color: #744210;">Slide 4</h3>
                        <p style="margin: 0; color: #4a5568;">Fourth slide with yellow background. Almost there!</p>
                    </div>
                </div>
                
                <div class="debug-slide" style="position: absolute; width: 100%; height: 100%; background: #e6fffa; border-radius: 8px; padding: 2rem; box-sizing: border-box; display: flex; align-items: center; justify-content: center; transform: translateX(400%); transition: transform 0.5s ease;">
                    <div style="text-align: center;">
                        <h3 style="margin: 0 0 1rem 0; color: #234e52;">Slide 5</h3>
                        <p style="margin: 0; color: #4a5568;">Final slide! This proves the carousel can handle multiple slides with smooth transitions.</p>
                    </div>
                </div>
            </div>
            
            <button class="debug-next" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: white; border: 2px solid #333; border-radius: 50%; width: 40px; height: 40px; cursor: pointer; z-index: 10;">›</button>
        </div>
        
        <div class="debug-dots" style="display: flex; justify-content: center; gap: 0.5rem; margin-top: 1rem;">
            <button class="debug-dot debug-dot-active" data-slide="0" style="width: 12px; height: 12px; border-radius: 50%; border: none; background: #333; cursor: pointer;"></button>
            <button class="debug-dot" data-slide="1" style="width: 12px; height: 12px; border-radius: 50%; border: none; background: #ddd; cursor: pointer;"></button>
            <button class="debug-dot" data-slide="2" style="width: 12px; height: 12px; border-radius: 50%; border: none; background: #ddd; cursor: pointer;"></button>
            <button class="debug-dot" data-slide="3" style="width: 12px; height: 12px; border-radius: 50%; border: none; background: #ddd; cursor: pointer;"></button>
            <button class="debug-dot" data-slide="4" style="width: 12px; height: 12px; border-radius: 50%; border: none; background: #ddd; cursor: pointer;"></button>
        </div>
        
        <script>
        // Simple debug carousel JavaScript
        (function() {
            let currentSlide = 0;
            const totalSlides = 5;
            const slides = document.querySelectorAll('.debug-slide');
            const dots = document.querySelectorAll('.debug-dot');
            const prevBtn = document.querySelector('.debug-prev');
            const nextBtn = document.querySelector('.debug-next');
            
            function updateCarousel() {
                slides.forEach((slide, index) => {
                    slide.style.transform = `translateX(${(index - currentSlide) * 100}%)`;
                    slide.classList.toggle('debug-slide-active', index === currentSlide);
                });
                
                dots.forEach((dot, index) => {
                    dot.style.background = index === currentSlide ? '#333' : '#ddd';
                    dot.classList.toggle('debug-dot-active', index === currentSlide);
                });
            }
            
            function nextSlide() {
                currentSlide = (currentSlide + 1) % totalSlides;
                updateCarousel();
            }
            
            function prevSlide() {
                currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
                updateCarousel();
            }
            
            function goToSlide(index) {
                currentSlide = index;
                updateCarousel();
            }
            
            // Event listeners
            if (nextBtn) nextBtn.addEventListener('click', nextSlide);
            if (prevBtn) prevBtn.addEventListener('click', prevSlide);
            
            dots.forEach((dot, index) => {
                dot.addEventListener('click', () => goToSlide(index));
            });
            
            // Auto-play every 4 seconds
            setInterval(nextSlide, 4000);
            
            console.log('Debug carousel initialized with', totalSlides, 'slides');
        })();
        </script>
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