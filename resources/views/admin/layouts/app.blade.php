<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Admin</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <!-- Alpine.js -->
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.13.3/cdn.min.js"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @include('admin.layouts.navigation')

        <!-- Page Heading -->
        @if (isset($header))
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
        @endif

        <!-- Breadcrumbs (optional) -->
        @if(isset($breadcrumbs))
        <div class="bg-gray-50 border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <nav class="flex py-3" aria-label="Breadcrumb">
                    <ol class="flex items-center space-x-2">
                        @foreach($breadcrumbs as $breadcrumb)
                            @if($loop->last)
                                <li class="text-sm text-gray-500">{{ $breadcrumb['label'] }}</li>
                            @else
                                <li>
                                    <a href="{{ $breadcrumb['url'] }}" class="text-sm text-gray-500 hover:text-gray-700">{{ $breadcrumb['label'] }}</a>
                                    <span class="mx-2 text-gray-400">/</span>
                                </li>
                            @endif
                        @endforeach
                    </ol>
                </nav>
            </div>
        </div>
        @endif

        <!-- Page Content -->
        <main id="main-content">
            @yield('content')
        </main>
    </div>
    
    @yield('scripts')
</body>

</html>