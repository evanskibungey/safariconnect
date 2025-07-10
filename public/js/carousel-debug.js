// Carousel Debug Script
console.log('Carousel Debug Script Loaded');

// Check if all carousel elements exist
document.addEventListener('DOMContentLoaded', function() {
    const elements = {
        slides: document.querySelectorAll('.carousel-slide'),
        contents: document.querySelectorAll('.hero-content'),
        indicators: document.querySelectorAll('.carousel-indicator'),
        prevBtn: document.getElementById('carousel-prev'),
        nextBtn: document.getElementById('carousel-next'),
        heroSection: document.getElementById('hero-section')
    };
    
    console.log('Carousel Elements Check:', {
        'Slides found': elements.slides.length,
        'Contents found': elements.contents.length,
        'Indicators found': elements.indicators.length,
        'Prev button': elements.prevBtn ? 'Found' : 'Not found',
        'Next button': elements.nextBtn ? 'Found' : 'Not found',
        'Hero section': elements.heroSection ? 'Found' : 'Not found'
    });
    
    // Check initial visibility
    elements.slides.forEach((slide, index) => {
        console.log(`Slide ${index} opacity:`, window.getComputedStyle(slide).opacity);
    });
    
    elements.contents.forEach((content, index) => {
        console.log(`Content ${index} opacity:`, window.getComputedStyle(content).opacity);
    });
});
