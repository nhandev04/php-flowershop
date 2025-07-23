@extends('layouts.admin')

@section('title', ' - Người dùng')

@section('content')
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">Người dùng</h1>
            <a href="{{ route('admin.users.create') }}"
                class="bg-pink-600 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded">
                <i class="fas fa-plus mr-2"></i> Thêm người dùng
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                    <tr>
                        <th class="py-3 px-6 text-left">ID</th>
                        <th class="py-3 px-6 text-left">Họ tên</th>
                        <th class="py-3 px-6 text-left">Tên đăng nhập</th>
                        <th class="py-3 px-6 text-left">Email</th>
                        <th class="py-3 px-6 text-center">Vai trò</th>
                        <th class="py-3 px-6 text-center">Ngày tạo</th>
                        <th class="py-3 px-6 text-center">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm">
                    @forelse($users as $user)
                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                            <td class="py-3 px-6">{{ $user->id }}</td>
                            <td class="py-3 px-6">{{ $user->name }}</td>
                            <td class="py-3 px-6">{{ $user->username }}</td>
                            <td class="py-3 px-6">{{ $user->email }}</td>
                            <td class="py-3 px-6 text-center">
                                @if($user->role === 'admin')
                                    <span class="bg-purple-100 text-purple-800 py-1 px-3 rounded-full text-xs">Quản trị viên</span>
                                @else
                                    <span class="bg-blue-100 text-blue-800 py-1 px-3 rounded-full text-xs">Người dùng</span>
                                @endif
                            </td>
                            <td class="py-3 px-6 text-center">
                                {{ $user->created_at->format('d/m/Y') }}
                            </td>
                            <td class="py-3 px-6 text-center">
                                <div class="flex item-center justify-center">
                                    <a href="{{ route('admin.users.show', $user->id) }}"
                                        class="w-4 mr-2 transform hover:text-blue-500 hover:scale-110" title="Xem">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.users.edit', $user->id) }}"
                                        class="w-4 mr-2 transform hover:text-yellow-500 hover:scale-110" title="Sửa">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @if(auth()->user()->id !== $user->id)
                                        <form class="inline-block" action="{{ route('admin.users.destroy', $user->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Bạn có chắc chắn muốn xóa người dùng này không?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-4 transform hover:text-red-500 hover:scale-110"
                                                title="Xóa">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-3 px-6 text-center">Không tìm thấy người dùng nào</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>
@endsection