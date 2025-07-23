<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cửa hàng Hoa @yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>

<body class="bg-gray-50">
    <header class="bg-pink-600 text-white shadow-md">
        <div class="container mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="text-2xl font-bold flex items-center">
                        <i class="fas fa-flower fa-lg mr-2"></i>
                        Cửa hàng Hoa
                    </a>
                </div>

                <nav class="hidden md:flex space-x-6">
                    <a href="{{ route('home') }}" class="hover:text-pink-200">Trang chủ</a>
                    <a href="{{ route('products.index') }}" class="hover:text-pink-200">Tất cả hoa</a>
                    @foreach(App\Models\Category::where('is_active', true)->take(4)->get() as $category)
                        <a href="{{ route('products.category', $category) }}"
                            class="hover:text-pink-200">{{ $category->name }}</a>
                    @endforeach
                </nav>

                <div class="flex items-center space-x-4">
                    <form action="{{ route('products.search') }}" method="GET" class="hidden md:flex">
                        <input type="text" name="query" placeholder="Tìm kiếm hoa..."
                            class="px-3 py-1 text-black rounded-l-md focus:outline-none">
                        <button type="submit" class="bg-pink-700 px-3 py-1 rounded-r-md hover:bg-pink-800">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>

                    <a href="{{ route('cart.index') }}" class="flex items-center">
                        <i class="fas fa-shopping-cart text-xl"></i>
                        <span id="cart-count" class="ml-1">
                            @if(session('cart'))
                                {{ count(session('cart')) }}
                            @else
                                0
                            @endif
                        </span>
                    </a>

                    <a href="{{ route('wishlist.show') }}" class="flex items-center ml-4">
                        <i class="fas fa-heart text-xl"></i>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <main>
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mx-auto my-4 max-w-7xl">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mx-auto my-4 max-w-7xl">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="bg-gray-800 text-white py-8 mt-12">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-lg font-semibold mb-4">Về chúng tôi</h3>
                    <p class="text-gray-400">Chúng tôi cung cấp hoa tươi đẹp cho mọi dịp. Từ sinh nhật đến đám cưới, hoa
                        của chúng tôi luôn tươi mới và rực rỡ.</p>
                </div>

                <div>
                    <h3 class="text-lg font-semibold mb-4">Liên kết nhanh</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-white">Trang chủ</a></li>
                        <li><a href="{{ route('products.index') }}" class="text-gray-400 hover:text-white">Cửa hàng</a>
                        </li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-lg font-semibold mb-4">Danh mục</h3>
                    <ul class="space-y-2">
                        @foreach(App\Models\Category::where('is_active', true)->take(5)->get() as $category)
                            <li>
                                <a href="{{ route('products.category', $category) }}"
                                    class="text-gray-400 hover:text-white">
                                    {{ $category->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div>
                    <h3 class="text-lg font-semibold mb-4">Liên hệ</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li class="flex items-center"><i class="fas fa-map-marker-alt w-6"></i> 123 Đường Hoa, Thành phố
                        </li>
                        <li class="flex items-center"><i class="fas fa-phone w-6"></i> +1 234 567 8901</li>
                        <li class="flex items-center"><i class="fas fa-envelope w-6"></i> info@flowershop.com</li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-700 mt-8 pt-6 flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-400">&copy; {{ date('Y') }} Cửa hàng Hoa. Đã đăng ký bản quyền.</p>

                <div class="flex space-x-4 mt-4 md:mt-0">
                    <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-facebook"></i></a>
                    <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-twitter"></i></a>
                </div>
            </div>
        </div>
    </footer>

    @yield('scripts')
</body>

</html>