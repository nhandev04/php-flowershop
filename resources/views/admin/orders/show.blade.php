@extends('layouts.admin')

@section('title', 'Order Details')

@section('content')
    <div class="container-fluid p-6">
        <div class="mb-6 flex justify-between items-center">
            <h1 class="text-2xl font-bold">Order #{{ $order->id }}</h1>
            <div>
                <a href="{{ route('admin.orders.edit', $order->id) }}"
                    class="bg-yellow-500 hover:bg-yellow-600 text-white py-2 px-4 rounded mr-2">
                    <i class="fas fa-edit mr-2"></i> Edit
                </a>
                <a href="{{ route('admin.orders.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded">
                    <i class="fas fa-arrow-left mr-2"></i> Back
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="md:col-span-2">
                <div class="bg-white rounded shadow mb-6">
                    <div class="p-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold">Order Items</h2>
                    </div>
                    <div class="p-4">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b">
                                    <th class="text-left py-2">Product</th>
                                    <th class="text-center py-2">Quantity</th>
                                    <th class="text-right py-2">Price</th>
                                    <th class="text-right py-2">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->orderItems as $item)
                                    <tr class="border-b">
                                        <td class="py-3">
                                            <div class="flex items-center">
                                                @if($item->product && $item->product->image)
                                                    <img src="{{ asset('storage/' . $item->product->image) }}"
                                                        alt="{{ $item->product_name }}" class="w-12 h-12 object-cover mr-3">
                                                @else
                                                    <div class="w-12 h-12 bg-gray-200 mr-3"></div>
                                                @endif
                                                <div>
                                                    <p class="font-medium">{{ $item->product_name }}</p>
                                                    <p class="text-sm text-gray-500">SKU:
                                                        {{ $item->product ? $item->product->sku : 'N/A' }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">{{ $item->quantity }}</td>
                                        <td class="text-right">${{ number_format($item->price, 2) }}</td>
                                        <td class="text-right">${{ number_format($item->price * $item->quantity, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="border-b">
                                    <td colspan="3" class="text-right py-3 font-medium">Subtotal:</td>
                                    <td class="text-right py-3">${{ number_format($order->subtotal_amount, 2) }}</td>
                                </tr>
                                <tr class="border-b">
                                    <td colspan="3" class="text-right py-3 font-medium">Tax:</td>
                                    <td class="text-right py-3">${{ number_format($order->tax_amount, 2) }}</td>
                                </tr>
                                <tr class="border-b">
                                    <td colspan="3" class="text-right py-3 font-medium">Shipping:</td>
                                    <td class="text-right py-3">${{ number_format($order->shipping_amount, 2) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-right py-3 font-semibold">Total:</td>
                                    <td class="text-right py-3 font-semibold">${{ number_format($order->total_amount, 2) }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <div>
                <div class="bg-white rounded shadow mb-6">
                    <div class="p-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold">Order Information</h2>
                    </div>
                    <div class="p-4">
                        <div class="mb-4">
                            <p class="text-gray-600 mb-1">Order Number:</p>
                            <p class="font-medium">#{{ $order->id }}</p>
                        </div>
                        <div class="mb-4">
                            <p class="text-gray-600 mb-1">Date:</p>
                            <p class="font-medium">{{ $order->created_at->format('M d, Y H:i') }}</p>
                        </div>
                        <div class="mb-4">
                            <p class="text-gray-600 mb-1">Status:</p>
                            <p>
                                <span
                                    class="px-2 py-1 rounded text-xs 
                                {{ $order->status == 'completed' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $order->status == 'processing' ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ $order->status == 'cancelled' ? 'bg-red-100 text-red-800' : '' }}
                                {{ !in_array($order->status, ['completed', 'processing', 'cancelled']) ? 'bg-yellow-100 text-yellow-800' : '' }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </p>
                        </div>
                        <div class="mb-4">
                            <p class="text-gray-600 mb-1">Payment Method:</p>
                            <p class="font-medium">{{ $order->payment_method ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600 mb-1">Payment Status:</p>
                            <p>
                                <span
                                    class="px-2 py-1 rounded text-xs 
                                {{ $order->payment_status == 'paid' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ ucfirst($order->payment_status ?? 'pending') }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded shadow mb-6">
                    <div class="p-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold">Customer Information</h2>
                    </div>
                    <div class="p-4">
                        <div class="mb-4">
                            <p class="text-gray-600 mb-1">Name:</p>
                            <p class="font-medium">{{ $order->customer->name ?? 'N/A' }}</p>
                        </div>
                        <div class="mb-4">
                            <p class="text-gray-600 mb-1">Email:</p>
                            <p class="font-medium">{{ $order->customer->email ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600 mb-1">Phone:</p>
                            <p class="font-medium">{{ $order->customer->phone ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded shadow">
                    <div class="p-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold">Shipping Address</h2>
                    </div>
                    <div class="p-4">
                        <p>{{ $order->shipping_address ?? $order->customer->address ?? 'No address provided' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection