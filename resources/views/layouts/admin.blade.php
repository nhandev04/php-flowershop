<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Flower Shop @yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>

<body class="bg-gray-100">
    <div class="flex h-screen bg-gray-100">
        <!-- Sidebar -->
        <div class="hidden md:flex md:flex-col md:w-64 md:bg-pink-800 md:text-white">
            <div class="flex items-center justify-center h-20 border-b border-pink-700">
                <h1 class="text-2xl font-bold">Flower Shop Admin</h1>
            </div>
            <nav class="flex-grow px-4 pb-4 md:block md:overflow-y-auto">
                <a class="block px-4 py-2 mt-2 text-sm hover:bg-pink-700 rounded" href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
                </a>
                <a class="block px-4 py-2 mt-2 text-sm hover:bg-pink-700 rounded"
                    href="{{ route('admin.categories.index') }}">
                    <i class="fas fa-list mr-2"></i> Categories
                </a>
                <a class="block px-4 py-2 mt-2 text-sm hover:bg-pink-700 rounded"
                    href="{{ route('admin.brands.index') }}">
                    <i class="fas fa-copyright mr-2"></i> Brands
                </a>
                <a class="block px-4 py-2 mt-2 text-sm hover:bg-pink-700 rounded"
                    href="{{ route('admin.products.index') }}">
                    <i class="fas fa-box mr-2"></i> Products
                </a>
                <a class="block px-4 py-2 mt-2 text-sm hover:bg-pink-700 rounded"
                    href="{{ route('admin.orders.index') }}">
                    <i class="fas fa-shopping-cart mr-2"></i> Orders
                </a>
                <a class="block px-4 py-2 mt-2 text-sm hover:bg-pink-700 rounded"
                    href="{{ route('admin.customers.index') }}">
                    <i class="fas fa-users mr-2"></i> Customers
                </a>
                @if(auth()->user()->role === 'admin')
                    <a class="block px-4 py-2 mt-2 text-sm hover:bg-pink-700 rounded"
                        href="{{ route('admin.users.index') }}">
                        <i class="fas fa-user-shield mr-2"></i> Users
                    </a>
                @endif
                <a class="block px-4 py-2 mt-2 text-sm hover:bg-pink-700 rounded"
                    href="{{ route('admin.banners.index') }}">
                    <i class="fas fa-images mr-2"></i> Banners
                </a>
            </nav>
        </div>

        <!-- Content area -->
        <div class="flex flex-col flex-1 overflow-hidden">
            <header class="flex items-center justify-between px-4 py-3 bg-white border-b">
                <button class="block md:hidden" @click="sidebarOpen = true">
                    <i class="fas fa-bars"></i>
                </button>

                <div class="flex items-center">
                    <div class="relative">
                        <div class="flex items-center">
                            <span class="mr-2">{{ auth()->user()->name }}</span>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="text-sm text-red-500 hover:text-red-700">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-4">
                <div class="container mx-auto">
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                            {{ session('error') }}
                        </div>
                    @endif

                    @yield('content')
                </div>
            </main>
        </div>
    </div>
</body>

</html>