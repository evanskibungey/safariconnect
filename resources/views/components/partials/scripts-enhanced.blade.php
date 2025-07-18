<script>
    // ===================================
    // GLOBAL VARIABLES AND UTILITIES
    // ===================================
    
    // Mobile menu functionality
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');

    if (mobileMenuBtn && mobileMenu) {
        mobileMenuBtn.addEventListener('click', () => {
            const isOpen = mobileMenu.style.transform === 'translateY(0px)';
            mobileMenu.style.transform = isOpen ? 'translateY(-100%)' : 'translateY(0px)';
        });
    }

    // ===================================
    // BOOKING SUCCESS MODAL FUNCTIONALITY
    // ===================================
    
    const bookingSuccessModal = document.getElementById('booking-success-modal');
    const viewDashboardBtn = document.getElementById('view-dashboard-btn');
    const bookAnotherBtn = document.getElementById('book-another-btn');
    
    function showBookingSuccess(result, bookingData) {
        // Populate modal with booking details
        document.getElementById('booking-reference').textContent = result.booking_reference;
        document.getElementById('service-type').textContent = result.booking_details?.service || 'Transportation Service';
        document.getElementById('route-info').textContent = result.booking_details?.route || 'Route information';
        
        // Use travel_info if available, otherwise construct from separate fields
        const travelInfo = result.booking_details?.travel_info || 
            ((result.booking_details?.travel_date || result.booking_details?.pickup_date || result.booking_details?.hire_start_date) + 
            ' at ' + 
            (result.booking_details?.travel_time || result.booking_details?.pickup_time));
        document.getElementById('travel-info').textContent = travelInfo;
        
        document.getElementById('total-amount').textContent = 
            'KSh ' + (result.booking_details?.total_price || 0).toLocaleString();
        
        // Handle account status
        const accountStatus = document.getElementById('account-status');
        const accountMessage = document.getElementById('account-message');
        const accountEmail = document.getElementById('account-email');
        
        if (result.account_created) {
            accountMessage.textContent = 'Your SafariConnect account has been created!';
            accountEmail.textContent = 'Login email: ' + (bookingData.customer_email || result.account_info?.login_email || 'N/A');
            accountStatus.classList.remove('hidden');
            document.getElementById('success-subtitle').textContent = 'Your account has been created and booking confirmed';
        } else {
            accountMessage.textContent = 'Welcome back! You are now logged in.';
            accountEmail.textContent = 'Login email: ' + (bookingData.customer_email || result.account_info?.login_email || 'N/A');
            accountStatus.classList.remove('hidden');
            document.getElementById('success-subtitle').textContent = 'Your booking has been confirmed';
        }
        
        // Show the modal
        bookingSuccessModal.classList.remove('hidden');
        
        // Close any open booking modals and forms
        closeAllBookingModals();
        closeSharedRideForm();
        closeAirportTransferForm();
        closeSoloRideForm();
        closeCarHireForm();
        closeParcelDeliveryForm();
    }
    
    function closeBookingSuccessModal() {
        if (bookingSuccessModal) {
            bookingSuccessModal.classList.add('hidden');
        }
    }
    
    function closeAllBookingModals() {
        // Close all booking modals (now only login and booking success modals remain)
        const modals = [];
        
        modals.forEach(modalId => {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.add('hidden');
                // Reset form if it exists
                const form = modal.querySelector('form');
                if (form) form.reset();
                // Hide price displays
                const priceDisplay = modal.querySelector('[id*="price-display"]');
                if (priceDisplay) priceDisplay.classList.add('hidden');
            }
        });
        
        // Also hide inline forms
        hideAllForms();
        closeSoloRideForm();
        closeCarHireForm();
        closeParcelDeliveryForm();
    }
    
    // Hide all inline forms
    function hideAllForms() {
        const forms = [
            'shared-ride-form-container',
            'airport-transfer-form-container',
            'solo-ride-form-container',
            'car-hire-form-container',
            'parcel-delivery-form-container'
        ];
        
        forms.forEach(formId => {
            const form = document.getElementById(formId);
            if (form) {
                form.classList.add('hidden');
            }
        });
    }
    
    // Update active card styling with improved visual feedback
    function updateActiveCard(activeCardId) {
        // Reset all cards
        resetCardStyling();
        
        // Highlight active card with smooth animation
        const activeCard = document.getElementById(activeCardId);
        if (activeCard) {
            // Add selection animation
            activeCard.classList.add('selecting');
            
            setTimeout(() => {
                // Remove default styling
                activeCard.classList.remove('bg-white', 'border-gray-200', 'text-gray-800');
                
                // Add selected styling
                activeCard.classList.add('service-card-selected');
                
                // Update background and border
                activeCard.style.background = 'linear-gradient(135deg, #8B4513 0%, #d97706 100%)';
                activeCard.style.borderColor = '#8B4513';
                activeCard.style.color = 'white';
                
                // Update text colors for better readability
                const title = activeCard.querySelector('h3');
                const description = activeCard.querySelector('p');
                const badge = activeCard.querySelector('.inline-flex');
                
                if (title) title.style.color = 'white';
                if (description) description.style.color = 'rgba(255, 255, 255, 0.9)';
                if (badge) {
                    badge.style.background = 'rgba(255, 255, 255, 0.2)';
                    badge.style.color = 'white';
                    badge.style.backdropFilter = 'blur(10px)';
                }
                
                // Add selection indicator if it doesn't exist
                if (!activeCard.querySelector('.selection-indicator')) {
                    const indicator = document.createElement('div');
                    indicator.className = 'selection-indicator absolute -top-2 -right-2 w-6 h-6 bg-orange-custom rounded-full flex items-center justify-center shadow-lg';
                    indicator.innerHTML = `
                        <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                    `;
                    activeCard.appendChild(indicator);
                }
                
                // Remove animation class
                activeCard.classList.remove('selecting');
            }, 100);
        }
    }
    
    // Reset card styling to default state
    function resetCardStyling() {
        const allCards = document.querySelectorAll('.service-card');
        allCards.forEach(card => {
            // Remove all selection classes
            card.classList.remove('service-card-selected', 'selecting');
            
            // Reset to default styling
            card.classList.add('bg-white', 'border-gray-200', 'text-gray-800');
            
            // Reset inline styles
            card.style.background = '';
            card.style.borderColor = '';
            card.style.color = '';
            card.style.transform = '';
            card.style.boxShadow = '';
            
            // Reset text colors
            const title = card.querySelector('h3');
            const description = card.querySelector('p');
            const badge = card.querySelector('.inline-flex');
            
            if (title) title.style.color = '';
            if (description) description.style.color = '';
            if (badge) {
                badge.style.background = '';
                badge.style.color = '';
                badge.style.backdropFilter = '';
            }
            
            // Remove selection indicator
            const indicator = card.querySelector('.selection-indicator');
            if (indicator) {
                indicator.remove();
            }
        });
        
        // Set Solo Ride as default selected
        const soloRideCard = document.getElementById('solo-ride-card');
        if (soloRideCard) {
            soloRideCard.classList.remove('bg-white', 'border-gray-200', 'text-gray-800');
            soloRideCard.classList.add('service-card-selected');
            
            // Apply selected styling
            soloRideCard.style.background = 'linear-gradient(135deg, #8B4513 0%, #d97706 100%)';
            soloRideCard.style.borderColor = '#8B4513';
            soloRideCard.style.color = 'white';
            soloRideCard.style.transform = 'scale(1.02) translateY(-4px)';
            soloRideCard.style.boxShadow = '0 12px 30px rgba(139, 69, 19, 0.3)';
            
            // Update text colors
            const title = soloRideCard.querySelector('h3');
            const description = soloRideCard.querySelector('p');
            const badge = soloRideCard.querySelector('.inline-flex');
            
            if (title) title.style.color = 'white';
            if (description) description.style.color = 'rgba(255, 255, 255, 0.9)';
            if (badge) {
                badge.style.background = 'rgba(255, 255, 255, 0.2)';
                badge.style.color = 'white';
                badge.style.backdropFilter = 'blur(10px)';
            }
            
            // Add selection indicator
            if (!soloRideCard.querySelector('.selection-indicator')) {
                const indicator = document.createElement('div');
                indicator.className = 'selection-indicator absolute -top-2 -right-2 w-6 h-6 bg-orange-custom rounded-full flex items-center justify-center shadow-lg';
                indicator.innerHTML = `
                    <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg>
                `;
                soloRideCard.appendChild(indicator);
            }
        }
    }
    
    // Event listeners for success modal
    if (viewDashboardBtn) {
        viewDashboardBtn.addEventListener('click', () => {
            window.location.href = '/dashboard';
        });
    }
    
    if (bookAnotherBtn) {
        bookAnotherBtn.addEventListener('click', () => {
            closeBookingSuccessModal();
            // Optionally scroll to service cards
            const serviceCards = document.getElementById('service-cards-section');
            if (serviceCards) {
                serviceCards.scrollIntoView({ behavior: 'smooth' });
            }
        });
    }
    
    // Close modal when clicking outside
    if (bookingSuccessModal) {
        bookingSuccessModal.addEventListener('click', (e) => {
            if (e.target === bookingSuccessModal) {
                closeBookingSuccessModal();
            }
        });
    }

    // ===================================
    // HEADER SCROLL EFFECT
    // ===================================
    
    const header = document.getElementById('header');
    const headerBg = header?.querySelector('.header-bg');
    const heroSection = document.getElementById('hero-section');
    
    // Function to check if header needs background
    function updateHeaderBackground() {
        if (!header || !headerBg) return;
        
        const scrollY = window.scrollY;
        
        // Show background when scrolled past 50px
        if (scrollY > 50) {
            headerBg.style.opacity = '1';
            header.classList.add('header-scrolled');
        } else {
            headerBg.style.opacity = '0';
            header.classList.remove('header-scrolled');
        }
    }
    
    // Initial check
    updateHeaderBackground();
    
    // Update on scroll with throttling for performance
    let ticking = false;
    function requestTick() {
        if (!ticking) {
            window.requestAnimationFrame(updateHeaderBackground);
            ticking = true;
            setTimeout(() => { ticking = false; }, 100);
        }
    }
    window.addEventListener('scroll', requestTick);

    // ===================================
    // HERO CAROUSEL FUNCTIONALITY
    // ===================================
    
    let currentSlide = 0;
    let slides, contents, indicators, totalSlides;
    let carouselInterval;
    
    // Initialize carousel
    function initCarousel() {
        // Query elements inside init to ensure they exist
        slides = document.querySelectorAll('.carousel-slide');
        contents = document.querySelectorAll('.hero-content');
        indicators = document.querySelectorAll('.carousel-indicator');
        totalSlides = slides.length;
        
        // Debug carousel elements
        console.log('Carousel initialized:', {
            slides: slides.length,
            contents: contents.length,
            indicators: indicators.length
        });
        
        if (slides.length === 0) {
            console.error('No carousel slides found!');
            return;
        }
        
        // Set up event listeners
        setupCarouselEventListeners();
        
        // Show first slide and start
        showSlide(0);
        startAutoPlay();
    }
    
    // Show specific slide
    function showSlide(index) {
        // Hide all slides and contents
        slides.forEach((slide, i) => {
            slide.style.opacity = i === index ? '1' : '0';
            slide.style.zIndex = i === index ? '1' : '0';
        });
        
        contents.forEach((content, i) => {
            content.style.opacity = i === index ? '1' : '0';
            content.style.visibility = i === index ? 'visible' : 'hidden';
        });
        
        // Update indicators
        indicators.forEach((indicator, i) => {
            if (i === index) {
                indicator.classList.add('active', 'bg-white');
                indicator.classList.remove('bg-white/50');
            } else {
                indicator.classList.remove('active', 'bg-white');
                indicator.classList.add('bg-white/50');
            }
        });
        
        currentSlide = index;
    }
    
    // Next slide
    function nextSlide() {
        showSlide((currentSlide + 1) % totalSlides);
    }
    
    // Previous slide
    function prevSlide() {
        showSlide((currentSlide - 1 + totalSlides) % totalSlides);
    }
    
    // Auto-play functionality
    function startAutoPlay() {
        carouselInterval = setInterval(nextSlide, 5000); // Change slide every 5 seconds
    }
    
    function stopAutoPlay() {
        clearInterval(carouselInterval);
    }
    
    // Setup carousel event listeners
    function setupCarouselEventListeners() {
        // Event listeners for carousel controls
        const prevBtn = document.getElementById('carousel-prev');
        const nextBtn = document.getElementById('carousel-next');
        
        if (prevBtn) {
            prevBtn.addEventListener('click', () => {
                stopAutoPlay();
                prevSlide();
                startAutoPlay();
            });
        }
        
        if (nextBtn) {
            nextBtn.addEventListener('click', () => {
                stopAutoPlay();
                nextSlide();
                startAutoPlay();
            });
        }
        
        // Indicator clicks
        indicators.forEach((indicator, index) => {
            indicator.addEventListener('click', (e) => {
                e.preventDefault();
                stopAutoPlay();
                showSlide(index);
                startAutoPlay();
            });
        });
        
        // Pause on hover (only on desktop)
        const heroSection = document.getElementById('hero-section');
        if (heroSection && window.innerWidth > 768) {
            heroSection.addEventListener('mouseenter', stopAutoPlay);
            heroSection.addEventListener('mouseleave', startAutoPlay);
        }
    }
    
    // Initialize carousel when DOM is ready
    function ensureCarouselInit() {
        const checkElements = () => {
            const slides = document.querySelectorAll('.carousel-slide');
            const contents = document.querySelectorAll('.hero-content');
            const indicators = document.querySelectorAll('.carousel-indicator');
            
            if (slides.length > 0 && contents.length > 0 && indicators.length > 0) {
                console.log('Carousel elements ready, initializing...');
                initCarousel();
            } else {
                console.log('Waiting for carousel elements...');
                setTimeout(checkElements, 100);
            }
        };
        checkElements();
    }
    
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', ensureCarouselInit);
    } else {
        ensureCarouselInit();
    }

    // ===================================
    // SHARED RIDE FUNCTIONALITY
    // ===================================
    
    // Shared Ride Form Elements
    const sharedRideCard = document.getElementById('shared-ride-card');
    const sharedRideFormContainer = document.getElementById('shared-ride-form-container');
    const closeSharedRideFormBtn = document.getElementById('close-shared-ride-form');
    const cancelSharedRideBookingBtn = document.getElementById('cancel-shared-ride-booking');
    const sharedRideForm = document.getElementById('shared-ride-form');
    const priceDisplay = document.getElementById('price-display');
    const priceAmount = document.getElementById('price-amount');
    const dynamicFormsArea = document.getElementById('dynamic-forms-area');
    
    // Open shared ride form when card is clicked
    if (sharedRideCard) {
        sharedRideCard.addEventListener('click', () => {
            // Hide all other forms first
            hideAllForms();
            
            // Show shared ride form
            if (sharedRideFormContainer) {
                // Move form to dynamic area and show it
                if (dynamicFormsArea && !dynamicFormsArea.contains(sharedRideFormContainer)) {
                    dynamicFormsArea.appendChild(sharedRideFormContainer);
                }
                sharedRideFormContainer.classList.remove('hidden');
                
                // Scroll to form
                sharedRideFormContainer.scrollIntoView({ 
                    behavior: 'smooth', 
                    block: 'start',
                    inline: 'nearest'
                });
                
                // Load shared ride data
                loadSharedRideData();
                
                // Update card styling
                updateActiveCard('shared-ride-card');
            }
        });
    }
    
    // Close shared ride form
    function closeSharedRideForm() {
        if (sharedRideFormContainer) {
            sharedRideFormContainer.classList.add('hidden');
            if (sharedRideForm) sharedRideForm.reset();
            if (priceDisplay) priceDisplay.classList.add('hidden');
            
            // Clear password validation errors
            const passwordError = document.getElementById('password-error');
            if (passwordError) passwordError.remove();
            
            // Remove error styling from password fields
            const passwordField = document.getElementById('password');
            const passwordConfirmField = document.getElementById('password_confirmation');
            if (passwordField) passwordField.classList.remove('border-red-500');
            if (passwordConfirmField) passwordConfirmField.classList.remove('border-red-500');
            
            // Reset card styling
            resetCardStyling();
        }
    }
    
    if (closeSharedRideFormBtn) closeSharedRideFormBtn.addEventListener('click', closeSharedRideForm);
    if (cancelSharedRideBookingBtn) cancelSharedRideBookingBtn.addEventListener('click', closeSharedRideForm);

    // Load shared ride data (cities and pricing)
    async function loadSharedRideData() {
        try {
            // Load cities for dropdowns
            const response = await fetch('/api/cities');
            if (response.ok) {
                const cities = await response.json();
                populateCityDropdowns(cities);
            } else {
                // Fallback data
                const sampleCities = [
                    { id: 1, name: 'Nairobi' },
                    { id: 2, name: 'Mombasa' }, 
                    { id: 3, name: 'Kisumu' },
                    { id: 4, name: 'Nakuru' },
                    { id: 5, name: 'Eldoret' }
                ];
                populateCityDropdowns(sampleCities);
            }
        } catch (error) {
            console.error('Error loading shared ride data:', error);
            // Fallback data
            const sampleCities = [
                { id: 1, name: 'Nairobi' },
                { id: 2, name: 'Mombasa' }, 
                { id: 3, name: 'Kisumu' },
                { id: 4, name: 'Nakuru' },
                { id: 5, name: 'Eldoret' }
            ];
            populateCityDropdowns(sampleCities);
        }
    }

    // Shared ride password validation
    const passwordField = document.getElementById('password');
    const passwordConfirmField = document.getElementById('password_confirmation');
    
    function validatePasswords() {
        if (!passwordField || !passwordConfirmField) return true;
        
        const password = passwordField.value;
        const passwordConfirm = passwordConfirmField.value;
        
        // Remove any existing error styles
        passwordField.classList.remove('border-red-500');
        passwordConfirmField.classList.remove('border-red-500');
        
        // Remove any existing error messages
        const existingError = document.getElementById('password-error');
        if (existingError) {
            existingError.remove();
        }
        
        let isValid = true;
        let errorMessage = '';
        
        if (password.length < 4) {
            errorMessage = 'Password must be at least 4 characters long.';
            passwordField.classList.add('border-red-500');
            isValid = false;
        } else if (password !== passwordConfirm) {
            errorMessage = 'Passwords do not match.';
            passwordConfirmField.classList.add('border-red-500');
            isValid = false;
        }
        
        if (!isValid && errorMessage) {
            const errorDiv = document.createElement('div');
            errorDiv.id = 'password-error';
            errorDiv.className = 'text-red-500 text-xs mt-1';
            errorDiv.textContent = errorMessage;
            passwordConfirmField.parentNode.appendChild(errorDiv);
        }
        
        return isValid;
    }
    
    // Add real-time password validation
    if (passwordField) passwordField.addEventListener('input', validatePasswords);
    if (passwordConfirmField) passwordConfirmField.addEventListener('input', validatePasswords);

    // ===================================
    // SOLO RIDE FUNCTIONALITY  
    // ===================================
    
    // Solo Ride Form Elements
    const soloRideCard = document.getElementById('solo-ride-card');
    const soloRideFormContainer = document.getElementById('solo-ride-form-container');
    const closeSoloRideFormBtn = document.getElementById('close-solo-ride-form');
    const cancelSoloRideBookingBtn = document.getElementById('cancel-solo-ride-booking');
    const soloRideForm = document.getElementById('solo-ride-form');
    const soloPriceDisplay = document.getElementById('solo-price-display');
    const soloPriceAmount = document.getElementById('solo-price-amount');
    
    // Open solo ride form when card is clicked
    if (soloRideCard) {
        soloRideCard.addEventListener('click', () => {
            // Hide all other forms first
            hideAllForms();
            
            // Show solo ride form
            if (soloRideFormContainer) {
                // Move form to dynamic area and show it
                if (dynamicFormsArea && !dynamicFormsArea.contains(soloRideFormContainer)) {
                    dynamicFormsArea.appendChild(soloRideFormContainer);
                }
                soloRideFormContainer.classList.remove('hidden');
                
                // Scroll to form
                soloRideFormContainer.scrollIntoView({ 
                    behavior: 'smooth', 
                    block: 'start',
                    inline: 'nearest'
                });
                
                // Load solo ride data
                loadSoloRideData();
                
                // Update card styling
                updateActiveCard('solo-ride-card');
            }
        });
    }
    
    // Close solo ride form
    function closeSoloRideForm() {
        if (soloRideFormContainer) {
            soloRideFormContainer.classList.add('hidden');
            if (soloRideForm) soloRideForm.reset();
            if (soloPriceDisplay) soloPriceDisplay.classList.add('hidden');
            
            // Clear password validation errors
            const soloPasswordError = document.getElementById('solo-password-error');
            if (soloPasswordError) soloPasswordError.remove();
            
            // Remove error styling from password fields
            const soloPasswordField = document.getElementById('solo_password');
            const soloPasswordConfirmField = document.getElementById('solo_password_confirmation');
            if (soloPasswordField) soloPasswordField.classList.remove('border-red-500');
            if (soloPasswordConfirmField) soloPasswordConfirmField.classList.remove('border-red-500');
            
            // Reset card styling
            resetCardStyling();
        }
    }
    
    if (closeSoloRideFormBtn) closeSoloRideFormBtn.addEventListener('click', closeSoloRideForm);
    if (cancelSoloRideBookingBtn) cancelSoloRideBookingBtn.addEventListener('click', closeSoloRideForm);

    // Solo ride password validation
    const soloPasswordField = document.getElementById('solo_password');
    const soloPasswordConfirmField = document.getElementById('solo_password_confirmation');
    
    function validateSoloPasswords() {
        if (!soloPasswordField || !soloPasswordConfirmField) return true;
        
        const password = soloPasswordField.value;
        const passwordConfirm = soloPasswordConfirmField.value;
        
        // Remove any existing error styles
        soloPasswordField.classList.remove('border-red-500');
        soloPasswordConfirmField.classList.remove('border-red-500');
        
        // Remove any existing error messages
        const existingError = document.getElementById('solo-password-error');
        if (existingError) {
            existingError.remove();
        }
        
        let isValid = true;
        let errorMessage = '';
        
        if (password.length < 4) {
            errorMessage = 'Password must be at least 4 characters long.';
            soloPasswordField.classList.add('border-red-500');
            isValid = false;
        } else if (password !== passwordConfirm) {
            errorMessage = 'Passwords do not match.';
            soloPasswordConfirmField.classList.add('border-red-500');
            isValid = false;
        }
        
        if (!isValid && errorMessage) {
            const errorDiv = document.createElement('div');
            errorDiv.id = 'solo-password-error';
            errorDiv.className = 'text-red-500 text-xs mt-1';
            errorDiv.textContent = errorMessage;
            soloPasswordConfirmField.parentNode.appendChild(errorDiv);
        }
        
        return isValid;
    }
    
    // Add real-time password validation for solo ride
    if (soloPasswordField) soloPasswordField.addEventListener('input', validateSoloPasswords);
    if (soloPasswordConfirmField) soloPasswordConfirmField.addEventListener('input', validateSoloPasswords);

    // Load solo ride data
    async function loadSoloRideData() {
        try {
            // Load cities
            const citiesResponse = await fetch('/api/cities');
            if (citiesResponse.ok) {
                const cities = await citiesResponse.json();
                populateSoloCityDropdowns(cities);
            }
            
            // Load vehicle types
            const vehicleResponse = await fetch('/api/vehicle-types');
            if (vehicleResponse.ok) {
                const vehicleTypes = await vehicleResponse.json();
                populateSoloVehicleTypes(vehicleTypes);
            } else {
                // Fallback vehicle types
                const sampleVehicleTypes = [
                    { id: 1, name: 'Economy Car', description: 'Affordable and efficient' },
                    { id: 2, name: 'Sedan', description: 'Comfortable mid-size vehicle' },
                    { id: 3, name: 'SUV', description: 'Spacious and versatile' },
                    { id: 4, name: 'Premium Car', description: 'Luxury and comfort' },
                    { id: 5, name: 'Van', description: 'For large groups' }
                ];
                populateSoloVehicleTypes(sampleVehicleTypes);
            }
        } catch (error) {
            console.error('Error loading solo ride data:', error);
        }
    }

    // ===================================
    // CAR HIRE FUNCTIONALITY
    // ===================================
    
    // Car Hire Form Elements
    const carHireCard = document.getElementById('car-hire-card');
    const carHireFormContainer = document.getElementById('car-hire-form-container');
    const closeCarHireFormBtn = document.getElementById('close-car-hire-form');
    const cancelCarHireBookingBtn = document.getElementById('cancel-car-hire-booking');
    const carHireForm = document.getElementById('car-hire-form');
    const carHirePriceDisplay = document.getElementById('car-hire-price-display');
    const carHirePricePerDay = document.getElementById('car-hire-price-per-day');
    const carHireTotalPrice = document.getElementById('car-hire-total-price');
    const carHireDuration = document.getElementById('car-hire-duration');
    
    // Open car hire form when card is clicked
    if (carHireCard) {
        carHireCard.addEventListener('click', () => {
            // Hide all other forms first
            hideAllForms();
            
            // Show car hire form
            if (carHireFormContainer) {
                // Move form to dynamic area and show it
                if (dynamicFormsArea && !dynamicFormsArea.contains(carHireFormContainer)) {
                    dynamicFormsArea.appendChild(carHireFormContainer);
                }
                carHireFormContainer.classList.remove('hidden');
                
                // Scroll to form
                carHireFormContainer.scrollIntoView({ 
                    behavior: 'smooth', 
                    block: 'start',
                    inline: 'nearest'
                });
                
                // Load car hire data
                loadCarHireData();
                
                // Update card styling
                updateActiveCard('car-hire-card');
            }
        });
    }
    
    // Close car hire form
    function closeCarHireForm() {
        if (carHireFormContainer) {
            carHireFormContainer.classList.add('hidden');
            if (carHireForm) carHireForm.reset();
            if (carHirePriceDisplay) carHirePriceDisplay.classList.add('hidden');
            
            // Clear password validation errors
            const carHirePasswordError = document.getElementById('car-hire-password-error');
            if (carHirePasswordError) carHirePasswordError.remove();
            
            // Remove error styling from password fields
            const carHirePasswordField = document.getElementById('car_hire_password');
            const carHirePasswordConfirmField = document.getElementById('car_hire_password_confirmation');
            if (carHirePasswordField) carHirePasswordField.classList.remove('border-red-500');
            if (carHirePasswordConfirmField) carHirePasswordConfirmField.classList.remove('border-red-500');
            
            // Reset card styling
            resetCardStyling();
        }
    }
    
    if (closeCarHireFormBtn) closeCarHireFormBtn.addEventListener('click', closeCarHireForm);
    if (cancelCarHireBookingBtn) cancelCarHireBookingBtn.addEventListener('click', closeCarHireForm);

    // Car hire password validation
    const carHirePasswordField = document.getElementById('car_hire_password');
    const carHirePasswordConfirmField = document.getElementById('car_hire_password_confirmation');
    
    function validateCarHirePasswords() {
        if (!carHirePasswordField || !carHirePasswordConfirmField) return true;
        
        const password = carHirePasswordField.value;
        const passwordConfirm = carHirePasswordConfirmField.value;
        
        // Remove any existing error styles
        carHirePasswordField.classList.remove('border-red-500');
        carHirePasswordConfirmField.classList.remove('border-red-500');
        
        // Remove any existing error messages
        const existingError = document.getElementById('car-hire-password-error');
        if (existingError) {
            existingError.remove();
        }
        
        let isValid = true;
        let errorMessage = '';
        
        if (password.length < 4) {
            errorMessage = 'Password must be at least 4 characters long.';
            carHirePasswordField.classList.add('border-red-500');
            isValid = false;
        } else if (password !== passwordConfirm) {
            errorMessage = 'Passwords do not match.';
            carHirePasswordConfirmField.classList.add('border-red-500');
            isValid = false;
        }
        
        if (!isValid && errorMessage) {
            const errorDiv = document.createElement('div');
            errorDiv.id = 'car-hire-password-error';
            errorDiv.className = 'text-red-500 text-xs mt-1';
            errorDiv.textContent = errorMessage;
            carHirePasswordConfirmField.parentNode.appendChild(errorDiv);
        }
        
        return isValid;
    }
    
    // Add real-time password validation for car hire
    if (carHirePasswordField) carHirePasswordField.addEventListener('input', validateCarHirePasswords);
    if (carHirePasswordConfirmField) carHirePasswordConfirmField.addEventListener('input', validateCarHirePasswords);

    // Load car hire data
    async function loadCarHireData() {
        try {
            // Load cities
            const citiesResponse = await fetch('/api/cities');
            if (citiesResponse.ok) {
                const cities = await citiesResponse.json();
                populateCarHireCityDropdown(cities);
            }
            
            // Load vehicle types
            const vehicleResponse = await fetch('/api/vehicle-types');
            if (vehicleResponse.ok) {
                const vehicleTypes = await vehicleResponse.json();
                populateCarHireVehicleTypes(vehicleTypes);
            } else {
                // Fallback vehicle types
                const sampleVehicleTypes = [
                    { id: 1, name: 'Economy Car', description: 'Fuel efficient and affordable' },
                    { id: 2, name: 'Compact Car', description: 'Perfect for city driving' },
                    { id: 3, name: 'Sedan', description: 'Comfortable mid-size vehicle' },
                    { id: 4, name: 'SUV', description: 'Spacious and versatile' },
                    { id: 5, name: 'Premium Car', description: 'Luxury and comfort' },
                    { id: 6, name: 'Van', description: 'For large groups or cargo' }
                ];
                populateCarHireVehicleTypes(sampleVehicleTypes);
            }
        } catch (error) {
            console.error('Error loading car hire data:', error);
        }
    }

    function populateCarHireCityDropdown(cities) {
        const cityOptions = cities.map(city => 
            `<option value="${city.id}">${city.name}</option>`
        ).join('');
        
        const pickupLocationSelect = document.getElementById('pickup_location');
        
        if (pickupLocationSelect) {
            pickupLocationSelect.innerHTML = '<option value="">Select pickup location</option>' + cityOptions;
            // Add event listener for pricing updates
            pickupLocationSelect.addEventListener('change', checkCarHirePricing);
        }
    }
    
    function populateCarHireVehicleTypes(vehicleTypes) {
        const vehicleOptions = vehicleTypes.map(vehicle => 
            `<option value="${vehicle.id}">${vehicle.name}${vehicle.description ? ' - ' + vehicle.description : ''}</option>`
        ).join('');
        
        const vehicleSelect = document.getElementById('car_hire_vehicle_type');
        if (vehicleSelect) {
            vehicleSelect.innerHTML = '<option value="">Select vehicle type</option>' + vehicleOptions;
            // Add event listener for pricing updates
            vehicleSelect.addEventListener('change', checkCarHirePricing);
        }
    }

    // Calculate hire duration and check pricing
    function calculateHireDuration() {
        const startDateInput = document.getElementById('hire_start_date');
        const endDateInput = document.getElementById('hire_end_date');
        
        if (!startDateInput || !endDateInput || !startDateInput.value || !endDateInput.value) {
            return 0;
        }
        
        const startDate = new Date(startDateInput.value);
        const endDate = new Date(endDateInput.value);
        
        if (endDate <= startDate) {
            return 0;
        }
        
        // Calculate difference in days (including both start and end days)
        const timeDiff = endDate.getTime() - startDate.getTime();
        const daysDiff = Math.ceil(timeDiff / (1000 * 3600 * 24)) + 1;
        
        return daysDiff;
    }

    // Check car hire pricing when required fields are selected
    async function checkCarHirePricing() {
        const vehicleTypeId = document.getElementById('car_hire_vehicle_type')?.value;
        const pickupCityId = document.getElementById('pickup_location')?.value;
        const hireDays = calculateHireDuration();
        
        console.log('Checking car hire pricing with:', { vehicleTypeId, pickupCityId, hireDays });
        
        if (!vehicleTypeId || hireDays <= 0) {
            console.log('Missing required fields for pricing');
            if (carHirePriceDisplay) carHirePriceDisplay.classList.add('hidden');
            return;
        }
        
        try {
            const params = new URLSearchParams({
                vehicle_type_id: vehicleTypeId,
                hire_days: hireDays
            });
            
            // Add pickup city if selected
            if (pickupCityId) {
                params.append('pickup_city_id', pickupCityId);
            }
            
            console.log('Making pricing request with params:', params.toString());
            
            const response = await fetch(`/api/car-hire/pricing?${params}`);
            const data = await response.json();
            
            console.log('Pricing API response:', data);
            
            if (response.ok && data.success && data.price_per_day && data.total_price) {
                // Update price display
                carHirePricePerDay.textContent = `KSh ${data.price_per_day.toLocaleString()}`;
                carHireTotalPrice.textContent = `KSh ${data.total_price.toLocaleString()}`;
                carHireDuration.textContent = `${hireDays} day${hireDays > 1 ? 's' : ''}`;
                
                // Hide discount info since we removed discounts
                carHirePriceDisplay.classList.remove('hidden');
                console.log('Price display updated successfully');
            } else {
                console.log('Invalid response data:', data);
                if (carHirePriceDisplay) carHirePriceDisplay.classList.add('hidden');
                
                // Show error if available
                if (data.error) {
                    console.error('Pricing error:', data.error);
                }
            }
        } catch (error) {
            console.error('Error checking car hire price:', error);
            
            // Show sample price for demonstration only if we have the required fields
            if (vehicleTypeId && hireDays > 0) {
                const basePrices = { 1: 2500, 2: 3000, 3: 4000, 4: 6000, 5: 8000, 6: 10000 };
                const pricePerDay = basePrices[vehicleTypeId] || 4000;
                const totalPrice = pricePerDay * hireDays;
                
                carHirePricePerDay.textContent = `KSh ${pricePerDay.toLocaleString()}`;
                carHireTotalPrice.textContent = `KSh ${totalPrice.toLocaleString()}`;
                carHireDuration.textContent = `${hireDays} day${hireDays > 1 ? 's' : ''}`;
                
                carHirePriceDisplay.classList.remove('hidden');
                console.log('Fallback pricing displayed');
            } else {
                if (carHirePriceDisplay) carHirePriceDisplay.classList.add('hidden');
            }
        }
    }

    // Add event listeners for date changes
    const hireStartDateInput = document.getElementById('hire_start_date');
    const hireEndDateInput = document.getElementById('hire_end_date');
    
    if (hireStartDateInput) {
        hireStartDateInput.addEventListener('change', () => {
            // Update end date minimum to be after start date
            if (hireEndDateInput && hireStartDateInput.value) {
                const startDate = new Date(hireStartDateInput.value);
                const nextDay = new Date(startDate);
                nextDay.setDate(startDate.getDate() + 1);
                hireEndDateInput.min = nextDay.toISOString().split('T')[0];
            }
            checkCarHirePricing();
        });
    }
    
    if (hireEndDateInput) {
        hireEndDateInput.addEventListener('change', checkCarHirePricing);
    }

    // ===================================
    // AIRPORT TRANSFER FUNCTIONALITY
    // ===================================
    
    // Airport Transfer Form Elements  
    const airportTransferCard = document.getElementById('airport-transfer-card');
    const airportTransferFormContainer = document.getElementById('airport-transfer-form-container');
    const closeAirportTransferFormBtn = document.getElementById('close-airport-transfer-form');
    const cancelAirportTransferBookingBtn = document.getElementById('cancel-airport-transfer-booking');
    const airportTransferForm = document.getElementById('airport-transfer-form');
    const airportPriceDisplay = document.getElementById('airport-price-display');
    const airportPriceAmount = document.getElementById('airport-price-amount');
    const airportPriceBreakdown = document.getElementById('airport-price-breakdown');
    
    // Transfer type radio buttons
    const pickupTransferRadio = document.getElementById('pickup_transfer');
    const dropoffTransferRadio = document.getElementById('dropoff_transfer');
    
    // Route sections
    const pickupRouteSection = document.getElementById('pickup-route');
    const dropoffRouteSection = document.getElementById('dropoff-route');
    
    // Open airport transfer form when card is clicked
    if (airportTransferCard) {
        airportTransferCard.addEventListener('click', () => {
            // Hide all other forms first
            hideAllForms();
            
            // Show airport transfer form
            if (airportTransferFormContainer) {
                // Move form to dynamic area and show it
                if (dynamicFormsArea && !dynamicFormsArea.contains(airportTransferFormContainer)) {
                    dynamicFormsArea.appendChild(airportTransferFormContainer);
                }
                airportTransferFormContainer.classList.remove('hidden');
                
                // Scroll to form
                airportTransferFormContainer.scrollIntoView({ 
                    behavior: 'smooth', 
                    block: 'start',
                    inline: 'nearest'
                });
                
                // Load airport transfer data
                loadAirportTransferData();
                
                // Update card styling
                updateActiveCard('airport-transfer-card');
            }
        });
    }
    
    // Close airport transfer form
    function closeAirportTransferForm() {
        if (airportTransferFormContainer) {
            airportTransferFormContainer.classList.add('hidden');
            if (airportTransferForm) airportTransferForm.reset();
            if (airportPriceDisplay) airportPriceDisplay.classList.add('hidden');
            
            // Hide all route sections
            if (pickupRouteSection) pickupRouteSection.classList.add('hidden');
            if (dropoffRouteSection) dropoffRouteSection.classList.add('hidden');
            
            // Clear transfer type selections
            document.querySelectorAll('.transfer-type-option').forEach(option => {
                option.classList.remove('border-blue-500', 'bg-blue-50');
                option.classList.add('border-gray-200');
            });
            
            // Reset card styling
            resetCardStyling();
        }
    }
    
    if (closeAirportTransferFormBtn) closeAirportTransferFormBtn.addEventListener('click', closeAirportTransferForm);
    if (cancelAirportTransferBookingBtn) cancelAirportTransferBookingBtn.addEventListener('click', closeAirportTransferForm);

    // Transfer type selection handling
    if (pickupTransferRadio) {
        pickupTransferRadio.addEventListener('change', function() {
            if (this.checked) {
                if (pickupRouteSection) pickupRouteSection.classList.remove('hidden');
                if (dropoffRouteSection) dropoffRouteSection.classList.add('hidden');
                updateTransferTypeStyles(this);
                checkAirportTransferPricing();
            }
        });
    }
    
    if (dropoffTransferRadio) {
        dropoffTransferRadio.addEventListener('change', function() {
            if (this.checked) {
                if (dropoffRouteSection) dropoffRouteSection.classList.remove('hidden');
                if (pickupRouteSection) pickupRouteSection.classList.add('hidden');
                updateTransferTypeStyles(this);
                checkAirportTransferPricing();
            }
        });
    }
    
    function updateTransferTypeStyles(selectedRadio) {
        // Reset all styles
        document.querySelectorAll('.transfer-type-option').forEach(option => {
            option.classList.remove('border-blue-500', 'bg-blue-50');
            option.classList.add('border-gray-200');
        });
        
        // Apply selected styles
        const selectedLabel = selectedRadio.nextElementSibling;
        if (selectedLabel) {
            selectedLabel.classList.remove('border-gray-200');
            selectedLabel.classList.add('border-blue-500', 'bg-blue-50');
        }
    }

    // Load airport transfer data
    async function loadAirportTransferData() {
        try {
            // Load cities
            const citiesResponse = await fetch('/api/cities');
            if (citiesResponse.ok) {
                const cities = await citiesResponse.json();
                populateAirportCityDropdowns(cities);
            }
            
            // Load airports
            const airportsResponse = await fetch('/api/airports');
            if (airportsResponse.ok) {
                const airports = await airportsResponse.json();
                populateAirportDropdowns(airports);
            } else {
                // Fallback airports
                const sampleAirports = [
                    { id: 1, name: 'Jomo Kenyatta International Airport', code: 'NBO' },
                    { id: 2, name: 'Moi International Airport', code: 'MBA' },
                    { id: 3, name: 'Kisumu Airport', code: 'KIS' }
                ];
                populateAirportDropdowns(sampleAirports);
            }
            
            // Load vehicle types
            const vehicleTypesResponse = await fetch('/api/vehicle-types');
            if (vehicleTypesResponse.ok) {
                const vehicleTypes = await vehicleTypesResponse.json();
                populateAirportVehicleTypes(vehicleTypes);
            } else {
                // Fallback vehicle types
                const sampleVehicleTypes = [
                    { id: 1, name: 'Economy Car' },
                    { id: 2, name: 'Sedan' },
                    { id: 3, name: 'SUV' },
                    { id: 4, name: 'Premium Car' },
                    { id: 5, name: 'Van' }
                ];
                populateAirportVehicleTypes(sampleVehicleTypes);
            }
        } catch (error) {
            console.error('Error loading airport transfer data:', error);
        }
    }

    // ===================================
    // UTILITY FUNCTIONS
    // ===================================
    
    function populateCityDropdowns(cities) {
        const cityOptions = cities.map(city => 
            `<option value="${city.id}">${city.name}</option>`
        ).join('');
        
        // Populate shared ride dropdowns
        const pickupCitySelect = document.getElementById('pickup_city');
        const dropoffCitySelect = document.getElementById('dropoff_city');
        
        if (pickupCitySelect) {
            pickupCitySelect.innerHTML = '<option value="">Select pickup city</option>' + cityOptions;
            // Add event listener for pricing updates
            pickupCitySelect.addEventListener('change', checkSharedRidePricing);
        }
        if (dropoffCitySelect) {
            dropoffCitySelect.innerHTML = '<option value="">Select drop-off city</option>' + cityOptions;
            // Add event listener for pricing updates
            dropoffCitySelect.addEventListener('change', checkSharedRidePricing);
        }
        
        // Add event listener for passengers dropdown
        const passengersSelect = document.getElementById('passengers');
        if (passengersSelect) {
            passengersSelect.addEventListener('change', checkSharedRidePricing);
        }
    }

    // Check shared ride pricing when cities are selected
    async function checkSharedRidePricing() {
        const pickupCitySelect = document.getElementById('pickup_city');
        const dropoffCitySelect = document.getElementById('dropoff_city');
        const passengersSelect = document.getElementById('passengers');
        const priceDisplay = document.getElementById('price-display');
        const priceAmount = document.getElementById('price-amount');
        const priceDescription = document.getElementById('price-description');
        
        if (!pickupCitySelect || !dropoffCitySelect || !passengersSelect) return;
        
        const pickupCityId = pickupCitySelect.value;
        const dropoffCityId = dropoffCitySelect.value;
        const passengers = passengersSelect.value;
        
        if (pickupCityId && dropoffCityId && passengers && pickupCityId !== dropoffCityId) {
            try {
                const response = await fetch(`/api/shared-ride/pricing?pickup_city_id=${pickupCityId}&dropoff_city_id=${dropoffCityId}&passengers=${passengers}`);
                if (response.ok) {
                    const data = await response.json();
                    if (data.price) {
                        priceAmount.textContent = `KSh ${data.price.toLocaleString()}`;
                        
                        // Update description based on passenger count
                        const passengerCount = parseInt(passengers);
                        if (passengerCount === 1) {
                            priceDescription.textContent = 'Total for 1 passenger';
                        } else {
                            priceDescription.textContent = `Total for ${passengerCount} passengers`;
                            
                            // Also show per-passenger breakdown if available
                            if (data.price_per_passenger) {
                                priceDescription.innerHTML = `Total for ${passengerCount} passengers<br><small class="text-gray-500">(KSh ${data.price_per_passenger.toLocaleString()} per passenger)</small>`;
                            }
                        }
                        
                        priceDisplay.classList.remove('hidden');
                    } else {
                        priceDisplay.classList.add('hidden');
                    }
                }
            } catch (error) {
                console.error('Error checking shared ride price:', error);
                // Show sample price for demonstration
                const passengerCount = parseInt(passengers) || 1;
                const samplePricePerPassenger = 1500;
                const totalPrice = samplePricePerPassenger * passengerCount;
                
                priceAmount.textContent = `KSh ${totalPrice.toLocaleString()}`;
                if (passengerCount === 1) {
                    priceDescription.textContent = 'Total for 1 passenger';
                } else {
                    priceDescription.innerHTML = `Total for ${passengerCount} passengers<br><small class="text-gray-500">(KSh ${samplePricePerPassenger.toLocaleString()} per passenger)</small>`;
                }
                priceDisplay.classList.remove('hidden');
            }
        } else {
            if (priceDisplay) priceDisplay.classList.add('hidden');
        }
    }

    function populateSoloCityDropdowns(cities) {
        const cityOptions = cities.map(city => 
            `<option value="${city.id}">${city.name}</option>`
        ).join('');
        
        const soloPickupCitySelect = document.getElementById('solo_pickup_city');
        const soloDropoffCitySelect = document.getElementById('solo_dropoff_city');
        
        if (soloPickupCitySelect) {
            soloPickupCitySelect.innerHTML = '<option value="">Select pickup city</option>' + cityOptions;
            // Add event listener for pricing updates
            soloPickupCitySelect.addEventListener('change', checkSoloRidePricing);
        }
        if (soloDropoffCitySelect) {
            soloDropoffCitySelect.innerHTML = '<option value="">Select drop-off city</option>' + cityOptions;
            // Add event listener for pricing updates
            soloDropoffCitySelect.addEventListener('change', checkSoloRidePricing);
        }
    }
    
    function populateSoloVehicleTypes(vehicleTypes) {
        const vehicleOptions = vehicleTypes.map(vehicle => 
            `<option value="${vehicle.id}">${vehicle.name}${vehicle.description ? ' - ' + vehicle.description : ''}</option>`
        ).join('');
        
        const vehicleSelect = document.getElementById('solo_vehicle_type');
        if (vehicleSelect) {
            vehicleSelect.innerHTML = '<option value="">Select vehicle type</option>' + vehicleOptions;
            // Add event listener for pricing updates
            vehicleSelect.addEventListener('change', checkSoloRidePricing);
        }
    }

    // Check solo ride pricing when required fields are selected
    async function checkSoloRidePricing() {
        const soloPickupCitySelect = document.getElementById('solo_pickup_city');
        const soloDropoffCitySelect = document.getElementById('solo_dropoff_city');
        const soloVehicleTypeSelect = document.getElementById('solo_vehicle_type');
        const soloPriceDisplay = document.getElementById('solo-price-display');
        const soloPriceAmount = document.getElementById('solo-price-amount');
        
        if (!soloPickupCitySelect || !soloDropoffCitySelect || !soloVehicleTypeSelect) return;
        
        const pickupCityId = soloPickupCitySelect.value;
        const dropoffCityId = soloDropoffCitySelect.value;
        const vehicleTypeId = soloVehicleTypeSelect.value;
        
        if (pickupCityId && dropoffCityId && vehicleTypeId && pickupCityId !== dropoffCityId) {
            try {
                const response = await fetch(`/api/solo-ride/pricing?pickup_city_id=${pickupCityId}&dropoff_city_id=${dropoffCityId}&vehicle_type_id=${vehicleTypeId}`);
                if (response.ok) {
                    const data = await response.json();
                    if (data.price) {
                        soloPriceAmount.textContent = `KSh ${data.price.toLocaleString()}`;
                        soloPriceDisplay.classList.remove('hidden');
                    } else {
                        soloPriceDisplay.classList.add('hidden');
                    }
                }
            } catch (error) {
                console.error('Error checking solo ride price:', error);
                // Show sample price for demonstration
                const basePrices = { 1: 2500, 2: 3500, 3: 4500, 4: 6000, 5: 7000 };
                const samplePrice = basePrices[vehicleTypeId] || 3500;
                soloPriceAmount.textContent = `KSh ${samplePrice.toLocaleString()}`;
                soloPriceDisplay.classList.remove('hidden');
            }
        } else {
            if (soloPriceDisplay) soloPriceDisplay.classList.add('hidden');
        }
    }

    function populateAirportCityDropdowns(cities) {
        const cityOptions = cities.map(city => 
            `<option value="${city.id}">${city.name}</option>`
        ).join('');
        
        const destinationCitySelect = document.getElementById('destination_city');
        const originCitySelect = document.getElementById('origin_city');
        
        if (destinationCitySelect) {
            destinationCitySelect.innerHTML = '<option value="">Select destination city</option>' + cityOptions;
            // Add event listener for pricing updates
            destinationCitySelect.addEventListener('change', checkAirportTransferPricing);
        }
        if (originCitySelect) {
            originCitySelect.innerHTML = '<option value="">Select origin city</option>' + cityOptions;
            // Add event listener for pricing updates
            originCitySelect.addEventListener('change', checkAirportTransferPricing);
        }
    }
    
    function populateAirportDropdowns(airports) {
        const airportOptions = airports.map(airport => 
            `<option value="${airport.id}">${airport.name}${airport.code ? ' (' + airport.code + ')' : ''}</option>`
        ).join('');
        
        const pickupAirportSelect = document.getElementById('pickup_airport');
        const dropoffAirportSelect = document.getElementById('dropoff_airport');
        
        if (pickupAirportSelect) {
            pickupAirportSelect.innerHTML = '<option value="">Select pickup airport</option>' + airportOptions;
            // Add event listener for pricing updates
            pickupAirportSelect.addEventListener('change', checkAirportTransferPricing);
        }
        if (dropoffAirportSelect) {
            dropoffAirportSelect.innerHTML = '<option value="">Select drop-off airport</option>' + airportOptions;
            // Add event listener for pricing updates
            dropoffAirportSelect.addEventListener('change', checkAirportTransferPricing);
        }
    }

    function populateAirportVehicleTypes(vehicleTypes) {
        const vehicleOptions = vehicleTypes.map(vehicle => 
            `<option value="${vehicle.id}">${vehicle.name}${vehicle.description ? ' - ' + vehicle.description : ''}</option>`
        ).join('');
        
        const airportVehicleSelect = document.getElementById('airport_vehicle_type');
        if (airportVehicleSelect) {
            airportVehicleSelect.innerHTML = '<option value="">Select vehicle type</option>' + vehicleOptions;
            // Add event listener for pricing updates
            airportVehicleSelect.addEventListener('change', checkAirportTransferPricing);
        }
        
        // Add event listener for passengers field
        const airportPassengersSelect = document.getElementById('airport_passengers');
        if (airportPassengersSelect) {
            airportPassengersSelect.addEventListener('change', checkAirportTransferPricing);
        }
    }

    // Check airport transfer pricing when required fields are selected
    async function checkAirportTransferPricing() {
        const transferType = document.querySelector('input[name="transfer_type"]:checked')?.value;
        const vehicleTypeId = document.getElementById('airport_vehicle_type')?.value;
        const airportPriceDisplay = document.getElementById('airport-price-display');
        const airportPriceAmount = document.getElementById('airport-price-amount');
        const airportPriceBreakdown = document.getElementById('airport-price-breakdown');
        
        if (!transferType || !vehicleTypeId || !airportPriceDisplay) {
            if (airportPriceDisplay) airportPriceDisplay.classList.add('hidden');
            return;
        }
        
        let routeComplete = false;
        let pickupAirportId, dropoffCityId, pickupCityId, dropoffAirportId;
        
        if (transferType === 'pickup') {
            pickupAirportId = document.getElementById('pickup_airport')?.value;
            dropoffCityId = document.getElementById('destination_city')?.value;
            routeComplete = pickupAirportId && dropoffCityId;
        } else {
            pickupCityId = document.getElementById('origin_city')?.value;
            dropoffAirportId = document.getElementById('dropoff_airport')?.value;
            routeComplete = pickupCityId && dropoffAirportId;
        }
        
        if (routeComplete) {
            try {
                const params = new URLSearchParams({
                    transfer_type: transferType,
                    vehicle_type_id: vehicleTypeId
                });
                
                if (transferType === 'pickup') {
                    params.append('pickup_airport_id', pickupAirportId);
                    params.append('dropoff_city_id', dropoffCityId);
                } else {
                    params.append('pickup_city_id', pickupCityId);
                    params.append('dropoff_airport_id', dropoffAirportId);
                }
                
                const response = await fetch(`/api/airport-transfer/pricing?${params}`);
                if (response.ok) {
                    const data = await response.json();
                    if (data.price) {
                        airportPriceAmount.textContent = `KSh ${data.price.toLocaleString()}`;
                        
                        // Show price breakdown
                        let breakdown = `Base price: KSh ${data.base_price?.toLocaleString() || data.price.toLocaleString()}`;
                        if (data.airport_surcharge && data.airport_surcharge > 0) {
                            breakdown += `<br>Airport surcharge: KSh ${data.airport_surcharge.toLocaleString()}`;
                        }
                        airportPriceBreakdown.innerHTML = breakdown;
                        
                        airportPriceDisplay.classList.remove('hidden');
                    } else {
                        airportPriceDisplay.classList.add('hidden');
                    }
                }
            } catch (error) {
                console.error('Error checking airport transfer price:', error);
                // Show sample price for demonstration
                const basePrices = { 1: 3000, 2: 4000, 3: 5500, 4: 7000, 5: 8500 };
                const basePrice = basePrices[vehicleTypeId] || 4000;
                const surcharge = transferType === 'pickup' ? 500 : 300;
                const totalPrice = basePrice + surcharge;
                
                airportPriceAmount.textContent = `KSh ${totalPrice.toLocaleString()}`;
                airportPriceBreakdown.innerHTML = `Base price: KSh ${basePrice.toLocaleString()}<br>Airport surcharge: KSh ${surcharge.toLocaleString()}`;
                airportPriceDisplay.classList.remove('hidden');
            }
        } else {
            airportPriceDisplay.classList.add('hidden');
        }
    }

    // ===================================
    // FORM SUBMISSIONS
    // ===================================
    
    // Handle shared ride form submission
    if (sharedRideForm) {
        sharedRideForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            // Validate passwords
            if (!validatePasswords()) {
                return;
            }
            
            // Collect form data
            const formData = new FormData(sharedRideForm);
            const bookingData = Object.fromEntries(formData);
            
            // Show loading state
            const submitBtn = sharedRideForm.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            submitBtn.textContent = 'Processing...';
            submitBtn.disabled = true;
            
            try {
                // Make booking request
                const response = await fetch('/api/shared-ride/book', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                    },
                    body: JSON.stringify(bookingData)
                });
                
                const result = await response.json();
                
                if (response.ok && result.success) {
                    // Show success modal instead of alert
                    showBookingSuccess(result, bookingData);
                } else {
                    // Handle errors
                    if (result.errors) {
                        // Handle form validation errors
                        let errorMessage = 'Please fix the following issues:\n\n';
                        
                        // Check for specific field errors
                        if (result.errors.customer_email) {
                            errorMessage += '📧 Email: ' + result.errors.customer_email.join(', ') + '\n';
                        }
                        if (result.errors.password) {
                            errorMessage += '🔒 Password: ' + result.errors.password.join(', ') + '\n';
                        }
                        if (result.errors.customer_phone) {
                            errorMessage += '📱 Phone: ' + result.errors.customer_phone.join(', ') + '\n';
                        }
                        
                        // Add other field errors
                        Object.keys(result.errors).forEach(field => {
                            if (!['customer_email', 'password', 'customer_phone'].includes(field)) {
                                errorMessage += `${field}: ${result.errors[field].join(', ')}\n`;
                            }
                        });
                        
                        alert(errorMessage);
                    } else {
                        alert(result.error || 'Sorry, there was an error processing your shared ride booking. Please try again.');
                    }
                }
            } catch (error) {
                console.error('Shared ride booking error:', error);
                alert('Sorry, there was an error processing your shared ride booking. Please try again.');
            } finally {
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
            }
        });
    }

    // Handle solo ride form submission
    if (soloRideForm) {
        soloRideForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            // Validate passwords
            if (!validateSoloPasswords()) {
                return;
            }
            
            // Collect form data
            const formData = new FormData(soloRideForm);
            const bookingData = Object.fromEntries(formData);
            
            // Show loading state
            const submitBtn = soloRideForm.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            submitBtn.textContent = 'Processing...';
            submitBtn.disabled = true;
            
            try {
                // Make booking request
                const response = await fetch('/api/solo-ride/book', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                    },
                    body: JSON.stringify(bookingData)
                });
                
                const result = await response.json();
                
                if (response.ok && result.success) {
                    // Show success modal instead of alert
                    showBookingSuccess(result, bookingData);
                } else {
                    // Handle errors
                    if (result.errors) {
                        // Handle form validation errors
                        let errorMessage = 'Please fix the following issues:\n\n';
                        
                        // Check for specific field errors
                        if (result.errors.customer_email) {
                            errorMessage += '📧 Email: ' + result.errors.customer_email.join(', ') + '\n';
                        }
                        if (result.errors.password) {
                            errorMessage += '🔒 Password: ' + result.errors.password.join(', ') + '\n';
                        }
                        if (result.errors.customer_phone) {
                            errorMessage += '📱 Phone: ' + result.errors.customer_phone.join(', ') + '\n';
                        }
                        
                        // Add other field errors
                        Object.keys(result.errors).forEach(field => {
                            if (!['customer_email', 'password', 'customer_phone'].includes(field)) {
                                errorMessage += `${field}: ${result.errors[field].join(', ')}\n`;
                            }
                        });
                        
                        alert(errorMessage);
                    } else {
                        alert(result.error || 'Sorry, there was an error processing your solo ride booking. Please try again.');
                    }
                }
            } catch (error) {
                console.error('Solo ride booking error:', error);
                alert('Sorry, there was an error processing your solo ride booking. Please try again.');
            } finally {
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
            }
        });
    }

    // Handle airport transfer form submission
    if (airportTransferForm) {
        airportTransferForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            // Validate transfer type selection
            const transferType = document.querySelector('input[name="transfer_type"]:checked');
            if (!transferType) {
                alert('Please select a transfer type (pickup or drop-off).');
                return;
            }
            
            // Collect form data
            const formData = new FormData(airportTransferForm);
            const bookingData = Object.fromEntries(formData);
            
            // Show loading state
            const submitBtn = airportTransferForm.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            submitBtn.textContent = 'Processing...';
            submitBtn.disabled = true;
            
            try {
                // Make booking request
                const response = await fetch('/api/airport-transfer/book', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                    },
                    body: JSON.stringify(bookingData)
                });
                
                const result = await response.json();
                
                if (response.ok && result.success) {
                    // Show success modal instead of alert
                    showBookingSuccess(result, bookingData);
                } else {
                    alert(result.error || 'Sorry, there was an error processing your airport transfer booking. Please try again.');
                }
            } catch (error) {
                console.error('Airport transfer booking error:', error);
                alert('Sorry, there was an error processing your airport transfer booking. Please try again.');
            } finally {
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
            }
        });
    }

    // ===================================
    // PARCEL DELIVERY FUNCTIONALITY
    // ===================================
    
    // Parcel Delivery Form Elements
    const parcelDeliveryCard = document.getElementById('parcel-delivery-card');
    const parcelDeliveryFormContainer = document.getElementById('parcel-delivery-form-container');
    const closeParcelDeliveryFormBtn = document.getElementById('close-parcel-delivery-form');
    const cancelParcelDeliveryBookingBtn = document.getElementById('cancel-parcel-delivery-booking');
    const parcelDeliveryForm = document.getElementById('parcel-delivery-form');
    const parcelPriceDisplay = document.getElementById('parcel-price-display');
    const parcelPriceAmount = document.getElementById('parcel-price-amount');
    const parcelPriceBreakdown = document.getElementById('parcel-price-breakdown');
    
    // Open parcel delivery form when card is clicked
    if (parcelDeliveryCard) {
        parcelDeliveryCard.addEventListener('click', () => {
            // Hide all other forms first
            hideAllForms();
            
            // Show parcel delivery form
            if (parcelDeliveryFormContainer) {
                // Move form to dynamic area and show it
                if (dynamicFormsArea && !dynamicFormsArea.contains(parcelDeliveryFormContainer)) {
                    dynamicFormsArea.appendChild(parcelDeliveryFormContainer);
                }
                parcelDeliveryFormContainer.classList.remove('hidden');
                
                // Scroll to form
                parcelDeliveryFormContainer.scrollIntoView({ 
                    behavior: 'smooth', 
                    block: 'start',
                    inline: 'nearest'
                });
                
                // Load parcel delivery data
                loadParcelDeliveryData();
                
                // Update card styling
                updateActiveCard('parcel-delivery-card');
            }
        });
    }
    
    // Close parcel delivery form
    function closeParcelDeliveryForm() {
        if (parcelDeliveryFormContainer) {
            parcelDeliveryFormContainer.classList.add('hidden');
            if (parcelDeliveryForm) parcelDeliveryForm.reset();
            if (parcelPriceDisplay) parcelPriceDisplay.classList.add('hidden');
            
            // Clear password validation errors
            const parcelPasswordError = document.getElementById('parcel-password-error');
            if (parcelPasswordError) parcelPasswordError.remove();
            
            // Remove error styling from password fields
            const parcelPasswordField = document.getElementById('parcel_password');
            const parcelPasswordConfirmField = document.getElementById('parcel_password_confirmation');
            if (parcelPasswordField) parcelPasswordField.classList.remove('border-red-500');
            if (parcelPasswordConfirmField) parcelPasswordConfirmField.classList.remove('border-red-500');
            
            // Reset card styling
            resetCardStyling();
        }
    }
    
    if (closeParcelDeliveryFormBtn) closeParcelDeliveryFormBtn.addEventListener('click', closeParcelDeliveryForm);
    if (cancelParcelDeliveryBookingBtn) cancelParcelDeliveryBookingBtn.addEventListener('click', closeParcelDeliveryForm);

    // Parcel delivery password validation
    const parcelPasswordField = document.getElementById('parcel_password');
    const parcelPasswordConfirmField = document.getElementById('parcel_password_confirmation');
    
    function validateParcelPasswords() {
        if (!parcelPasswordField || !parcelPasswordConfirmField) return true;
        
        const password = parcelPasswordField.value;
        const passwordConfirm = parcelPasswordConfirmField.value;
        
        // Remove any existing error styles
        parcelPasswordField.classList.remove('border-red-500');
        parcelPasswordConfirmField.classList.remove('border-red-500');
        
        // Remove any existing error messages
        const existingError = document.getElementById('parcel-password-error');
        if (existingError) {
            existingError.remove();
        }
        
        let isValid = true;
        let errorMessage = '';
        
        if (password.length < 4) {
            errorMessage = 'Password must be at least 4 characters long.';
            parcelPasswordField.classList.add('border-red-500');
            isValid = false;
        } else if (password !== passwordConfirm) {
            errorMessage = 'Passwords do not match.';
            parcelPasswordConfirmField.classList.add('border-red-500');
            isValid = false;
        }
        
        if (!isValid && errorMessage) {
            const errorDiv = document.createElement('div');
            errorDiv.id = 'parcel-password-error';
            errorDiv.className = 'text-red-500 text-xs mt-1';
            errorDiv.textContent = errorMessage;
            parcelPasswordConfirmField.parentNode.appendChild(errorDiv);
        }
        
        return isValid;
    }
    
    // Add real-time password validation for parcel delivery
    if (parcelPasswordField) parcelPasswordField.addEventListener('input', validateParcelPasswords);
    if (parcelPasswordConfirmField) parcelPasswordConfirmField.addEventListener('input', validateParcelPasswords);

    // Load parcel delivery data
    async function loadParcelDeliveryData() {
        try {
            // Load cities
            const citiesResponse = await fetch('/api/cities');
            if (citiesResponse.ok) {
                const cities = await citiesResponse.json();
                populateParcelCityDropdowns(cities);
            } else {
                console.error('Failed to load cities:', citiesResponse.status);
                showError('Unable to load cities. Please refresh the page.');
                return;
            }
            
            // Load parcel types from admin-configured database ONLY
            console.log('Loading parcel types from admin configuration...');
            const parcelTypesResponse = await fetch('/api/parcel-types');
            
            if (parcelTypesResponse.ok) {
                const parcelTypes = await parcelTypesResponse.json();
                console.log('Parcel types loaded from admin panel:', parcelTypes);
                
                if (parcelTypes && parcelTypes.length > 0) {
                    populateParcelTypes(parcelTypes);
                } else {
                    console.warn('No parcel types found in admin configuration');
                    showParcelTypeEmptyState();
                }
            } else {
                console.error('Failed to load parcel types from admin panel:', parcelTypesResponse.status);
                const errorData = await parcelTypesResponse.json().catch(() => ({}));
                console.error('Error details:', errorData);
                showParcelTypeError('Unable to load parcel types. Please check your admin configuration.');
            }
        } catch (error) {
            console.error('Error loading parcel delivery data:', error);
            showParcelTypeError('Unable to load parcel types. Please check your connection and try again.');
        }
    }

    // Show empty state when no parcel types are configured in admin
    function showParcelTypeEmptyState() {
        const parcelTypeSelect = document.getElementById('parcel_type');
        if (parcelTypeSelect) {
            parcelTypeSelect.innerHTML = `
                <option value="">No parcel types available</option>
                <option value="" disabled>Please configure parcel types in admin panel</option>
            `;
            parcelTypeSelect.disabled = true;
            
            // Show helpful message to admin
            const messageDiv = document.createElement('div');
            messageDiv.className = 'mt-2 p-3 bg-yellow-50 border border-yellow-200 rounded text-sm';
            messageDiv.innerHTML = `
                <div class="flex items-center">
                    <i class="fas fa-exclamation-triangle text-yellow-500 mr-2"></i>
                    <span class="text-yellow-800">
                        No parcel types configured. 
                        <a href="/admin/transportation/parcel-types" target="_blank" 
                           class="underline hover:text-yellow-900">Configure in Admin Panel</a>
                    </span>
                </div>
            `;
            parcelTypeSelect.parentNode.appendChild(messageDiv);
        }
    }

    // Show error message for parcel type loading
    function showParcelTypeError(message) {
        const parcelTypeSelect = document.getElementById('parcel_type');
        if (parcelTypeSelect) {
            parcelTypeSelect.innerHTML = `<option value="">${message}</option>`;
            parcelTypeSelect.disabled = true;
        }
    }
    
    // Show general error message
    function showError(message) {
        console.error(message);
        // Could be enhanced to show user-friendly error notifications
    }

    function populateParcelCityDropdowns(cities) {
        const cityOptions = cities.map(city => 
            `<option value="${city.id}">${city.name}</option>`
        ).join('');
        
        const parcelPickupCitySelect = document.getElementById('parcel_pickup_city');
        const parcelDropoffCitySelect = document.getElementById('parcel_dropoff_city');
        
        if (parcelPickupCitySelect) {
            parcelPickupCitySelect.innerHTML = '<option value="">Select pickup city</option>' + cityOptions;
            // Add event listener for pricing updates
            parcelPickupCitySelect.addEventListener('change', checkParcelDeliveryPricing);
        }
        if (parcelDropoffCitySelect) {
            parcelDropoffCitySelect.innerHTML = '<option value="">Select delivery city</option>' + cityOptions;
            // Add event listener for pricing updates
            parcelDropoffCitySelect.addEventListener('change', checkParcelDeliveryPricing);
        }
    }
    
    function populateParcelTypes(parcelTypes) {
        console.log('Populating parcel types:', parcelTypes);
        
        if (!parcelTypes || parcelTypes.length === 0) {
            showParcelTypeError('No parcel types available');
            return;
        }
        
        const parcelOptions = parcelTypes.map(parcel => {
            const maxWeight = parseFloat(parcel.max_weight_kg) || 0;
            const baseRate = parseFloat(parcel.base_rate) || 0;
            const description = parcel.description ? ` - ${parcel.description}` : '';
            const rateInfo = baseRate > 0 ? ` (Base: KSh ${baseRate.toLocaleString()})` : '';
            
            return `<option value="${parcel.id}" 
                            data-max-weight="${maxWeight}" 
                            data-base-rate="${baseRate}" 
                            data-name="${parcel.name}">
                        ${parcel.name} (max ${maxWeight}kg)${description}${rateInfo}
                    </option>`;
        }).join('');
        
        const parcelTypeSelect = document.getElementById('parcel_type');
        if (parcelTypeSelect) {
            // Enable the select if it was disabled due to error
            parcelTypeSelect.disabled = false;
            parcelTypeSelect.innerHTML = '<option value="">Select parcel type</option>' + parcelOptions;
            
            // Remove any existing event listeners to avoid duplicates
            parcelTypeSelect.removeEventListener('change', handleParcelTypeChange);
            // Add event listener for pricing updates and weight validation
            parcelTypeSelect.addEventListener('change', handleParcelTypeChange);
        }
    }

    // Handle parcel type change
    function handleParcelTypeChange() {
        const parcelTypeSelect = document.getElementById('parcel_type');
        const selectedOption = parcelTypeSelect.options[parcelTypeSelect.selectedIndex];
        
        if (selectedOption && selectedOption.value) {
            const maxWeight = parseFloat(selectedOption.dataset.maxWeight) || 0;
            const parcelName = selectedOption.dataset.name || '';
            
            console.log(`Selected parcel type: ${parcelName}, Max weight: ${maxWeight}kg`);
            
            // Update weight field placeholder and max attribute
            const weightInput = document.getElementById('parcel_weight');
            if (weightInput && maxWeight > 0) {
                weightInput.placeholder = `Max ${maxWeight}kg`;
                weightInput.max = maxWeight;
                weightInput.step = maxWeight > 1 ? "0.1" : "0.01";
            }
        }
        
        validateParcelWeight();
        checkParcelDeliveryPricing();
    }

    // Validate parcel weight against selected parcel type (now optional)
    function validateParcelWeight() {
        const parcelTypeSelect = document.getElementById('parcel_type');
        const parcelWeightInput = document.getElementById('parcel_weight');
        
        if (!parcelTypeSelect || !parcelWeightInput) return;
        
        // If no weight is entered, that's okay now
        if (!parcelWeightInput.value) {
            parcelWeightInput.setCustomValidity('');
            return;
        }
        
        const selectedOption = parcelTypeSelect.options[parcelTypeSelect.selectedIndex];
        const maxWeight = selectedOption ? parseFloat(selectedOption.dataset.maxWeight) : null;
        const currentWeight = parseFloat(parcelWeightInput.value);
        
        if (maxWeight && currentWeight && currentWeight > maxWeight) {
            parcelWeightInput.setCustomValidity(`Weight cannot exceed ${maxWeight}kg for this parcel type`);
            parcelWeightInput.reportValidity();
        } else {
            parcelWeightInput.setCustomValidity('');
        }
    }

    // Weight input event listener (now optional)
    const parcelWeightInput = document.getElementById('parcel_weight');
    if (parcelWeightInput) {
        parcelWeightInput.addEventListener('input', () => {
            validateParcelWeight();
            checkParcelDeliveryPricing(); // Update pricing when weight changes
        });
    }

    // Check parcel delivery pricing when required fields are selected (simplified to use only base price)
    async function checkParcelDeliveryPricing() {
        const pickupCityId = document.getElementById('parcel_pickup_city')?.value;
        const dropoffCityId = document.getElementById('parcel_dropoff_city')?.value;
        const parcelTypeId = document.getElementById('parcel_type')?.value;
        const parcelWeight = document.getElementById('parcel_weight')?.value || '1.0'; // Default weight if not provided
        
        console.log('Checking pricing with:', {
            pickupCityId, dropoffCityId, parcelTypeId, weight: parcelWeight
        });
        
        if (!pickupCityId || !dropoffCityId || !parcelTypeId || pickupCityId === dropoffCityId) {
            if (parcelPriceDisplay) parcelPriceDisplay.classList.add('hidden');
            return;
        }
        
        try {
            const params = new URLSearchParams({
                pickup_city_id: pickupCityId,
                dropoff_city_id: dropoffCityId,
                parcel_type_id: parcelTypeId,
                weight: parcelWeight, // Include weight parameter (default 1.0 if not provided)
                urgent_delivery: '0', // Default to false since you removed delivery options
                insurance_required: '0' // Default to false since you removed delivery options
            });
            
            console.log('Making pricing API call with params:', params.toString());
            
            const response = await fetch(`/api/parcel-delivery/pricing?${params}`);
            const data = await response.json();
            
            console.log('Pricing API response:', data);
            
            if (response.ok && data.success && data.total_price) {
                // Update price display with base price only
                parcelPriceAmount.textContent = `KSh ${Math.round(data.total_price).toLocaleString()}`;
                
                // Show simplified price breakdown (base price only)
                let breakdown = '';
                if (data.base_price) {
                    breakdown = `Base rate: KSh ${Math.round(data.base_price).toLocaleString()}`;
                } else if (data.breakdown && data.breakdown.base_rate > 0) {
                    breakdown = `Base rate: KSh ${Math.round(data.breakdown.base_rate).toLocaleString()}`;
                } else {
                    // Fallback breakdown
                    breakdown = `Base price for ${data.parcel_type || 'parcel'}: KSh ${Math.round(data.total_price).toLocaleString()}`;
                }
                
                parcelPriceBreakdown.innerHTML = breakdown;
                parcelPriceDisplay.classList.remove('hidden');
                
                // Hide config notice if it was shown
                const configNotice = document.getElementById('parcel-config-notice');
                if (configNotice) {
                    configNotice.classList.add('hidden');
                }
            } else {
                if (parcelPriceDisplay) parcelPriceDisplay.classList.add('hidden');
                
                // Show error if available
                if (data.error) {
                    console.error('Parcel pricing error:', data.error);
                    
                    // Check if admin configuration is needed
                    if (data.admin_config_needed) {
                        const configNotice = document.getElementById('parcel-config-notice');
                        const configMessage = document.getElementById('parcel-config-message');
                        const configLink = document.getElementById('parcel-config-link');
                        
                        if (configNotice && configMessage) {
                            configMessage.textContent = data.error;
                            if (configLink && data.admin_url) {
                                configLink.href = data.admin_url;
                            }
                            configNotice.classList.remove('hidden');
                        }
                    }
                }
            }
        } catch (error) {
            console.error('Error checking parcel delivery price:', error);
            
            // Show error message - no fallback pricing
            if (parcelPriceDisplay) {
                parcelPriceDisplay.classList.add('hidden');
            }
            
            // Show configuration notice if admin config is needed
            const configNotice = document.getElementById('parcel-config-notice');
            const configMessage = document.getElementById('parcel-config-message');
            const configLink = document.getElementById('parcel-config-link');
            
            if (configNotice && configMessage) {
                configMessage.textContent = 'Unable to calculate price. The administrator needs to configure pricing for this route and parcel type.';
                if (configLink) {
                    configLink.href = '/admin/transportation/pricing';
                }
                configNotice.classList.remove('hidden');
            }
        }
    }

    // Handle parcel delivery form submission
    if (parcelDeliveryForm) {
        parcelDeliveryForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            // Validate passwords
            if (!validateParcelPasswords()) {
                return;
            }
            
            // Optional weight validation (only if weight is provided)
            if (parcelWeightInput && parcelWeightInput.value) {
                validateParcelWeight();
                if (!parcelWeightInput.checkValidity()) {
                    return;
                }
            }
            
            // Collect form data
            const formData = new FormData(parcelDeliveryForm);
            const bookingData = Object.fromEntries(formData);
            
            // Ensure weight has a default value if not provided
            if (!bookingData.parcel_weight || bookingData.parcel_weight === '') {
                bookingData.parcel_weight = '1.0';
            }
            
            // Set default values for removed delivery options
            bookingData.urgent_delivery = false;
            bookingData.signature_required = false;
            bookingData.insurance_required = false;
            
            // Show loading state
            const submitBtn = parcelDeliveryForm.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            submitBtn.textContent = 'Processing...';
            submitBtn.disabled = true;
            
            try {
                // Make booking request
                const response = await fetch('/api/parcel-delivery/book', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                    },
                    body: JSON.stringify(bookingData)
                });
                
                const result = await response.json();
                
                if (response.ok && result.success) {
                    // Show success modal instead of alert
                    showBookingSuccess(result, bookingData);
                } else {
                    // Handle errors
                    if (result.errors) {
                        // Handle form validation errors
                        let errorMessage = 'Please fix the following issues:\n\n';
                        
                        // Check for specific field errors
                        if (result.errors.customer_email) {
                            errorMessage += '📧 Email: ' + result.errors.customer_email.join(', ') + '\n';
                        }
                        if (result.errors.password) {
                            errorMessage += '🔒 Password: ' + result.errors.password.join(', ') + '\n';
                        }
                        
                        // Add other field errors
                        Object.keys(result.errors).forEach(field => {
                            if (!['customer_email', 'password'].includes(field)) {
                                errorMessage += `${field}: ${result.errors[field].join(', ')}\n`;
                            }
                        });
                        
                        alert(errorMessage);
                    } else if (result.admin_config_needed) {
                        // Show admin configuration needed error
                        alert(`❌ Booking Failed\n\n${result.error}\n\nThe administrator needs to configure pricing for this route and parcel type in the admin panel.\n\nPlease contact support or try a different route.`);
                    } else {
                        alert(result.error || 'Sorry, there was an error processing your parcel delivery booking. Please try again.');
                    }
                }
            } catch (error) {
                console.error('Parcel delivery booking error:', error);
                alert('Sorry, there was an error processing your parcel delivery booking. Please try again.');
            } finally {
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
            }
        });
    }

    // Handle car hire form submission
    if (carHireForm) {
        carHireForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            // Validate passwords
            if (!validateCarHirePasswords()) {
                return;
            }
            
            // Validate dates
            const startDate = document.getElementById('hire_start_date').value;
            const endDate = document.getElementById('hire_end_date').value;
            
            if (!startDate || !endDate) {
                alert('Please select both start and end dates for your car hire.');
                return;
            }
            
            if (new Date(endDate) <= new Date(startDate)) {
                alert('End date must be after the start date.');
                return;
            }
            
            // Collect form data
            const formData = new FormData(carHireForm);
            const bookingData = Object.fromEntries(formData);
            
            // Show loading state
            const submitBtn = carHireForm.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            submitBtn.textContent = 'Processing...';
            submitBtn.disabled = true;
            
            try {
                // Make booking request
                const response = await fetch('/api/car-hire/book', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                    },
                    body: JSON.stringify(bookingData)
                });
                
                const result = await response.json();
                
                if (response.ok && result.success) {
                    // Show success modal instead of alert
                    showBookingSuccess(result, bookingData);
                } else {
                    // Handle errors
                    if (result.errors) {
                        // Handle form validation errors
                        let errorMessage = 'Please fix the following issues:\n\n';
                        
                        // Check for specific field errors
                        if (result.errors.customer_email) {
                            errorMessage += '📧 Email: ' + result.errors.customer_email.join(', ') + '\n';
                        }
                        if (result.errors.password) {
                            errorMessage += '🔒 Password: ' + result.errors.password.join(', ') + '\n';
                        }
                        if (result.errors.drivers_license_number) {
                            errorMessage += '🪪 Driver\'s License: ' + result.errors.drivers_license_number.join(', ') + '\n';
                        }
                        
                        // Add other field errors
                        Object.keys(result.errors).forEach(field => {
                            if (!['customer_email', 'password', 'drivers_license_number'].includes(field)) {
                                errorMessage += `${field}: ${result.errors[field].join(', ')}\n`;
                            }
                        });
                        
                        alert(errorMessage);
                    } else {
                        alert(result.error || 'Sorry, there was an error processing your car hire booking. Please try again.');
                    }
                }
            } catch (error) {
                console.error('Car hire booking error:', error);
                alert('Sorry, there was an error processing your car hire booking. Please try again.');
            } finally {
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
            }
        });
    }

    // ===================================
    // INITIALIZATION
    // ===================================

    // Set minimum dates for date inputs
    document.addEventListener('DOMContentLoaded', function() {
        const today = new Date().toISOString().split('T')[0];
        const dateInputs = document.querySelectorAll('input[type="date"]');
        
        dateInputs.forEach(input => {
            input.min = today;
        });
        
        // Initialize service cards with proper styling
        initializeServiceCards();
    });
    
    // Initialize service cards with improved interaction and Solo Ride as default
    function initializeServiceCards() {
        // Set up initial state
        resetCardStyling();
        
        // Add enhanced click handlers for all service cards
        const serviceCards = document.querySelectorAll('.service-card');
        serviceCards.forEach(card => {
            // Add click handler
            card.addEventListener('click', handleCardClick);
            
            // Add keyboard accessibility
            card.setAttribute('tabindex', '0');
            card.setAttribute('role', 'button');
            card.setAttribute('aria-pressed', card.id === 'solo-ride-card' ? 'true' : 'false');
            
            // Handle keyboard navigation
            card.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    handleCardClick.call(this, e);
                }
            });
        });
    }
    
    // Enhanced card click handler
    function handleCardClick(e) {
        e.preventDefault();
        
        // Prevent double-clicking the already selected card
        if (this.classList.contains('service-card-selected')) {
            return;
        }
        
        // Add visual feedback
        this.style.transform = 'scale(0.98)';
        
        setTimeout(() => {
            // Update aria-pressed for all cards
            document.querySelectorAll('.service-card').forEach(card => {
                card.setAttribute('aria-pressed', 'false');
            });
            this.setAttribute('aria-pressed', 'true');
            
            // Update active card
            updateActiveCard(this.id);
            
            // Reset transform
            this.style.transform = '';
        }, 100);
    }
    
    // Add a function to ensure brand colors are properly loaded
    function ensureBrandColors() {
        // Add CSS custom properties for brand colors if not already defined
        const root = document.documentElement;
        root.style.setProperty('--orange-custom', '#FF6B35');
        root.style.setProperty('--brown-custom', '#8B4513');
    }
    
    // Call on page load
    ensureBrandColors();
</script>
