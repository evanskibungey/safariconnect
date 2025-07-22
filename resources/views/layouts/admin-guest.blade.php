<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex, nofollow">

    <title>{{ config('app.name', 'SafariKonnect') }} - {{ $title ?? 'Admin Portal' }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <!-- Alpine.js -->
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.13.3/cdn.min.js"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
    :root {
        --admin-primary: #1e40af;
        --admin-primary-dark: #1e3a8a;
        --admin-secondary: #64748b;
        --admin-success: #10b981;
        --admin-warning: #f59e0b;
        --admin-danger: #ef4444;
        --admin-bg: #f8fafc;
        --admin-card: #ffffff;
        --admin-border: #e2e8f0;
        --admin-text: #1e293b;
        --admin-text-muted: #64748b;
    }

    body {
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
    }

    .admin-container {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .admin-form {
        position: relative;
        z-index: 10;
    }

    .security-badge {
        background: linear-gradient(45deg, #10b981, #059669);
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
    }

    .floating-shapes {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        overflow: hidden;
        z-index: 1;
    }

    .floating-shapes::before,
    .floating-shapes::after {
        content: '';
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.1);
        animation: float 6s ease-in-out infinite;
    }

    .floating-shapes::before {
        width: 60px;
        height: 60px;
        top: 10%;
        left: 20%;
        animation-delay: 0s;
    }

    .floating-shapes::after {
        width: 80px;
        height: 80px;
        top: 70%;
        right: 20%;
        animation-delay: 3s;
    }

    @keyframes float {

        0%,
        100% {
            transform: translateY(0px);
        }

        50% {
            transform: translateY(-20px);
        }
    }

    .input-group {
        position: relative;
    }

    .input-icon {
        position: absolute;
        left: 0.75rem;
        top: 50%;
        transform: translateY(-50%);
        color: #64748b;
        z-index: 10;
    }

    .input-with-icon {
        padding-left: 2.5rem;
    }

    .admin-btn-primary {
        background: linear-gradient(45deg, var(--admin-primary), var(--admin-primary-dark));
        border: none;
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        font-weight: 600;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .admin-btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 10px 25px rgba(30, 64, 175, 0.3);
    }

    .admin-btn-primary::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s;
    }

    .admin-btn-primary:hover::before {
        left: 100%;
    }

    .security-info {
        background: linear-gradient(45deg, #f0f9ff, #e0f2fe);
        border: 1px solid #0ea5e9;
        border-radius: 0.5rem;
        padding: 1rem;
    }

    .pulse-dot {
        animation: pulse-dot 2s infinite;
    }

    @keyframes pulse-dot {
        0% {
            opacity: 1;
        }

        50% {
            opacity: 0.5;
        }

        100% {
            opacity: 1;
        }
    }
    </style>
</head>

<body class="antialiased">
    <div class="floating-shapes"></div>

    <div class="min-h-screen flex flex-col justify-center py-12 sm:px-6 lg:px-8 relative z-10">
        <!-- Header -->
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <div class="flex justify-center mb-6">
                <div class="w-20 h-20 bg-white rounded-full shadow-lg flex items-center justify-center">
                    <i class="fas fa-shield-alt text-3xl text-blue-600"></i>
                </div>
            </div>
            <h2 class="mt-6 text-center text-3xl font-bold text-white drop-shadow-lg">
                {{ $title ?? 'Admin Portal' }}
            </h2>
            <p class="mt-2 text-center text-sm text-white/90">
                {{ $subtitle ?? 'Secure Administrative Access' }}
            </p>

            <!-- Security Badge -->
            <div class="flex justify-center mt-4">
                <span class="security-badge">
                    <i class="fas fa-lock pulse-dot"></i>
                    Secured with Single Admin Policy
                </span>
            </div>
        </div>

        <!-- Main Content -->
        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="admin-container shadow-2xl rounded-xl px-8 py-10">
                <div class="admin-form">
                    {{ $slot }}
                </div>
            </div>

            <!-- Footer -->
            <div class="mt-8 text-center">
                <p class="text-xs text-white/80">
                    <i class="fas fa-shield-alt mr-1"></i>
                    Protected by Enhanced Security Protocols
                </p>
                <p class="text-xs text-white/70 mt-1">
                    SafariKonnect &copy; {{ date('Y') }} - All rights reserved
                </p>
            </div>
        </div>
    </div>

    <!-- Security Toast Messages -->
    @if(session('status'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" x-transition
        class="fixed top-4 right-4 max-w-sm bg-green-50 border border-green-200 rounded-lg p-4 shadow-lg z-50">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="fas fa-check-circle text-green-400"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-green-800">
                    {{ session('status') }}
                </p>
            </div>
            <div class="ml-auto pl-3">
                <div class="-mx-1.5 -my-1.5">
                    <button @click="show = false"
                        class="inline-flex bg-green-50 rounded-md p-1.5 text-green-500 hover:bg-green-100">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if($errors->any())
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 8000)" x-transition
        class="fixed top-4 right-4 max-w-sm bg-red-50 border border-red-200 rounded-lg p-4 shadow-lg z-50">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="fas fa-exclamation-triangle text-red-400"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-red-800">
                    Security Alert
                </p>
                <p class="text-xs text-red-600 mt-1">
                    Authentication failed - Please check your credentials
                </p>
            </div>
            <div class="ml-auto pl-3">
                <div class="-mx-1.5 -my-1.5">
                    <button @click="show = false"
                        class="inline-flex bg-red-50 rounded-md p-1.5 text-red-500 hover:bg-red-100">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</body>

</html>