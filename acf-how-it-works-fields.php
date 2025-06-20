<?php
/**
 * ACF Fields for How It Works Page Template
 * Add these fields to your ACF setup
 */

if (function_exists('acf_add_local_field_group')) {

    // How It Works Page Fields
    acf_add_local_field_group(array(
        'key' => 'group_how_it_works',
        'title' => 'How It Works Page Content',
        'fields' => array(
            
            // Hero Section Tab
            array(
                'key' => 'field_hero_tab',
                'label' => 'Hero Section',
                'name' => '',
                'type' => 'tab',
                'placement' => 'top',
            ),
            
            // Hero Subtitle
            array(
                'key' => 'field_hero_subtitle',
                'label' => 'Hero Subtitle',
                'name' => 'hero_subtitle',
                'type' => 'text',
                'default_value' => 'Your transformation journey, simplified into clear, actionable steps',
                'instructions' => 'The subtitle text that appears below the page title',
            ),
            
            // Hero Description
            array(
                'key' => 'field_hero_description',
                'label' => 'Hero Description',
                'name' => 'hero_description',
                'type' => 'textarea',
                'instructions' => 'Optional additional description for the hero section',
                'rows' => 3,
            ),
            
            // Process Steps Tab
            array(
                'key' => 'field_steps_tab',
                'label' => 'Process Steps',
                'name' => '',
                'type' => 'tab',
                'placement' => 'top',
            ),
            
            // Steps Repeater
            array(
                'key' => 'field_process_steps',
                'label' => 'Process Steps',
                'name' => 'process_steps',
                'type' => 'repeater',
                'instructions' => 'Add your coaching process steps. Each step will be numbered automatically.',
                'min' => 1,
                'max' => 10,
                'layout' => 'block',
                'button_label' => 'Add Step',
                'sub_fields' => array(
                    array(
                        'key' => 'field_step_icon',
                        'label' => 'Step Icon',
                        'name' => 'step_icon',
                        'type' => 'select',
                        'choices' => array(
                            'consultation' => 'Consultation (People)',
                            'planning' => 'Planning (Document)',
                            'training' => 'Training (Activity)',
                            'tracking' => 'Tracking (Chart)',
                            'success' => 'Success (Target)',
                            'heart' => 'Heart',
                            'star' => 'Star',
                            'trophy' => 'Trophy',
                            'calendar' => 'Calendar',
                            'clock' => 'Clock',
                        ),
                        'default_value' => 'consultation',
                    ),
                    array(
                        'key' => 'field_step_title',
                        'label' => 'Step Title',
                        'name' => 'step_title',
                        'type' => 'text',
                        'required' => 1,
                    ),
                    array(
                        'key' => 'field_step_description',
                        'label' => 'Step Description',
                        'name' => 'step_description',
                        'type' => 'textarea',
                        'required' => 1,
                        'rows' => 3,
                    ),
                    array(
                        'key' => 'field_step_features',
                        'label' => 'Step Features',
                        'name' => 'step_features',
                        'type' => 'repeater',
                        'instructions' => 'Key features or bullet points for this step',
                        'min' => 1,
                        'max' => 6,
                        'layout' => 'table',
                        'button_label' => 'Add Feature',
                        'sub_fields' => array(
                            array(
                                'key' => 'field_feature_text',
                                'label' => 'Feature',
                                'name' => 'feature_text',
                                'type' => 'text',
                                'required' => 1,
                            ),
                        ),
                    ),
                ),
            ),
            
            // Timeline Tab
            array(
                'key' => 'field_timeline_tab',
                'label' => 'Timeline',
                'name' => '',
                'type' => 'tab',
                'placement' => 'top',
            ),
            
            // Timeline Section Title
            array(
                'key' => 'field_timeline_title',
                'label' => 'Timeline Section Title',
                'name' => 'timeline_title',
                'type' => 'text',
                'default_value' => 'Your Transformation Timeline',
            ),
            
            // Timeline Items
            array(
                'key' => 'field_timeline_items',
                'label' => 'Timeline Items',
                'name' => 'timeline_items',
                'type' => 'repeater',
                'instructions' => 'Add timeline milestones for the transformation journey',
                'min' => 1,
                'max' => 8,
                'layout' => 'block',
                'button_label' => 'Add Timeline Item',
                'sub_fields' => array(
                    array(
                        'key' => 'field_timeline_period',
                        'label' => 'Time Period',
                        'name' => 'timeline_period',
                        'type' => 'text',
                        'required' => 1,
                        'placeholder' => 'e.g., Week 1-2, Month 1, etc.',
                    ),
                    array(
                        'key' => 'field_timeline_description',
                        'label' => 'Description',
                        'name' => 'timeline_description',
                        'type' => 'textarea',
                        'required' => 1,
                        'rows' => 2,
                    ),
                ),
            ),
            
            // FAQ Tab
            array(
                'key' => 'field_faq_tab',
                'label' => 'FAQ Section',
                'name' => '',
                'type' => 'tab',
                'placement' => 'top',
            ),
            
            // FAQ Section Title
            array(
                'key' => 'field_faq_title',
                'label' => 'FAQ Section Title',
                'name' => 'faq_title',
                'type' => 'text',
                'default_value' => 'Frequently Asked Questions',
            ),
            
            // FAQ Items
            array(
                'key' => 'field_faq_items',
                'label' => 'FAQ Items',
                'name' => 'faq_items',
                'type' => 'repeater',
                'instructions' => 'Add frequently asked questions and answers',
                'min' => 1,
                'max' => 12,
                'layout' => 'block',
                'button_label' => 'Add FAQ',
                'sub_fields' => array(
                    array(
                        'key' => 'field_faq_question',
                        'label' => 'Question',
                        'name' => 'faq_question',
                        'type' => 'text',
                        'required' => 1,
                    ),
                    array(
                        'key' => 'field_faq_answer',
                        'label' => 'Answer',
                        'name' => 'faq_answer',
                        'type' => 'textarea',
                        'required' => 1,
                        'rows' => 3,
                    ),
                ),
            ),
            
            // CTA Tab
            array(
                'key' => 'field_cta_tab',
                'label' => 'Call to Action',
                'name' => '',
                'type' => 'tab',
                'placement' => 'top',
            ),
            
            // CTA Title
            array(
                'key' => 'field_cta_title',
                'label' => 'CTA Title',
                'name' => 'cta_title',
                'type' => 'text',
                'default_value' => 'Ready to Start Your Transformation?',
            ),
            
            // CTA Description
            array(
                'key' => 'field_cta_description',
                'label' => 'CTA Description',
                'name' => 'cta_description',
                'type' => 'textarea',
                'default_value' => 'Let\'s discuss your goals and create a personalized plan that works for you.',
                'rows' => 2,
            ),
            
            // CTA Button Text
            array(
                'key' => 'field_cta_button_text',
                'label' => 'Button Text',
                'name' => 'cta_button_text',
                'type' => 'text',
                'default_value' => 'Schedule Your Consultation',
            ),
            
            // CTA Button Link
            array(
                'key' => 'field_cta_button_link',
                'label' => 'Button Link',
                'name' => 'cta_button_link',
                'type' => 'link',
                'instructions' => 'Link for the CTA button (contact page, booking system, etc.)',
            ),
            
        ),
        'location' => array(
            array(
                array(
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'page-how-it-works.php',
                ),
            ),
            array(
                array(
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'page-template-how-it-works.php',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
    ));

}

// Default step data for initial setup
function get_default_how_it_works_steps() {
    return array(
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

// Default timeline data
function get_default_timeline_items() {
    return array(
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

// Default FAQ data
function get_default_faq_items() {
    return array(
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
?> 