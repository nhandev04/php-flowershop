<!DOCTYPE html>
<html lang="en" x-data="{
        darkMode: localStorage.getItem('darkMode') === 'true' || (localStorage.getItem('darkMode') === null && {{ $settings['dark_mode_default'] ? 'true' : 'false' }}),
        sidebarOpen: false
    }" x-init="
        $watch('darkMode', val => {
            localStorage.setItem('darkMode', val);
            if (val) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        });
        // Ensure dark mode is applied on init
        if (darkMode) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    " x-bind:class="darkMode ? 'dark' : ''">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Quản trị - {{ $settings['site_name'] ?? 'Flower Shop' }} @yield('title')</title>
@vite(['resources/css/app.css', 'resources/css/admin.css', 'resources/js/app.js'])
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<!-- Dark mode initialization script -->
<script>
// Initialize dark mode before Alpine.js loads
(function() {
    const isDarkModeDefault = {{ $settings['dark_mode_default'] ? 'true' : 'false' }};
    const savedDarkMode = localStorage.getItem('darkMode');
    const isDarkMode = savedDarkMode === 'true' || (savedDarkMode === null && isDarkModeDefault);

    if (isDarkMode) {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }
})();
</script>
<style>
    .sidebar-transition {
        transition: all 0.3s ease-in-out;
    }

    .glass-effect {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .gradient-bg {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .card-hover {
        transition: all 0.3s ease;
    }

    .card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    /* Custom Toggle Switch */
    .toggle-switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
    }

    .toggle-switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: .4s;
        border-radius: 34px;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }

    input:checked+.slider {
        background-color: #2196F3;
    }

    input:checked+.slider:before {
        transform: translateX(26px);
    }
</style>
</style>
</head>

<body class="bg-gray-50 dark:bg-gray-900 transition-colors duration-300">
    <div class="flex h-screen bg-gray-50 dark:bg-gray-900">
        <!-- Mobile sidebar overlay -->
        <div x-show="sidebarOpen" x-transition:enter="transition-opacity ease-linear duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" class="fixed inset-0 z-50 flex md:hidden" @click="sidebarOpen = false">
            <div class="fixed inset-0 bg-black opacity-50"></div>
        </div>

        <!-- Sidebar -->
        <div class="sidebar-transition fixed inset-y-0 left-0 z-50 w-64 md:static md:inset-0 transform md:transform-none"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'">
            <div
                class="flex flex-col h-full bg-gradient-to-br from-pink-600 via-pink-700 to-pink-800 text-white shadow-xl">
                <!-- Header -->
                <div class="flex items-center justify-between h-20 px-6 border-b border-pink-600">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-seedling text-white text-xl"></i>
                        </div>
                        <div>
                            <h1 class="text-lg font-bold">{{ $settings['site_name'] ?? 'Flower Shop' }}</h1>
                            <p class="text-xs text-pink-200">Admin Panel</p>
                        </div>
                    </div>
                    <button @click="sidebarOpen = false" class="md:hidden text-white hover:text-pink-200">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 hover:bg-white hover:bg-opacity-10 hover:scale-105 {{ request()->routeIs('admin.dashboard') ? 'bg-white bg-opacity-20 shadow-lg' : '' }}">
                        <i class="fas fa-chart-pie w-5 h-5 mr-3"></i>
                        <span>Bảng điều khiển</span>
                    </a>

                    <a href="{{ route('admin.categories.index') }}"
                        class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 hover:bg-white hover:bg-opacity-10 hover:scale-105 {{ request()->routeIs('admin.categories.*') ? 'bg-white bg-opacity-20 shadow-lg' : '' }}">
                        <i class="fas fa-list w-5 h-5 mr-3"></i>
                        <span>Danh mục</span>
                    </a>

                    <a href="{{ route('admin.brands.index') }}"
                        class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 hover:bg-white hover:bg-opacity-10 hover:scale-105 {{ request()->routeIs('admin.brands.*') ? 'bg-white bg-opacity-20 shadow-lg' : '' }}">
                        <i class="fas fa-copyright w-5 h-5 mr-3"></i>
                        <span>Thương hiệu</span>
                    </a>

                    <a href="{{ route('admin.products.index') }}"
                        class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 hover:bg-white hover:bg-opacity-10 hover:scale-105 {{ request()->routeIs('admin.products.*') ? 'bg-white bg-opacity-20 shadow-lg' : '' }}">
                        <i class="fas fa-box w-5 h-5 mr-3"></i>
                        <span>Sản phẩm</span>
                    </a>

                    <a href="{{ route('admin.orders.index') }}"
                        class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 hover:bg-white hover:bg-opacity-10 hover:scale-105 {{ request()->routeIs('admin.orders.*') ? 'bg-white bg-opacity-20 shadow-lg' : '' }}">
                        <i class="fas fa-shopping-cart w-5 h-5 mr-3"></i>
                        <span>Đơn hàng</span>
                    </a>

                    <a href="{{ route('admin.customers.index') }}"
                        class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 hover:bg-white hover:bg-opacity-10 hover:scale-105 {{ request()->routeIs('admin.customers.*') ? 'bg-white bg-opacity-20 shadow-lg' : '' }}">
                        <i class="fas fa-users w-5 h-5 mr-3"></i>
                        <span>Khách hàng</span>
                    </a>

                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.users.index') }}"
                            class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 hover:bg-white hover:bg-opacity-10 hover:scale-105 {{ request()->routeIs('admin.users.*') ? 'bg-white bg-opacity-20 shadow-lg' : '' }}">
                            <i class="fas fa-user-shield w-5 h-5 mr-3"></i>
                            <span>Người dùng</span>
                        </a>
                    @endif

                    <a href="{{ route('admin.banners.index') }}"
                        class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 hover:bg-white hover:bg-opacity-10 hover:scale-105 {{ request()->routeIs('admin.banners.*') ? 'bg-white bg-opacity-20 shadow-lg' : '' }}">
                        <i class="fas fa-images w-5 h-5 mr-3"></i>
                        <span>Banner</span>
                    </a>
                </nav>

                <!-- User info -->
                <div class="px-4 py-4 border-t border-pink-600">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-white"></i>
                        </div>
                        <div class="ml-3 flex-1">
                            <p class="text-sm font-medium">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-pink-200">{{ auth()->user()->role }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content area -->
        <div class="flex flex-col flex-1 overflow-hidden">
            <!-- Header -->
            <header class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between px-6 py-4">
                    <div class="flex items-center">
                        <button @click="sidebarOpen = true"
                            class="md:hidden text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 focus:outline-none focus:ring-2 focus:ring-pink-500 rounded-lg p-2">
                            <i class="fas fa-bars text-xl"></i>
                        </button>

                        <div class="hidden md:block ml-4">
                            <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">
                                @yield('page-title', 'Bảng điều khiển')</h1>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Quản lý cửa hàng hoa của bạn</p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-4">


                        <!-- Dark mode toggle -->
                        <button @click="
                            darkMode = !darkMode;
                            console.log('Toggle clicked, darkMode now:', darkMode);
                            console.log('Document has dark class:', document.documentElement.classList.contains('dark'));
                        "
                            class="p-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 focus:outline-none focus:ring-2 focus:ring-pink-500 rounded-lg transition-colors duration-200 relative"
                            title="Chuyển đổi chế độ tối">
                            <i x-show="!darkMode" class="fas fa-moon text-lg"></i>
                            <i x-show="darkMode" class="fas fa-sun text-lg text-yellow-400"></i>
                            <span class="sr-only">Chuyển đổi chế độ tối</span>
                        </button>

                        <!-- Notifications -->
                        <!-- <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open"
                                class="p-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 focus:outline-none focus:ring-2 focus:ring-pink-500 rounded-lg transition-colors duration-200">
                                <i class="fas fa-bell text-xl"></i>
                                <span class="absolute top-0 right-0 block h-2 w-2 bg-red-500 rounded-full"></span>
                            </button>

                            <div x-show="open" @click.away="open = false"
                                x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="transform opacity-0 scale-95"
                                x-transition:enter-end="transform opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="transform opacity-100 scale-100"
                                x-transition:leave-end="transform opacity-0 scale-95"
                                class="absolute right-0 mt-2 w-80 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 z-50">
                                <div class="p-4">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Thông báo</h3>
                                    <div class="space-y-2">
                                        <div class="p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                                            <p class="text-sm text-blue-800 dark:text-blue-200">Có 3 đơn hàng mới cần xử
                                                lý</p>
                                        </div>
                                        <div class="p-3 bg-green-50 dark:bg-green-900/20 rounded-lg">
                                            <p class="text-sm text-green-800 dark:text-green-200">Sản phẩm "Hoa Hồng Đỏ"
                                                sắp hết hàng</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->

                        <!-- User dropdown -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open"
                                class="flex items-center space-x-3 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg px-3 py-2 transition-colors duration-200">
                                <div
                                    class="w-8 h-8 bg-gradient-to-r from-pink-500 to-purple-600 rounded-full flex items-center justify-center">
                                    <span
                                        class="text-white text-sm font-medium">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                </div>
                                <div class="hidden md:block text-left">
                                    <p class="text-sm font-medium">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ auth()->user()->role }}</p>
                                </div>
                                <i class="fas fa-chevron-down text-xs"></i>
                            </button>

                            <div x-show="open" @click.away="open = false"
                                x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="transform opacity-0 scale-95"
                                x-transition:enter-end="transform opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="transform opacity-100 scale-100"
                                x-transition:leave-end="transform opacity-0 scale-95"
                                class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 z-50">
                                <div class="py-2">
                                    <a href="{{ route('admin.profile') }}"
                                        class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                                        <i class="fas fa-user mr-2"></i>
                                        Hồ sơ cá nhân
                                    </a>
                                    <a href="{{ route('admin.settings') }}"
                                        class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                                        <i class="fas fa-cog mr-2"></i>
                                        Cài đặt
                                    </a>
                                    <hr class="my-2 border-gray-200 dark:border-gray-700">
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="flex items-center w-full px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700 text-left transition-colors duration-200">
                                            <i class="fas fa-sign-out-alt mr-2"></i>
                                            Đăng xuất
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 dark:bg-gray-900">
                <div class="container mx-auto px-6 py-8">
                    <!-- Alert messages -->
                    @if(session('success'))
                        <div
                            class="mb-6 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-200 px-4 py-3 rounded-lg shadow-sm">
                            <div class="flex items-center">
                                <i class="fas fa-check-circle mr-2"></i>
                                {{ session('success') }}
                            </div>
                        </div>
                    @endif

                    @if(session('error'))
                        <div
                            class="mb-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-200 px-4 py-3 rounded-lg shadow-sm">
                            <div class="flex items-center">
                                <i class="fas fa-exclamation-circle mr-2"></i>
                                {{ session('error') }}
                            </div>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <script>
        // Auto close mobile sidebar when clicking on navigation links
        document.addEventListener('DOMContentLoaded', function () {
            const sidebarLinks = document.querySelectorAll('nav a');
            sidebarLinks.forEach(link => {
                link.addEventListener('click', function () {
                    if (window.innerWidth < 768) {
                        Alpine.store('sidebar', false);
                    }
                });
            });

            // Debug dark mode
            console.log('Dark mode debug:', {
                localStorage: localStorage.getItem('darkMode'),
                hasClass: document.documentElement.classList.contains('dark'),
                defaultSetting: {{ $settings['dark_mode_default'] ? 'true' : 'false' }}
            });

            // Add support for image display in tables and cards
            const allImages = document.querySelectorAll('img:not([data-no-error-handler])');
            allImages.forEach(img => {
                img.addEventListener('error', function () {
                    // Replace broken images with placeholder based on context
                    if (this.classList.contains('rounded-full')) {
                        // Avatar/logo placeholder
                        this.src = "{{ asset('storage/placeholder-avatar.png') }}";
                    } else if (this.parentElement && this.parentElement.classList.contains('product-image')) {
                        // Product image placeholder
                        this.src = "{{ asset('storage/products/default.png') }}";
                    } else if (this.parentElement && this.parentElement.classList.contains('banner-image')) {
                        // Banner image placeholder
                        this.src = "{{ asset('storage/banners/default.png') }}";
                    } else {
                        // Generic placeholder
                        this.src = "{{ asset('storage/placeholder.png') }}";
                    }
                    this.alt = 'Hình ảnh không tìm thấy';
                    this.classList.add('img-error');
                });

                // Add lightbox effect
                img.addEventListener('click', function () {
                    if (this.classList.contains('img-expanded')) {
                        this.classList.remove('img-expanded');
                    } else {
                        this.classList.add('img-expanded');
                    }
                });
            });
        });
    </script>
</body>

</html>