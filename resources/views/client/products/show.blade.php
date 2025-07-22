@extends('layouts.client')

@section('title', ' - ' . $product->name)

@section('content')
    <div class="bg-gray-100 py-6">
        <div class="container mx-auto px-4">
            <nav class="text-sm text-gray-500">
                <ol class="list-none p-0 flex flex-wrap">
                    <li><a href="{{ route('home') }}" class="hover:text-pink-600">Home</a></li>
                    <li class="mx-2">/</li>
                    <li><a href="{{ route('products.index') }}" class="hover:text-pink-600">Products</a></li>
                    @if($product->category)
                        <li class="mx-2">/</li>
                        <li><a href="{{ route('products.category', $product->category) }}"
                                class="hover:text-pink-600">{{ $product->category->name }}</a></li>
                    @endif
                    <li class="mx-2">/</li>
                    <li class="text-pink-600">{{ $product->name }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="flex flex-col lg:flex-row">
                <!-- Product Image -->
                <div class="lg:w-1/2">
                    <div class="aspect-w-1 aspect-h-1 bg-gray-200">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gray-200">
                                <i class="fas fa-image text-6xl text-gray-400"></i>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Product Details -->
                <div class="lg:w-1/2 p-6 lg:p-8">
                    <h1 class="text-3xl font-bold mb-2">{{ $product->name }}</h1>

                    <div class="flex items-center mb-4">
                        <span class="text-2xl font-bold text-pink-600">${{ number_format($product->price, 2) }}</span>
                        @if($product->compare_price > $product->price)
                            <span
                                class="ml-2 text-lg text-gray-500 line-through">${{ number_format($product->compare_price, 2) }}</span>
                            <span class="ml-2 bg-green-100 text-green-800 text-xs font-semibold px-2 py-1 rounded">
                                {{ round((($product->compare_price - $product->price) / $product->compare_price) * 100) }}% OFF
                            </span>
                        @endif
                    </div>

                    <div class="mb-6">
                        @if($product->stock_status === 'in_stock')
                            <span class="inline-block bg-green-100 text-green-800 text-sm font-semibold px-3 py-1 rounded-full">
                                <i class="fas fa-check-circle mr-1"></i> In Stock
                            </span>
                        @else
                            <span class="inline-block bg-red-100 text-red-800 text-sm font-semibold px-3 py-1 rounded-full">
                                <i class="fas fa-times-circle mr-1"></i> Out of Stock
                            </span>
                        @endif
                    </div>

                    <div class="mb-6">
                        <p class="text-gray-700">{{ $product->description }}</p>
                    </div>

                    <div class="mb-6 text-sm text-gray-600">
                        @if($product->category)
                            <p class="mb-1">
                                <span class="font-semibold">Category:</span>
                                <a href="{{ route('products.category', $product->category) }}"
                                    class="text-pink-600 hover:underline">
                                    {{ $product->category->name }}
                                </a>
                            </p>
                        @endif

                        @if($product->brand)
                            <p class="mb-1">
                                <span class="font-semibold">Brand:</span>
                                <a href="{{ route('products.brand', $product->brand) }}" class="text-pink-600 hover:underline">
                                    {{ $product->brand->name }}
                                </a>
                            </p>
                        @endif

                        @if($product->sku)
                            <p class="mb-1"><span class="font-semibold">SKU:</span> {{ $product->sku }}</p>
                        @endif
                    </div>

                    <div class="border-t border-gray-200 pt-6">
                        @if($product->stock_status === 'in_stock')
                            <form action="{{ route('cart.add') }}" method="POST" class="flex flex-col md:flex-row items-center">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">

                                <div
                                    class="flex items-center border border-gray-300 rounded-md overflow-hidden mb-4 md:mb-0 md:mr-4">
                                    <button type="button"
                                        class="quantity-btn minus-btn px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <input type="number" name="quantity" min="1" value="1"
                                        class="w-16 text-center border-0 focus:ring-0 focus:outline-none" id="quantity-input">
                                    <button type="button"
                                        class="quantity-btn plus-btn px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>

                                <button type="submit"
                                    class="bg-pink-600 hover:bg-pink-700 text-white py-2 px-6 rounded-md transition duration-300 w-full md:w-auto flex items-center justify-center">
                                    <i class="fas fa-shopping-cart mr-2"></i>
                                    Add to Cart
                                </button>
                            </form>
                        @else
                            <button disabled
                                class="bg-gray-300 text-gray-500 py-2 px-6 rounded-md w-full md:w-auto flex items-center justify-center cursor-not-allowed">
                                <i class="fas fa-shopping-cart mr-2"></i>
                                Out of Stock
                            </button>
                        @endif

                        <div class="mt-4 flex flex-wrap gap-2 text-sm">
                            @auth
                                @php
                                    $inWishlist = \App\Models\Wishlist::where('user_id', auth()->id())
                                        ->where('product_id', $product->id)
                                        ->exists();
                                @endphp
                                
                                @if($inWishlist)
                                    <form action="{{ route('wishlist.remove', \App\Models\Wishlist::where('user_id', auth()->id())->where('product_id', $product->id)->first()) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="flex items-center text-pink-600 hover:text-pink-700">
                                            <i class="fas fa-heart mr-1"></i> Remove from Wishlist
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('wishlist.add', $product) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="flex items-center text-gray-600 hover:text-pink-600">
                                            <i class="far fa-heart mr-1"></i> Add to Wishlist
                                        </button>
                                    </form>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="flex items-center text-gray-600 hover:text-pink-600">
                                    <i class="far fa-heart mr-1"></i> Add to Wishlist
                                </a>
                            @endauth
                            <span class="text-gray-300 mx-2">|</span>
                            <a href="#" class="flex items-center text-gray-600 hover:text-pink-600">
                                <i class="fas fa-share-alt mr-1"></i> Share
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Information -->
            <div class="p-6 border-t border-gray-200">
                <div class="mb-6">
                    <h2 class="text-xl font-bold mb-4 pb-2 border-b border-gray-200">Product Details</h2>
                    <div class="prose max-w-none text-gray-700">
                        {{ $product->description }}
                    </div>
                </div>

                @if($product->specifications)
                    <div class="mb-6">
                        <h2 class="text-xl font-bold mb-4 pb-2 border-b border-gray-200">Specifications</h2>
                        <div class="prose max-w-none text-gray-700">
                            {!! $product->specifications !!}
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Related Products -->
        @if($relatedProducts->count() > 0)
            <div class="mt-12">
                <h2 class="text-2xl font-bold mb-6">Related Products</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($relatedProducts as $relatedProduct)
                        <div
                            class="bg-white rounded-lg overflow-hidden shadow hover:shadow-lg transition duration-300 border border-gray-200">
                            <a href="{{ route('products.show', $relatedProduct) }}">
                                <div class="h-48 overflow-hidden">
                                    @if($relatedProduct->image)
                                        <img src="{{ asset('storage/' . $relatedProduct->image) }}" alt="{{ $relatedProduct->name }}"
                                            class="w-full h-full object-cover hover:scale-110 transition duration-300">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-gray-200">
                                            <i class="fas fa-image text-4xl text-gray-400"></i>
                                        </div>
                                    @endif
                                </div>
                            </a>
                            <div class="p-4">
                                <a href="{{ route('products.show', $relatedProduct) }}" class="block mb-2">
                                    <h3 class="text-lg font-semibold hover:text-pink-600 transition duration-300">
                                        {{ $relatedProduct->name }}</h3>
                                </a>
                                <div class="flex justify-between items-center">
                                    <span
                                        class="text-lg font-bold text-pink-600">${{ number_format($relatedProduct->price, 2) }}</span>
                                    <div class="flex gap-2">
                                        <form action="{{ route('cart.add') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $relatedProduct->id }}">
                                            <button type="submit"
                                                class="bg-pink-600 hover:bg-pink-700 text-white rounded-full w-10 h-10 flex items-center justify-center transition duration-300">
                                                <i class="fas fa-shopping-basket"></i>
                                            </button>
                                        </form>
                                        
                                        @auth
                                            @php
                                                $inWishlist = \App\Models\Wishlist::where('user_id', auth()->id())
                                                    ->where('product_id', $relatedProduct->id)
                                                    ->exists();
                                            @endphp
                                            
                                            @if($inWishlist)
                                                <form action="{{ route('wishlist.remove', \App\Models\Wishlist::where('user_id', auth()->id())->where('product_id', $relatedProduct->id)->first()) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="bg-gray-200 hover:bg-gray-300 text-pink-600 rounded-full w-10 h-10 flex items-center justify-center transition duration-300">
                                                        <i class="fas fa-heart"></i>
                                                    </button>
                                                </form>
                                            @else
                                                <form action="{{ route('wishlist.add', $relatedProduct) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="bg-gray-200 hover:bg-gray-300 text-gray-600 hover:text-pink-600 rounded-full w-10 h-10 flex items-center justify-center transition duration-300">
                                                        <i class="far fa-heart"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        @else
                                            <a href="{{ route('login') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-600 hover:text-pink-600 rounded-full w-10 h-10 flex items-center justify-center transition duration-300">
                                                <i class="far fa-heart"></i>
                                            </a>
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Quantity buttons
            const minusBtn = document.querySelector('.minus-btn');
            const plusBtn = document.querySelector('.plus-btn');
            const quantityInput = document.getElementById('quantity-input');

            if (minusBtn && plusBtn && quantityInput) {
                minusBtn.addEventListener('click', function () {
                    const currentValue = parseInt(quantityInput.value);
                    if (currentValue > 1) {
                        quantityInput.value = currentValue - 1;
                    }
                });

                plusBtn.addEventListener('click', function () {
                    const currentValue = parseInt(quantityInput.value);
                    quantityInput.value = currentValue + 1;
                });

                quantityInput.addEventListener('change', function () {
                    if (this.value < 1) {
                        this.value = 1;
                    }
                });
            }
        });
    </script>
@endsection