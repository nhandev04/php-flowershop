@extends('layouts.admin')

@section('title', ' - Chi tiết tin tức')
@section('page-title', 'Chi tiết tin tức')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Chi tiết tin tức</h1>
                <p class="text-gray-600 dark:text-gray-400">Xem thông tin chi tiết bài viết</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('admin.blogs.edit', $blog) }}"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition-colors duration-200">
                    <i class="fas fa-edit mr-2"></i>
                    Sửa
                </a>
                <a href="{{ route('admin.blogs.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Quay lại
                </a>
            </div>
        </div>

        <!-- Blog Details Card -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div
                            class="w-10 h-10 bg-gradient-to-r from-green-500 to-blue-600 rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-newspaper text-white"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">{{ $blog->title }}</h2>
                            <p class="text-sm text-gray-600 dark:text-gray-400">ID: #{{ $blog->id }}</p>
                        </div>
                    </div>
                    @if($blog->is_active)
                        <span class="px-3 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">
                            Hoạt động
                        </span>
                    @else
                        <span class="px-3 py-1 text-sm font-semibold rounded-full bg-red-100 text-red-800">
                            Không hoạt động
                        </span>
                    @endif
                </div>
            </div>

            <div class="p-6 space-y-6">
                <!-- Image -->
                @if($blog->image)
                    <div>
                        <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Hình ảnh</h3>
                        <img src="{{ asset('storage/' . $blog->image) }}" alt="{{ $blog->title }}" class="rounded-lg max-w-2xl">
                    </div>
                @endif

                <!-- Title -->
                <div>
                    <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tiêu đề</h3>
                    <p class="text-gray-900 dark:text-gray-100 text-lg">{{ $blog->title }}</p>
                </div>

                <!-- Content -->
                <div>
                    <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nội dung</h3>
                    <div
                        class="text-gray-900 dark:text-gray-100 whitespace-pre-line bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                        {{ $blog->content }}</div>
                </div>

                <!-- Meta Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <div>
                        <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Ngày tạo</h3>
                        <p class="text-gray-900 dark:text-gray-100">{{ $blog->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Cập nhật lần cuối</h3>
                        <p class="text-gray-900 dark:text-gray-100">{{ $blog->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex gap-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('admin.blogs.edit', $blog) }}"
                        class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition-colors duration-200">
                        <i class="fas fa-edit mr-2"></i>
                        Sửa tin tức
                    </a>
                    <form action="{{ route('admin.blogs.destroy', $blog) }}" method="POST"
                        onsubmit="return confirm('Bạn có chắc chắn muốn xóa tin tức này?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="px-6 py-2.5 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors duration-200">
                            <i class="fas fa-trash mr-2"></i>
                            Xóa tin tức
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection