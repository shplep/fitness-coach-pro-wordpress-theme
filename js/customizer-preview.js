/**
 * Customizer Live Preview
 * Handles real-time updates for typography settings
 */

(function($) {
    'use strict';

    // Helper function to update Google Fonts
    function updateGoogleFonts() {
        const headingFont = wp.customize('fitness_coach_heading_font')();
        const bodyFont = wp.customize('fitness_coach_body_font')();
        const headingWeight = wp.customize('fitness_coach_heading_weight')();
        const bodyWeight = wp.customize('fitness_coach_body_weight')();
        
        // Remove existing Google Fonts link
        $('#fitness-coach-google-fonts-css').remove();
        
        if (headingFont || bodyFont) {
            const fonts = [];
            
            // Add heading font with weights
            if (headingFont) {
                const headingWeights = [headingWeight, '400', '700'].filter((v, i, a) => a.indexOf(v) === i);
                fonts.push(headingFont + ':' + headingWeights.join(','));
            }
            
            // Add body font with weights (if different from heading font)
            if (bodyFont && bodyFont !== headingFont) {
                const bodyWeights = [bodyWeight, '400', '700'].filter((v, i, a) => a.indexOf(v) === i);
                fonts.push(bodyFont + ':' + bodyWeights.join(','));
            } else if (bodyFont === headingFont && bodyWeight !== headingWeight) {
                // Same font but different weight, combine weights
                const allWeights = [headingWeight, bodyWeight, '400', '700'].filter((v, i, a) => a.indexOf(v) === i);
                fonts.splice(0, 1, bodyFont + ':' + allWeights.join(','));
            }
            
            if (fonts.length > 0) {
                // Use Google Fonts API v2 format
                const familyParams = fonts.map(font => 'family=' + font.replace(/ /g, '+'));
                const fontsUrl = 'https://fonts.googleapis.com/css2?' + 
                    familyParams.join('&') + 
                    '&display=swap';
                
                $('<link>')
                    .attr({
                        'id': 'fitness-coach-google-fonts-css',
                        'rel': 'stylesheet',
                        'type': 'text/css',
                        'href': fontsUrl
                    })
                    .appendTo('head');
            }
        }
    }

    // Helper function to update typography CSS
    function updateTypographyCSS() {
        const headingFont = wp.customize('fitness_coach_heading_font')();
        const bodyFont = wp.customize('fitness_coach_body_font')();
        const headingWeight = wp.customize('fitness_coach_heading_weight')();
        const bodyWeight = wp.customize('fitness_coach_body_weight')();
        const fontScale = wp.customize('fitness_coach_font_size_scale')();
        
        const scaleFactor = fontScale / 100;
        
        const css = `
        :root {
            --font-scale: ${scaleFactor};
        }
        
        body {
            font-family: '${bodyFont}', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif !important;
            font-weight: ${bodyWeight} !important;
            font-size: calc(1rem * var(--font-scale)) !important;
            line-height: calc(1.6 * var(--font-scale)) !important;
        }
        
        h1, h2, h3, h4, h5, h6, .site-title {
            font-family: '${headingFont}', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif !important;
            font-weight: ${headingWeight} !important;
        }
        
        h1 {
            font-size: calc(2.5rem * var(--font-scale)) !important;
            line-height: calc(1.2 * var(--font-scale)) !important;
        }
        
        h2 {
            font-size: calc(2rem * var(--font-scale)) !important;
            line-height: calc(1.3 * var(--font-scale)) !important;
        }
        
        h3 {
            font-size: calc(1.75rem * var(--font-scale)) !important;
            line-height: calc(1.4 * var(--font-scale)) !important;
        }
        
        h4 {
            font-size: calc(1.5rem * var(--font-scale)) !important;
            line-height: calc(1.4 * var(--font-scale)) !important;
        }
        
        h5 {
            font-size: calc(1.25rem * var(--font-scale)) !important;
            line-height: calc(1.5 * var(--font-scale)) !important;
        }
        
        h6 {
            font-size: calc(1.125rem * var(--font-scale)) !important;
            line-height: calc(1.5 * var(--font-scale)) !important;
        }
        
        .hero h1 {
            font-size: calc(3rem * var(--font-scale)) !important;
        }
        
        .btn {
            font-family: '${headingFont}', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif !important;
            font-weight: ${headingWeight} !important;
            font-size: calc(1rem * var(--font-scale)) !important;
        }
        
        .nav-link, .main-navigation a {
            font-family: '${headingFont}', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif !important;
            font-weight: ${headingWeight} !important;
            font-size: calc(0.95rem * var(--font-scale)) !important;
        }
        
        .feature-card h3 {
            font-size: calc(1.5rem * var(--font-scale)) !important;
        }
        
        .testimonial-text {
            font-size: calc(1.1rem * var(--font-scale)) !important;
            line-height: calc(1.6 * var(--font-scale)) !important;
        }
        
        .testimonial-author {
            font-weight: ${headingWeight} !important;
            font-size: calc(1rem * var(--font-scale)) !important;
        }
        
        .section-title {
            font-size: calc(2.5rem * var(--font-scale)) !important;
        }
        
        @media (max-width: 768px) {
            h1 {
                font-size: calc(2rem * var(--font-scale)) !important;
            }
            
            h2 {
                font-size: calc(1.75rem * var(--font-scale)) !important;
            }
            
            .hero h1 {
                font-size: calc(2.5rem * var(--font-scale)) !important;
            }
            
            .section-title {
                font-size: calc(2rem * var(--font-scale)) !important;
            }
        }
        `;
        
        // Remove existing typography styles and add new ones
        $('#fitness-coach-typography').remove();
        $('<style>')
            .attr('id', 'fitness-coach-typography')
            .html(css)
            .appendTo('head');
    }

    // Font change handlers
    wp.customize('fitness_coach_heading_font', function(value) {
        value.bind(function(newval) {
            setTimeout(function() {
                updateGoogleFonts();
                updateTypographyCSS();
            }, 100);
        });
    });

    wp.customize('fitness_coach_body_font', function(value) {
        value.bind(function(newval) {
            setTimeout(function() {
                updateGoogleFonts();
                updateTypographyCSS();
            }, 100);
        });
    });

    wp.customize('fitness_coach_heading_weight', function(value) {
        value.bind(function(newval) {
            setTimeout(function() {
                updateGoogleFonts();
                updateTypographyCSS();
            }, 100);
        });
    });

    wp.customize('fitness_coach_body_weight', function(value) {
        value.bind(function(newval) {
            setTimeout(function() {
                updateGoogleFonts();
                updateTypographyCSS();
            }, 100);
        });
    });

    wp.customize('fitness_coach_font_size_scale', function(value) {
        value.bind(function(newval) {
            updateTypographyCSS();
        });
    });

})(jQuery); 