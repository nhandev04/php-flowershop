@extends('layouts.admin')

@section('title', ' - View Category')

@section('content')
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">Category Details</h1>
            <div>
                <a href="{{ route('admin.categories.edit', $category->id) }}"
                    class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded mr-2">
                    <i class="fas fa-edit mr-2"></i> Edit
                </a>
                <a href="{{ route('admin.categories.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-arrow-left mr-2"></i> Back
                </a>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-xl font-bold mb-4">Basic Information</h3>

                        <div class="mb-4">
                            <p class="text-gray-600 text-sm">ID</p>
                            <p class="font-medium">{{ $category->id }}</p>
                        </div>

                        <div class="mb-4">
                            <p class="text-gray-600 text-sm">Name</p>
                            <p class="font-medium">{{ $category->name }}</p>
                        </div>

                        <div class="mb-4">
                            <p class="text-gray-600 text-sm">Description</p>
                            <p class="font-medium">{{ $category->description ?: 'Not specified' }}</p>
                        </div>

                        <div class="mb-4">
                            <p class="text-gray-600 text-sm">Sort Order</p>
                            <p class="font-medium">{{ $category->sort_order }}</p>
                        </div>

                        <div class="mb-4">
                            <p class="text-gray-600 text-sm">Status</p>
                            @if($category->is_active)
                                <span class="bg-green-100 text-green-800 py-1 px-3 rounded-full text-xs">Active</span>
                            @else
                                <span class="bg-red-100 text-red-800 py-1 px-3 rounded-full text-xs">Inactive</span>
                            @endif
                        </div>

                        <div class="mb-4">
                            <p class="text-gray-600 text-sm">Created At</p>
                            <p class="font-medium">{{ $category->created_at->format('F j, Y, g:i a') }}</p>
                        </div>

                        <div class="mb-4">
                            <p class="text-gray-600 text-sm">Last Updated</p>
                            <p class="font-medium">{{ $category->updated_at->format('F j, Y, g:i a') }}</p>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-xl font-bold mb-4">Image</h3>

                        @if($category->image)
                            <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}"
                                class="max-w-full h-auto rounded-lg shadow">
                        @else
                            <div class="h-48 w-full rounded-lg bg-gray-200 flex items-center justify-center">
                                <i class="fas fa-image text-gray-400 text-4xl"></i>
                            </div>
                            <p class="text-gray-500 mt-2">No image available</p>
                        @endif
                    </div>
                </div>

                <div class="mt-8">
                    <h3 class="text-xl font-bold mb-4">Products in this Category</h3>

                    @if($category->products->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white">
                                <thead class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                                    <tr>
                                        <th class="py-3 px-6 text-left">ID</th>
                                        <th class="py-3 px-6 text-left">Image</th>
                                        <th class="py-3 px-6 text-left">Name</th>
                                        <th class="py-3 px-6 text-left">Price</th>
                                        <th class="py-3 px-6 text-center">Status</th>
                                        <th class="py-3 px-6 text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-600 text-sm">
                                    @foreach($category->products as $product)
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
                                                        class="bg-green-100 text-green-800 py-1 px-3 rounded-full text-xs">Active</span>
                                                @else
                                                    <span class="bg-red-100 text-red-800 py-1 px-3 rounded-full text-xs">Inactive</span>
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
                        <p class="text-gray-500">No products in this category yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection