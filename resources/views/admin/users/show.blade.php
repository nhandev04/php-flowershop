@extends('layouts.admin')

@section('title', ' - Xem người dùng')

@section('content')
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">Chi tiết người dùng</h1>
            <div>
                <a href="{{ route('admin.users.edit', $user->id) }}"
                    class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded mr-2">
                    <i class="fas fa-edit mr-2"></i> Chỉnh sửa
                </a>
                <a href="{{ route('admin.users.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-arrow-left mr-2"></i> Quay lại
                </a>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-xl font-bold mb-4">Thông tin người dùng</h3>

                        <div class="mb-4">
                            <p class="text-gray-600 text-sm">ID</p>
                            <p class="font-medium">{{ $user->id }}</p>
                        </div>

                        <div class="mb-4">
                            <p class="text-gray-600 text-sm">Tên</p>
                            <p class="font-medium">{{ $user->name }}</p>
                        </div>

                        <div class="mb-4">
                            <p class="text-gray-600 text-sm">Tên đăng nhập</p>
                            <p class="font-medium">{{ $user->username }}</p>
                        </div>

                        <div class="mb-4">
                            <p class="text-gray-600 text-sm">Email</p>
                            <p class="font-medium">{{ $user->email }}</p>
                        </div>

                        <div class="mb-4">
                            <p class="text-gray-600 text-sm">Vai trò</p>
                            @if($user->role === 'admin')
                                <span class="bg-purple-100 text-purple-800 py-1 px-3 rounded-full text-xs">Quản trị viên</span>
                            @else
                                <span class="bg-blue-100 text-blue-800 py-1 px-3 rounded-full text-xs">Người dùng</span>
                            @endif
                        </div>
                    </div>

                    <div>
                        <h3 class="text-xl font-bold mb-4">Thời gian hoạt động</h3>

                        <div class="mb-4">
                            <p class="text-gray-600 text-sm">Tạo tài khoản</p>
                            <p class="font-medium">{{ $user->created_at->format('d/m/Y H:i') }}</p>
                        </div>

                        <div class="mb-4">
                            <p class="text-gray-600 text-sm">Cập nhật lần cuối</p>
                            <p class="font-medium">{{ $user->updated_at->format('d/m/Y H:i') }}</p>
                        </div>

                        @if($user->email_verified_at)
                            <div class="mb-4">
                                <p class="text-gray-600 text-sm">Email đã xác minh</p>
                                <p class="font-medium">{{ $user->email_verified_at->format('d/m/Y H:i') }}</p>
                            </div>
                        @else
                            <div class="mb-4">
                                <p class="text-gray-600 text-sm">Xác minh Email</p>
                                <span class="bg-yellow-100 text-yellow-800 py-1 px-3 rounded-full text-xs">Chưa xác minh</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection