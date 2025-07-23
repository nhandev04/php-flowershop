@extends('layouts.client')

@section('title', ' - Tài khoản của tôi')

@section('content')
    <div class="bg-gray-100 py-6">
        <div class="container mx-auto px-4">
            <h1 class="text-3xl font-bold mb-2">Tài khoản của tôi</h1>
            <nav class="text-sm text-gray-500">
                <ol class="list-none p-0 flex flex-wrap">
                    <li><a href="{{ route('home') }}" class="hover:text-pink-600">Trang chủ</a></li>
                    <li class="mx-2">/</li>
                    <li class="text-pink-600">Tài khoản của tôi</li>
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
                        <strong class="font-bold">Thành công!</strong>
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                <!-- Dashboard Overview -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div class="rounded-full bg-blue-100 p-3">
                                <i class="fas fa-shopping-bag text-xl text-blue-600"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-medium text-gray-500">Tổng đơn hàng</h3>
                                <p class="text-2xl font-bold text-gray-800">{{ $totalOrders }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div class="rounded-full bg-green-100 p-3">
                                <i class="fas fa-dollar-sign text-xl text-green-600"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-medium text-gray-500">Tổng chi tiêu</h3>
                                <p class="text-2xl font-bold text-gray-800">{{ number_format($totalSpent, 0) }}₫</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div class="rounded-full bg-purple-100 p-3">
                                <i class="fas fa-heart text-xl text-purple-600"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-medium text-gray-500">Yêu thích</h3>
                                <div class="mt-1">
                                    <a href="{{ route('account.wishlist') }}"
                                        class="text-pink-600 text-sm hover:underline">Xem danh sách</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Orders -->
                <div class="bg-white rounded-lg shadow overflow-hidden mb-8">
                    <div class="border-b border-gray-200 px-6 py-4 flex items-center justify-between">
                        <h2 class="text-xl font-bold text-gray-800">Đơn hàng gần đây</h2>
                        <a href="{{ route('account.orders') }}" class="text-sm text-pink-600 hover:underline">Xem tất cả</a>
                    </div>

                    @if($recentOrders->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Đơn hàng
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Ngày
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Trạng thái
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
                                    @foreach($recentOrders as $order)
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
                                                {{ number_format($order->total, 0) }}₫
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <a href="{{ route('orders.show', $order) }}"
                                                    class="text-pink-600 hover:text-pink-900">Xem</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="p-6 text-center">
                            <p class="text-gray-600">Bạn chưa đặt đơn hàng nào.</p>
                        </div>
                    @endif
                </div>

                <!-- Account Details -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="border-b border-gray-200 px-6 py-4">
                        <h2 class="text-xl font-bold text-gray-800">Thông tin tài khoản</h2>
                    </div>

                    <div class="p-6">
                        <div class="flex flex-col md:flex-row md:justify-between md:items-center">
                            <div>
                                <p class="text-lg font-medium">{{ $user->name }}</p>
                                <p class="text-gray-600">{{ $user->email }}</p>
                            </div>
                            <div class="mt-4 md:mt-0">
                                <a href="{{ route('account.profile') }}"
                                    class="inline-flex items-center justify-center px-4 py-2 bg-pink-600 hover:bg-pink-700 text-white rounded-md transition duration-300">
                                    Chỉnh sửa hồ sơ
                                </a>
                            </div>
                        </div>

                        <div class="mt-6 border-t border-gray-200 pt-4">
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Địa chỉ giao hàng mặc định</h3>

                            @if($user->address)
                                <address class="not-italic text-gray-600">
                                    {{ $user->address }}<br>
                                    {{ $user->city }}, {{ $user->state }} {{ $user->zip_code }}<br>
                                    {{ $user->phone ?? 'Chưa có số điện thoại' }}
                                </address>
                                <div class="mt-2">
                                    <a href="{{ route('account.addresses') }}" class="text-sm text-pink-600 hover:underline">Sửa
                                        địa chỉ</a>
                                </div>
                            @else
                                <p class="text-gray-600">Bạn chưa thiết lập địa chỉ giao hàng.</p>
                                <div class="mt-2">
                                    <a href="{{ route('account.addresses') }}"
                                        class="text-sm text-pink-600 hover:underline">Thêm địa chỉ</a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection