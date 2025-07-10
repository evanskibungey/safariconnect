<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SafariConnect - Airport Transfers Made Easy</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    'orange-custom': '#FF6B35',
                    'brown-custom': '#8B4513',
                    'dark-blue': '#1e293b',
                },
                animation: {
                    'float': 'float 6s ease-in-out infinite',
                    'float-slow': 'float 8s ease-in-out infinite',
                    'float-medium': 'float 6s ease-in-out infinite',
                    'float-fast': 'float 4s ease-in-out infinite',
                    'slide-up': 'slideUp 0.5s ease-out',
                    'fade-in': 'fadeIn 0.6s ease-out',
                    'fade-in-up': 'fadeInUp 0.8s ease-out',
                    'bounce-slow': 'bounce 3s ease-in-out infinite',
                },
                keyframes: {
                    float: {
                        '0%, 100%': {
                            transform: 'translateY(0px) translateX(0px)'
                        },
                        '33%': {
                            transform: 'translateY(-20px) translateX(10px)'
                        },
                        '66%': {
                            transform: 'translateY(10px) translateX(-10px)'
                        },
                    },
                    slideUp: {
                        '0%': {
                            transform: 'translateY(30px)',
                            opacity: '0'
                        },
                        '100%': {
                            transform: 'translateY(0)',
                            opacity: '1'
                        },
                    },
                    fadeIn: {
                        '0%': {
                            opacity: '0'
                        },
                        '100%': {
                            opacity: '1'
                        },
                    },
                    fadeInUp: {
                        '0%': {
                            opacity: '0',
                            transform: 'translateY(30px)'
                        },
                        '100%': {
                            opacity: '1',
                            transform: 'translateY(0)'
                        },
                    },
                    bounce: {
                        '0%, 100%': {
                            transform: 'translateY(0)'
                        },
                        '50%': {
                            transform: 'translateY(-10px)'
                        },
                    }
                }
            }
        }
    }
    </script>
    <style>
    /* Custom glassmorphism effect */
    .glass {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    /* Carousel indicator styles */
    .carousel-indicator.active {
        background: linear-gradient(to right, #FF6B35, #ef4444);
        width: 1rem;
        box-shadow: 0 0 10px rgba(255, 107, 53, 0.5);
    }

    .hero-gradient {
        background: linear-gradient(135deg, #1e293b 0%, #334155 50%, #475569 100%);
    }

    /* Remove global transition to prevent conflicts */
    /* Smooth scrolling */
    html {
        scroll-behavior: smooth;
    }

    /* Custom scrollbar */
    ::-webkit-scrollbar {
        width: 6px;
    }

    ::-webkit-scrollbar-track {
        background: #f1f5f9;
    }

    ::-webkit-scrollbar-thumb {
        background: #FF6B35;
        border-radius: 3px;
    }
    </style>
</head>
