        <!-- Footer -->
        <footer class="footer">
            <div class="footer-content">
                <?php if (is_active_sidebar('footer-1')) : ?>
                    <div class="footer-widgets">
                        <?php dynamic_sidebar('footer-1'); ?>
                    </div>
                <?php endif; ?>
                
                <!-- Social Media Icons -->
                <?php fitness_coach_social_media_icons(); ?>
                
                <!-- Footer Links -->
                <div class="footer-links">
                    <a href="<?php echo esc_url(get_privacy_policy_url()); ?>">Privacy Policy</a>
                    <a href="<?php echo esc_url(home_url('/terms-of-service/')); ?>">Terms of Service</a>
                    <a href="<?php echo esc_url(home_url('/affiliate-policy/')); ?>">Affiliate Policy</a>
                </div>
                
                <!-- Copyright -->
                <div class="footer-copyright">
                    <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. All rights reserved.</p>
                </div>
            </div>
        </footer>

<?php wp_footer(); ?>
</body>
</html> 