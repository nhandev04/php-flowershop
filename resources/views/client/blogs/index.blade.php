@extends('layouts.client')

@section('title', 'Tin tức')

@section('content')
    <!-- Breadcrumb -->
    <div class="bg-gray-100 dark:bg-gray-800 py-4">
        <div class="container mx-auto px-4">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('home') }}"
                            class="text-gray-700 dark:text-gray-300 hover:text-pink-600 dark:hover:text-pink-400">
                            <i class="fas fa-home mr-2"></i>
                            Trang chủ
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                            <span class="text-gray-500 dark:text-gray-400">Tin tức</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="mb-8 text-center">
            <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">Tin tức</h1>
            <p class="text-gray-600 dark:text-gray-400 text-lg">Cập nhật những tin tức mới nhất về hoa và cây cảnh</p>
        </div>

        <!-- Search Bar -->
        <div class="max-w-2xl mx-auto mb-8">
            <form method="GET" action="{{ route('blogs.index') }}" class="relative">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Tìm kiếm tin tức..."
                    class="w-full px-4 py-3 pl-12 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent dark:bg-gray-700 dark:text-white">
                <i class="fas fa-search absolute left-4 top-4 text-gray-400"></i>
                <button type="submit"
                    class="absolute right-2 top-2 px-4 py-2 bg-pink-600 hover:bg-pink-700 text-white rounded-lg transition-colors duration-200">
                    Tìm
                </button>
            </form>
        </div>

        <!-- Blogs Grid -->
        @if($blogs->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-8">
                @foreach($blogs as $blog)
                    <article
                        class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300">
                        <!-- Image -->
                        <a href="{{ route('blogs.show', $blog) }}" class="block overflow-hidden">
                            @if($blog->image)
                                <img src="{{ asset('storage/' . $blog->image) }}" alt="{{ $blog->title }}"
                                    class="w-full h-48 object-cover hover:scale-110 transition-transform duration-300">
                            @else
                                <div class="w-full h-48 bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                    <i class="fas fa-image text-gray-400 text-4xl"></i>
                                </div>
                            @endif
                        </a>

                        <!-- Content -->
                        <div class="p-6">
                            <div class="flex items-center text-sm text-gray-500 dark:text-gray-400 mb-3">
                                <i class="fas fa-calendar-alt mr-2"></i>
                                {{ $blog->created_at->format('d/m/Y') }}
                            </div>

                            <h2
                                class="text-xl font-bold text-gray-900 dark:text-white mb-3 hover:text-pink-600 dark:hover:text-pink-400 transition-colors duration-200">
                                <a href="{{ route('blogs.show', $blog) }}">{{ $blog->title }}</a>
                            </h2>

                            <p class="text-gray-600 dark:text-gray-400 mb-4 line-clamp-3">
                                {{ Str::limit(strip_tags($blog->content), 150) }}
                            </p>

                            <a href="{{ route('blogs.show', $blog) }}"
                                class="inline-flex items-center text-pink-600 dark:text-pink-400 hover:text-pink-700 dark:hover:text-pink-300 font-medium">
                                Đọc thêm
                                <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($blogs->hasPages())
                <div class="flex justify-center">
                    {{ $blogs->links() }}
                </div>
            @endif
        @else
            <div class="text-center py-12">
                <i class="fas fa-newspaper text-gray-400 text-6xl mb-4"></i>
                <p class="text-gray-500 dark:text-gray-400 text-xl">
                    @if(request('search'))
                        Không tìm thấy tin tức nào phù hợp với "{{ request('search') }}"
                    @else
                        Chưa có tin tức nào
                    @endif
                </p>
                @if(request('search'))
                    <a href="{{ route('blogs.index') }}" class="inline-block mt-4 text-pink-600 hover:text-pink-700">
                        Xem tất cả tin tức
                    </a>
                @endif
            </div>
        @endif
    </div>
@endsection