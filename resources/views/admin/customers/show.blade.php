@extends('layouts.admin')

@section('title', 'Customer Details')

@section('content')
    <div class="container-fluid p-6">
        <div class="mb-6 flex justify-between items-center">
            <h1 class="text-2xl font-bold">Customer Details</h1>
            <div>
                <a href="{{ route('admin.customers.edit', $customer->id) }}"
                    class="bg-yellow-500 hover:bg-yellow-600 text-white py-2 px-4 rounded mr-2">
                    <i class="fas fa-edit mr-2"></i> Edit
                </a>
                <a href="{{ route('admin.customers.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded">
                    <i class="fas fa-arrow-left mr-2"></i> Back
                </a>
            </div>
        </div>

        <div class="bg-white rounded shadow overflow-hidden">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-semibold mb-4">Customer Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-gray-600 mb-1">Name:</p>
                        <p class="font-medium">{{ $customer->name }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 mb-1">Email:</p>
                        <p class="font-medium">{{ $customer->email }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 mb-1">Phone:</p>
                        <p class="font-medium">{{ $customer->phone ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 mb-1">Created:</p>
                        <p class="font-medium">{{ $customer->created_at->format('M d, Y H:i') }}</p>
                    </div>
                </div>
            </div>

            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-semibold mb-4">Address</h2>
                <p>{{ $customer->address ?? 'No address provided' }}</p>
            </div>

            <div class="p-6">
                <h2 class="text-xl font-semibold mb-4">Orders</h2>
                @if($customer->orders && $customer->orders->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full table-auto">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-4 py-2 text-left">Order #</th>
                                    <th class="px-4 py-2 text-left">Date</th>
                                    <th class="px-4 py-2 text-left">Total</th>
                                    <th class="px-4 py-2 text-left">Status</th>
                                    <th class="px-4 py-2 text-left">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($customer->orders as $order)
                                    <tr class="border-t">
                                        <td class="px-4 py-2">#{{ $order->id }}</td>
                                        <td class="px-4 py-2">{{ $order->created_at->format('M d, Y') }}</td>
                                        <td class="px-4 py-2">${{ number_format($order->total_amount, 2) }}</td>
                                        <td class="px-4 py-2">
                                            <span
                                                class="px-2 py-1 rounded text-xs 
                                                    {{ $order->status == 'completed' ? 'bg-green-100 text-green-800' : '' }}
                                                    {{ $order->status == 'processing' ? 'bg-blue-100 text-blue-800' : '' }}
                                                    {{ $order->status == 'cancelled' ? 'bg-red-100 text-red-800' : '' }}
                                                    {{ !in_array($order->status, ['completed', 'processing', 'cancelled']) ? 'bg-yellow-100 text-yellow-800' : '' }}">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-2">
                                            <a href="{{ route('admin.orders.show', $order->id) }}"
                                                class="text-blue-500 hover:text-blue-700">
                                                <i class="fas fa-eye mr-1"></i> View
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-gray-500">No orders found for this customer.</p>
                @endif
            </div>
        </div>
    </div>
@endsection