<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Savanna Connect</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
    // We can define our custom "maroon" color here for easy reuse.
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    maroon: {
                        '600': '#8C2D2D', // A nice, modern maroon
                        '700': '#732525', // A darker shade for hover effects
                    },
                }
            }
        }
    }
    </script>
</head>

<body class="bg-gray-100 dark:bg-gray-900 font-sans">

    <!-- 
      IMPROVED HEADER:
      - Full-width background with a centered container for content.
      - Uses Flexbox to align the logo to the left and nav to the right.
      - Added padding for better spacing.
    -->
    <header class="w-full bg-white dark:bg-gray-800 shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">

                <!-- Logo -->
                <div class="flex-shrink-0">
                    <a href="/" class="text-2xl font-bold text-maroon-600 dark:text-maroon-600">
                        SafariKonnect
                    </a>
                </div>

                <!-- Navigation Links -->
                @if (Route::has('login'))
                <nav class="flex items-center gap-4">
                    @auth
                    <!-- Logged-in User: Dashboard Link -->
                    <a href="{{ url('/dashboard') }}"
                        class="font-medium text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white transition-colors duration-200">
                        Dashboard
                    </a>
                    @else
                    <!-- Guest User: Login and Register Links -->
                    <a href="{{ route('login') }}"
                        class="font-medium text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white transition-colors duration-200">
                        Log in
                    </a>

                    @if (Route::has('register'))
                    <!-- 
                      IMPROVED BUTTON:
                      - This is the main "call to action" button.
                      - It has a solid maroon background to make it stand out.
                      - Includes smooth transitions for a better user experience.
                    -->
                    <a href="{{ route('register') }}"
                        class="inline-block px-4 py-2 bg-maroon-600 hover:bg-maroon-700 text-white font-semibold rounded-md shadow-sm transition-all duration-200 ease-in-out">
                        Register
                    </a>
                    @endif
                    @endauth
                </nav>
                @endif
            </div>
        </div>
    </header>

    <!-- Example content to show the header in context -->
    <main class="p-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Welcome to the Page</h1>
        <p class="mt-4 text-gray-700 dark:text-gray-300">This is the main content area below the improved header.</p>
    </main>

</body>

</html>