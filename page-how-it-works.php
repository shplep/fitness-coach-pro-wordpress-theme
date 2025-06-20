<?php
/**
 * Template Name: How It Works
 * Template for explaining the fitness coaching process
 */

get_header(); ?>

<div class="how-it-works-page">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        
        <!-- Hero Section -->
        <section class="how-it-works-hero">
            <div class="container">
                <h1 class="page-title"><?php the_title(); ?></h1>
                <div class="hero-subtitle">
                    <p>Your transformation journey, simplified into clear, actionable steps</p>
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
                    
                    <!-- Step 1: Initial Consultation -->
                    <div class="step-item" data-step="1">
                        <div class="step-number">
                            <span>01</span>
                        </div>
                        <div class="step-content">
                            <div class="step-icon">
                                <svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="9" cy="7" r="4"></circle>
                                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                </svg>
                            </div>
                            <h3>Initial Consultation</h3>
                            <p>We start with a comprehensive discussion about your goals, current fitness level, lifestyle, and any challenges you're facing. This helps me understand where you are and where you want to go.</p>
                            <ul class="step-features">
                                <li>Goal assessment and priority setting</li>
                                <li>Health and fitness history review</li>
                                <li>Lifestyle and schedule analysis</li>
                                <li>Expectations and timeline discussion</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Step 2: Assessment & Planning -->
                    <div class="step-item" data-step="2">
                        <div class="step-number">
                            <span>02</span>
                        </div>
                        <div class="step-content">
                            <div class="step-icon">
                                <svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                    <polyline points="14,2 14,8 20,8"></polyline>
                                    <line x1="16" y1="13" x2="8" y2="13"></line>
                                    <line x1="16" y1="17" x2="8" y2="17"></line>
                                    <polyline points="10,9 9,9 8,9"></polyline>
                                </svg>
                            </div>
                            <h3>Custom Plan Creation</h3>
                            <p>Based on our consultation, I create a personalized fitness and nutrition plan tailored specifically to your goals, preferences, and lifestyle constraints.</p>
                            <ul class="step-features">
                                <li>Customized workout routines</li>
                                <li>Personalized nutrition guidelines</li>
                                <li>Progressive milestone mapping</li>
                                <li>Equipment and resource planning</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Step 3: Implementation & Training -->
                    <div class="step-item" data-step="3">
                        <div class="step-number">
                            <span>03</span>
                        </div>
                        <div class="step-content">
                            <div class="step-icon">
                                <svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M22 12h-4l-3 9L9 3l-3 9H2"></path>
                                </svg>
                            </div>
                            <h3>Training & Execution</h3>
                            <p>We begin implementing your plan with hands-on training sessions, proper form instruction, and building sustainable habits that fit your lifestyle.</p>
                            <ul class="step-features">
                                <li>One-on-one training sessions</li>
                                <li>Form correction and technique training</li>
                                <li>Habit formation and routine building</li>
                                <li>Real-time feedback and adjustments</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Step 4: Monitoring & Support -->
                    <div class="step-item" data-step="4">
                        <div class="step-number">
                            <span>04</span>
                        </div>
                        <div class="step-content">
                            <div class="step-icon">
                                <svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M3 3v18h18"></path>
                                    <path d="M18.7 8l-5.1 5.2-2.8-2.7L7 14.3"></path>
                                </svg>
                            </div>
                            <h3>Progress Tracking</h3>
                            <p>Regular check-ins, progress measurements, and plan adjustments ensure you stay on track and continue making steady progress toward your goals.</p>
                            <ul class="step-features">
                                <li>Weekly progress assessments</li>
                                <li>Performance metric tracking</li>
                                <li>Plan optimization and adjustments</li>
                                <li>Motivation and accountability support</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Step 5: Results & Maintenance -->
                    <div class="step-item" data-step="5">
                        <div class="step-number">
                            <span>05</span>
                        </div>
                        <div class="step-content">
                            <div class="step-icon">
                                <svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M6 9l6 6 6-6"></path>
                                    <circle cx="12" cy="12" r="10"></circle>
                                </svg>
                            </div>
                            <h3>Achievement & Beyond</h3>
                            <p>Celebrate your success and establish a sustainable maintenance plan to keep your results long-term, with ongoing support as needed.</p>
                            <ul class="step-features">
                                <li>Goal achievement celebration</li>
                                <li>Maintenance strategy development</li>
                                <li>Long-term sustainability planning</li>
                                <li>Continued support options</li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- Timeline Visualization -->
        <section class="process-timeline">
            <div class="container">
                <h2 class="section-title">Your Transformation Timeline</h2>
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-marker"></div>
                        <div class="timeline-content">
                            <h4>Week 1-2</h4>
                            <p>Consultation, assessment, and plan creation. Getting started with proper form and habit building.</p>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-marker"></div>
                        <div class="timeline-content">
                            <h4>Week 3-8</h4>
                            <p>Intensive training phase with regular progress tracking and plan refinements.</p>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-marker"></div>
                        <div class="timeline-content">
                            <h4>Week 9-12</h4>
                            <p>Advanced training, goal achievement, and transition to maintenance strategies.</p>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-marker"></div>
                        <div class="timeline-content">
                            <h4>Ongoing</h4>
                            <p>Maintenance support, advanced goals, and continued transformation journey.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- FAQ Section -->
        <section class="how-it-works-faq">
            <div class="container">
                <h2 class="section-title">Frequently Asked Questions</h2>
                <div class="faq-grid">
                    <div class="faq-item">
                        <h4>How long does it take to see results?</h4>
                        <p>Most clients see initial improvements in energy and strength within 2-3 weeks, with visible physical changes typically appearing after 4-6 weeks of consistent training.</p>
                    </div>
                    <div class="faq-item">
                        <h4>What if I have no gym experience?</h4>
                        <p>Perfect! I specialize in working with beginners. We'll start with the basics and build your confidence and skills progressively.</p>
                    </div>
                    <div class="faq-item">
                        <h4>Do I need special equipment?</h4>
                        <p>Not necessarily. I can design programs for home workouts, gym settings, or minimal equipment based on your preferences and access.</p>
                    </div>
                    <div class="faq-item">
                        <h4>How often will we meet?</h4>
                        <p>This depends on your goals and preferences. Options range from 1-3 sessions per week, with additional check-ins and support as needed.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="how-it-works-cta">
            <div class="container">
                <div class="cta-content">
                    <h2>Ready to Start Your Transformation?</h2>
                    <p>Let's discuss your goals and create a personalized plan that works for you.</p>
                    <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn primary-button">Schedule Your Consultation</a>
                </div>
            </div>
        </section>

    <?php endwhile; endif; ?>
</div>

<?php get_footer(); ?> 