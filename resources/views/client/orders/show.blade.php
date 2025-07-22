@extends('layouts.client')

@section('title', ' - Order #' . $order->order_number)

@section('content')
    <div class="bg-gray-100 py-6">
        <div class="container mx-auto px-4">
            <h1 class="text-3xl font-bold mb-2">Order #{{ $order->order_number }}</h1>
            <nav class="text-sm text-gray-500">
                <ol class="list-none p-0 flex flex-wrap">
                    <li><a href="{{ route('home') }}" class="hover:text-pink-600">Home</a></li>
                    <li class="mx-2">/</li>
                    <li><a href="{{ route('account.orders') }}" class="hover:text-pink-600">My Orders</a></li>
                    <li class="mx-2">/</li>
                    <li class="text-pink-600">Order #{{ $order->order_number }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <!-- Order Status -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <div class="flex flex-col md:flex-row md:justify-between md:items-center">
                <div>
                    <h2 class="text-xl font-bold text-gray-800">Order #{{ $order->order_number }}</h2>
                    <p class="text-gray-600 mt-1">Placed on {{ $order->created_at->format('M d, Y, h:i A') }}</p>
                </div>
                <div class="mt-4 md:mt-0">
                    <div class="inline-flex items-center px-3 py-1 rounded-full
                            {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                            {{ $order->status === 'processing' ? 'bg-blue-100 text-blue-800' : '' }}
                            {{ $order->status === 'completed' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}
                        ">
                        <span class="text-xs font-medium">{{ ucfirst($order->status) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-6">
            <!-- Order Items -->
            <div class="lg:w-2/3">
                <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
                    <h3 class="bg-gray-50 px-6 py-3 text-lg font-semibold">Order Items</h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
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
                                        Total
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($order->items as $item)
                                    <tr>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-16 w-16">
                                                    @if($item->product && $item->product->image)
                                                        <img src="{{ asset('storage/' . $item->product->image) }}"
                                                            alt="{{ $item->product_name }}" class="h-16 w-16 object-cover rounded">
                                                    @else
                                                        <div class="h-16 w-16 bg-gray-200 rounded flex items-center justify-center">
                                                            <i class="fas fa-image text-gray-400"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $item->product_name }}
                                                    </div>
                                                    @if($item->product)
                                                        <div class="text-xs text-gray-500 mt-1">
                                                            SKU: {{ $item->product->sku ?? 'N/A' }}
                                                        </div>
                                                    @endif
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
                        </table>
                    </div>
                </div>

                <!-- Order Tracking -->
                @if($order->status !== 'cancelled' && $order->status !== 'pending')
                    <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
                        <h3 class="bg-gray-50 px-6 py-3 text-lg font-semibold">Order Tracking</h3>

                        <div class="p-6">
                            <div class="relative">
                                <!-- Track line -->
                                <div class="absolute top-0 left-5 ml-px border-l-2 border-gray-200 h-full"></div>

                                <!-- Order placed -->
                                <div class="relative flex items-start mb-8">
                                    <div class="flex items-center justify-center h-10 w-10 rounded-full bg-pink-600 text-white">
                                        <i class="fas fa-check"></i>
                                    </div>
                                    <div class="ml-4">
                                        <h4 class="text-lg font-semibold">Order Placed</h4>
                                        <p class="text-sm text-gray-600">{{ $order->created_at->format('M d, Y, h:i A') }}</p>
                                        <p class="text-sm text-gray-600 mt-1">Your order has been received</p>
                                    </div>
                                </div>

                                <!-- Processing -->
                                <div class="relative flex items-start mb-8">
                                    <div
                                        class="flex items-center justify-center h-10 w-10 rounded-full 
                                            {{ in_array($order->status, ['processing', 'shipped', 'completed']) ? 'bg-pink-600 text-white' : 'bg-gray-200 text-gray-400' }}">
                                        <i class="fas fa-cog"></i>
                                    </div>
                                    <div class="ml-4">
                                        <h4 class="text-lg font-semibold">Processing</h4>
                                        @if($order->processing_at)
                                            <p class="text-sm text-gray-600">{{ $order->processing_at->format('M d, Y, h:i A') }}
                                            </p>
                                            <p class="text-sm text-gray-600 mt-1">Your order is being processed</p>
                                        @else
                                            <p class="text-sm text-gray-400">Pending</p>
                                        @endif
                                    </div>
                                </div>

                                <!-- Shipped -->
                                <div class="relative flex items-start mb-8">
                                    <div
                                        class="flex items-center justify-center h-10 w-10 rounded-full 
                                            {{ in_array($order->status, ['shipped', 'completed']) ? 'bg-pink-600 text-white' : 'bg-gray-200 text-gray-400' }}">
                                        <i class="fas fa-shipping-fast"></i>
                                    </div>
                                    <div class="ml-4">
                                        <h4 class="text-lg font-semibold">Shipped</h4>
                                        @if($order->shipped_at)
                                            <p class="text-sm text-gray-600">{{ $order->shipped_at->format('M d, Y, h:i A') }}</p>
                                            <p class="text-sm text-gray-600 mt-1">Your order has been shipped</p>
                                            @if($order->tracking_number)
                                                <p class="text-sm font-medium mt-1">Tracking #: {{ $order->tracking_number }}</p>
                                            @endif
                                        @else
                                            <p class="text-sm text-gray-400">Pending</p>
                                        @endif
                                    </div>
                                </div>

                                <!-- Delivered -->
                                <div class="relative flex items-start">
                                    <div
                                        class="flex items-center justify-center h-10 w-10 rounded-full 
                                            {{ $order->status === 'completed' ? 'bg-pink-600 text-white' : 'bg-gray-200 text-gray-400' }}">
                                        <i class="fas fa-home"></i>
                                    </div>
                                    <div class="ml-4">
                                        <h4 class="text-lg font-semibold">Delivered</h4>
                                        @if($order->completed_at)
                                            <p class="text-sm text-gray-600">{{ $order->completed_at->format('M d, Y, h:i A') }}</p>
                                            <p class="text-sm text-gray-600 mt-1">Your order has been delivered</p>
                                        @else
                                            <p class="text-sm text-gray-400">Pending</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <div class="lg:w-1/3">
                <!-- Order Summary -->
                <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
                    <h3 class="bg-gray-50 px-6 py-3 text-lg font-semibold">Order Summary</h3>

                    <div class="p-6">
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Subtotal</span>
                                <span>${{ number_format($order->subtotal, 2) }}</span>
                            </div>

                            @if($order->discount > 0)
                                <div class="flex justify-between text-green-600">
                                    <span>Discount</span>
                                    <span>-${{ number_format($order->discount, 2) }}</span>
                                </div>
                            @endif

                            @if($order->tax > 0)
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Tax</span>
                                    <span>${{ number_format($order->tax, 2) }}</span>
                                </div>
                            @endif

                            <div class="flex justify-between">
                                <span class="text-gray-600">Shipping</span>
                                <span>
                                    @if($order->shipping > 0)
                                        ${{ number_format($order->shipping, 2) }}
                                    @else
                                        <span class="text-green-600">Free</span>
                                    @endif
                                </span>
                            </div>

                            <div class="pt-2 border-t border-gray-200 flex justify-between">
                                <span class="font-bold">Total</span>
                                <span class="font-bold text-pink-600">${{ number_format($order->total, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Billing Address -->
                <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
                    <h3 class="bg-gray-50 px-6 py-3 text-lg font-semibold">Billing Address</h3>

                    <div class="p-6">
                        <address class="not-italic">
                            <p class="font-medium">{{ $order->first_name }} {{ $order->last_name }}</p>
                            <p class="text-gray-600">{{ $order->address }}</p>
                            <p class="text-gray-600">{{ $order->city }}, {{ $order->state }} {{ $order->zip_code }}</p>
                            <p class="text-gray-600 mt-2">{{ $order->email }}</p>
                            <p class="text-gray-600">{{ $order->phone }}</p>
                        </address>
                    </div>
                </div>

                <!-- Shipping Address -->
                @if($order->different_shipping)
                    <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
                        <h3 class="bg-gray-50 px-6 py-3 text-lg font-semibold">Shipping Address</h3>

                        <div class="p-6">
                            <address class="not-italic">
                                <p class="font-medium">{{ $order->shipping_first_name }} {{ $order->shipping_last_name }}</p>
                                <p class="text-gray-600">{{ $order->shipping_address }}</p>
                                <p class="text-gray-600">{{ $order->shipping_city }}, {{ $order->shipping_state }}
                                    {{ $order->shipping_zip_code }}</p>
                                <p class="text-gray-600">{{ $order->shipping_phone }}</p>
                            </address>
                        </div>
                    </div>
                @endif

                <!-- Payment Information -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <h3 class="bg-gray-50 px-6 py-3 text-lg font-semibold">Payment Information</h3>

                    <div class="p-6">
                        <p>
                            <span class="font-medium">Method:</span>
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

                        <div class="mt-2 flex items-center">
                            <span class="font-medium mr-2">Status:</span>
                            <span
                                class="px-2 py-1 text-xs rounded-full {{ $order->payment_status === 'paid' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </div>

                        @if($order->payment_method === 'bank_transfer' && $order->payment_status !== 'paid')
                            <div class="mt-4 bg-yellow-50 p-4 rounded-md border border-yellow-100">
                                <h4 class="font-medium text-yellow-800">Bank Transfer Details</h4>
                                <ul class="mt-2 text-sm text-yellow-700 space-y-1">
                                    <li>Bank: National Bank</li>
                                    <li>Account Name: Flower Shop Inc.</li>
                                    <li>Account Number: 1234567890</li>
                                    <li>Sort Code: 12-34-56</li>
                                    <li>Reference: Order #{{ $order->order_number }}</li>
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-8 flex flex-wrap gap-4">
            <a href="{{ route('account.orders') }}"
                class="inline-flex items-center justify-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-md transition duration-300">
                <i class="fas fa-arrow-left mr-2"></i> Back to My Orders
            </a>

            @if($order->status !== 'cancelled' && $order->status !== 'completed')
                <form action="{{ route('orders.cancel', $order) }}" method="POST" class="inline-block"
                    onsubmit="return confirm('Are you sure you want to cancel this order? This action cannot be undone.')">
                    @csrf
                    @method('PATCH')
                    <button type="submit"
                        class="inline-flex items-center justify-center px-4 py-2 bg-red-50 hover:bg-red-100 text-red-700 rounded-md transition duration-300">
                        <i class="fas fa-times-circle mr-2"></i> Cancel Order
                    </button>
                </form>
            @endif

            <a href="#" onclick="window.print()"
                class="inline-flex items-center justify-center px-4 py-2 bg-blue-50 hover:bg-blue-100 text-blue-700 rounded-md transition duration-300">
                <i class="fas fa-print mr-2"></i> Print Order
            </a>
        </div>
    </div>
@endsection