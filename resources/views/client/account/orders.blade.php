@extends('layouts.client')

@section('title', ' - My Orders')

@section('content')
    <div class="bg-gray-100 py-6">
        <div class="container mx-auto px-4">
            <h1 class="text-3xl font-bold mb-2">My Orders</h1>
            <nav class="text-sm text-gray-500">
                <ol class="list-none p-0 flex flex-wrap">
                    <li><a href="{{ route('home') }}" class="hover:text-pink-600">Home</a></li>
                    <li class="mx-2">/</li>
                    <li><a href="{{ route('account.dashboard') }}" class="hover:text-pink-600">My Account</a></li>
                    <li class="mx-2">/</li>
                    <li class="text-pink-600">Orders</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Account Sidebar -->
            @include('client.account.partials.sidebar')

            <!-- Main Content -->
            <div class="lg:w-3/4">
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6"
                        role="alert">
                        <strong class="font-bold">Success!</strong>
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="border-b border-gray-200 px-6 py-4 flex items-center justify-between">
                        <h2 class="text-xl font-bold text-gray-800">Order History</h2>
                    </div>

                    @if($orders->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Order
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Date
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Total
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($orders as $order)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="text-sm font-medium text-gray-900">#{{ $order->order_number }}</span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $order->created_at->format('M d, Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                        {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                        {{ $order->status === 'processing' ? 'bg-blue-100 text-blue-800' : '' }}
                                                        {{ $order->status === 'completed' ? 'bg-green-100 text-green-800' : '' }}
                                                        {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}
                                                    ">
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                ${{ number_format($order->total, 2) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <a href="{{ route('orders.show', $order) }}"
                                                    class="text-pink-600 hover:text-pink-900">View</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="px-6 py-4">
                            {{ $orders->links() }}
                        </div>
                    @else
                        <div class="p-8 text-center">
                            <div class="text-gray-400 mb-4">
                                <i class="fas fa-shopping-bag text-6xl"></i>
                            </div>
                            <h3 class="text-xl font-bold text-gray-700 mb-2">No Orders Yet</h3>
                            <p class="text-gray-500 mb-6">You haven't placed any orders with us yet.</p>
                            <a href="{{ route('products.index') }}"
                                class="inline-block bg-pink-600 hover:bg-pink-700 text-white py-2 px-6 rounded-md transition duration-300">
                                Start Shopping
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection