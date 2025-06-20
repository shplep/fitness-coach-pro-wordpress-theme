<?php
/**
 * Template Name: Image and Text Rows
 * Description: Flexible layout with alternating text and image sections
 */

get_header(); ?>

<div class="image-text-rows-page">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        
        <!-- Hero Section -->
        <section class="image-text-hero">
            <div class="container">
                <h1 class="page-title"><?php the_title(); ?></h1>
                <?php 
                $show_hero = get_field('show_hero');
                $hero_subtitle = get_field('hero_subtitle');
                if (($show_hero !== false) && $hero_subtitle) : ?>
                    <div class="hero-subtitle">
                        <p><?php echo esc_html($hero_subtitle); ?></p>
                    </div>
                <?php endif; ?>
                
                <?php if (($show_hero !== false) && get_the_content()) : ?>
                    <div class="hero-content">
                        <?php the_content(); ?>
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <!-- Content Rows Section -->
        <section class="content-rows-section">
            <?php
            $content_rows = get_field('content_rows');
            
            if ($content_rows) :
                foreach ($content_rows as $index => $row) :
                    $layout = $row['row_layout'] ?? 'text_left';
                    $text_content = $row['text_content'] ?? '';
                    $image = $row['row_image'] ?? null;
                    $background = $row['row_background'] ?? 'white';
                    
                    // Generate background class
                    $bg_class = '';
                    switch ($background) {
                        case 'light_gray':
                            $bg_class = 'bg-light-gray';
                            break;
                        case 'primary':
                            $bg_class = 'bg-primary';
                            break;
                        default:
                            $bg_class = 'bg-white';
                    }
                    
                    $row_number = $index + 1;
            ?>
                <div class="content-row <?php echo esc_attr($bg_class); ?>" data-row="<?php echo $row_number; ?>">
                    <div class="container">
                        <div class="row-content row-layout-<?php echo esc_attr($layout); ?>">
                            
                            <?php if ($layout === 'text_only') : ?>
                                <!-- Text Only Layout -->
                                <div class="text-only-section">
                                    <div class="text-content">
                                        <?php echo wp_kses_post($text_content); ?>
                                    </div>
                                </div>
                                
                            <?php elseif ($layout === 'text_left') : ?>
                                <!-- Text Left, Image Right Layout -->
                                <div class="text-section">
                                    <div class="text-content">
                                        <?php echo wp_kses_post($text_content); ?>
                                    </div>
                                </div>
                                <div class="image-section">
                                    <?php if ($image) : ?>
                                        <div class="image-container">
                                            <img src="<?php echo esc_url($image['url']); ?>" 
                                                 alt="<?php echo esc_attr($image['alt'] ?: $image['title']); ?>"
                                                 loading="lazy">
                                        </div>
                                    <?php else : ?>
                                        <div class="image-placeholder">
                                            <span>📷</span>
                                            <p>Image placeholder</p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                            <?php else : // text_right ?>
                                <!-- Image Left, Text Right Layout -->
                                <div class="image-section">
                                    <?php if ($image) : ?>
                                        <div class="image-container">
                                            <img src="<?php echo esc_url($image['url']); ?>" 
                                                 alt="<?php echo esc_attr($image['alt'] ?: $image['title']); ?>"
                                                 loading="lazy">
                                        </div>
                                    <?php else : ?>
                                        <div class="image-placeholder">
                                            <span>📷</span>
                                            <p>Image placeholder</p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="text-section">
                                    <div class="text-content">
                                        <?php echo wp_kses_post($text_content); ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                        </div>
                    </div>
                </div>
            <?php
                endforeach;
            else :
                // Default content if no rows are set
            ?>
                <div class="content-row bg-white">
                    <div class="container">
                        <div class="row-content row-layout-text_only">
                            <div class="text-only-section">
                                <div class="text-content">
                                    <h2>Welcome to Our Flexible Layout Template</h2>
                                    <p>This is a versatile layout template that allows you to create engaging content with three different layout options:</p>
                                    <ul>
                                        <li><strong>Text Left + Image Right</strong> - 65% text, 35% image</li>
                                        <li><strong>Image Left + Text Right</strong> - 35% image, 65% text</li>
                                        <li><strong>Text Only</strong> - 100% width text for content-focused sections</li>
                                    </ul>
                                    <p>Add as many rows as you need and mix different layouts to create the perfect page for your content. Each row can have its own background style and content.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </section>

        <?php 
        $show_cta = get_field('show_cta');
        if ($show_cta !== false) : // Show by default if not set
            $cta_title = get_field('cta_title');
            $cta_button_text = get_field('cta_button_text');
            $cta_button_link = get_field('cta_button_link');
            
            // Set defaults if not set
            if (!$cta_title) {
                $cta_title = 'Ready to Get Started?';
            }
            if (!$cta_button_text) {
                $cta_button_text = 'Get In Touch';
            }
        ?>
        <!-- Call to Action Section -->
        <section class="image-text-cta">
            <div class="container">
                <div class="cta-content">
                    <h2><?php echo esc_html($cta_title); ?></h2>
                    <?php if ($cta_button_link) : 
                        $link_url = $cta_button_link['url'] ?? '#';
                        $link_target = $cta_button_link['target'] ?? '_self';
                    ?>
                        <a href="<?php echo esc_url($link_url); ?>" target="<?php echo esc_attr($link_target); ?>" class="btn btn-primary">
                            <?php echo esc_html($cta_button_text); ?>
                        </a>
                    <?php else : ?>
                        <a href="#contact" class="btn btn-primary">
                            <?php echo esc_html($cta_button_text); ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </section>
        <?php endif; ?>

    <?php endwhile; endif; ?>
</div>

<?php get_footer(); ?> 