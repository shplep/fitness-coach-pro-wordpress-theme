<?php
/**
 * ACF Fields for Image and Text Rows Page Template
 */

if (function_exists('acf_add_local_field_group')) {

    acf_add_local_field_group(array(
        'key' => 'group_image_text_rows',
        'title' => 'Image and Text Rows Content',
        'fields' => array(
            
            // Hero Section Tab
            array(
                'key' => 'field_hero_section_tab',
                'label' => 'Hero Section',
                'name' => '',
                'type' => 'tab',
                'placement' => 'top',
            ),
            
            // Show Hero Section
            array(
                'key' => 'field_show_hero',
                'label' => 'Show Hero Section',
                'name' => 'show_hero',
                'type' => 'true_false',
                'instructions' => 'Display a hero section at the top of the page',
                'default_value' => 1,
                'ui' => 1,
            ),
            
            // Hero Subtitle
            array(
                'key' => 'field_hero_subtitle_text',
                'label' => 'Hero Subtitle',
                'name' => 'hero_subtitle',
                'type' => 'text',
                'instructions' => 'Optional subtitle text that appears below the page title',
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'field_show_hero',
                            'operator' => '==',
                            'value' => '1',
                        ),
                    ),
                ),
            ),
            
            // Hero Description
            array(
                'key' => 'field_hero_description_text',
                'label' => 'Hero Description',
                'name' => 'hero_description',
                'type' => 'textarea',
                'instructions' => 'Optional description text for the hero section',
                'rows' => 3,
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'field_show_hero',
                            'operator' => '==',
                            'value' => '1',
                        ),
                    ),
                ),
            ),
            
            // Content Rows Tab
            array(
                'key' => 'field_content_rows_tab',
                'label' => 'Content Rows',
                'name' => '',
                'type' => 'tab',
                'placement' => 'top',
            ),
            
            // Content Rows Repeater
            array(
                'key' => 'field_content_rows',
                'label' => 'Content Rows',
                'name' => 'content_rows',
                'type' => 'repeater',
                'instructions' => 'Add rows with text and image content. You can choose the layout for each row.',
                'min' => 1,
                'max' => 20,
                'layout' => 'block',
                'button_label' => 'Add Content Row',
                'sub_fields' => array(
                    
                    // Row Layout
                    array(
                        'key' => 'field_row_layout',
                        'label' => 'Row Layout',
                        'name' => 'row_layout',
                        'type' => 'select',
                        'instructions' => 'Choose the layout for this row',
                        'required' => 1,
                        'choices' => array(
                            'text_left' => 'Text Left (65%) + Image Right (35%)',
                            'text_right' => 'Image Left (35%) + Text Right (65%)',
                            'text_only' => 'Text Only (100% width)',
                        ),
                        'default_value' => 'text_left',
                    ),
                    
                    // Text Content
                    array(
                        'key' => 'field_text_content',
                        'label' => 'Text Content',
                        'name' => 'text_content',
                        'type' => 'wysiwyg',
                        'instructions' => 'Add your text content (supports rich text formatting)',
                        'required' => 1,
                        'tabs' => 'all',
                        'toolbar' => 'full',
                        'media_upload' => 0,
                    ),
                    
                    // Image
                    array(
                        'key' => 'field_row_image',
                        'label' => 'Image',
                        'name' => 'row_image',
                        'type' => 'image',
                        'instructions' => 'Upload an image for this row (not required for Text Only layout)',
                        'required' => 0,
                        'return_format' => 'array',
                        'preview_size' => 'medium',
                        'library' => 'all',
                        'conditional_logic' => array(
                            array(
                                array(
                                    'field' => 'field_row_layout',
                                    'operator' => '!=',
                                    'value' => 'text_only',
                                ),
                            ),
                        ),
                    ),
                    
                    // Image Alt Text (for accessibility)
                    array(
                        'key' => 'field_image_alt',
                        'label' => 'Image Alt Text',
                        'name' => 'image_alt',
                        'type' => 'text',
                        'instructions' => 'Alternative text for the image (important for accessibility)',
                        'placeholder' => 'Describe what the image shows...',
                        'conditional_logic' => array(
                            array(
                                array(
                                    'field' => 'field_row_layout',
                                    'operator' => '!=',
                                    'value' => 'text_only',
                                ),
                            ),
                        ),
                    ),
                    
                    // Image Link URL (optional)
                    array(
                        'key' => 'field_image_url',
                        'label' => 'Image Link URL (Optional)',
                        'name' => 'image_url',
                        'type' => 'url',
                        'instructions' => 'Optional: Add a URL to make the image clickable (leave empty for no link)',
                        'placeholder' => 'https://example.com',
                        'conditional_logic' => array(
                            array(
                                array(
                                    'field' => 'field_row_layout',
                                    'operator' => '!=',
                                    'value' => 'text_only',
                                ),
                            ),
                        ),
                    ),
                    
                    // Link Target (for image URL)
                    array(
                        'key' => 'field_image_link_target',
                        'label' => 'Open Link In',
                        'name' => 'image_link_target',
                        'type' => 'select',
                        'instructions' => 'Choose how the link should open',
                        'choices' => array(
                            '_self' => 'Same window/tab',
                            '_blank' => 'New window/tab',
                        ),
                        'default_value' => '_self',
                        'conditional_logic' => array(
                            array(
                                array(
                                    'field' => 'field_row_layout',
                                    'operator' => '!=',
                                    'value' => 'text_only',
                                ),
                                array(
                                    'field' => 'field_image_url',
                                    'operator' => '!=',
                                    'value' => '',
                                ),
                            ),
                        ),
                    ),
                    
                    // Enable Lightbox
                    array(
                        'key' => 'field_enable_lightbox',
                        'label' => 'Open Image in Lightbox',
                        'name' => 'enable_lightbox',
                        'type' => 'true_false',
                        'instructions' => 'Enable this to open the image in a lightbox overlay when clicked (overrides URL link if both are set)',
                        'default_value' => 0,
                        'ui' => 1,
                        'conditional_logic' => array(
                            array(
                                array(
                                    'field' => 'field_row_layout',
                                    'operator' => '!=',
                                    'value' => 'text_only',
                                ),
                            ),
                        ),
                    ),
                    
                    // Background Color
                    array(
                        'key' => 'field_row_background',
                        'label' => 'Row Background',
                        'name' => 'row_background',
                        'type' => 'select',
                        'instructions' => 'Choose a background style for this row',
                        'choices' => array(
                            'white' => 'White Background',
                            'light_gray' => 'Light Gray Background',
                            'primary' => 'Primary Color Background',
                            'gradient' => 'Gradient Background',
                        ),
                        'default_value' => 'white',
                    ),
                    
                    // Text Alignment
                    array(
                        'key' => 'field_text_alignment',
                        'label' => 'Text Vertical Alignment',
                        'name' => 'text_alignment',
                        'type' => 'select',
                        'instructions' => 'How should the text be aligned vertically with the image?',
                        'choices' => array(
                            'center' => 'Center (default)',
                            'top' => 'Top',
                            'bottom' => 'Bottom',
                        ),
                        'default_value' => 'center',
                    ),
                    
                    // Padding Controls
                    array(
                        'key' => 'field_padding_top',
                        'label' => 'Top Padding',
                        'name' => 'padding_top',
                        'type' => 'select',
                        'instructions' => 'Control the top padding of this row',
                        'choices' => array(
                            'default' => 'Default (4rem)',
                            'none' => 'None (0)',
                            'small' => 'Small (2rem)',
                            'medium' => 'Medium (3rem)',
                            'large' => 'Large (5rem)',
                            'extra_large' => 'Extra Large (6rem)',
                        ),
                        'default_value' => 'default',
                    ),
                    
                    array(
                        'key' => 'field_padding_bottom',
                        'label' => 'Bottom Padding',
                        'name' => 'padding_bottom',
                        'type' => 'select',
                        'instructions' => 'Control the bottom padding of this row',
                        'choices' => array(
                            'default' => 'Default (4rem)',
                            'none' => 'None (0)',
                            'small' => 'Small (2rem)',
                            'medium' => 'Medium (3rem)',
                            'large' => 'Large (5rem)',
                            'extra_large' => 'Extra Large (6rem)',
                        ),
                        'default_value' => 'default',
                    ),
                    
                ),
            ),
            
            // Call to Action Tab
            array(
                'key' => 'field_cta_section_tab',
                'label' => 'Call to Action',
                'name' => '',
                'type' => 'tab',
                'placement' => 'top',
            ),
            
            // Show CTA Section
            array(
                'key' => 'field_show_cta',
                'label' => 'Show Call to Action Section',
                'name' => 'show_cta',
                'type' => 'true_false',
                'instructions' => 'Display a call-to-action section at the bottom of the page',
                'default_value' => 1,
                'ui' => 1,
            ),
            
            // CTA Title
            array(
                'key' => 'field_cta_title_text',
                'label' => 'CTA Title',
                'name' => 'cta_title',
                'type' => 'text',
                'default_value' => 'Ready to Get Started?',
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'field_show_cta',
                            'operator' => '==',
                            'value' => '1',
                        ),
                    ),
                ),
            ),
            
            // CTA Description
            array(
                'key' => 'field_cta_description_text',
                'label' => 'CTA Description',
                'name' => 'cta_description',
                'type' => 'textarea',
                'default_value' => 'Contact me today to learn more about how I can help you achieve your fitness goals.',
                'rows' => 2,
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'field_show_cta',
                            'operator' => '==',
                            'value' => '1',
                        ),
                    ),
                ),
            ),
            
            // CTA Button Text
            array(
                'key' => 'field_cta_button_text_custom',
                'label' => 'Button Text',
                'name' => 'cta_button_text',
                'type' => 'text',
                'default_value' => 'Get In Touch',
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'field_show_cta',
                            'operator' => '==',
                            'value' => '1',
                        ),
                    ),
                ),
            ),
            
            // CTA Button Link
            array(
                'key' => 'field_cta_button_link_custom',
                'label' => 'Button Link',
                'name' => 'cta_button_link',
                'type' => 'link',
                'instructions' => 'Link for the CTA button (contact page, booking system, etc.)',
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'field_show_cta',
                            'operator' => '==',
                            'value' => '1',
                        ),
                    ),
                ),
            ),
            
        ),
        'location' => array(
            array(
                array(
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'page-template-image-text-rows.php',
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
?> 