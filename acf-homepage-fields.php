<?php
/**
 * ACF Field Group Configuration for Homepage
 * 
 * To use this file:
 * 1. Install Advanced Custom Fields plugin
 * 2. Copy this code and paste it in ACF > Tools > Import
 * OR
 * 3. Create the fields manually using the structure below
 */

// Homepage Field Group Configuration
if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
    'key' => 'group_homepage_fields',
    'title' => 'Homepage Content',
    'fields' => array(
        // Hero Section Tab
        array(
            'key' => 'field_hero_tab',
            'label' => 'Hero Section',
            'name' => '',
            'type' => 'tab',
            'placement' => 'top',
        ),
        array(
            'key' => 'field_profile_image',
            'label' => 'Profile Image',
            'name' => 'profile_image',
            'type' => 'image',
            'instructions' => 'Upload your profile photo (recommended: 400x400px square)',
            'return_format' => 'array',
            'preview_size' => 'medium',
        ),
        array(
            'key' => 'field_profile_name',
            'label' => 'Name/Title',
            'name' => 'profile_name',
            'type' => 'text',
            'instructions' => 'Your name or business name',
            'placeholder' => 'Your Name',
        ),
        array(
            'key' => 'field_hero_subheadline',
            'label' => 'Hero Subheadline',
            'name' => 'hero_subheadline',
            'type' => 'text',
            'instructions' => 'Brief tagline under your name (optional)',
            'placeholder' => 'Certified Personal Trainer & Nutrition Coach',
        ),
        
        // Main Content Tab
        array(
            'key' => 'field_content_tab',
            'label' => 'Main Content',
            'name' => '',
            'type' => 'tab',
            'placement' => 'top',
        ),
        array(
            'key' => 'field_main_tagline',
            'label' => 'Main Tagline',
            'name' => 'main_tagline',
            'type' => 'text',
            'instructions' => 'Your main value proposition (large headline)',
            'placeholder' => 'Build Consistency And Stop The All Or Nothing Mindset For Good!',
        ),
        array(
            'key' => 'field_supporting_text',
            'label' => 'Supporting Text',
            'name' => 'supporting_text',
            'type' => 'textarea',
            'instructions' => 'Additional supporting text under the main tagline (optional)',
            'rows' => 3,
        ),
        
        // Transformation Images Tab
        array(
            'key' => 'field_transformation_tab',
            'label' => 'Transformation Images',
            'name' => '',
            'type' => 'tab',
            'placement' => 'top',
        ),
        array(
            'key' => 'field_transformation_images',
            'label' => 'Transformation Images',
            'name' => 'transformation_images',
            'type' => 'repeater',
            'instructions' => 'Add before/after or transformation images with captions',
            'layout' => 'block',
            'button_label' => 'Add Transformation Image',
            'sub_fields' => array(
                array(
                    'key' => 'field_transformation_image',
                    'label' => 'Image',
                    'name' => 'image',
                    'type' => 'image',
                    'return_format' => 'array',
                    'preview_size' => 'medium',
                    'wrapper' => array(
                        'width' => '50',
                    ),
                ),
                array(
                    'key' => 'field_transformation_caption',
                    'label' => 'Caption',
                    'name' => 'caption',
                    'type' => 'text',
                    'placeholder' => '6 months transformation',
                    'wrapper' => array(
                        'width' => '50',
                    ),
                ),
            ),
        ),
        
        // CTA Section Tab
        array(
            'key' => 'field_cta_tab',
            'label' => 'Call to Action',
            'name' => '',
            'type' => 'tab',
            'placement' => 'top',
        ),
        array(
            'key' => 'field_cta_headline',
            'label' => 'CTA Headline',
            'name' => 'cta_headline',
            'type' => 'text',
            'instructions' => 'Main call-to-action headline',
            'placeholder' => 'Apply for 1-on-1 Online Fitness Coaching',
        ),
        array(
            'key' => 'field_cta_description',
            'label' => 'CTA Description',
            'name' => 'cta_description',
            'type' => 'textarea',
            'instructions' => 'Supporting text for your CTA (optional)',
            'rows' => 2,
        ),
        array(
            'key' => 'field_cta_button_text',
            'label' => 'Button Text',
            'name' => 'cta_button_text',
            'type' => 'text',
            'placeholder' => 'GET STARTED TODAY',
            'wrapper' => array(
                'width' => '50',
            ),
        ),
        array(
            'key' => 'field_cta_button_url',
            'label' => 'Button URL',
            'name' => 'cta_button_url',
            'type' => 'url',
            'placeholder' => 'https://calendly.com/yourname',
            'wrapper' => array(
                'width' => '50',
            ),
        ),
        
        // Feature Boxes Tab
        array(
            'key' => 'field_features_tab',
            'label' => 'Feature Boxes',
            'name' => '',
            'type' => 'tab',
            'placement' => 'top',
        ),
        array(
            'key' => 'field_feature_boxes',
            'label' => 'Feature Boxes',
            'name' => 'feature_boxes',
            'type' => 'repeater',
            'instructions' => 'Add feature boxes (services, links, etc.)',
            'layout' => 'block',
            'button_label' => 'Add Feature Box',
            'sub_fields' => array(
                array(
                    'key' => 'field_feature_icon',
                    'label' => 'Icon (Optional)',
                    'name' => 'icon',
                    'type' => 'image',
                    'instructions' => 'Small icon for this feature (60x60px recommended)',
                    'return_format' => 'array',
                    'preview_size' => 'thumbnail',
                ),
                array(
                    'key' => 'field_feature_title',
                    'label' => 'Title',
                    'name' => 'title',
                    'type' => 'text',
                    'placeholder' => 'Supplements and Clothes',
                ),
                array(
                    'key' => 'field_feature_description',
                    'label' => 'Description',
                    'name' => 'description',
                    'type' => 'textarea',
                    'rows' => 2,
                    'placeholder' => 'Everything I Use!',
                ),
                array(
                    'key' => 'field_feature_button_text',
                    'label' => 'Button Text',
                    'name' => 'button_text',
                    'type' => 'text',
                    'placeholder' => 'SHOP NOW',
                    'wrapper' => array(
                        'width' => '40',
                    ),
                ),
                array(
                    'key' => 'field_feature_button_url',
                    'label' => 'Button URL',
                    'name' => 'button_url',
                    'type' => 'url',
                    'wrapper' => array(
                        'width' => '40',
                    ),
                ),
                array(
                    'key' => 'field_feature_button_style',
                    'label' => 'Button Style',
                    'name' => 'button_style',
                    'type' => 'select',
                    'choices' => array(
                        'primary' => 'Primary (Dark)',
                        'secondary' => 'Secondary (Light)',
                    ),
                    'default_value' => 'primary',
                    'wrapper' => array(
                        'width' => '20',
                    ),
                ),
            ),
        ),
        
        // Testimonials Tab
        array(
            'key' => 'field_testimonials_tab',
            'label' => 'Testimonials',
            'name' => '',
            'type' => 'tab',
            'placement' => 'top',
        ),
        array(
            'key' => 'field_testimonials_title',
            'label' => 'Testimonials Title',
            'name' => 'testimonials_title',
            'type' => 'text',
            'placeholder' => 'What My Clients Say',
        ),
        array(
            'key' => 'field_testimonials_source',
            'label' => 'Testimonials Source',
            'name' => 'testimonials_source',
            'type' => 'radio',
            'instructions' => 'Choose where to pull testimonials from',
            'choices' => array(
                'post_type' => 'Use Testimonials from Post Type',
                'custom' => 'Custom Testimonials for Homepage',
            ),
            'default_value' => 'post_type',
            'layout' => 'vertical',
        ),
        array(
            'key' => 'field_custom_testimonials',
            'label' => 'Custom Testimonials',
            'name' => 'custom_testimonials',
            'type' => 'repeater',
            'instructions' => 'Add testimonials specifically for the homepage',
            'layout' => 'block',
            'button_label' => 'Add Testimonial',
            'conditional_logic' => array(
                array(
                    array(
                        'field' => 'field_testimonials_source',
                        'operator' => '==',
                        'value' => 'custom',
                    ),
                ),
            ),
            'sub_fields' => array(
                array(
                    'key' => 'field_testimonial_text',
                    'label' => 'Testimonial Text',
                    'name' => 'testimonial_text',
                    'type' => 'textarea',
                    'rows' => 4,
                ),
                array(
                    'key' => 'field_testimonial_author',
                    'label' => 'Author Name',
                    'name' => 'author_name',
                    'type' => 'text',
                    'wrapper' => array(
                        'width' => '50',
                    ),
                ),
                array(
                    'key' => 'field_testimonial_show_rating',
                    'label' => 'Show Rating',
                    'name' => 'show_rating',
                    'type' => 'true_false',
                    'instructions' => 'Display star rating for this testimonial',
                    'default_value' => 1,
                    'ui' => 1,
                    'wrapper' => array(
                        'width' => '25',
                    ),
                ),
                array(
                    'key' => 'field_testimonial_rating',
                    'label' => 'Rating',
                    'name' => 'rating',
                    'type' => 'select',
                    'instructions' => 'Select star rating (only shown if "Show Rating" is enabled)',
                    'choices' => array(
                        '' => 'No Rating',
                        '5' => '5 Stars',
                        '4' => '4 Stars',
                        '3' => '3 Stars',
                        '2' => '2 Stars',
                        '1' => '1 Star',
                    ),
                    'default_value' => '5',
                    'conditional_logic' => array(
                        array(
                            array(
                                'field' => 'field_testimonial_show_rating',
                                'operator' => '==',
                                'value' => '1',
                            ),
                        ),
                    ),
                    'wrapper' => array(
                        'width' => '25',
                    ),
                ),
            ),
        ),
        
        // Testimonials Carousel Settings Tab
        array(
            'key' => 'field_testimonials_carousel_tab',
            'label' => 'Carousel Settings',
            'name' => '',
            'type' => 'tab',
            'placement' => 'top',
        ),
        array(
            'key' => 'field_testimonials_show_dots',
            'label' => 'Show Navigation Dots',
            'name' => 'testimonials_show_dots',
            'type' => 'true_false',
            'instructions' => 'Display indicator dots below testimonials',
            'default_value' => 1,
            'ui' => 1,
            'wrapper' => array(
                'width' => '33',
            ),
        ),
        array(
            'key' => 'field_testimonials_show_arrows',
            'label' => 'Show Navigation Arrows',
            'name' => 'testimonials_show_arrows',
            'type' => 'true_false',
            'instructions' => 'Display previous/next arrows',
            'default_value' => 1,
            'ui' => 1,
            'wrapper' => array(
                'width' => '33',
            ),
        ),
        array(
            'key' => 'field_testimonials_autoplay',
            'label' => 'Autoplay Speed (seconds)',
            'name' => 'testimonials_autoplay',
            'type' => 'number',
            'instructions' => 'Set to 0 to disable autoplay. Recommended: 5-8 seconds',
            'default_value' => 6,
            'min' => 0,
            'max' => 30,
            'wrapper' => array(
                'width' => '34',
            ),
        ),
        
        // Contact Section Tab
        array(
            'key' => 'field_contact_tab',
            'label' => 'Contact Section',
            'name' => '',
            'type' => 'tab',
            'placement' => 'top',
        ),
        array(
            'key' => 'field_contact_headline',
            'label' => 'Contact Headline',
            'name' => 'contact_headline',
            'type' => 'text',
            'placeholder' => 'Get Started With Coaching',
        ),
        array(
            'key' => 'field_contact_description',
            'label' => 'Contact Description',
            'name' => 'contact_description',
            'type' => 'textarea',
            'instructions' => 'Text above the contact form (optional)',
            'rows' => 3,
        ),
        array(
            'key' => 'field_contact_form_type',
            'label' => 'Contact Form Type',
            'name' => 'contact_form_type',
            'type' => 'radio',
            'instructions' => 'Choose which type of form to display',
            'choices' => array(
                'built_in' => 'Built-in Contact Form',
                'gravity' => 'Gravity Form',
                'none' => 'No Form',
            ),
            'default_value' => 'built_in',
            'layout' => 'vertical',
        ),
        array(
            'key' => 'field_contact_button_text',
            'label' => 'Contact Button Text',
            'name' => 'contact_button_text',
            'type' => 'text',
            'instructions' => 'Text for the contact form submit button',
            'placeholder' => 'SUBMIT APPLICATION',
            'conditional_logic' => array(
                array(
                    array(
                        'field' => 'field_contact_form_type',
                        'operator' => '==',
                        'value' => 'built_in',
                    ),
                ),
            ),
        ),
        array(
            'key' => 'field_gravity_form_id',
            'label' => 'Gravity Form ID',
            'name' => 'gravity_form_id',
            'type' => 'number',
            'instructions' => 'Enter the ID of your Gravity Form (found in Forms > All Forms)',
            'placeholder' => '1',
            'conditional_logic' => array(
                array(
                    array(
                        'field' => 'field_contact_form_type',
                        'operator' => '==',
                        'value' => 'gravity',
                    ),
                ),
            ),
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'page_type',
                'operator' => '==',
                'value' => 'front_page',
            ),
        ),
    ),
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'active' => true,
));

endif; 