<div class="lg:w-1/4 mb-6 lg:mb-0">
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <!-- User Info -->
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center">
                <div
                    class="flex-shrink-0 h-12 w-12 rounded-full bg-pink-100 text-pink-600 flex items-center justify-center">
                    <span class="text-lg font-bold">{{ substr(auth()->user()->name, 0, 1) }}</span>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-medium text-gray-900">{{ auth()->user()->name }}</h3>
                    <p class="text-sm text-gray-500">{{ auth()->user()->email }}</p>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <div class="p-3">
            <nav class="space-y-1">
                <a href="{{ route('account.dashboard') }}"
                    class="block px-3 py-2 rounded-md {{ request()->routeIs('account.dashboard') ? 'bg-pink-100 text-pink-700' : 'text-gray-700 hover:bg-gray-50' }}">
                    <div class="flex items-center">
                        <i class="fas fa-tachometer-alt w-5 h-5"></i>
                        <span class="ml-2">Dashboard</span>
                    </div>
                </a>

                <a href="{{ route('account.orders') }}"
                    class="block px-3 py-2 rounded-md {{ request()->routeIs('account.orders') ? 'bg-pink-100 text-pink-700' : 'text-gray-700 hover:bg-gray-50' }}">
                    <div class="flex items-center">
                        <i class="fas fa-shopping-bag w-5 h-5"></i>
                        <span class="ml-2">My Orders</span>
                    </div>
                </a>

                <a href="{{ route('account.profile') }}"
                    class="block px-3 py-2 rounded-md {{ request()->routeIs('account.profile') ? 'bg-pink-100 text-pink-700' : 'text-gray-700 hover:bg-gray-50' }}">
                    <div class="flex items-center">
                        <i class="fas fa-user w-5 h-5"></i>
                        <span class="ml-2">Profile</span>
                    </div>
                </a>

                <a href="{{ route('account.addresses') }}"
                    class="block px-3 py-2 rounded-md {{ request()->routeIs('account.addresses') ? 'bg-pink-100 text-pink-700' : 'text-gray-700 hover:bg-gray-50' }}">
                    <div class="flex items-center">
                        <i class="fas fa-map-marker-alt w-5 h-5"></i>
                        <span class="ml-2">Addresses</span>
                    </div>
                </a>

                <a href="{{ route('account.wishlist') }}"
                    class="block px-3 py-2 rounded-md {{ request()->routeIs('account.wishlist') ? 'bg-pink-100 text-pink-700' : 'text-gray-700 hover:bg-gray-50' }}">
                    <div class="flex items-center">
                        <i class="fas fa-heart w-5 h-5"></i>
                        <span class="ml-2">Wishlist</span>
                    </div>
                </a>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="w-full text-left block px-3 py-2 rounded-md text-gray-700 hover:bg-gray-50">
                        <div class="flex items-center">
                            <i class="fas fa-sign-out-alt w-5 h-5"></i>
                            <span class="ml-2">Logout</span>
                        </div>
                    </button>
                </form>
            </nav>
        </div>
    </div>
</div>