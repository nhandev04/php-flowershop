@extends('layouts.admin')

@section('title', ' - Thương hiệu')

@section('content')
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">Thương hiệu</h1>
            <a href="{{ route('admin.brands.create') }}"
                class="bg-pink-600 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded">
                <i class="fas fa-plus mr-2"></i> Thêm thương hiệu
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
                        <th class="py-3 px-6 text-left">Logo</th>
                        <th class="py-3 px-6 text-left">Tên</th>
                        <th class="py-3 px-6 text-left">Website</th>
                        <th class="py-3 px-6 text-center">Trạng thái</th>
                        <th class="py-3 px-6 text-center">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm">
                    @forelse($brands as $brand)
                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                            <td class="py-3 px-6">{{ $brand->id }}</td>
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
                            <td class="py-3 px-6">{{ $brand->name }}</td>
                            <td class="py-3 px-6">
                                @if($brand->website)
                                    <a href="{{ $brand->website }}" target="_blank" class="text-blue-500 hover:underline">
                                        {{ Str::limit($brand->website, 30) }}
                                    </a>
                                @else
                                    <span class="text-gray-400">Không có website</span>
                                @endif
                            </td>
                            <td class="py-3 px-6 text-center">
                                @if($brand->is_active)
                                    <span class="bg-green-100 text-green-800 py-1 px-3 rounded-full text-xs">Hoạt động</span>
                                @else
                                    <span class="bg-red-100 text-red-800 py-1 px-3 rounded-full text-xs">Không hoạt động</span>
                                @endif
                            </td>
                            <td class="py-3 px-6 text-center">
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
                            <td colspan="6" class="py-3 px-6 text-center">Không tìm thấy thương hiệu nào</td>
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