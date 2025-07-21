{{-- Service Cards Section --}}
<section id="service-cards" class="relative -mt-16 z-30 pb-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Service Cards Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-6 mb-12">
            {{-- Share Ride Card --}}
            <div id="shared-ride-card"
                class="service-card group bg-white border-2 border-gray-200 hover:border-green-safari text-gray-800 p-6 rounded-2xl shadow-md hover:shadow-xl cursor-pointer transition-all duration-300 transform hover:-translate-y-1 hover:scale-[1.02]">
                <div class="text-center">
                    <div class="icon-container w-16 h-16 bg-gradient-to-br from-green-100 to-green-200 rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:from-green-safari group-hover:to-green-safari-light transition-all duration-300">
                        <span class="text-2xl group-hover:scale-110 transition-transform duration-300">🚗</span>
                    </div>
                    <h3 class="font-bold text-xl mb-3 text-gray-800 group-hover:text-green-safari transition-colors duration-300">
                        Share Ride
                    </h3>
                    <p class="text-sm text-gray-600 leading-relaxed mb-4 group-hover:text-gray-700 transition-colors duration-300">
                        Split costs and travel together. Perfect for budget-friendly journeys with fellow travelers.
                    </p>
                    <div class="flex items-center justify-center">
                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-gray-100 text-gray-700 group-hover:bg-green-100 group-hover:text-green-800 transition-all duration-300">
                            💰 Budget-friendly
                        </span>
                    </div>
                </div>
            </div>

            {{-- Solo Ride Card (Default Selected) --}}
            <div id="solo-ride-card"
                class="service-card service-card-selected group bg-gradient-to-br from-brown-custom to-amber-700 border-2 border-brown-custom text-white p-6 rounded-2xl shadow-lg cursor-pointer transition-all duration-300 transform scale-[1.02] -translate-y-1 relative">
                <div class="text-center">
                    <div class="icon-container w-16 h-16 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:bg-white/30 group-hover:scale-110 transition-all duration-300">
                        <span class="text-2xl">🚙</span>
                    </div>
                    <h3 class="font-bold text-xl mb-3 text-white transition-colors duration-300">
                        Private Ride
                    </h3>
                    <p class="text-sm text-white/90 leading-relaxed mb-4 transition-colors duration-300">
                        Your own private vehicle with professional driver. Comfort and privacy guaranteed.
                    </p>
                    <div class="flex items-center justify-center">
                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-white/20 text-white backdrop-blur-sm transition-all duration-300">
                            ⭐ Premium
                        </span>
                    </div>
                </div>
                {{-- Selection Indicator --}}
                <div class="selection-indicator absolute -top-2 -right-2 w-6 h-6 bg-orange-custom rounded-full flex items-center justify-center shadow-lg">
                    <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg>
                </div>
            </div>

            {{-- Airport Transfer Card --}}
            <div id="airport-transfer-card"
                class="service-card group bg-white border-2 border-gray-200 hover:border-orange-custom text-gray-800 p-6 rounded-2xl shadow-md hover:shadow-xl cursor-pointer transition-all duration-300 transform hover:-translate-y-1 hover:scale-[1.02]">
                <div class="text-center">
                    <div class="icon-container w-16 h-16 bg-gradient-to-br from-blue-100 to-blue-200 rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:from-orange-custom group-hover:to-orange-600 transition-all duration-300">
                        <span class="text-2xl group-hover:scale-110 transition-transform duration-300">✈️</span>
                    </div>
                    <h3 class="font-bold text-xl mb-3 text-gray-800 group-hover:text-orange-custom transition-colors duration-300">
                        Airport Transfer
                    </h3>
                    <p class="text-sm text-gray-600 leading-relaxed mb-4 group-hover:text-gray-700 transition-colors duration-300">
                        Reliable airport pickups and drop-offs. Never miss a flight with our punctual service.
                    </p>
                    <div class="flex items-center justify-center">
                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-gray-100 text-gray-700 group-hover:bg-orange-100 group-hover:text-orange-800 transition-all duration-300">
                            🕐 On-time
                        </span>
                    </div>
                </div>
            </div>

            {{-- Car Hire Card --}}
            <div id="car-hire-card"
                class="service-card group bg-white border-2 border-gray-200 hover:border-green-safari-light text-gray-800 p-6 rounded-2xl shadow-md hover:shadow-xl cursor-pointer transition-all duration-300 transform hover:-translate-y-1 hover:scale-[1.02]">
                <div class="text-center">
                    <div class="icon-container w-16 h-16 bg-gradient-to-br from-green-100 to-green-200 rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:from-green-safari-light group-hover:to-green-safari transition-all duration-300">
                        <span class="text-2xl group-hover:scale-110 transition-transform duration-300">🚐</span>
                    </div>
                    <h3 class="font-bold text-xl mb-3 text-gray-800 group-hover:text-green-safari-light transition-colors duration-300">
                        Car Hire
                    </h3>
                    <p class="text-sm text-gray-600 leading-relaxed mb-4 group-hover:text-gray-700 transition-colors duration-300">
                        Rent a vehicle for your convenience. Perfect for extended trips and personal mobility.
                    </p>
                    <div class="flex items-center justify-center">
                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-gray-100 text-gray-700 group-hover:bg-green-100 group-hover:text-green-800 transition-all duration-300">
                            🗓️ Flexible
                        </span>
                    </div>
                </div>
            </div>

            {{-- Parcel Delivery Card --}}
            <div id="parcel-delivery-card"
                class="service-card group bg-white border-2 border-gray-200 hover:border-orange-custom text-gray-800 p-6 rounded-2xl shadow-md hover:shadow-xl cursor-pointer transition-all duration-300 transform hover:-translate-y-1 hover:scale-[1.02]">
                <div class="text-center">
                    <div class="icon-container w-16 h-16 bg-gradient-to-br from-amber-100 to-amber-200 rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:from-orange-custom group-hover:to-orange-600 transition-all duration-300">
                        <span class="text-2xl group-hover:scale-110 transition-transform duration-300">📦</span>
                    </div>
                    <h3 class="font-bold text-xl mb-3 text-gray-800 group-hover:text-orange-custom transition-colors duration-300">
                        Parcel Delivery
                    </h3>
                    <p class="text-sm text-gray-600 leading-relaxed mb-4 group-hover:text-gray-700 transition-colors duration-300">
                        Fast and secure package delivery. Send your items safely to any destination.
                    </p>
                    <div class="flex items-center justify-center">
                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-gray-100 text-gray-700 group-hover:bg-orange-100 group-hover:text-orange-800 transition-all duration-300">
                            🚀 Fast
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Dynamic Forms Area --}}
    <div id="dynamic-forms-area" class="mt-8">
        {{-- Forms will be dynamically inserted here --}}
    </div>
</section>

{{-- Enhanced Custom Styles for Service Cards --}}
<style>
/* Service Card States */
.service-card {
    position: relative;
    overflow: hidden;
}

.service-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, transparent 0%, rgba(255, 107, 53, 0.1) 100%);
    opacity: 0;
    transition: opacity 0.3s ease;
    pointer-events: none;
}

.service-card:hover::before {
    opacity: 1;
}

/* Selected State */
.service-card-selected {
    position: relative;
    box-shadow: 0 10px 30px rgba(139, 69, 19, 0.3) !important;
    background: linear-gradient(135deg, #8B4513 0%, #d97706 100%) !important;
    border-color: #8B4513 !important;
    color: white !important;
    transform: scale(1.02) translateY(-4px) !important;
}

.service-card-selected::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, transparent 50%);
    pointer-events: none;
}

/* Default unselected state styling */
.service-card:not(.service-card-selected) {
    background: white;
    border: 2px solid #e5e7eb;
    color: #374151;
}

/* Hover effects for unselected cards */
.service-card:not(.service-card-selected):hover {
    border-color: #FF6B35;
    box-shadow: 0 10px 25px rgba(255, 107, 53, 0.15);
}

/* Ensure readability in selected state */
.service-card-selected h3,
.service-card-selected p {
    color: white !important;
}

.service-card-selected .inline-flex {
    background: rgba(255, 255, 255, 0.2) !important;
    color: white !important;
    backdrop-filter: blur(10px);
}

/* Animation for selection */
.service-card.selecting {
    animation: selectCard 0.4s ease-out forwards;
}

@keyframes selectCard {
    0% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.05);
    }
    100% {
        transform: scale(1.02) translateY(-4px);
    }
}

/* Improved icon containers */
.service-card .icon-container {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.service-card:hover .icon-container {
    transform: scale(1.1) rotate(2deg);
}

.service-card-selected .icon-container {
    background: rgba(255, 255, 255, 0.2) !important;
    backdrop-filter: blur(10px);
}

/* Professional typography */
.service-card h3 {
    font-weight: 700;
    letter-spacing: -0.025em;
    line-height: 1.3;
}

.service-card p {
    line-height: 1.5;
    font-weight: 400;
}

/* Responsive improvements */
@media (max-width: 640px) {
    .service-card {
        padding: 1.25rem;
    }
    
    .service-card h3 {
        font-size: 1.125rem;
    }
    
    .service-card p {
        font-size: 0.875rem;
    }
}

/* Focus states for accessibility */
.service-card:focus {
    outline: 2px solid #FF6B35;
    outline-offset: 2px;
}

/* Selection indicator animation */
.service-card-selected .selection-indicator {
    animation: checkmarkPop 0.4s ease-out 0.2s both;
}

@keyframes checkmarkPop {
    0% {
        transform: scale(0);
        opacity: 0;
    }
    80% {
        transform: scale(1.1);
    }
    100% {
        transform: scale(1);
        opacity: 1;
    }
}

/* Ensure orange-custom color is available */
.border-orange-custom {
    border-color: #FF6B35;
}

.hover\:border-orange-custom:hover {
    border-color: #FF6B35;
}

.text-orange-custom {
    color: #FF6B35;
}

.group:hover .group-hover\:text-orange-custom {
    color: #FF6B35;
}

.bg-orange-custom {
    background-color: #FF6B35;
}

.group-hover\:from-orange-custom:hover {
    --tw-gradient-from: #FF6B35;
}

.group-hover\:to-orange-600:hover {
    --tw-gradient-to: #ea580c;
}

.group-hover\:bg-orange-100:hover {
    background-color: #fed7aa;
}

.group-hover\:text-orange-800:hover {
    color: #9a3412;
}

/* Brown custom colors */
.bg-brown-custom {
    background-color: #8B4513;
}

.border-brown-custom {
    border-color: #8B4513;
}

.from-brown-custom {
    --tw-gradient-from: #8B4513;
}

/* Green Safari custom colors */
.border-green-safari {
    border-color: #2D5016;
}

.hover\:border-green-safari:hover {
    border-color: #2D5016;
}

.border-green-safari-light {
    border-color: #4A7C59;
}

.hover\:border-green-safari-light:hover {
    border-color: #4A7C59;
}

.text-green-safari {
    color: #2D5016;
}

.text-green-safari-light {
    color: #4A7C59;
}

.group:hover .group-hover\:text-green-safari {
    color: #2D5016;
}

.group:hover .group-hover\:text-green-safari-light {
    color: #4A7C59;
}

.bg-green-safari {
    background-color: #2D5016;
}

.bg-green-safari-light {
    background-color: #4A7C59;
}

.group-hover\:from-green-safari:hover {
    --tw-gradient-from: #2D5016;
}

.group-hover\:to-green-safari:hover {
    --tw-gradient-to: #2D5016;
}

.group-hover\:from-green-safari-light:hover {
    --tw-gradient-from: #4A7C59;
}

.group-hover\:to-green-safari-light:hover {
    --tw-gradient-to: #4A7C59;
}

.group-hover\:bg-green-100:hover {
    background-color: #dcfce7;
}

.group-hover\:text-green-800:hover {
    color: #166534;
}
</style>
