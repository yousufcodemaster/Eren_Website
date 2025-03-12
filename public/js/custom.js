// Add ambient glow effect to headings
document.addEventListener('DOMContentLoaded', () => {
    const headings = document.querySelectorAll('.heading-glow');
    headings.forEach(heading => {
        const glow = document.createElement('div');
        glow.classList.add('heading-glow-effect');
        heading.appendChild(glow);
    });
});

// Intersection Observer for fade-in animations
const fadeInElements = document.querySelectorAll('.interactive-element, .pricing-card');
const fadeInObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
        }
    });
}, {
    threshold: 0.1,
    rootMargin: '50px'
});

fadeInElements.forEach(element => {
    element.style.opacity = '0';
    element.style.transform = 'translateY(20px)';
    element.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
    fadeInObserver.observe(element);
});

// Smooth scroll with offset for header
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        const headerOffset = 100;
        const elementPosition = target.getBoundingClientRect().top;
        const offsetPosition = elementPosition + window.pageYOffset - headerOffset;

        window.scrollTo({
            top: offsetPosition,
            behavior: 'smooth'
        });
    });
});

// Parallax effect for background elements
window.addEventListener('scroll', () => {
    const parallaxElements = document.querySelectorAll('.parallax');
    const scrolled = window.pageYOffset;
    
    parallaxElements.forEach(element => {
        const speed = element.dataset.speed || 0.3;
        const yPos = -(scrolled * speed);
        element.style.transform = `translate3d(0px, ${yPos}px, 0px)`;
    });
});

// Add hover effect to interactive elements
document.querySelectorAll('.interactive-element, .btn-primary, .btn-secondary').forEach(element => {
    element.addEventListener('mouseenter', () => {
        element.style.transform = 'scale(1.05)';
        element.style.boxShadow = '0 0 20px rgba(99, 102, 241, 0.4)';
    });

    element.addEventListener('mouseleave', () => {
        element.style.transform = 'scale(1)';
        element.style.boxShadow = 'none';
    });
}); 