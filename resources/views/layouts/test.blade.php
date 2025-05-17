<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Medical E-Commerce')</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Additional Styles -->
    <style>
        /* Custom styles can go here */
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>

    @stack('styles')
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">
    <!-- Header -->
    <header class="bg-white shadow-sm">
        <div class="container mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <!-- Logo -->
                <a href="{{ route('shop.home') }}" class="flex items-center">
                    <img src="https://img.icons8.com/color/96/medical-doctor.png" alt="Medical E-Commerce" class="h-10 mr-2">

                    <span class="text-xl font-bold text-blue-600">MedShop</span>
                </a>

                <!-- Search Bar -->
                {{-- <div class="hidden md:block flex-grow max-w-md mx-4">
                    <form action="{{ route('shop.home') }}" method="GET" class="relative">
                        <input type="text" name="search" placeholder="Search products..."
                               class="w-full py-2 px-4 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               value="{{ request('search') }}">
                        <button type="submit" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                    </form>
                </div> --}}

                <!-- Navigation -->
                <nav class="flex items-center">
                    <a href="{{ route('shop.home') }}" class="px-3 py-2 text-gray-700 hover:text-blue-600">Home</a>
                    <a href="{{ route('shop.products') }}" class="px-3 py-2 text-gray-700 hover:text-blue-600">Orders</a>
                    <a href="{{ route('shop.home') }}" class="px-3 py-2 text-gray-700 hover:text-blue-600">Contact</a>

                    <!-- Cart -->
                    <a href="{{ route('cart.index') }}" class="ml-4 relative">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-700 hover:text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        @if(session('cart') && count(session('cart')) > 0)
                            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs w-4 h-4 flex items-center justify-center rounded-full">
                                {{ count(session('cart')) }}
                            </span>
                        @endif
                    </a>

                </nav>
            </div>

            {{-- <!-- Mobile Search -->
            <div class="mt-4 md:hidden">
                <form action="{{ route('shop.home') }}" method="GET" class="relative">
                    <input type="text" name="search" placeholder="Search products..."
                           class="w-full py-2 px-4 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           value="{{ request('search') }}">
                    <button type="submit" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                </form>
            </div> --}}
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-lg font-semibold mb-4">About Us</h3>
                    <p class="text-gray-300 text-sm">MedShop is your trusted source for high-quality medical products. We're dedicated to providing healthcare professionals and individuals with the best medical supplies.</p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('shop.home') }}" class="text-gray-300 hover:text-white">Home</a></li>
                        <li><a href="{{ route('shop.products') }}" class="text-gray-300 hover:text-white">Products</a></li>
                        <li><a href="{{ route('shop.home') }}" class="text-gray-300 hover:text-white">About Us</a></li>
                        <li><a href="{{ route('shop.home') }}" class="text-gray-300 hover:text-white">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Customer Service</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('shop.home') }}" class="text-gray-300 hover:text-white">FAQ</a></li>
                        <li><a href="{{ route('shop.home') }}" class="text-gray-300 hover:text-white">Shipping Policy</a></li>
                        <li><a href="{{ route('shop.home') }}" class="text-gray-300 hover:text-white">Returns Policy</a></li>
                        <li><a href="{{ route('shop.home') }}" class="text-gray-300 hover:text-white">Privacy Policy</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Contact Us</h3>
                    <ul class="space-y-2 text-sm">
                        <li class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <span>+1 (800) 123-4567</span>
                        </li>
                        <li class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <span>support@medshop.com</span>
                        </li>
                        <li class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span>123 Medical Plaza, Healthville, CA 92345</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="mt-8 pt-6 border-t border-gray-700 text-center text-sm text-gray-400">
                <p>&copy; {{ date('Y') }} MedShop. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        // Toggle user dropdown menu
        const userDropdown = document.getElementById('userDropdown');
        const userMenu = document.getElementById('userMenu');

        if (userDropdown && userMenu) {
            userDropdown.addEventListener('click', function() {
                userMenu.classList.toggle('hidden');
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(event) {
                if (!userDropdown.contains(event.target) && !userMenu.contains(event.target)) {
                    userMenu.classList.add('hidden');
                }
            });
        }
    </script>

    @stack('scripts')
</body>
</html>
