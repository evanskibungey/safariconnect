<!DOCTYPE html>
<html lang="en">

@include('components.partials.head')

<body class="bg-gray-50 font-sans overflow-x-hidden">

    @include('components.sections.header')

    @include('components.sections.hero')

    @include('components.sections.service-cards')

    @include('components.sections.features')

    @include('components.sections.newsletter')

    @include('components.sections.footer')

    @include('components.forms.shared-ride-form')

    @include('components.forms.airport-transfer-form')

    @include('components.forms.solo-ride-form')

    @include('components.forms.car-hire-form')

    @include('components.forms.parcel-delivery-form')

    @include('components.modals.booking-success-modal')

    @include('components.modals.login-modal')

    @include('components.partials.scripts-enhanced')
    
    <!-- Booking Form Enhancement for Authenticated Users -->
    <script src="{{ asset('js/booking-form-enhancement.js') }}"></script>
    
    <!-- Temporary debug script - remove after testing -->
    <script src="{{ asset('js/carousel-debug.js') }}"></script>

</body>

</html>
