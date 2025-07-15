/**
 * Enhanced booking form functionality for authenticated users
 * Automatically pre-fills customer information for logged-in users
 */

class BookingFormEnhancer {
    constructor() {
        this.currentUser = null;
        this.userBookingData = null;
        this.init();
    }

    async init() {
        try {
            // Fetch current user data when the page loads
            await this.fetchCurrentUser();
            
            // Setup form enhancement for all booking forms
            this.setupFormEnhancements();
            
            // Setup user status display
            this.setupUserStatusDisplay();
            
            console.log('Booking form enhancement initialized', {
                authenticated: this.currentUser?.authenticated || false,
                userEmail: this.currentUser?.user?.email || null
            });
        } catch (error) {
            console.error('Error initializing booking form enhancement:', error);
        }
    }

    async fetchCurrentUser() {
        try {
            const response = await fetch('/api/user/current');
            this.currentUser = await response.json();
            
            if (this.currentUser.authenticated) {
                // Also fetch booking preferences
                const bookingDataResponse = await fetch('/api/user/booking-data');
                this.userBookingData = await bookingDataResponse.json();
            }
        } catch (error) {
            console.error('Error fetching user data:', error);
            this.currentUser = { authenticated: false, user: null };
        }
    }

    setupUserStatusDisplay() {
        if (this.currentUser?.authenticated) {
            this.showUserWelcome();
        }
    }

    showUserWelcome() {
        // Add a user welcome banner to the page if user is authenticated
        const existingWelcome = document.getElementById('user-welcome-banner');
        if (existingWelcome) return; // Already showing

        const welcomeBanner = document.createElement('div');
        welcomeBanner.id = 'user-welcome-banner';
        welcomeBanner.className = 'fixed top-0 left-0 right-0 bg-gradient-to-r from-green-500 to-emerald-500 text-white py-2 px-4 text-sm z-50 transition-all duration-300';
        welcomeBanner.innerHTML = `
            <div class="max-w-7xl mx-auto flex justify-between items-center">
                <div class="flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                    </svg>
                    Welcome back, ${this.currentUser.user.name}! Your details will be auto-filled for faster booking.
                </div>
                <button onclick="this.parentElement.parentElement.style.display='none'" class="text-white hover:text-gray-200">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </button>
            </div>
        `;

        document.body.insertBefore(welcomeBanner, document.body.firstChild);

        // Auto-hide after 5 seconds
        setTimeout(() => {
            welcomeBanner.style.transform = 'translateY(-100%)';
            setTimeout(() => welcomeBanner.remove(), 300);
        }, 5000);
    }

    setupFormEnhancements() {
        // Watch for when booking forms are shown
        const observer = new MutationObserver((mutations) => {
            mutations.forEach((mutation) => {
                mutation.addedNodes.forEach((node) => {
                    if (node.nodeType === 1 && node.querySelector) {
                        this.enhanceVisibleForms();
                    }
                });
            });
        });

        observer.observe(document.body, { childList: true, subtree: true });

        // Also enhance any forms that are already visible
        setTimeout(() => this.enhanceVisibleForms(), 1000);
    }

    enhanceVisibleForms() {
        if (!this.currentUser?.authenticated) return;

        // Find all visible booking forms
        const forms = [
            '#shared-ride-form',
            '#solo-ride-form', 
            '#airport-transfer-form',
            '#car-hire-form',
            '#parcel-delivery-form'
        ];

        forms.forEach(selector => {
            const form = document.querySelector(selector);
            if (form && this.isElementVisible(form)) {
                this.enhanceForm(form);
            }
        });
    }

    isElementVisible(element) {
        const rect = element.getBoundingClientRect();
        const style = window.getComputedStyle(element);
        return (
            rect.width > 0 && 
            rect.height > 0 && 
            style.display !== 'none' && 
            style.visibility !== 'hidden' &&
            style.opacity !== '0'
        );
    }

    enhanceForm(form) {
        const container = form.closest('[id$="-form-container"]');
        if (!container || container.dataset.enhanced === 'true') {
            console.log('Form already enhanced or container not found:', form.id);
            return;
        }

        console.log('Starting form enhancement for authenticated user:', form.id);

        // Mark as enhanced to avoid double-processing
        container.dataset.enhanced = 'true';

        // Pre-fill user information
        this.preFillUserInfo(form);

        // Hide/modify password fields for authenticated users
        this.modifyPasswordFields(form);

        // Add user status indicator
        this.addUserStatusIndicator(form);

        // Add frequent routes suggestion if available
        this.addRoutesSuggestion(form);

        console.log('Form enhancement completed for:', form.id);
    }

    preFillUserInfo(form) {
        const user = this.currentUser.user;
        
        // Fill name field
        const nameField = form.querySelector('input[name="customer_name"]');
        if (nameField && !nameField.value) {
            nameField.value = user.name;
            this.addPrefilledIndicator(nameField);
        }

        // Fill email field  
        const emailField = form.querySelector('input[name="customer_email"]');
        if (emailField && !emailField.value) {
            emailField.value = user.email;
            emailField.readOnly = true; // Prevent email changes for security
            this.addPrefilledIndicator(emailField);
        }

        // Fill phone field
        const phoneField = form.querySelector('input[name="customer_phone"]');
        if (phoneField && !phoneField.value && user.phone) {
            phoneField.value = user.phone;
            this.addPrefilledIndicator(phoneField);
        }
    }

    addPrefilledIndicator(field) {
        // Add a visual indicator that this field was pre-filled
        field.style.borderColor = '#10B981';
        field.style.backgroundColor = '#F0FDF4';
        
        // Add a small icon to indicate pre-filled
        const icon = document.createElement('div');
        icon.className = 'absolute right-2 top-1/2 transform -translate-y-1/2 text-green-500';
        icon.innerHTML = `
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
        `;
        
        // Make field container relative if it isn't already
        const container = field.parentElement;
        if (window.getComputedStyle(container).position === 'static') {
            container.style.position = 'relative';
        }
        container.appendChild(icon);
    }

    modifyPasswordFields(form) {
        // Find password section
        const passwordFields = form.querySelectorAll('input[name="password"], input[name="password_confirmation"]');
        
        passwordFields.forEach(field => {
            // Remove required attribute since user is already authenticated
            field.removeAttribute('required');
            field.value = ''; // Clear any existing value
            
            // Hide the field and its container
            const fieldContainer = field.closest('div');
            if (fieldContainer) {
                fieldContainer.style.display = 'none';
            }
        });

        // Find password section container and add an info message
        const passwordSection = form.querySelector('input[name="password"]')?.closest('.bg-gradient-to-br');
        if (passwordSection) {
            // Replace password section with logged-in user info
            passwordSection.innerHTML = `
                <h4 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                    <div class="p-2 bg-green-100 rounded-lg mr-2 border border-green-200">
                        <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    You're Logged In
                </h4>
                <div class="space-y-3">
                    <div class="p-4 bg-gradient-to-br from-green-50 to-emerald-50 border border-green-200 rounded-lg">
                        <div class="flex items-center mb-2">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-800">${this.currentUser.user.name}</p>
                                <p class="text-xs text-gray-600">${this.currentUser.user.email}</p>
                            </div>
                        </div>
                        <p class="text-xs text-gray-600">Your account details have been automatically filled. No password required!</p>
                    </div>
                    
                    ${this.getUserStatsHTML()}
                </div>
            `;
        }
        
        // Override form validation for this form
        this.overrideFormValidation(form);
    }

    overrideFormValidation(form) {
        // Store reference to the enhancement instance
        const enhancer = this;
        
        console.log('Setting up enhanced form validation for:', form.id);
        
        // Don't clone the form - instead, add a new event listener that captures before the original
        form.addEventListener('submit', function(e) {
            console.log('Enhanced submit handler triggered for authenticated user');
            e.preventDefault();
            e.stopPropagation();
            
            // Get form data
            const formData = new FormData(form);
            const bookingData = Object.fromEntries(formData);
            
            // Remove password fields from data since user is authenticated
            delete bookingData.password;
            delete bookingData.password_confirmation;
            
            console.log('Booking data for authenticated user:', bookingData);
            
            // Determine which booking API to call based on form
            let apiEndpoint = '';
            const formId = form.id;
            
            if (formId.includes('shared-ride')) {
                apiEndpoint = '/api/shared-ride/book';
            } else if (formId.includes('solo-ride')) {
                apiEndpoint = '/api/solo-ride/book';
            } else if (formId.includes('airport-transfer')) {
                apiEndpoint = '/api/airport-transfer/book';
            } else if (formId.includes('car-hire')) {
                apiEndpoint = '/api/car-hire/book';
            } else if (formId.includes('parcel-delivery')) {
                apiEndpoint = '/api/parcel-delivery/book';
            } else {
                console.error('Unknown form type:', formId);
                alert('Unable to determine booking type. Please try again.');
                return;
            }
            
            // Show loading state
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalBtnText = submitBtn.textContent;
            submitBtn.textContent = 'Processing...';
            submitBtn.disabled = true;
            
            // Submit the booking
            enhancer.submitAuthenticatedBooking(apiEndpoint, bookingData, submitBtn, originalBtnText);
        }, true); // Use capture phase to run before other handlers
        
        console.log('Enhanced form validation setup complete for:', form.id);
    }
    
    async submitAuthenticatedBooking(apiEndpoint, bookingData, submitBtn, originalBtnText) {
        try {
            console.log('Submitting authenticated booking to:', apiEndpoint);
            
            const response = await fetch(apiEndpoint, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                },
                body: JSON.stringify(bookingData)
            });
            
            const result = await response.json();
            console.log('Booking response:', result);
            
            if (response.ok && result.success) {
                // Success - show success modal if available
                if (typeof showBookingSuccess === 'function') {
                    showBookingSuccess(result, bookingData);
                } else {
                    // Fallback - show alert and redirect
                    alert(`🎉 Booking successful!\n\nBooking Reference: ${result.booking_reference}\n\n${result.message}`);
                    window.location.href = '/dashboard';
                }
            } else {
                // Handle errors
                console.error('Booking error:', result);
                
                if (result.errors) {
                    let errorMessage = 'Please fix the following issues:\n\n';
                    Object.keys(result.errors).forEach(field => {
                        errorMessage += `• ${field}: ${result.errors[field].join(', ')}\n`;
                    });
                    alert(errorMessage);
                } else {
                    alert(result.error || 'Sorry, there was an error processing your booking. Please try again.');
                }
            }
        } catch (error) {
            console.error('Network error during booking:', error);
            alert('Sorry, there was a network error. Please check your connection and try again.');
        } finally {
            // Restore button state
            submitBtn.textContent = originalBtnText;
            submitBtn.disabled = false;
        }
    }

    getUserStatsHTML() {
        if (!this.userBookingData?.statistics) return '';

        const stats = this.userBookingData.statistics;
        return `
            <div class="mt-4 p-3 bg-white/50 rounded-lg border border-green-100">
                <h5 class="text-sm font-bold text-gray-800 mb-2">Your Booking Stats</h5>
                <div class="grid grid-cols-2 gap-2 text-xs">
                    <div class="text-center">
                        <div class="font-bold text-blue-600">${stats.total_bookings}</div>
                        <div class="text-gray-600">Total Trips</div>
                    </div>
                    <div class="text-center">
                        <div class="font-bold text-green-600">${stats.success_rate}%</div>
                        <div class="text-gray-600">Success Rate</div>
                    </div>
                </div>
            </div>
        `;
    }

    addUserStatusIndicator(form) {
        const container = form.closest('[id$="-form-container"]');
        if (!container) return;

        // Add a status bar at the top of the form
        const statusBar = document.createElement('div');
        statusBar.className = 'bg-green-50 border-l-4 border-green-400 p-3 mb-4';
        statusBar.innerHTML = `
            <div class="flex items-center">
                <svg class="w-5 h-5 text-green-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <div>
                    <p class="text-sm font-medium text-green-800">
                        Booking as ${this.currentUser.user.name}
                    </p>
                    <p class="text-xs text-green-600">
                        Your information has been pre-filled for faster booking
                    </p>
                </div>
            </div>
        `;

        const formBody = container.querySelector('form');
        if (formBody) {
            formBody.insertBefore(statusBar, formBody.firstChild);
        }
    }

    addRoutesSuggestion(form) {
        if (!this.userBookingData?.preferences?.frequent_routes?.length) return;

        // Find route selection area
        const pickupField = form.querySelector('select[name="pickup_city_id"]');
        const dropoffField = form.querySelector('select[name="dropoff_city_id"]');
        
        if (!pickupField || !dropoffField) return;

        // Add frequent routes suggestion
        const suggestionContainer = document.createElement('div');
        suggestionContainer.className = 'mt-3 p-3 bg-blue-50 border border-blue-200 rounded-lg';
        suggestionContainer.innerHTML = `
            <h5 class="text-sm font-semibold text-blue-800 mb-2 flex items-center">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Your Frequent Routes
            </h5>
            <div class="space-y-1">
                ${this.userBookingData.preferences.frequent_routes.slice(0, 3).map(route => `
                    <button type="button" class="frequent-route-btn w-full text-left px-2 py-1 text-xs bg-white rounded border hover:bg-blue-50 transition-colors"
                            data-pickup="${route.pickup_city_id}" data-dropoff="${route.dropoff_city_id}">
                        ${route.pickupCity?.name || 'Unknown'} → ${route.dropoffCity?.name || 'Unknown'} 
                        <span class="text-gray-500">(${route.frequency} trips)</span>
                    </button>
                `).join('')}
            </div>
        `;

        // Insert after route selection fields
        const routeContainer = pickupField.closest('.grid') || pickupField.closest('.space-y-4');
        if (routeContainer) {
            routeContainer.parentNode.insertBefore(suggestionContainer, routeContainer.nextSibling);
        }

        // Add click handlers for frequent route buttons
        suggestionContainer.addEventListener('click', (e) => {
            if (e.target.classList.contains('frequent-route-btn')) {
                const pickup = e.target.dataset.pickup;
                const dropoff = e.target.dataset.dropoff;
                
                if (pickup && dropoff) {
                    pickupField.value = pickup;
                    dropoffField.value = dropoff;
                    
                    // Trigger change events to update pricing
                    pickupField.dispatchEvent(new Event('change'));
                    dropoffField.dispatchEvent(new Event('change'));
                    
                    // Visual feedback
                    e.target.style.backgroundColor = '#DBEAFE';
                    setTimeout(() => {
                        e.target.style.backgroundColor = '';
                    }, 1000);
                }
            }
        });
    }
}

// Initialize the booking form enhancer when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    new BookingFormEnhancer();
});

// Also initialize if DOM is already loaded
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        new BookingFormEnhancer();
    });
} else {
    new BookingFormEnhancer();
}
