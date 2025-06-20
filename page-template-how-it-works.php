<?php
/**
 * Template Name: How It Works Process
 * Description: A beautiful step-by-step layout explaining the fitness coaching process
 */

get_header(); ?>

<div class="how-it-works-page">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        
        <!-- Hero Section -->
        <section class="how-it-works-hero">
            <div class="container">
                <h1 class="page-title"><?php the_title(); ?></h1>
                <div class="hero-subtitle">
                    <?php 
                    $hero_subtitle = get_field('hero_subtitle');
                    if (!$hero_subtitle) {
                        $hero_subtitle = 'Your transformation journey, simplified into clear, actionable steps';
                    }
                    ?>
                    <p><?php echo esc_html($hero_subtitle); ?></p>
                </div>
                <?php if (get_the_content()) : ?>
                    <div class="hero-content">
                        <?php the_content(); ?>
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <!-- Process Steps Section -->
        <section class="process-steps">
            <div class="container">
                <div class="steps-grid">
                    <?php
                    $process_steps = get_field('process_steps');
                    
                    // If no custom steps, use defaults
                    if (!$process_steps) {
                        $process_steps = array(
                            array(
                                'step_icon' => 'consultation',
                                'step_title' => 'Initial Consultation',
                                'step_description' => 'We start with a comprehensive discussion about your goals, current fitness level, lifestyle, and any challenges you\'re facing. This helps me understand where you are and where you want to go.',
                                'step_features' => array(
                                    array('feature_text' => 'Goal assessment and priority setting'),
                                    array('feature_text' => 'Health and fitness history review'),
                                    array('feature_text' => 'Lifestyle and schedule analysis'),
                                    array('feature_text' => 'Expectations and timeline discussion'),
                                ),
                            ),
                            array(
                                'step_icon' => 'planning',
                                'step_title' => 'Custom Plan Creation',
                                'step_description' => 'Based on our consultation, I create a personalized fitness and nutrition plan tailored specifically to your goals, preferences, and lifestyle constraints.',
                                'step_features' => array(
                                    array('feature_text' => 'Customized workout routines'),
                                    array('feature_text' => 'Personalized nutrition guidelines'),
                                    array('feature_text' => 'Progressive milestone mapping'),
                                    array('feature_text' => 'Equipment and resource planning'),
                                ),
                            ),
                            array(
                                'step_icon' => 'training',
                                'step_title' => 'Training & Execution',
                                'step_description' => 'We begin implementing your plan with hands-on training sessions, proper form instruction, and building sustainable habits that fit your lifestyle.',
                                'step_features' => array(
                                    array('feature_text' => 'One-on-one training sessions'),
                                    array('feature_text' => 'Form correction and technique training'),
                                    array('feature_text' => 'Habit formation and routine building'),
                                    array('feature_text' => 'Real-time feedback and adjustments'),
                                ),
                            ),
                            array(
                                'step_icon' => 'tracking',
                                'step_title' => 'Progress Tracking',
                                'step_description' => 'Regular check-ins, progress measurements, and plan adjustments ensure you stay on track and continue making steady progress toward your goals.',
                                'step_features' => array(
                                    array('feature_text' => 'Weekly progress assessments'),
                                    array('feature_text' => 'Performance metric tracking'),
                                    array('feature_text' => 'Plan optimization and adjustments'),
                                    array('feature_text' => 'Motivation and accountability support'),
                                ),
                            ),
                            array(
                                'step_icon' => 'success',
                                'step_title' => 'Achievement & Beyond',
                                'step_description' => 'Celebrate your success and establish a sustainable maintenance plan to keep your results long-term, with ongoing support as needed.',
                                'step_features' => array(
                                    array('feature_text' => 'Goal achievement celebration'),
                                    array('feature_text' => 'Maintenance strategy development'),
                                    array('feature_text' => 'Long-term sustainability planning'),
                                    array('feature_text' => 'Continued support options'),
                                ),
                            ),
                        );
                    }
                    
                    if ($process_steps) :
                        $step_count = 1;
                        foreach ($process_steps as $step) :
                            $icon = $step['step_icon'] ?? 'consultation';
                            $title = $step['step_title'] ?? '';
                            $description = $step['step_description'] ?? '';
                            $features = $step['step_features'] ?? array();
                    ?>
                        <div class="step-item" data-step="<?php echo $step_count; ?>">
                            <div class="step-number">
                                <span><?php echo str_pad($step_count, 2, '0', STR_PAD_LEFT); ?></span>
                            </div>
                            <div class="step-content">
                                <div class="step-icon">
                                    <?php echo fitness_coach_get_step_icon($icon); ?>
                                </div>
                                <h3><?php echo esc_html($title); ?></h3>
                                <p><?php echo esc_html($description); ?></p>
                                <?php if ($features) : ?>
                                    <ul class="step-features">
                                        <?php foreach ($features as $feature) : ?>
                                            <li><?php echo esc_html($feature['feature_text']); ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php
                        $step_count++;
                        endforeach;
                    endif;
                    ?>
                </div>
            </div>
        </section>

        <!-- Timeline Visualization -->
        <section class="process-timeline">
            <div class="container">
                <?php 
                $timeline_title = get_field('timeline_title');
                if (!$timeline_title) {
                    $timeline_title = 'Your Transformation Timeline';
                }
                ?>
                <h2 class="section-title"><?php echo esc_html($timeline_title); ?></h2>
                <div class="timeline">
                    <?php
                    $timeline_items = get_field('timeline_items');
                    
                    // If no custom timeline, use defaults
                    if (!$timeline_items) {
                        $timeline_items = array(
                            array(
                                'timeline_period' => 'Week 1-2',
                                'timeline_description' => 'Consultation, assessment, and plan creation. Getting started with proper form and habit building.',
                            ),
                            array(
                                'timeline_period' => 'Week 3-8',
                                'timeline_description' => 'Intensive training phase with regular progress tracking and plan refinements.',
                            ),
                            array(
                                'timeline_period' => 'Week 9-12',
                                'timeline_description' => 'Advanced training, goal achievement, and transition to maintenance strategies.',
                            ),
                            array(
                                'timeline_period' => 'Ongoing',
                                'timeline_description' => 'Maintenance support, advanced goals, and continued transformation journey.',
                            ),
                        );
                    }
                    
                    if ($timeline_items) :
                        foreach ($timeline_items as $item) :
                            $period = $item['timeline_period'] ?? '';
                            $description = $item['timeline_description'] ?? '';
                    ?>
                        <div class="timeline-item">
                            <div class="timeline-marker"></div>
                            <div class="timeline-content">
                                <h4><?php echo esc_html($period); ?></h4>
                                <p><?php echo esc_html($description); ?></p>
                            </div>
                        </div>
                    <?php
                        endforeach;
                    endif;
                    ?>
                </div>
            </div>
        </section>

        <!-- FAQ Section -->
        <section class="how-it-works-faq">
            <div class="container">
                <?php 
                $faq_title = get_field('faq_title');
                if (!$faq_title) {
                    $faq_title = 'Frequently Asked Questions';
                }
                ?>
                <h2 class="section-title"><?php echo esc_html($faq_title); ?></h2>
                <div class="faq-grid">
                    <?php
                    $faq_items = get_field('faq_items');
                    
                    // If no custom FAQs, use defaults
                    if (!$faq_items) {
                        $faq_items = array(
                            array(
                                'faq_question' => 'How long does it take to see results?',
                                'faq_answer' => 'Most clients see initial improvements in energy and strength within 2-3 weeks, with visible physical changes typically appearing after 4-6 weeks of consistent training.',
                            ),
                            array(
                                'faq_question' => 'What if I have no gym experience?',
                                'faq_answer' => 'Perfect! I specialize in working with beginners. We\'ll start with the basics and build your confidence and skills progressively.',
                            ),
                            array(
                                'faq_question' => 'Do I need special equipment?',
                                'faq_answer' => 'Not necessarily. I can design programs for home workouts, gym settings, or minimal equipment based on your preferences and access.',
                            ),
                            array(
                                'faq_question' => 'How often will we meet?',
                                'faq_answer' => 'This depends on your goals and preferences. Options range from 1-3 sessions per week, with additional check-ins and support as needed.',
                            ),
                        );
                    }
                    
                    if ($faq_items) :
                        foreach ($faq_items as $faq) :
                            $question = $faq['faq_question'] ?? '';
                            $answer = $faq['faq_answer'] ?? '';
                    ?>
                        <div class="faq-item">
                            <h4><?php echo esc_html($question); ?></h4>
                            <p><?php echo esc_html($answer); ?></p>
                        </div>
                    <?php
                        endforeach;
                    endif;
                    ?>
                </div>
            </div>
        </section>

        <!-- Call to Action Section -->
        <section class="how-it-works-cta">
            <div class="container">
                <?php 
                $cta_title = get_field('cta_title');
                $cta_description = get_field('cta_description');
                $cta_button_text = get_field('cta_button_text');
                $cta_button_link = get_field('cta_button_link');
                
                // Set defaults if not set
                if (!$cta_title) {
                    $cta_title = 'Ready to Start Your Transformation?';
                }
                if (!$cta_description) {
                    $cta_description = 'Let\'s discuss your goals and create a personalized plan that works for you.';
                }
                if (!$cta_button_text) {
                    $cta_button_text = 'Schedule Your Consultation';
                }
                ?>
                <div class="cta-content">
                    <h2><?php echo esc_html($cta_title); ?></h2>
                    <p><?php echo esc_html($cta_description); ?></p>
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

    <?php endwhile; endif; ?>
</div>

<?php get_footer(); ?> 