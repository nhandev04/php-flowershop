@extends('layouts.admin')

@section('title', 'Quản lý Banner')

@section('content')
    <div class="container-fluid p-6">
        <div class="mb-6 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Danh sách Banner</h1>
            <a href="{{ route('admin.banners.create') }}"
                class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded">
                <i class="fas fa-plus mr-2"></i> Thêm Banner Mới
            </a>
        </div>

        <!-- Search and Filter -->
        <div class="bg-white dark:bg-gray-800 rounded shadow p-4 mb-4 transition-colors duration-300">
            <form method="GET" action="{{ route('admin.banners.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tìm kiếm</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Tiêu đề, mô tả..."
                        class="w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Trạng thái</label>
                    <select name="status"
                        class="w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Tất cả trạng thái</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Hoạt động</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Không hoạt động
                        </option>
                    </select>
                </div>
                <div class="flex items-end gap-2">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                        <i class="fas fa-search mr-1"></i> Tìm kiếm
                    </button>
                    <a href="{{ route('admin.banners.index') }}"
                        class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                        <i class="fas fa-times mr-1"></i> Xóa
                    </a>
                </div>
            </form>
        </div>

        @if(session('success'))
            <div
                class="bg-green-100 dark:bg-green-900/20 border border-green-400 dark:border-green-800 text-green-700 dark:text-green-200 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div
                class="bg-red-100 dark:bg-red-900/20 border border-red-400 dark:border-red-800 text-red-700 dark:text-red-200 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 rounded shadow overflow-x-auto transition-colors duration-300">
            <table class="w-full table-auto">
                <thead>
                    <tr class="bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white">
                        <th class="px-4 py-2 text-left">
                            <a href="{{ route('admin.banners.index', array_merge(request()->query(), ['sort' => 'id', 'direction' => request('sort') == 'id' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}"
                                class="flex items-center  text-gray-900 dark:text-white">
                                ID
                                @if(request('sort') == 'id')
                                    <i class="fas fa-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }} ml-1"></i>
                                @else
                                    <i class="fas fa-sort ml-1 opacity-50"></i>
                                @endif
                            </a>
                        </th>
                        <th class="px-4 py-2 text-left">
                            <a href="{{ route('admin.banners.index', array_merge(request()->query(), ['sort' => 'title', 'direction' => request('sort') == 'title' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}"
                                class="flex items-center ">
                                Tiêu đề
                                @if(request('sort') == 'title')
                                    <i class="fas fa-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }} ml-1"></i>
                                @else
                                    <i class="fas fa-sort ml-1 opacity-50"></i>
                                @endif
                            </a>
                        </th>
                        <th class="px-4 py-2 text-left">Hình ảnh</th>
                        <th class="px-4 py-2 text-left">
                            <a href="{{ route('admin.banners.index', array_merge(request()->query(), ['sort' => 'is_active', 'direction' => request('sort') == 'is_active' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}"
                                class="flex items-center ">
                                Trạng thái
                                @if(request('sort') == 'is_active')
                                    <i class="fas fa-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }} ml-1"></i>
                                @else
                                    <i class="fas fa-sort ml-1 opacity-50"></i>
                                @endif
                            </a>
                        </th>
                        <th class="px-4 py-2 text-left">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($banners as $banner)
                        <tr class="border-t border-gray-200 dark:border-gray-700">
                            <td class="px-4 py-2 text-gray-900 dark:text-white">{{ $banner->id }}</td>
                            <td class="px-4 py-2 text-gray-900 dark:text-white">{{ $banner->title }}</td>
                            <td class="px-4 py-2 text-gray-900 dark:text-white">
                                @if($banner->image)
                                    <img src="{{ asset('storage/' . $banner->image) }}" alt="{{ $banner->title }}"
                                        class="w-16 h-16 object-cover rounded">
                                @else
                                    Không có hình ảnh
                                @endif
                            </td>
                            <td class="px-4 py-2">
                                <span
                                    class="px-2 py-1 rounded text-xs {{ $banner->is_active ? 'bg-green-100 dark:bg-green-900/20 text-green-800 dark:text-green-200' : 'bg-red-100 dark:bg-red-900/20 text-red-800 dark:text-red-200' }}">
                                    {{ $banner->is_active ? 'Hoạt động' : 'Không hoạt động' }}
                                </span>
                            </td>
                            <td class="px-4 py-2 flex space-x-2">
                                <a href="{{ route('admin.banners.show', $banner->id) }}"
                                    class="text-blue-500 hover:text-blue-700">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.banners.edit', $banner->id) }}"
                                    class="text-yellow-500 hover:text-yellow-700">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form class="inline-block" action="{{ route('admin.banners.destroy', $banner->id) }}"
                                    method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa banner này?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-2 text-center text-gray-500 dark:text-gray-400">Không tìm thấy banner
                                nào</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $banners->links() }}
        </div>
    </div>
@endsection