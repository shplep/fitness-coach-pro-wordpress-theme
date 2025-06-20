<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header">
    <div class="header-container">
        <div class="site-logo">
            <?php
            if (has_custom_logo()) {
                the_custom_logo();
            } elseif (get_theme_mod('fitness_coach_show_site_title', true)) {
                // Only show site title if the option is enabled
                if (is_front_page() && is_home()) :
                    ?>
                    <h1 class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php bloginfo('name'); ?></a></h1>
                    <?php
                else :
                    ?>
                    <div class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php bloginfo('name'); ?></a></div>
                    <?php
                endif;
            }
            ?>
        </div>

        <!-- Desktop Navigation -->
        <nav class="main-navigation" role="navigation">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'menu_id'        => 'primary-menu',
                'fallback_cb'    => 'fitness_coach_default_menu',
            ));
            ?>
        </nav>

        <!-- Hamburger Menu Button -->
        <div class="hamburger-menu" id="hamburger-menu">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>

    <!-- Mobile Menu -->
    <nav class="mobile-menu" id="mobile-menu">
        <?php
        wp_nav_menu(array(
            'theme_location' => 'primary',
            'menu_id'        => 'mobile-menu-list',
            'fallback_cb'    => 'fitness_coach_default_menu',
        ));
        ?>
    </nav>
</header> 