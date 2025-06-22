/**
 * Testimonials Carousel
 * Displays 3 testimonials at a time with navigation and autoplay
 */
class TestimonialsCarousel {
    constructor(element) {
        this.carousel = element;
        this.container = this.carousel.querySelector('.testimonials-container');
        this.testimonials = Array.from(this.container.querySelectorAll('.testimonial'));
        this.prevButton = document.querySelector('.carousel-prev');
        this.nextButton = document.querySelector('.carousel-next');
        this.dotsContainer = document.querySelector('.carousel-dots');
        
        // Settings from data attributes
        this.autoplaySpeed = parseInt(this.carousel.dataset.autoplay) * 1000 || 0;
        this.showDots = this.carousel.dataset.showDots === 'true';
        this.showArrows = this.carousel.dataset.showArrows === 'true';
        
        // Carousel state
        this.currentSlide = 0;
        this.slidesToShow = 3;
        this.totalSlides = Math.ceil(this.testimonials.length / this.slidesToShow);
        this.autoplayTimer = null;
        this.isAnimating = false;
        
        this.init();
    }
    
    init() {
        if (this.testimonials.length === 0) return;
        
        this.setupCarousel();
        this.setupDots();
        this.setupArrows();
        this.setupResponsive();
        this.startAutoplay();
        
        // Handle window resize
        window.addEventListener('resize', () => this.handleResize());
    }
    
    setupCarousel() {
        // Much simpler approach - just work with existing testimonials
        this.slides = this.testimonials;
        this.totalSlides = this.testimonials.length;
        
        // Set initial positions for all testimonials
        this.testimonials.forEach((testimonial, index) => {
            testimonial.style.position = 'absolute';
            testimonial.style.width = '100%';
            testimonial.style.left = '0';
            testimonial.style.top = '0';
            testimonial.style.transform = `translateX(${index * 100}%)`;
            testimonial.style.transition = 'transform 0.5s ease-in-out';
            testimonial.style.opacity = '1';
            testimonial.style.visibility = 'visible';
        });
        
        // Set container to relative positioning
        this.container.style.position = 'relative';
        this.container.style.height = '300px';
        this.container.style.overflow = 'hidden';
        
        // Set initial position
        this.updateCarousel();
    }
    
    setupDots() {
        if (!this.showDots || !this.dotsContainer) return;
        
        this.dotsContainer.innerHTML = '';
        
        for (let i = 0; i < this.totalSlides; i++) {
            const dot = document.createElement('button');
            dot.className = 'carousel-dot';
            dot.setAttribute('aria-label', `Go to slide ${i + 1}`);
            dot.addEventListener('click', () => this.goToSlide(i));
            this.dotsContainer.appendChild(dot);
        }
        
        this.dots = Array.from(this.dotsContainer.querySelectorAll('.carousel-dot'));
        this.updateDots();
    }
    
    setupArrows() {
        if (!this.showArrows) return;
        
        if (this.prevButton) {
            this.prevButton.addEventListener('click', () => this.prevSlide());
        }
        
        if (this.nextButton) {
            this.nextButton.addEventListener('click', () => this.nextSlide());
        }
    }
    
    setupResponsive() {
        // Simplified responsive - just one testimonial per slide for now
        // We can enhance this later once basic functionality works
        this.slidesToShow = 1;
    }
    
    handleResize() {
        clearTimeout(this.resizeTimer);
        this.resizeTimer = setTimeout(() => {
            this.setupResponsive();
        }, 250);
    }
    
    goToSlide(index) {
        if (this.isAnimating || index === this.currentSlide) return;
        
        this.currentSlide = index;
        this.updateCarousel();
        this.updateDots();
        this.resetAutoplay();
    }
    
    nextSlide() {
        const nextIndex = (this.currentSlide + 1) % this.totalSlides;
        this.goToSlide(nextIndex);
    }
    
    prevSlide() {
        const prevIndex = (this.currentSlide - 1 + this.totalSlides) % this.totalSlides;
        this.goToSlide(prevIndex);
    }
    
    updateCarousel() {
        if (!this.slides.length) return;
        
        this.isAnimating = true;
        
        // Simple slide positioning - each testimonial moves as one slide
        this.testimonials.forEach((testimonial, index) => {
            testimonial.style.transform = `translateX(${(index - this.currentSlide) * 100}%)`;
            testimonial.classList.toggle('active', index === this.currentSlide);
        });
        
        // Reset animation flag after transition
        setTimeout(() => {
            this.isAnimating = false;
        }, 500);
    }
    
    updateDots() {
        if (!this.dots) return;
        
        this.dots.forEach((dot, index) => {
            dot.classList.toggle('active', index === this.currentSlide);
        });
    }
    
    startAutoplay() {
        if (this.autoplaySpeed <= 0) return;
        
        this.autoplayTimer = setInterval(() => {
            this.nextSlide();
        }, this.autoplaySpeed);
    }
    
    stopAutoplay() {
        if (this.autoplayTimer) {
            clearInterval(this.autoplayTimer);
            this.autoplayTimer = null;
        }
    }
    
    resetAutoplay() {
        this.stopAutoplay();
        this.startAutoplay();
    }
    
    pauseOnHover() {
        this.carousel.addEventListener('mouseenter', () => this.stopAutoplay());
        this.carousel.addEventListener('mouseleave', () => this.startAutoplay());
    }
}

// Initialize carousel when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    const carouselElement = document.querySelector('.testimonials-carousel');
    
    if (carouselElement) {
        const carousel = new TestimonialsCarousel(carouselElement);
        carousel.pauseOnHover();
    }
}); 