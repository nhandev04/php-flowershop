@extends('layouts.client')

@section('title', ' - Order Confirmation')

@section('content')
    <div class="bg-gray-100 py-6">
        <div class="container mx-auto px-4">
            <h1 class="text-3xl font-bold mb-2">Order Confirmation</h1>
            <nav class="text-sm text-gray-500">
                <ol class="list-none p-0 flex flex-wrap">
                    <li><a href="{{ route('home') }}" class="hover:text-pink-600">Home</a></li>
                    <li class="mx-2">/</li>
                    <li class="text-pink-600">Order Confirmation</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="container mx-auto px-4 py-12">
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="p-6 md:p-12 text-center">
                <div class="w-20 h-20 mx-auto bg-green-100 rounded-full flex items-center justify-center mb-6">
                    <i class="fas fa-check text-3xl text-green-600"></i>
                </div>

                <h2 class="text-3xl font-bold text-gray-800 mb-2">Thank You!</h2>
                <p class="text-lg text-gray-600 mb-6">Your order has been placed successfully.</p>

                <div class="mb-8">
                    <p class="text-sm text-gray-500 mb-1">Order Number:</p>
                    <p class="text-xl font-semibold text-gray-800 mb-2">#{{ $order->order_number }}</p>
                    <p class="text-sm text-gray-500">A confirmation email has been sent to
                        <strong>{{ $order->email }}</strong></p>
                </div>

                <div class="flex flex-col md:flex-row justify-center gap-4">
                    <a href="{{ route('orders.show', $order) }}"
                        class="bg-pink-600 hover:bg-pink-700 text-white py-2 px-6 rounded-md transition duration-300">
                        View Order Details
                    </a>
                    <a href="{{ route('products.index') }}"
                        class="bg-gray-100 hover:bg-gray-200 text-gray-800 py-2 px-6 rounded-md transition duration-300">
                        Continue Shopping
                    </a>
                </div>
            </div>

            <div class="bg-gray-50 p-6 md:p-12 border-t border-gray-200">
                <div class="max-w-3xl mx-auto">
                    <h3 class="text-xl font-bold mb-4">Order Summary</h3>

                    <!-- Order Items -->
                    <div class="mb-6">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Product
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Price
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Quantity
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Subtotal
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($order->items as $item)
                                        <tr>
                                            <td class="px-6 py-4">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-10 w-10">
                                                        @if($item->product && $item->product->image)
                                                            <img src="{{ asset('storage/' . $item->product->image) }}"
                                                                alt="{{ $item->product_name }}"
                                                                class="h-10 w-10 object-cover rounded">
                                                        @else
                                                            <div
                                                                class="h-10 w-10 bg-gray-200 rounded flex items-center justify-center">
                                                                <i class="fas fa-image text-gray-400"></i>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            {{ $item->product_name }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                ${{ number_format($item->price, 2) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $item->quantity }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                                                ${{ number_format($item->price * $item->quantity, 2) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="px-6 py-3 text-right text-sm font-medium text-gray-700">
                                            Subtotal:
                                        </td>
                                        <td class="px-6 py-3 text-right text-sm font-medium text-gray-900">
                                            ${{ number_format($order->subtotal, 2) }}
                                        </td>
                                    </tr>
                                    @if($order->discount > 0)
                                        <tr>
                                            <td colspan="3" class="px-6 py-3 text-right text-sm font-medium text-green-600">
                                                Discount:
                                            </td>
                                            <td class="px-6 py-3 text-right text-sm font-medium text-green-600">
                                                -${{ number_format($order->discount, 2) }}
                                            </td>
                                        </tr>
                                    @endif
                                    @if($order->tax > 0)
                                        <tr>
                                            <td colspan="3" class="px-6 py-3 text-right text-sm font-medium text-gray-700">
                                                Tax:
                                            </td>
                                            <td class="px-6 py-3 text-right text-sm font-medium text-gray-900">
                                                ${{ number_format($order->tax, 2) }}
                                            </td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <td colspan="3" class="px-6 py-3 text-right text-sm font-medium text-gray-700">
                                            Shipping:
                                        </td>
                                        <td class="px-6 py-3 text-right text-sm font-medium text-gray-900">
                                            @if($order->shipping > 0)
                                                ${{ number_format($order->shipping, 2) }}
                                            @else
                                                Free
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="px-6 py-3 text-right text-base font-bold text-gray-900">
                                            Total:
                                        </td>
                                        <td class="px-6 py-3 text-right text-base font-bold text-pink-600">
                                            ${{ number_format($order->total, 2) }}
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Billing Information -->
                        <div>
                            <h4 class="font-semibold text-gray-800 mb-2">Billing Information</h4>
                            <div class="bg-white border border-gray-200 rounded-md p-4">
                                <p class="text-sm text-gray-800">{{ $order->first_name }} {{ $order->last_name }}</p>
                                <p class="text-sm text-gray-600">{{ $order->address }}</p>
                                <p class="text-sm text-gray-600">{{ $order->city }}, {{ $order->state }}
                                    {{ $order->zip_code }}</p>
                                <p class="text-sm text-gray-600 mt-2">{{ $order->email }}</p>
                                <p class="text-sm text-gray-600">{{ $order->phone }}</p>
                            </div>
                        </div>

                        <!-- Shipping Information (if different) -->
                        @if($order->different_shipping)
                            <div>
                                <h4 class="font-semibold text-gray-800 mb-2">Shipping Information</h4>
                                <div class="bg-white border border-gray-200 rounded-md p-4">
                                    <p class="text-sm text-gray-800">{{ $order->shipping_first_name }}
                                        {{ $order->shipping_last_name }}</p>
                                    <p class="text-sm text-gray-600">{{ $order->shipping_address }}</p>
                                    <p class="text-sm text-gray-600">{{ $order->shipping_city }}, {{ $order->shipping_state }}
                                        {{ $order->shipping_zip_code }}</p>
                                    <p class="text-sm text-gray-600">{{ $order->shipping_phone }}</p>
                                </div>
                            </div>
                        @endif

                        <!-- Payment Information -->
                        <div>
                            <h4 class="font-semibold text-gray-800 mb-2">Payment Information</h4>
                            <div class="bg-white border border-gray-200 rounded-md p-4">
                                <p class="text-sm text-gray-800">
                                    <span class="font-medium">Payment Method:</span>
                                    @if($order->payment_method === 'cod')
                                        Cash on Delivery
                                    @elseif($order->payment_method === 'bank_transfer')
                                        Bank Transfer
                                    @elseif($order->payment_method === 'credit_card')
                                        Credit Card
                                    @else
                                        {{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}
                                    @endif
                                </p>
                                <p class="text-sm text-gray-800">
                                    <span class="font-medium">Payment Status:</span>
                                    <span
                                        class="px-2 py-1 text-xs rounded-full {{ $order->payment_status === 'paid' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ ucfirst($order->payment_status) }}
                                    </span>
                                </p>
                            </div>
                        </div>

                        <!-- Order Information -->
                        <div>
                            <h4 class="font-semibold text-gray-800 mb-2">Order Information</h4>
                            <div class="bg-white border border-gray-200 rounded-md p-4">
                                <p class="text-sm text-gray-800">
                                    <span class="font-medium">Order Date:</span>
                                    {{ $order->created_at->format('M d, Y, h:i A') }}
                                </p>
                                <p class="text-sm text-gray-800">
                                    <span class="font-medium">Order Status:</span>
                                    <span class="px-2 py-1 text-xs rounded-full 
                                            {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                            {{ $order->status === 'processing' ? 'bg-blue-100 text-blue-800' : '' }}
                                            {{ $order->status === 'completed' ? 'bg-green-100 text-green-800' : '' }}
                                            {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}
                                        ">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </p>
                                @if($order->notes)
                                    <div class="mt-2">
                                        <p class="text-sm font-medium text-gray-800">Order Notes:</p>
                                        <p class="text-sm text-gray-600">{{ $order->notes }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection