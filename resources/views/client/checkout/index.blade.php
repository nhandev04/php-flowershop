@extends('layouts.client')

@section('title', ' - Checkout')

@section('content')
    <div class="bg-gray-100 py-6">
        <div class="container mx-auto px-4">
            <h1 class="text-3xl font-bold mb-2">Checkout</h1>
            <nav class="text-sm text-gray-500">
                <ol class="list-none p-0 flex flex-wrap">
                    <li><a href="{{ route('home') }}" class="hover:text-pink-600">Home</a></li>
                    <li class="mx-2">/</li>
                    <li><a href="{{ route('cart.index') }}" class="hover:text-pink-600">Cart</a></li>
                    <li class="mx-2">/</li>
                    <li class="text-pink-600">Checkout</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                <strong class="font-bold">Error!</strong>
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif
        
        @if($cartItems->isEmpty())
            <div class="bg-white rounded-lg shadow p-8 text-center">
                <div class="text-gray-400 mb-4">
                    <i class="fas fa-shopping-cart text-6xl"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-700 mb-2">Your Cart is Empty</h2>
                <p class="text-gray-500 mb-6">You need to add some products to your cart before checking out.</p>
                <a href="{{ route('products.index') }}" class="inline-block bg-pink-600 hover:bg-pink-700 text-white py-2 px-6 rounded-md transition duration-300">
                    Start Shopping
                </a>
            </div>
        @else
            <form action="{{ route('orders.store') }}" method="POST" id="checkout-form">
                @csrf
                <div class="flex flex-col lg:flex-row gap-8">
                    <!-- Billing & Shipping Details -->
                    <div class="lg:w-2/3 space-y-6">
                        <!-- Billing Details -->
                        <div class="bg-white rounded-lg shadow p-6">
                            <h2 class="text-lg font-bold mb-4 pb-2 border-b border-gray-200">Billing Details</h2>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="first_name" class="block text-sm font-medium text-gray-700 mb-1">First Name <span class="text-red-600">*</span></label>
                                    <input 
                                        type="text" 
                                        name="first_name" 
                                        id="first_name" 
                                        value="{{ old('first_name', auth()->check() ? auth()->user()->name : '') }}" 
                                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-pink-500 focus:border-pink-500 @error('first_name') border-red-500 @enderror" 
                                        required
                                    >
                                    @error('first_name')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="last_name" class="block text-sm font-medium text-gray-700 mb-1">Last Name <span class="text-red-600">*</span></label>
                                    <input 
                                        type="text" 
                                        name="last_name" 
                                        id="last_name" 
                                        value="{{ old('last_name', '') }}" 
                                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-pink-500 focus:border-pink-500 @error('last_name') border-red-500 @enderror" 
                                        required
                                    >
                                    @error('last_name')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email <span class="text-red-600">*</span></label>
                                    <input 
                                        type="email" 
                                        name="email" 
                                        id="email" 
                                        value="{{ old('email', auth()->user() ? auth()->user()->email : '') }}" 
                                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-pink-500 focus:border-pink-500 @error('email') border-red-500 @enderror" 
                                        required
                                    >
                                    @error('email')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone <span class="text-red-600">*</span></label>
                                    <input 
                                        type="text" 
                                        name="phone" 
                                        id="phone" 
                                        value="{{ old('phone', '') }}" 
                                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-pink-500 focus:border-pink-500 @error('phone') border-red-500 @enderror" 
                                        required
                                    >
                                    @error('phone')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="mt-4">
                                <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Address <span class="text-red-600">*</span></label>
                                <input 
                                    type="text" 
                                    name="address" 
                                    id="address" 
                                    value="{{ old('address', '') }}" 
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-pink-500 focus:border-pink-500 @error('address') border-red-500 @enderror" 
                                    required
                                >
                                @error('address')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                                <div>
                                    <label for="city" class="block text-sm font-medium text-gray-700 mb-1">City <span class="text-red-600">*</span></label>
                                    <input 
                                        type="text" 
                                        name="city" 
                                        id="city" 
                                        value="{{ old('city', '') }}" 
                                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-pink-500 focus:border-pink-500 @error('city') border-red-500 @enderror" 
                                        required
                                    >
                                    @error('city')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="state" class="block text-sm font-medium text-gray-700 mb-1">State/Province <span class="text-red-600">*</span></label>
                                    <input 
                                        type="text" 
                                        name="state" 
                                        id="state" 
                                        value="{{ old('state', '') }}" 
                                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-pink-500 focus:border-pink-500 @error('state') border-red-500 @enderror" 
                                        required
                                    >
                                    @error('state')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="zip_code" class="block text-sm font-medium text-gray-700 mb-1">Zip/Postal Code <span class="text-red-600">*</span></label>
                                    <input 
                                        type="text" 
                                        name="zip_code" 
                                        id="zip_code" 
                                        value="{{ old('zip_code', '') }}" 
                                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-pink-500 focus:border-pink-500 @error('zip_code') border-red-500 @enderror" 
                                        required
                                    >
                                    @error('zip_code')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="mt-4">
                                <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Order Notes (optional)</label>
                                <textarea 
                                    name="notes" 
                                    id="notes" 
                                    rows="3" 
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-pink-500 focus:border-pink-500"
                                    placeholder="Notes about your order, e.g. special delivery instructions"
                                >{{ old('notes') }}</textarea>
                            </div>
                        </div>
                        
                        <!-- Different Shipping Address -->
                        <div class="bg-white rounded-lg shadow p-6">
                            <div class="flex items-center">
                                <input type="checkbox" id="different_shipping" name="different_shipping" class="h-4 w-4 text-pink-600 focus:ring-pink-500 border-gray-300 rounded">
                                <label for="different_shipping" class="ml-2 block text-sm text-gray-700 font-medium">
                                    Ship to a different address?
                                </label>
                            </div>
                            
                            <div id="shipping_address_container" class="mt-4 hidden">
                                <!-- Add shipping form fields similar to billing but with shipping_ prefix -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="shipping_first_name" class="block text-sm font-medium text-gray-700 mb-1">First Name <span class="text-red-600">*</span></label>
                                        <input 
                                            type="text" 
                                            name="shipping_first_name" 
                                            id="shipping_first_name" 
                                            value="{{ old('shipping_first_name') }}" 
                                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-pink-500 focus:border-pink-500"
                                        >
                                    </div>
                                    
                                    <div>
                                        <label for="shipping_last_name" class="block text-sm font-medium text-gray-700 mb-1">Last Name <span class="text-red-600">*</span></label>
                                        <input 
                                            type="text" 
                                            name="shipping_last_name" 
                                            id="shipping_last_name" 
                                            value="{{ old('shipping_last_name') }}" 
                                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-pink-500 focus:border-pink-500"
                                        >
                                    </div>
                                    
                                    <div class="md:col-span-2">
                                        <label for="shipping_address" class="block text-sm font-medium text-gray-700 mb-1">Address <span class="text-red-600">*</span></label>
                                        <input 
                                            type="text" 
                                            name="shipping_address" 
                                            id="shipping_address" 
                                            value="{{ old('shipping_address') }}" 
                                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-pink-500 focus:border-pink-500"
                                        >
                                    </div>
                                    
                                    <div>
                                        <label for="shipping_city" class="block text-sm font-medium text-gray-700 mb-1">City <span class="text-red-600">*</span></label>
                                        <input 
                                            type="text" 
                                            name="shipping_city" 
                                            id="shipping_city" 
                                            value="{{ old('shipping_city') }}" 
                                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-pink-500 focus:border-pink-500"
                                        >
                                    </div>
                                    
                                    <div>
                                        <label for="shipping_state" class="block text-sm font-medium text-gray-700 mb-1">State/Province <span class="text-red-600">*</span></label>
                                        <input 
                                            type="text" 
                                            name="shipping_state" 
                                            id="shipping_state" 
                                            value="{{ old('shipping_state') }}" 
                                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-pink-500 focus:border-pink-500"
                                        >
                                    </div>
                                    
                                    <div>
                                        <label for="shipping_zip_code" class="block text-sm font-medium text-gray-700 mb-1">Zip/Postal Code <span class="text-red-600">*</span></label>
                                        <input 
                                            type="text" 
                                            name="shipping_zip_code" 
                                            id="shipping_zip_code" 
                                            value="{{ old('shipping_zip_code') }}" 
                                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-pink-500 focus:border-pink-500"
                                        >
                                    </div>
                                    
                                    <div>
                                        <label for="shipping_phone" class="block text-sm font-medium text-gray-700 mb-1">Phone <span class="text-red-600">*</span></label>
                                        <input 
                                            type="text" 
                                            name="shipping_phone" 
                                            id="shipping_phone" 
                                            value="{{ old('shipping_phone') }}" 
                                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-pink-500 focus:border-pink-500"
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Payment Method -->
                        <div class="bg-white rounded-lg shadow p-6">
                            <h2 class="text-lg font-bold mb-4 pb-2 border-b border-gray-200">Payment Method</h2>
                            
                            <div class="space-y-4">
                                <div class="flex items-center">
                                    <input 
                                        type="radio" 
                                        id="payment_method_cod" 
                                        name="payment_method" 
                                        value="cod" 
                                        class="h-4 w-4 text-pink-600 focus:ring-pink-500 border-gray-300"
                                        {{ old('payment_method', 'cod') === 'cod' ? 'checked' : '' }}
                                    >
                                    <label for="payment_method_cod" class="ml-2 block text-sm text-gray-700">
                                        Cash on Delivery (COD)
                                    </label>
                                </div>
                                
                                <div class="flex items-center">
                                    <input 
                                        type="radio" 
                                        id="payment_method_bank" 
                                        name="payment_method" 
                                        value="bank_transfer" 
                                        class="h-4 w-4 text-pink-600 focus:ring-pink-500 border-gray-300"
                                        {{ old('payment_method') === 'bank_transfer' ? 'checked' : '' }}
                                    >
                                    <label for="payment_method_bank" class="ml-2 block text-sm text-gray-700">
                                        Direct Bank Transfer
                                    </label>
                                </div>
                                
                                <div class="flex items-center">
                                    <input 
                                        type="radio" 
                                        id="payment_method_credit_card" 
                                        name="payment_method" 
                                        value="credit_card" 
                                        class="h-4 w-4 text-pink-600 focus:ring-pink-500 border-gray-300"
                                        {{ old('payment_method') === 'credit_card' ? 'checked' : '' }}
                                    >
                                    <label for="payment_method_credit_card" class="ml-2 block text-sm text-gray-700">
                                        Credit Card / Debit Card
                                    </label>
                                </div>
                                
                                @error('payment_method')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div id="credit_card_details" class="mt-4 hidden">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="md:col-span-2">
                                        <label for="card_number" class="block text-sm font-medium text-gray-700 mb-1">Card Number <span class="text-red-600">*</span></label>
                                        <input 
                                            type="text" 
                                            name="card_number" 
                                            id="card_number" 
                                            placeholder="1234 5678 9012 3456" 
                                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-pink-500 focus:border-pink-500"
                                        >
                                    </div>
                                    
                                    <div>
                                        <label for="card_expiry" class="block text-sm font-medium text-gray-700 mb-1">Expiry Date <span class="text-red-600">*</span></label>
                                        <input 
                                            type="text" 
                                            name="card_expiry" 
                                            id="card_expiry" 
                                            placeholder="MM/YY" 
                                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-pink-500 focus:border-pink-500"
                                        >
                                    </div>
                                    
                                    <div>
                                        <label for="card_cvv" class="block text-sm font-medium text-gray-700 mb-1">CVV <span class="text-red-600">*</span></label>
                                        <input 
                                            type="text" 
                                            name="card_cvv" 
                                            id="card_cvv" 
                                            placeholder="123" 
                                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-pink-500 focus:border-pink-500"
                                        >
                                    </div>
                                    
                                    <div class="md:col-span-2">
                                        <label for="card_name" class="block text-sm font-medium text-gray-700 mb-1">Name on Card <span class="text-red-600">*</span></label>
                                        <input 
                                            type="text" 
                                            name="card_name" 
                                            id="card_name" 
                                            placeholder="John Doe" 
                                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-pink-500 focus:border-pink-500"
                                        >
                                    </div>
                                </div>
                            </div>
                            
                            <div id="bank_transfer_details" class="mt-4 hidden bg-gray-50 p-4 rounded-md">
                                <p class="text-sm text-gray-700">
                                    Please use the following banking details to make your payment:
                                </p>
                                <ul class="list-disc pl-5 mt-2 text-sm text-gray-700 space-y-1">
                                    <li>Bank: National Bank</li>
                                    <li>Account Name: Flower Shop Inc.</li>
                                    <li>Account Number: 1234567890</li>
                                    <li>Sort Code: 12-34-56</li>
                                    <li>Reference: Your order number (will be provided after checkout)</li>
                                </ul>
                                <p class="text-sm text-gray-700 mt-2">
                                    Your order will not be shipped until the funds have cleared in our account.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="lg:w-1/3">
                        <div class="bg-white rounded-lg shadow p-6 sticky top-6">
                            <h2 class="text-lg font-bold mb-4 pb-2 border-b border-gray-200">Order Summary</h2>
                            
                            <div class="mb-4">
                                <div class="max-h-60 overflow-y-auto">
                                    @foreach($cartItems as $item)
                                        <div class="flex py-2 border-b border-gray-100">
                                            <div class="flex-shrink-0 w-16 h-16 border rounded-md overflow-hidden">
                                                @if($item->product->image)
                                                <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                                @else
                                                <div class="w-full h-full flex items-center justify-center bg-gray-100">
                                                    <i class="fas fa-image text-gray-400"></i>
                                                </div>
                                                @endif
                                            </div>
                                            <div class="ml-3 flex-1">
                                                <h3 class="text-sm font-medium text-gray-700">{{ $item->product->name }}</h3>
                                                <p class="text-xs text-gray-500 mt-1">Qty: {{ $item->quantity }}</p>
                                            </div>
                                            <div class="text-right">
                                                <p class="text-sm font-medium text-gray-700">${{ number_format($item->product->price * $item->quantity, 2) }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            
                            <div class="space-y-3 mb-6">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Subtotal</span>
                                    <span class="font-medium">${{ number_format($subtotal, 2) }}</span>
                                </div>
                                
                                @if($discount > 0)
                                <div class="flex justify-between text-green-600">
                                    <span>Discount</span>
                                    <span>-${{ number_format($discount, 2) }}</span>
                                </div>
                                @endif
                                
                                @if($tax > 0)
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Tax ({{ $taxRate * 100 }}%)</span>
                                    <span class="font-medium">${{ number_format($tax, 2) }}</span>
                                </div>
                                @endif
                                
                                @if($shipping > 0)
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Shipping</span>
                                    <span class="font-medium">${{ number_format($shipping, 2) }}</span>
                                </div>
                                @else
                                <div class="flex justify-between text-green-600">
                                    <span>Shipping</span>
                                    <span>Free</span>
                                </div>
                                @endif
                                
                                <div class="pt-2 border-t border-gray-200 flex justify-between">
                                    <span class="text-lg font-bold">Total</span>
                                    <span class="text-lg font-bold text-pink-600">${{ number_format($total, 2) }}</span>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <div class="flex items-center">
                                    <input type="checkbox" id="terms_accepted" name="terms_accepted" class="h-4 w-4 text-pink-600 focus:ring-pink-500 border-gray-300 rounded" required>
                                    <label for="terms_accepted" class="ml-2 block text-sm text-gray-700">
                                        I have read and agree to the <a href="#" class="text-pink-600 hover:text-pink-700">terms and conditions</a> <span class="text-red-600">*</span>
                                    </label>
                                </div>
                                @error('terms_accepted')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <button type="submit" class="w-full bg-pink-600 hover:bg-pink-700 text-white text-center py-3 px-4 rounded-md transition duration-300">
                                Place Order
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        @endif
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle different shipping address form
        const differentShippingCheckbox = document.getElementById('different_shipping');
        const shippingAddressContainer = document.getElementById('shipping_address_container');
        
        differentShippingCheckbox.addEventListener('change', function() {
            if (this.checked) {
                shippingAddressContainer.classList.remove('hidden');
            } else {
                shippingAddressContainer.classList.add('hidden');
            }
        });
        
        // Toggle payment method details
        const paymentMethods = document.querySelectorAll('input[name="payment_method"]');
        const creditCardDetails = document.getElementById('credit_card_details');
        const bankTransferDetails = document.getElementById('bank_transfer_details');
        
        paymentMethods.forEach(method => {
            method.addEventListener('change', function() {
                if (this.value === 'credit_card') {
                    creditCardDetails.classList.remove('hidden');
                    bankTransferDetails.classList.add('hidden');
                } else if (this.value === 'bank_transfer') {
                    bankTransferDetails.classList.remove('hidden');
                    creditCardDetails.classList.add('hidden');
                } else {
                    creditCardDetails.classList.add('hidden');
                    bankTransferDetails.classList.add('hidden');
                }
            });
        });
        
        // Initialize correct state based on default selection
        paymentMethods.forEach(method => {
            if (method.checked) {
                if (method.value === 'credit_card') {
                    creditCardDetails.classList.remove('hidden');
                } else if (method.value === 'bank_transfer') {
                    bankTransferDetails.classList.remove('hidden');
                }
            }
        });
    });
</script>
@endsection
