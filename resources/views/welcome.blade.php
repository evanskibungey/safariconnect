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

    @include('components.modals.shared-ride-modal')

    @include('components.modals.solo-ride-modal')

    @include('components.modals.airport-transfer-modal')

    @include('components.modals.car-hire-modal')

    @include('components.modals.parcel-delivery-modal')

    @include('components.modals.booking-success-modal')

    @include('components.modals.login-modal')

    @include('components.partials.scripts-enhanced')
    
    <!-- Temporary debug script - remove after testing -->
    <script src="{{ asset('js/carousel-debug.js') }}"></script>

</body>

</html>
