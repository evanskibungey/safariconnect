<script>
    // ===================================
    // GLOBAL VARIABLES AND UTILITIES
    // ===================================
    
    // Mobile menu functionality
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');

    if (mobileMenuBtn && mobileMenu) {
        mobileMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    }

    // ===================================
    // SHARED RIDE FUNCTIONALITY
    // ===================================
    
    // Shared Ride Modal Elements
    const sharedRideCard = document.getElementById('shared-ride-card');
    const sharedRideModal = document.getElementById('shared-ride-modal');
    const closeModalBtn = document.getElementById('close-modal');
    const cancelBookingBtn = document.getElementById('cancel-booking');
    const sharedRideForm = document.getElementById('shared-ride-form');
    const priceDisplay = document.getElementById('price-display');
    const priceAmount = document.getElementById('price-amount');
    
    // Open shared ride modal when card is clicked
    if (sharedRideCard) {
        sharedRideCard.addEventListener('click', () => {
            sharedRideModal.classList.remove('hidden');
            loadSharedRideData();
        });
    }
    
    // Close shared ride modal
    function closeSharedModal() {
        if (sharedRideModal) {
            sharedRideModal.classList.add('hidden');
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
        }
    }
    
    if (closeModalBtn) closeModalBtn.addEventListener('click', closeSharedModal);
    if (cancelBookingBtn) cancelBookingBtn.addEventListener('click', closeSharedModal);
    
    // Close modal when clicking outside
    if (sharedRideModal) {
        sharedRideModal.addEventListener('click', (e) => {
            if (e.target === sharedRideModal) {
                closeSharedModal();
            }
        });
    }

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
    
    // Solo Ride Modal Elements
    const soloRideCard = document.getElementById('solo-ride-card');
    const soloRideModal = document.getElementById('solo-ride-modal');
    const closeSoloModalBtn = document.getElementById('close-solo-modal');
    const cancelSoloBookingBtn = document.getElementById('cancel-solo-booking');
    const soloRideForm = document.getElementById('solo-ride-form');
    const soloPriceDisplay = document.getElementById('solo-price-display');
    const soloPriceAmount = document.getElementById('solo-price-amount');
    
    // Open solo ride modal when card is clicked
    if (soloRideCard) {
        soloRideCard.addEventListener('click', () => {
            soloRideModal.classList.remove('hidden');
            loadSoloRideData();
        });
    }
    
    // Close solo ride modal
    function closeSoloModal() {
        if (soloRideModal) {
            soloRideModal.classList.add('hidden');
            if (soloRideForm) soloRideForm.reset();
            if (soloPriceDisplay) soloPriceDisplay.classList.add('hidden');
        }
    }
    
    if (closeSoloModalBtn) closeSoloModalBtn.addEventListener('click', closeSoloModal);
    if (cancelSoloBookingBtn) cancelSoloBookingBtn.addEventListener('click', closeSoloModal);

    // Close modal when clicking outside
    if (soloRideModal) {
        soloRideModal.addEventListener('click', (e) => {
            if (e.target === soloRideModal) {
                closeSoloModal();
            }
        });
    }

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
    // AIRPORT TRANSFER FUNCTIONALITY
    // ===================================
    
    // Airport Transfer Modal Elements  
    const airportTransferCard = document.getElementById('airport-transfer-card');
    const airportTransferModal = document.getElementById('airport-transfer-modal');
    const closeAirportModalBtn = document.getElementById('close-airport-modal');
    const cancelAirportBookingBtn = document.getElementById('cancel-airport-booking');
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
    
    // Open airport transfer modal when card is clicked
    if (airportTransferCard) {
        airportTransferCard.addEventListener('click', () => {
            airportTransferModal.classList.remove('hidden');
            loadAirportTransferData();
        });
    }
    
    // Close airport transfer modal
    function closeAirportModal() {
        if (airportTransferModal) {
            airportTransferModal.classList.add('hidden');
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
        }
    }
    
    if (closeAirportModalBtn) closeAirportModalBtn.addEventListener('click', closeAirportModal);
    if (cancelAirportBookingBtn) cancelAirportBookingBtn.addEventListener('click', closeAirportModal);

    // Close modal when clicking outside
    if (airportTransferModal) {
        airportTransferModal.addEventListener('click', (e) => {
            if (e.target === airportTransferModal) {
                closeAirportModal();
            }
        });
    }

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
    }

    // Check shared ride pricing when cities are selected
    async function checkSharedRidePricing() {
        const pickupCitySelect = document.getElementById('pickup_city');
        const dropoffCitySelect = document.getElementById('dropoff_city');
        const priceDisplay = document.getElementById('price-display');
        const priceAmount = document.getElementById('price-amount');
        
        if (!pickupCitySelect || !dropoffCitySelect) return;
        
        const pickupCityId = pickupCitySelect.value;
        const dropoffCityId = dropoffCitySelect.value;
        
        if (pickupCityId && dropoffCityId && pickupCityId !== dropoffCityId) {
            try {
                const response = await fetch(`/api/shared-ride/pricing?pickup_city_id=${pickupCityId}&dropoff_city_id=${dropoffCityId}`);
                if (response.ok) {
                    const data = await response.json();
                    if (data.price) {
                        priceAmount.textContent = `KSh ${data.price.toLocaleString()}`;
                        priceDisplay.classList.remove('hidden');
                    } else {
                        priceDisplay.classList.add('hidden');
                    }
                }
            } catch (error) {
                console.error('Error checking shared ride price:', error);
                // Show sample price for demonstration
                priceAmount.textContent = 'KSh 1,500';
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
                    // Success message with booking reference and account info
                    let successMessage;
                    
                    if (result.account_created) {
                        successMessage = `🎉 Shared Ride Booking Successful!\n\nBooking Reference: ${result.booking_reference}\n\n✅ Your SafariConnect account has been created!\nEmail: ${bookingData.customer_email}\n\nYou are now logged in and can track your booking from your dashboard.\n\nWe will contact you shortly with confirmation details and driver assignment.`;
                    } else {
                        successMessage = `🎉 Shared Ride Booking Successful!\n\nBooking Reference: ${result.booking_reference}\n\n✅ Welcome back! You are now logged in.\n\nYou can track this booking from your dashboard.\n\nWe will contact you shortly with confirmation details and driver assignment.`;
                    }
                    
                    alert(successMessage);
                    closeSharedModal();
                    
                    // Refresh the page to show the updated header with user info
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
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
                    let successMessage;
                    
                    if (result.account_created) {
                        successMessage = `🎉 Solo Ride Booking Successful!\n\nBooking Reference: ${result.booking_reference}\n\n✅ Your SafariConnect account has been created!\nEmail: ${bookingData.customer_email}\n\nYou are now logged in and can track your booking from your dashboard.\n\nWe will contact you shortly with confirmation details and driver assignment.`;
                    } else {
                        successMessage = `🎉 Solo Ride Booking Successful!\n\nBooking Reference: ${result.booking_reference}\n\n✅ Welcome back! You are now logged in.\n\nYou can track this booking from your dashboard.\n\nWe will contact you shortly with confirmation details and driver assignment.`;
                    }
                    
                    alert(successMessage);
                    closeSoloModal();
                    
                    // Refresh the page to show the updated header with user info
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    alert(result.error || 'Sorry, there was an error processing your solo ride booking. Please try again.');
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
                    let successMessage;
                    
                    if (result.account_created) {
                        successMessage = `🎉 Airport Transfer Booking Successful!\n\nBooking Reference: ${result.booking_reference}\n\n✅ Your SafariConnect account has been created!\nEmail: ${bookingData.customer_email}\n\nYou are now logged in and can track your booking from your dashboard.\n\nWe will contact you shortly with confirmation details and driver assignment.`;
                    } else {
                        successMessage = `🎉 Airport Transfer Booking Successful!\n\nBooking Reference: ${result.booking_reference}\n\n✅ Welcome back! You are now logged in.\n\nYou can track this booking from your dashboard.\n\nWe will contact you shortly with confirmation details and driver assignment.`;
                    }
                    
                    alert(successMessage);
                    closeAirportModal();
                    
                    // Refresh the page to show the updated header with user info
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
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
    // INITIALIZATION
    // ===================================

    // Set minimum dates for date inputs
    document.addEventListener('DOMContentLoaded', function() {
        const today = new Date().toISOString().split('T')[0];
        const dateInputs = document.querySelectorAll('input[type="date"]');
        
        dateInputs.forEach(input => {
            input.min = today;
        });
    });
</script>
