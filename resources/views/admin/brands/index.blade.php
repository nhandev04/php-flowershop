@extends('layouts.admin')

@section('title', ' - Thương hiệu')

@section('content')
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Thương hiệu</h1>
            <a href="{{ route('admin.brands.create') }}"
                class="bg-pink-600 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded">
                <i class="fas fa-plus mr-2"></i> Thêm thương hiệu
            </a>
        </div>

        <!-- Search and Filter -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 mb-4 transition-colors duration-300">
            <form method="GET" action="{{ route('admin.brands.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tìm kiếm</label>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Tên thương hiệu, website..."
                        class="w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-pink-500 focus:border-pink-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Trạng thái</label>
                    <select name="status" class="w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-pink-500 focus:border-pink-500">
                        <option value="">Tất cả trạng thái</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Hoạt động</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Không hoạt động</option>
                    </select>
                </div>
                <div class="flex items-end gap-2">
                    <button type="submit" class="bg-pink-600 hover:bg-pink-700 text-white px-4 py-2 rounded">
                        <i class="fas fa-search mr-1"></i> Tìm kiếm
                    </button>
                    <a href="{{ route('admin.brands.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                        <i class="fas fa-times mr-1"></i> Xóa
                    </a>
                </div>
            </form>
        </div>

        @if(session('success'))
            <div class="bg-green-100 dark:bg-green-900/20 border border-green-400 dark:border-green-800 text-green-700 dark:text-green-200 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 dark:bg-red-900/20 border border-red-400 dark:border-red-800 text-red-700 dark:text-red-200 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden transition-colors duration-300">
            <table class="min-w-full bg-white dark:bg-gray-800">
                <thead class="bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 uppercase text-sm leading-normal">
                    <tr>
                        <th class="py-3 px-6 text-left">
                            <a href="{{ route('admin.brands.index', array_merge(request()->query(), ['sort' => 'id', 'direction' => request('sort') == 'id' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}" class="flex items-center hover:text-gray-800 dark:hover:text-gray-200 text-gray-600 dark:text-gray-300">
                                ID
                                @if(request('sort') == 'id')
                                    <i class="fas fa-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }} ml-1"></i>
                                @else
                                    <i class="fas fa-sort ml-1 opacity-50"></i>
                                @endif
                            </a>
                        </th>
                        <th class="py-3 px-6 text-left text-gray-600 dark:text-gray-300">Logo</th>
                        <th class="py-3 px-6 text-left">
                            <a href="{{ route('admin.brands.index', array_merge(request()->query(), ['sort' => 'name', 'direction' => request('sort') == 'name' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}" class="flex items-center hover:text-gray-800 dark:hover:text-gray-200 text-gray-600 dark:text-gray-300">
                                Tên
                                @if(request('sort') == 'name')
                                    <i class="fas fa-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }} ml-1"></i>
                                @else
                                    <i class="fas fa-sort ml-1 opacity-50"></i>
                                @endif
                            </a>
                        </th>
                        <th class="py-3 px-6 text-left text-gray-600 dark:text-gray-300">Website</th>
                        <th class="py-3 px-6 text-center">
                            <a href="{{ route('admin.brands.index', array_merge(request()->query(), ['sort' => 'is_active', 'direction' => request('sort') == 'is_active' && request('direction') == 'asc' ? 'desc' : 'asc'])) }}" class="flex items-center justify-center hover:text-gray-800 dark:hover:text-gray-200 text-gray-600 dark:text-gray-300">
                                Trạng thái
                                @if(request('sort') == 'is_active')
                                    <i class="fas fa-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }} ml-1"></i>
                                @else
                                    <i class="fas fa-sort ml-1 opacity-50"></i>
                                @endif
                            </a>
                        </th>
                        <th class="py-3 px-6 text-center text-gray-600 dark:text-gray-300">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 dark:text-gray-300 text-sm">
                    @forelse($brands as $brand)
                        <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="py-3 px-6 text-gray-900 dark:text-white">{{ $brand->id }}</td>
                            <td class="py-3 px-6">
                                @if($brand->image)
                                    <img src="{{ asset('storage/' . $brand->image) }}" alt="{{ $brand->name }}"
                                        class="h-10 w-10 rounded-full object-cover"
                                        onerror="this.onerror=null; this.src='{{ asset('storage/brands/default.png') }}'; this.classList.add('img-error')">
                                @else
                                    <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center dark:bg-gray-700">
                                        <i class="fas fa-image text-gray-400"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="py-3 px-6 text-gray-900 dark:text-white">{{ $brand->name }}</td>
                            <td class="py-3 px-6 text-gray-900 dark:text-white">
                                @if($brand->website)
                                    <a href="{{ $brand->website }}" target="_blank" class="text-blue-500 hover:underline">
                                        {{ Str::limit($brand->website, 30) }}
                                    </a>
                                @else
                                    <span class="text-gray-400 dark:text-gray-500">Không có website</span>
                                @endif
                            </td>
                            <td class="py-3 px-6 text-center">
                                @if($brand->is_active)
                                    <span class="bg-green-100 dark:bg-green-900/20 text-green-800 dark:text-green-200 py-1 px-3 rounded-full text-xs">Hoạt động</span>
                                @else
                                    <span class="bg-red-100 dark:bg-red-900/20 text-red-800 dark:text-red-200 py-1 px-3 rounded-full text-xs">Không hoạt động</span>
                                @endif
                            </td>
                            <td class="py-3 px-6 text-center text-gray-900 dark:text-white">
                                <div class="flex item-center justify-center">
                                    <a href="{{ route('admin.brands.show', $brand->id) }}"
                                        class="w-4 mr-2 transform hover:text-blue-500 hover:scale-110">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.brands.edit', $brand->id) }}"
                                        class="w-4 mr-2 transform hover:text-yellow-500 hover:scale-110">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form class="inline-block" action="{{ route('admin.brands.destroy', $brand->id) }}"
                                        method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa thương hiệu này?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-4 transform hover:text-red-500 hover:scale-110">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-3 px-6 text-center text-gray-500 dark:text-gray-400">Không tìm thấy thương hiệu nào</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $brands->links() }}
        </div>
    </div>
@endsection