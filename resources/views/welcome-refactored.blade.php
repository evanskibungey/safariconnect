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

    @include('components.partials.scripts')

</body>

</html>
