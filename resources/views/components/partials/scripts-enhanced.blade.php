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
    // CAR HIRE FUNCTIONALITY
    // ===================================
    
    // Car Hire Modal Elements
    const carHireCard = document.getElementById('car-hire-card');
    const carHireModal = document.getElementById('car-hire-modal');
    const closeCarHireModalBtn = document.getElementById('close-car-hire-modal');
    const cancelCarHireBookingBtn = document.getElementById('cancel-car-hire-booking');
    const carHireForm = document.getElementById('car-hire-form');
    const carHirePriceDisplay = document.getElementById('car-hire-price-display');
    const carHirePricePerDay = document.getElementById('car-hire-price-per-day');
    const carHireTotalPrice = document.getElementById('car-hire-total-price');
    const carHireDuration = document.getElementById('car-hire-duration');
    
    // Open car hire modal when card is clicked
    if (carHireCard) {
        carHireCard.addEventListener('click', () => {
            carHireModal.classList.remove('hidden');
            loadCarHireData();
        });
    }
    
    // Close car hire modal
    function closeCarHireModal() {
        if (carHireModal) {
            carHireModal.classList.add('hidden');
            if (carHireForm) carHireForm.reset();
            if (carHirePriceDisplay) carHirePriceDisplay.classList.add('hidden');
        }
    }
    
    if (closeCarHireModalBtn) closeCarHireModalBtn.addEventListener('click', closeCarHireModal);
    if (cancelCarHireBookingBtn) cancelCarHireBookingBtn.addEventListener('click', closeCarHireModal);

    // Close modal when clicking outside
    if (carHireModal) {
        carHireModal.addEventListener('click', (e) => {
            if (e.target === carHireModal) {
                closeCarHireModal();
            }
        });
    }

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
    // PARCEL DELIVERY FUNCTIONALITY
    // ===================================
    
    // Parcel Delivery Modal Elements
    const parcelDeliveryCard = document.getElementById('parcel-delivery-card');
    const parcelDeliveryModal = document.getElementById('parcel-delivery-modal');
    const closeParcelModalBtn = document.getElementById('close-parcel-modal');
    const cancelParcelBookingBtn = document.getElementById('cancel-parcel-booking');
    const parcelDeliveryForm = document.getElementById('parcel-delivery-form');
    const parcelPriceDisplay = document.getElementById('parcel-price-display');
    const parcelPriceAmount = document.getElementById('parcel-price-amount');
    const parcelPriceBreakdown = document.getElementById('parcel-price-breakdown');
    
    // Open parcel delivery modal when card is clicked
    if (parcelDeliveryCard) {
        parcelDeliveryCard.addEventListener('click', () => {
            parcelDeliveryModal.classList.remove('hidden');
            loadParcelDeliveryData();
        });
    }
    
    // Close parcel delivery modal
    function closeParcelModal() {
        if (parcelDeliveryModal) {
            parcelDeliveryModal.classList.add('hidden');
            if (parcelDeliveryForm) parcelDeliveryForm.reset();
            if (parcelPriceDisplay) parcelPriceDisplay.classList.add('hidden');
        }
    }
    
    if (closeParcelModalBtn) closeParcelModalBtn.addEventListener('click', closeParcelModal);
    if (cancelParcelBookingBtn) cancelParcelBookingBtn.addEventListener('click', closeParcelModal);

    // Close modal when clicking outside
    if (parcelDeliveryModal) {
        parcelDeliveryModal.addEventListener('click', (e) => {
            if (e.target === parcelDeliveryModal) {
                closeParcelModal();
            }
        });
    }

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

    // Validate parcel weight against selected parcel type
    function validateParcelWeight() {
        const parcelTypeSelect = document.getElementById('parcel_type');
        const parcelWeightInput = document.getElementById('parcel_weight');
        
        if (!parcelTypeSelect || !parcelWeightInput) return;
        
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

    // Add weight validation event listener
    const parcelWeightInput = document.getElementById('parcel_weight');
    if (parcelWeightInput) {
        parcelWeightInput.addEventListener('input', validateParcelWeight);
    }

    // Check parcel delivery pricing when required fields are selected
    async function checkParcelDeliveryPricing() {
        const pickupCityId = document.getElementById('parcel_pickup_city')?.value;
        const dropoffCityId = document.getElementById('parcel_dropoff_city')?.value;
        const parcelTypeId = document.getElementById('parcel_type')?.value;
        const weight = document.getElementById('parcel_weight')?.value;
        const urgentDelivery = document.querySelector('input[name="urgent_delivery"]')?.checked;
        const insuranceRequired = document.querySelector('input[name="insurance_required"]')?.checked;
        
        console.log('Checking pricing with:', {
            pickupCityId, dropoffCityId, parcelTypeId, weight, urgentDelivery, insuranceRequired
        });
        
        if (!pickupCityId || !dropoffCityId || !parcelTypeId || !weight || pickupCityId === dropoffCityId) {
            if (parcelPriceDisplay) parcelPriceDisplay.classList.add('hidden');
            return;
        }
        
        // Validate weight first
        const weightNum = parseFloat(weight);
        if (weightNum <= 0) {
            if (parcelPriceDisplay) parcelPriceDisplay.classList.add('hidden');
            return;
        }
        
        try {
            const params = new URLSearchParams({
                pickup_city_id: pickupCityId,
                dropoff_city_id: dropoffCityId,
                parcel_type_id: parcelTypeId,
                weight: weight,
                urgent_delivery: urgentDelivery ? '1' : '0',
                insurance_required: insuranceRequired ? '1' : '0'
            });
            
            console.log('Making pricing API call with params:', params.toString());
            
            const response = await fetch(`/api/parcel-delivery/pricing?${params}`);
            const data = await response.json();
            
            console.log('Pricing API response:', data);
            
            if (response.ok && data.success && data.total_price) {
                // Update price display
                parcelPriceAmount.textContent = `KSh ${Math.round(data.total_price).toLocaleString()}`;
                
                // Show detailed price breakdown
                let breakdown = '';
                if (data.breakdown) {
                    if (data.breakdown.base_rate > 0) {
                        breakdown += `Base rate: KSh ${Math.round(data.breakdown.base_rate).toLocaleString()}`;
                    }
                    if (data.breakdown.distance_surcharge > 0) {
                        breakdown += `<br>Distance: KSh ${Math.round(data.breakdown.distance_surcharge).toLocaleString()}`;
                    }
                    if (data.breakdown.weight_surcharge > 0) {
                        breakdown += `<br>Weight (${weight}kg): KSh ${Math.round(data.breakdown.weight_surcharge).toLocaleString()}`;
                    }
                    if (data.breakdown.urgent_delivery > 0) {
                        breakdown += `<br>Urgent delivery: KSh ${Math.round(data.breakdown.urgent_delivery).toLocaleString()}`;
                    }
                    if (data.breakdown.insurance > 0) {
                        breakdown += `<br>Insurance: KSh ${Math.round(data.breakdown.insurance).toLocaleString()}`;
                    }
                } else {
                    // Fallback breakdown
                    breakdown = `Total for ${data.parcel_type || 'parcel'}: KSh ${Math.round(data.total_price).toLocaleString()}`;
                }
                
                parcelPriceBreakdown.innerHTML = breakdown;
                parcelPriceDisplay.classList.remove('hidden');
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
                    } else if (data.error.includes('exceeds maximum')) {
                        // Show weight error in price display
                        parcelPriceBreakdown.innerHTML = `<span class="text-red-600">${data.error}</span>`;
                        parcelPriceDisplay.classList.remove('hidden');
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

    // Add event listeners for delivery options to update pricing
    const urgentDeliveryCheckbox = document.querySelector('input[name="urgent_delivery"]');
    const insuranceCheckbox = document.querySelector('input[name="insurance_required"]');
    
    if (urgentDeliveryCheckbox) {
        urgentDeliveryCheckbox.addEventListener('change', checkParcelDeliveryPricing);
    }
    
    if (insuranceCheckbox) {
        insuranceCheckbox.addEventListener('change', checkParcelDeliveryPricing);
    }

    // Handle parcel delivery form submission
    if (parcelDeliveryForm) {
        parcelDeliveryForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            // Validate parcel weight one more time
            validateParcelWeight();
            if (!parcelWeightInput.checkValidity()) {
                return;
            }
            
            // Collect form data
            const formData = new FormData(parcelDeliveryForm);
            const bookingData = Object.fromEntries(formData);
            
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
                    let successMessage;
                    
                    if (result.account_created) {
                        successMessage = `🎉 Parcel Delivery Booking Successful!\n\nBooking Reference: ${result.booking_reference}\n\n✅ Your SafariConnect account has been created!\nEmail: ${bookingData.customer_email}\n\nYou are now logged in and can track your parcel delivery from your dashboard.\n\nWe will contact you shortly with pickup confirmation and tracking details.`;
                    } else {
                        successMessage = `🎉 Parcel Delivery Booking Successful!\n\nBooking Reference: ${result.booking_reference}\n\n✅ Welcome back! You are now logged in.\n\nYou can track this parcel delivery from your dashboard.\n\nWe will contact you shortly with pickup confirmation and tracking details.`;
                    }
                    
                    alert(successMessage);
                    closeParcelModal();
                    
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
                        if (result.errors.parcel_weight) {
                            errorMessage += '⚖️ Weight: ' + result.errors.parcel_weight.join(', ') + '\n';
                        }
                        
                        // Add other field errors
                        Object.keys(result.errors).forEach(field => {
                            if (!['customer_email', 'password', 'parcel_weight'].includes(field)) {
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
                    let successMessage;
                    
                    if (result.account_created) {
                        successMessage = `🎉 Car Hire Booking Successful!\n\nBooking Reference: ${result.booking_reference}\n\n✅ Your SafariConnect account has been created!\nEmail: ${bookingData.customer_email}\n\nYou are now logged in and can track your booking from your dashboard.\n\nWe will contact you shortly with confirmation details and vehicle pickup instructions.\n\n🚗 Please bring your valid driver's license when picking up the vehicle.`;
                    } else {
                        successMessage = `🎉 Car Hire Booking Successful!\n\nBooking Reference: ${result.booking_reference}\n\n✅ Welcome back! You are now logged in.\n\nYou can track this booking from your dashboard.\n\nWe will contact you shortly with confirmation details and vehicle pickup instructions.\n\n🚗 Please bring your valid driver's license when picking up the vehicle.`;
                    }
                    
                    alert(successMessage);
                    closeCarHireModal();
                    
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
    });
</script>
