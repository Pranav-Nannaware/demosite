// Wait for the DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
    // Hero Slider Functionality
    const slides = document.querySelectorAll('.hero-slider .slide');
    const dots = document.querySelectorAll('.hero-slider .dot');
    const prevBtn = document.querySelector('.hero-slider .prev-btn');
    const nextBtn = document.querySelector('.hero-slider .next-btn');
    let currentSlide = 0;
    let slideInterval;

    // Function to show a specific slide
    function showSlide(index) {
        // Remove active class from all slides and dots
        slides.forEach(slide => slide.classList.remove('active'));
        dots.forEach(dot => dot.classList.remove('active'));
        
        // Add active class to current slide and dot
        slides[index].classList.add('active');
        dots[index].classList.add('active');
        
        // Update current slide index
        currentSlide = index;
    }

    // Function to show the next slide
    function nextSlide() {
        let next = currentSlide + 1;
        if (next >= slides.length) {
            next = 0;
        }
        showSlide(next);
    }

    // Function to show the previous slide
    function prevSlide() {
        let prev = currentSlide - 1;
        if (prev < 0) {
            prev = slides.length - 1;
        }
        showSlide(prev);
    }

    // Set up event listeners for slider controls
    if (prevBtn && nextBtn) {
        prevBtn.addEventListener('click', function() {
            prevSlide();
            resetSlideInterval();
        });

        nextBtn.addEventListener('click', function() {
            nextSlide();
            resetSlideInterval();
        });
    }

    // Set up event listeners for slider dots
    dots.forEach((dot, index) => {
        dot.addEventListener('click', function() {
            showSlide(index);
            resetSlideInterval();
        });
    });

    // Function to start automatic slide transition
    function startSlideInterval() {
        slideInterval = setInterval(nextSlide, 5000);
    }

    // Function to reset slide interval
    function resetSlideInterval() {
        clearInterval(slideInterval);
        startSlideInterval();
    }

    // Start automatic slide transition
    startSlideInterval();

    // Testimonials Slider Functionality
    const testimonials = document.querySelectorAll('.testimonials-slider .testimonial');
    const testimonialPrevBtn = document.querySelector('.testimonials-section .prev-btn');
    const testimonialNextBtn = document.querySelector('.testimonials-section .next-btn');
    let currentTestimonial = 0;

    // Function to show a specific testimonial
    function showTestimonial(index) {
        // Remove active class from all testimonials
        testimonials.forEach(testimonial => testimonial.classList.remove('active'));
        
        // Add active class to current testimonial
        testimonials[index].classList.add('active');
        
        // Update current testimonial index
        currentTestimonial = index;
    }

    // Function to show the next testimonial
    function nextTestimonial() {
        let next = currentTestimonial + 1;
        if (next >= testimonials.length) {
            next = 0;
        }
        showTestimonial(next);
    }

    // Function to show the previous testimonial
    function prevTestimonial() {
        let prev = currentTestimonial - 1;
        if (prev < 0) {
            prev = testimonials.length - 1;
        }
        showTestimonial(prev);
    }

    // Set up event listeners for testimonial controls
    if (testimonialPrevBtn && testimonialNextBtn) {
        testimonialPrevBtn.addEventListener('click', prevTestimonial);
        testimonialNextBtn.addEventListener('click', nextTestimonial);
    }

    // Mobile Menu Toggle
    const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
    const mainNav = document.querySelector('.main-nav');

    if (mobileMenuToggle && mainNav) {
        mobileMenuToggle.addEventListener('click', function() {
            mainNav.classList.toggle('active');
            this.classList.toggle('active');
        });
    }

    // Smooth Scrolling for Anchor Links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            
            const targetId = this.getAttribute('href');
            if (targetId === '#') return;
            
            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
                
                // Close mobile menu if open
                if (mainNav && mainNav.classList.contains('active')) {
                    mainNav.classList.remove('active');
                    if (mobileMenuToggle) {
                        mobileMenuToggle.classList.remove('active');
                    }
                }
            }
        });
    });

    // Form Submission
    const contactForm = document.querySelector('.contact-form form');
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Here you would typically send the form data to a server
            // For demonstration, we'll just show an alert
            alert('Thank you for your message! We will get back to you soon.');
            this.reset();
        });
    }

    // Add sticky header effect on scroll
    window.addEventListener('scroll', function() {
        const header = document.getElementById('header');
        if (header) {
            if (window.scrollY > 100) {
                header.classList.add('sticky');
            } else {
                header.classList.remove('sticky');
            }
        }
    });

    // Add animation on scroll
    const animateElements = document.querySelectorAll('.animate-on-scroll');
    
    function checkIfInView() {
        animateElements.forEach(element => {
            const elementTop = element.getBoundingClientRect().top;
            const elementVisible = 150;
            
            if (elementTop < window.innerHeight - elementVisible) {
                element.classList.add('visible');
            }
        });
    }

    // Initial check on page load
    checkIfInView();
    
    // Check on scroll
    window.addEventListener('scroll', checkIfInView);
}); 