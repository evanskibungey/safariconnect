<script>
    // Mobile menu functionality
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');

    mobileMenuBtn.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
    });

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
            sharedRideForm.reset();
            priceDisplay.classList.add('hidden');
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

    // ===================================
    // SOLO RIDE FUNCTIONALITY  
    // ===================================
    
    // Solo Ride Modal Elements
    const soloRideCard = document.getElementById('solo-ride-card');
    const soloRideModal = document.getElementById('solo-ride-modal');
    const closeSoloModalBtn = document.getElementById('close-solo-modal');
    const cancelSoloBookingBtn = document.getElementById('cancel-solo-booking');
    
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
        }
    }
    
    if (closeSoloModalBtn) closeSoloModalBtn.addEventListener('click', closeSoloModal);
    if (cancelSoloBookingBtn) cancelSoloBookingBtn.addEventListener('click', closeSoloModal);

    // ===================================
    // AIRPORT TRANSFER FUNCTIONALITY
    // ===================================
    
    // Airport Transfer Modal Elements  
    const airportTransferCard = document.getElementById('airport-transfer-card');
    const airportTransferModal = document.getElementById('airport-transfer-modal');
    const closeAirportModalBtn = document.getElementById('close-airport-modal');
    const cancelAirportBookingBtn = document.getElementById('cancel-airport-booking');
    
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
        }
    }
    
    if (closeAirportModalBtn) closeAirportModalBtn.addEventListener('click', closeAirportModal);
    if (cancelAirportBookingBtn) cancelAirportBookingBtn.addEventListener('click', closeAirportModal);

    // ===================================
    // DATA LOADING FUNCTIONS
    // ===================================
    
    // Load shared ride data (cities and pricing)
    async function loadSharedRideData() {
        try {
            // Load cities for dropdowns
            const response = await fetch('/api/cities');
            if (response.ok) {
                const cities = await response.json();
                populateCityDropdowns(cities);
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
    
    // Load solo ride data
    async function loadSoloRideData() {
        try {
            // Similar loading logic for solo rides
            await loadSharedRideData(); // Reuse city loading
            
            // Load vehicle types
            const vehicleResponse = await fetch('/api/vehicle-types');
            if (vehicleResponse.ok) {
                const vehicleTypes = await vehicleResponse.json();
                populateVehicleTypes(vehicleTypes);
            }
        } catch (error) {
            console.error('Error loading solo ride data:', error);
        }
    }
    
    // Load airport transfer data
    async function loadAirportTransferData() {
        try {
            // Load cities, airports, and vehicle types
            await loadSharedRideData(); // Reuse city loading
            
            const airportsResponse = await fetch('/api/airports');
            if (airportsResponse.ok) {
                const airports = await airportsResponse.json();
                populateAirportDropdowns(airports);
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
        }
        if (dropoffCitySelect) {
            dropoffCitySelect.innerHTML = '<option value="">Select drop-off city</option>' + cityOptions;
        }
    }
    
    function populateVehicleTypes(vehicleTypes) {
        const vehicleOptions = vehicleTypes.map(vehicle => 
            `<option value="${vehicle.id}">${vehicle.name}</option>`
        ).join('');
        
        const vehicleSelect = document.getElementById('solo_vehicle_type');
        if (vehicleSelect) {
            vehicleSelect.innerHTML = '<option value="">Select vehicle type</option>' + vehicleOptions;
        }
    }
    
    function populateAirportDropdowns(airports) {
        const airportOptions = airports.map(airport => 
            `<option value="${airport.id}">${airport.name} (${airport.code})</option>`
        ).join('');
        
        const pickupAirportSelect = document.getElementById('pickup_airport');
        const dropoffAirportSelect = document.getElementById('dropoff_airport');
        
        if (pickupAirportSelect) {
            pickupAirportSelect.innerHTML = '<option value="">Select pickup airport</option>' + airportOptions;
        }
        if (dropoffAirportSelect) {
            dropoffAirportSelect.innerHTML = '<option value="">Select drop-off airport</option>' + airportOptions;
        }
    }

    // ===================================
    // FORM SUBMISSIONS
    // ===================================
    
    // Handle shared ride form submission
    if (sharedRideForm) {
        sharedRideForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            
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
                    alert(`Booking successful! Reference: ${result.booking_reference}`);
                    closeSharedModal();
                    
                    // Refresh page if user was logged in
                    if (result.account_created) {
                        setTimeout(() => window.location.reload(), 1000);
                    }
                } else {
                    alert(result.error || 'Booking failed. Please try again.');
                }
            } catch (error) {
                console.error('Booking error:', error);
                alert('An error occurred. Please try again.');
            } finally {
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
            }
        });
    }

    // Set minimum dates for date inputs
    document.addEventListener('DOMContentLoaded', function() {
        const today = new Date().toISOString().split('T')[0];
        const dateInputs = document.querySelectorAll('input[type="date"]');
        
        dateInputs.forEach(input => {
            input.min = today;
        });
    });
</script>
