@extends('layouts.client')

@section('title', ' - Giỏ hàng')

@section('content')
    <div class="bg-gray-100 py-6">
        <div class="container mx-auto px-4">
            <h1 class="text-3xl font-bold mb-2">Giỏ hàng</h1>
            <nav class="text-sm text-gray-500">
                <ol class="list-none p-0 flex flex-wrap">
                    <li><a href="{{ route('home') }}" class="hover:text-pink-600">Trang chủ</a></li>
                    <li class="mx-2">/</li>
                    <li class="text-pink-600">Giỏ hàng</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        @if($cartItems->count() > 0)
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Cart Items -->
                <div class="lg:w-2/3">
                    <div class="bg-white rounded-lg shadow overflow-hidden">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Sản phẩm
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Giá
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Số lượng
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tổng
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Thao tác
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($cartItems as $item)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-16 w-16">
                                                    @if($item->product->image)
                                                        <img class="h-16 w-16 object-cover"
                                                            src="{{ asset('storage/' . $item->product->image) }}"
                                                            alt="{{ $item->product->name }}">
                                                    @else
                                                        <div class="h-16 w-16 bg-gray-200 flex items-center justify-center">
                                                            <i class="fas fa-image text-gray-400"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        <a href="{{ route('products.show', $item->product) }}"
                                                            class="hover:text-pink-600">
                                                            {{ $item->product->name }}
                                                        </a>
                                                    </div>
                                                    @if($item->product->sku)
                                                        <div class="text-xs text-gray-500">
                                                            SKU: {{ $item->product->sku }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ number_format($item->product->price, 0) }}₫
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <form action="{{ route('cart.update', $item->id) }}" method="POST"
                                                class="flex items-center cart-update-form">
                                                @csrf
                                                @method('PATCH')
                                                <div class="flex items-center border border-gray-300 rounded-md overflow-hidden">
                                                    <button type="button"
                                                        class="quantity-btn minus-btn px-2 py-1 bg-gray-100 hover:bg-gray-200 text-gray-700">
                                                        <i class="fas fa-minus"></i>
                                                    </button>
                                                    <input type="number" name="quantity" value="{{ $item->quantity }}" min="1"
                                                        class="w-12 text-center border-0 focus:ring-0 focus:outline-none text-sm"
                                                        data-item-id="{{ $item->id }}">
                                                    <button type="button"
                                                        class="quantity-btn plus-btn px-2 py-1 bg-gray-100 hover:bg-gray-200 text-gray-700">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </div>
                                            </form>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">
                                            {{ number_format($item->product->price * $item->quantity, 0) }}₫
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <form action="{{ route('cart.remove', $item->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800" title="Xóa sản phẩm">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6 flex justify-between">
                        <a href="{{ route('products.index') }}" class="flex items-center text-pink-600 hover:text-pink-800">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Tiếp tục mua sắm
                        </a>

                        <form action="{{ route('cart.clear') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="bg-gray-200 text-gray-700 py-2 px-4 rounded hover:bg-gray-300 transition duration-200">
                                Xóa giỏ hàng
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="lg:w-1/3">
                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="text-lg font-bold mb-4 pb-2 border-b border-gray-200">Tóm tắt đơn hàng</h2>

                        <div class="space-y-3 mb-6">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Tạm tính</span>
                                <span class="font-medium">{{ number_format($subtotal, 0) }}₫</span>
                            </div>

                            @if($discount > 0)
                                <div class="flex justify-between text-green-600">
                                    <span>Giảm giá</span>
                                    <span>-{{ number_format($discount, 0) }}₫</span>
                                </div>
                            @endif

                            @if($tax > 0)
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Thuế ({{ $taxRate * 100 }}%)</span>
                                    <span class="font-medium">{{ number_format($tax, 0) }}₫</span>
                                </div>
                            @endif

                            @if($shipping > 0)
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Phí vận chuyển</span>
                                    <span class="font-medium">{{ number_format($shipping, 0) }}₫</span>
                                </div>
                            @else
                                <div class="flex justify-between text-green-600">
                                    <span>Phí vận chuyển</span>
                                    <span>Miễn phí</span>
                                </div>
                            @endif

                            <div class="pt-2 border-t border-gray-200 flex justify-between">
                                <span class="text-lg font-bold">Tổng cộng</span>
                                <span class="text-lg font-bold text-pink-600">{{ number_format($total, 0) }}₫</span>
                            </div>
                        </div>

                        <!-- Coupon Code -->
                        <div class="mb-6 pt-4 border-t border-gray-200">
                            <form action="{{ route('cart.apply-coupon') }}" method="POST" class="flex flex-col space-y-2">
                                @csrf
                                <label for="coupon" class="text-sm font-medium text-gray-700">Mã giảm giá</label>
                                <div class="flex">
                                    <input type="text" id="coupon" name="coupon" value="{{ session('coupon_code', '') }}"
                                        class="flex-1 border-gray-300 rounded-l-md focus:ring-pink-500 focus:border-pink-500"
                                        placeholder="Nhập mã giảm giá">
                                    <button type="submit"
                                        class="bg-gray-100 border border-gray-300 text-gray-700 px-4 py-2 rounded-r-md hover:bg-gray-200 focus:outline-none">
                                        Áp dụng
                                    </button>
                                </div>
                                @if(session('coupon_message'))
                                    <p class="{{ session('coupon_success') ? 'text-green-600' : 'text-red-600' }} text-xs mt-1">
                                        {{ session('coupon_message') }}
                                    </p>
                                @endif
                            </form>
                        </div>

                        <!-- Checkout Button -->
                        <div class="mt-6">
                            <a href="{{ route('checkout') }}"
                                class="block w-full bg-pink-600 hover:bg-pink-700 text-white text-center py-3 px-4 rounded-md transition duration-300">
                                Tiến hành thanh toán
                            </a>
                        </div>

                        <!-- Payment Methods -->
                        <div class="mt-6 pt-4 border-t border-gray-200">
                            <p class="text-xs text-gray-500 mb-2">Thanh toán an toàn</p>
                            <div class="flex gap-2">
                                <span class="text-gray-400"><i class="fab fa-cc-visa text-2xl"></i></span>
                                <span class="text-gray-400"><i class="fab fa-cc-mastercard text-2xl"></i></span>
                                <span class="text-gray-400"><i class="fab fa-cc-amex text-2xl"></i></span>
                                <span class="text-gray-400"><i class="fab fa-cc-paypal text-2xl"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="bg-white rounded-lg shadow p-8 text-center">
                <div class="text-gray-400 mb-4">
                    <i class="fas fa-shopping-cart text-6xl"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-700 mb-2">Your Cart is Empty</h2>
                <p class="text-gray-500 mb-6">Looks like you haven't added anything to your cart yet.</p>
                <a href="{{ route('products.index') }}"
                    class="inline-block bg-pink-600 hover:bg-pink-700 text-white py-2 px-6 rounded-md transition duration-300">
                    Start Shopping
                </a>
            </div>
        @endif
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Handle quantity buttons
            document.querySelectorAll('.quantity-btn').forEach(button => {
                button.addEventListener('click', function () {
                    const form = this.closest('form');
                    const input = form.querySelector('input[name="quantity"]');
                    const currentValue = parseInt(input.value);

                    if (this.classList.contains('minus-btn') && currentValue > 1) {
                        input.value = currentValue - 1;
                    } else if (this.classList.contains('plus-btn')) {
                        input.value = currentValue + 1;
                    }

                    // Auto-submit form when quantity changes
                    form.submit();
                });
            });

            // Auto-submit form when input changes manually
            document.querySelectorAll('.cart-update-form input[name="quantity"]').forEach(input => {
                input.addEventListener('change', function () {
                    if (this.value < 1) {
                        this.value = 1;
                    }
                    this.closest('form').submit();
                });
            });
        });
    </script>
@endsection