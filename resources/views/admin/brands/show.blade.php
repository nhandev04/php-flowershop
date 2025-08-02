@extends('layouts.admin')

@section('title', ' - Xem thương hiệu')

@section('content')
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">Chi tiết thương hiệu</h1>
            <div>
                <a href="{{ route('admin.brands.edit', $brand->id) }}"
                    class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded mr-2">
                    <i class="fas fa-edit mr-2"></i> Chỉnh sửa
                </a>
                <a href="{{ route('admin.brands.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-arrow-left mr-2"></i> Quay lại
                </a>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-xl font-bold mb-4">Thông tin cơ bản</h3>

                        <div class="mb-4">
                            <p class="text-gray-600 text-sm">ID</p>
                            <p class="font-medium">{{ $brand->id }}</p>
                        </div>

                        <div class="mb-4">
                            <p class="text-gray-600 text-sm">Tên thương hiệu</p>
                            <p class="font-medium">{{ $brand->name }}</p>
                        </div>

                        <div class="mb-4">
                            <p class="text-gray-600 text-sm">Mô tả</p>
                            <p class="font-medium">{{ $brand->description ?: 'Chưa có thông tin' }}</p>
                        </div>

                        <div class="mb-4">
                            <p class="text-gray-600 text-sm">Website</p>
                            @if($brand->website)
                                <p class="font-medium">
                                    <a href="{{ $brand->website }}" target="_blank" class="text-blue-600 hover:underline">
                                        {{ $brand->website }}
                                    </a>
                                </p>
                            @else
                                <p class="text-gray-500">Chưa có thông tin</p>
                            @endif
                        </div>

                        <div class="mb-4">
                            <p class="text-gray-600 text-sm">Trạng thái</p>
                            @if($brand->is_active)
                                <span class="bg-green-100 text-green-800 py-1 px-3 rounded-full text-xs">Hoạt động</span>
                            @else
                                <span class="bg-red-100 text-red-800 py-1 px-3 rounded-full text-xs">Không hoạt động</span>
                            @endif
                        </div>

                        <div class="mb-4">
                            <p class="text-gray-600 text-sm">Ngày tạo</p>
                            <p class="font-medium">{{ $brand->created_at->format('F j, Y, g:i a') }}</p>
                        </div>

                        <div class="mb-4">
                            <p class="text-gray-600 text-sm">Cập nhật lần cuối</p>
                            <p class="font-medium">{{ $brand->updated_at->format('F j, Y, g:i a') }}</p>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-xl font-bold mb-4">Hình ảnh</h3>

                        @if($brand->image)
                            <img src="{{ asset('storage/' . $brand->image) }}" alt="{{ $brand->name }}"
                                class="max-w-full h-auto rounded-lg shadow">
                        @else
                            <div class="h-48 w-full rounded-lg bg-gray-200 flex items-center justify-center">
                                <i class="fas fa-image text-gray-400 text-4xl"></i>
                            </div>
                            <p class="text-gray-500 mt-2">Chưa có hình ảnh</p>
                        @endif
                    </div>
                </div>

                <div class="mt-8">
                    <h3 class="text-xl font-bold mb-4">Sản phẩm từ thương hiệu này</h3>

                    @if($brand->products->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white">
                                <thead class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                                    <tr>
                                        <th class="py-3 px-6 text-left">ID</th>
                                        <th class="py-3 px-6 text-left">Hình ảnh</th>
                                        <th class="py-3 px-6 text-left">Tên sản phẩm</th>
                                        <th class="py-3 px-6 text-left">Giá</th>
                                        <th class="py-3 px-6 text-center">Trạng thái</th>
                                        <th class="py-3 px-6 text-center">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-600 text-sm">
                                    @foreach($brand->products as $product)
                                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                                            <td class="py-3 px-6">{{ $product->id }}</td>
                                            <td class="py-3 px-6">
                                                @if($product->image)
                                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                                        class="h-10 w-10 rounded-full object-cover">
                                                @else
                                                    <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                                        <i class="fas fa-image text-gray-400"></i>
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="py-3 px-6">{{ $product->name }}</td>
                                            <td class="py-3 px-6">${{ number_format($product->price, 2) }}</td>
                                            <td class="py-3 px-6 text-center">
                                                @if($product->is_active)
                                                    <span
                                                        class="bg-green-100 text-green-800 py-1 px-3 rounded-full text-xs">Hoạt động</span>
                                                @else
                                                    <span class="bg-red-100 text-red-800 py-1 px-3 rounded-full text-xs">Không hoạt động</span>
                                                @endif
                                            </td>
                                            <td class="py-3 px-6 text-center">
                                                <div class="flex item-center justify-center">
                                                    <a href="{{ route('admin.products.show', $product->id) }}"
                                                        class="w-4 mr-2 transform hover:text-blue-500 hover:scale-110">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.products.edit', $product->id) }}"
                                                        class="w-4 mr-2 transform hover:text-yellow-500 hover:scale-110">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-500">Chưa có sản phẩm nào từ thương hiệu này.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection