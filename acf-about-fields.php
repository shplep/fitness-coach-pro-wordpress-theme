<?php
/**
 * ACF Field Group Configuration for About Page
 * 
 * To use this file:
 * 1. Make sure Advanced Custom Fields plugin is installed
 * 2. This will automatically create the field group for About pages
 */

// About Page Field Group Configuration
if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
    'key' => 'group_about_page_fields',
    'title' => 'About Page Content',
    'fields' => array(
        // Hero Section Tab
        array(
            'key' => 'field_about_hero_tab',
            'label' => 'Hero Section',
            'name' => '',
            'type' => 'tab',
            'placement' => 'top',
        ),
        array(
            'key' => 'field_about_headline',
            'label' => 'Page Headline',
            'name' => 'about_headline',
            'type' => 'text',
            'instructions' => 'Main headline for the about page',
            'placeholder' => 'About Me',
        ),
        array(
            'key' => 'field_about_intro',
            'label' => 'Introduction Text',
            'name' => 'about_intro',
            'type' => 'textarea',
            'instructions' => 'Brief introduction paragraph that appears under the headline',
            'rows' => 3,
            'placeholder' => 'Hi, I\'m [Your Name], a certified fitness coach dedicated to helping you achieve your health and wellness goals...',
        ),
        
        // Profile Images Tab
        array(
            'key' => 'field_about_images_tab',
            'label' => 'Profile Images',
            'name' => '',
            'type' => 'tab',
            'placement' => 'top',
        ),
        array(
            'key' => 'field_profile_images_title',
            'label' => 'Profile Images Section Title',
            'name' => 'profile_images_title',
            'type' => 'text',
            'instructions' => 'Heading for the profile images section',
            'placeholder' => 'Gallery',
            'default_value' => 'Gallery',
        ),
        array(
            'key' => 'field_profile_images',
            'label' => 'Profile Images',
            'name' => 'profile_images',
            'type' => 'repeater',
            'instructions' => 'Add multiple images of yourself to showcase your personality and expertise',
            'layout' => 'block',
            'button_label' => 'Add Profile Image',
            'sub_fields' => array(
                array(
                    'key' => 'field_profile_image',
                    'label' => 'Image',
                    'name' => 'image',
                    'type' => 'image',
                    'return_format' => 'array',
                    'preview_size' => 'medium',
                    'wrapper' => array(
                        'width' => '40',
                    ),
                ),
                array(
                    'key' => 'field_profile_image_caption',
                    'label' => 'Caption',
                    'name' => 'caption',
                    'type' => 'text',
                    'placeholder' => 'Professional headshot, Training session, etc.',
                    'wrapper' => array(
                        'width' => '30',
                    ),
                ),
                array(
                    'key' => 'field_profile_image_size',
                    'label' => 'Image Size',
                    'name' => 'image_size',
                    'type' => 'select',
                    'instructions' => 'Choose the display size for this image',
                    'choices' => array(
                        'large' => 'Large (Featured)',
                        'medium' => 'Medium',
                        'small' => 'Small',
                    ),
                    'default_value' => 'medium',
                    'wrapper' => array(
                        'width' => '30',
                    ),
                ),
            ),
        ),
        
        // Video Section Tab
        array(
            'key' => 'field_about_video_tab',
            'label' => 'Introduction Video',
            'name' => '',
            'type' => 'tab',
            'placement' => 'top',
        ),
        array(
            'key' => 'field_video_section_title',
            'label' => 'Video Section Title',
            'name' => 'video_section_title',
            'type' => 'text',
            'instructions' => 'Heading for the introduction video section',
            'placeholder' => 'Meet Your Coach',
            'default_value' => 'Meet Your Coach',
        ),
        array(
            'key' => 'field_youtube_video_url',
            'label' => 'YouTube Video URL',
            'name' => 'youtube_video_url',
            'type' => 'url',
            'instructions' => 'Paste your YouTube video URL here (supports youtube.com/watch, youtu.be, and youtube.com/embed formats)',
            'placeholder' => 'https://www.youtube.com/watch?v=VIDEO_ID or https://youtu.be/VIDEO_ID',
        ),
        
        // Story Section Tab
        array(
            'key' => 'field_about_story_tab',
            'label' => 'My Story',
            'name' => '',
            'type' => 'tab',
            'placement' => 'top',
        ),
        array(
            'key' => 'field_about_story',
            'label' => 'Your Story',
            'name' => 'about_story',
            'type' => 'wysiwyg',
            'instructions' => 'Tell your personal story, journey into fitness, and what drives your passion for helping others',
            'toolbar' => 'full',
            'media_upload' => 1,
        ),
        
        // Credentials Tab
        array(
            'key' => 'field_about_credentials_tab',
            'label' => 'Credentials',
            'name' => '',
            'type' => 'tab',
            'placement' => 'top',
        ),
        array(
            'key' => 'field_credentials_title',
            'label' => 'Credentials Section Title',
            'name' => 'credentials_title',
            'type' => 'text',
            'placeholder' => 'Qualifications & Experience',
        ),
        array(
            'key' => 'field_credentials_list',
            'label' => 'Credentials List',
            'name' => 'credentials_list',
            'type' => 'repeater',
            'instructions' => 'Add your certifications, qualifications, and professional experience',
            'layout' => 'block',
            'button_label' => 'Add Credential',
            'sub_fields' => array(
                array(
                    'key' => 'field_credential_icon',
                    'label' => 'Icon (Optional)',
                    'name' => 'credential_icon',
                    'type' => 'image',
                    'instructions' => 'Small icon representing this credential (optional)',
                    'return_format' => 'array',
                    'preview_size' => 'thumbnail',
                    'wrapper' => array(
                        'width' => '20',
                    ),
                ),
                array(
                    'key' => 'field_credential_title',
                    'label' => 'Credential Title',
                    'name' => 'credential_title',
                    'type' => 'text',
                    'placeholder' => 'Certified Personal Trainer',
                    'wrapper' => array(
                        'width' => '40',
                    ),
                ),
                array(
                    'key' => 'field_credential_year',
                    'label' => 'Year/Duration',
                    'name' => 'credential_year',
                    'type' => 'text',
                    'placeholder' => '2020 or 2018-Present',
                    'wrapper' => array(
                        'width' => '20',
                    ),
                ),
                array(
                    'key' => 'field_credential_organization',
                    'label' => 'Organization',
                    'name' => 'credential_organization',
                    'type' => 'text',
                    'placeholder' => 'NASM, ACE, etc.',
                    'wrapper' => array(
                        'width' => '20',
                    ),
                ),
                array(
                    'key' => 'field_credential_description',
                    'label' => 'Description',
                    'name' => 'credential_description',
                    'type' => 'textarea',
                    'instructions' => 'Brief description of this credential or experience',
                    'rows' => 2,
                ),
            ),
        ),
        
        // Personal Touch Tab
        array(
            'key' => 'field_about_personal_tab',
            'label' => 'Personal Touch',
            'name' => '',
            'type' => 'tab',
            'placement' => 'top',
        ),
        array(
            'key' => 'field_personal_touch_title',
            'label' => 'Personal Section Title',
            'name' => 'personal_touch_title',
            'type' => 'text',
            'placeholder' => 'Beyond Fitness',
            'instructions' => 'Title for the personal/lifestyle section',
        ),
        array(
            'key' => 'field_personal_touch_text',
            'label' => 'Personal Content',
            'name' => 'personal_touch_text',
            'type' => 'wysiwyg',
            'instructions' => 'Share personal interests, hobbies, family life, or anything that helps clients connect with you on a personal level',
            'toolbar' => 'full',
            'media_upload' => 1,
        ),
        
        // CTA Section Tab
        array(
            'key' => 'field_about_cta_tab',
            'label' => 'Call to Action',
            'name' => '',
            'type' => 'tab',
            'placement' => 'top',
        ),
        array(
            'key' => 'field_about_cta_section',
            'label' => 'Call to Action Content',
            'name' => 'about_cta_section',
            'type' => 'wysiwyg',
            'instructions' => 'Add a call-to-action at the bottom of your about page (optional). You can include buttons, links, or contact information.',
            'toolbar' => 'full',
            'media_upload' => 1,
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'page_template',
                'operator' => '==',
                'value' => 'page-about.php',
            ),
        ),
        array(
            array(
                'param' => 'post_title',
                'operator' => '==',
                'value' => 'About',
            ),
        ),
        array(
            array(
                'param' => 'post_title',
                'operator' => '==',
                'value' => 'About Me',
            ),
        ),
        array(
            array(
                'param' => 'post_title',
                'operator' => '==',
                'value' => 'About Us',
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