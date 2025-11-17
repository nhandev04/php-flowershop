@extends('layouts.client')

@section('title', $blog->title)

@section('content')
    <!-- Breadcrumb -->
    <div class="bg-gray-100 dark:bg-gray-800 py-4">
        <div class="container mx-auto px-4">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('home') }}" class="text-gray-700 dark:text-gray-300 hover:text-pink-600 dark:hover:text-pink-400">
                            <i class="fas fa-home mr-2"></i>
                            Trang chủ
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                            <a href="{{ route('blogs.index') }}" class="text-gray-700 dark:text-gray-300 hover:text-pink-600 dark:hover:text-pink-400">
                                Tin tức
                            </a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                            <span class="text-gray-500 dark:text-gray-400">{{ Str::limit($blog->title, 50) }}</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <!-- Article -->
            <article class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden mb-8">
                <!-- Featured Image -->
                @if($blog->image)
                    <div class="w-full">
                        <img src="{{ asset('storage/' . $blog->image) }}" alt="{{ $blog->title }}"
                            class="w-full h-auto max-h-96 object-cover">
                    </div>
                @endif

                <!-- Content -->
                <div class="p-8">
                    <!-- Meta -->
                    <div class="flex items-center text-sm text-gray-500 dark:text-gray-400 mb-6">
                        <i class="fas fa-calendar-alt mr-2"></i>
                        {{ $blog->created_at->format('d/m/Y') }}
                        <span class="mx-3">•</span>
                        <i class="fas fa-clock mr-2"></i>
                        {{ ceil(str_word_count($blog->content) / 200) }} phút đọc
                    </div>

                    <!-- Title -->
                    <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-6">{{ $blog->title }}</h1>

                    <!-- Content -->
                    <div class="prose prose-lg dark:prose-invert max-w-none">
                        <div class="text-gray-700 dark:text-gray-300 leading-relaxed whitespace-pre-line">{{ $blog->content }}</div>
                    </div>

                    <!-- Share Section -->
                    <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Chia sẻ bài viết</h3>
                        <div class="flex gap-3">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('blogs.show', $blog)) }}" 
                                target="_blank"
                                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-200">
                                <i class="fab fa-facebook-f mr-2"></i>
                                Facebook
                            </a>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('blogs.show', $blog)) }}&text={{ urlencode($blog->title) }}" 
                                target="_blank"
                                class="px-4 py-2 bg-sky-500 hover:bg-sky-600 text-white rounded-lg transition-colors duration-200">
                                <i class="fab fa-twitter mr-2"></i>
                                Twitter
                            </a>
                            <button onclick="copyToClipboard()" 
                                class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition-colors duration-200">
                                <i class="fas fa-link mr-2"></i>
                                Sao chép link
                            </button>
                        </div>
                    </div>
                </div>
            </article>

            <!-- Recent Posts -->
            @if($recentBlogs->count() > 0)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Bài viết liên quan</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @foreach($recentBlogs as $recentBlog)
                            <article class="group">
                                <a href="{{ route('blogs.show', $recentBlog) }}" class="block">
                                    @if($recentBlog->image)
                                        <div class="overflow-hidden rounded-lg mb-3">
                                            <img src="{{ asset('storage/' . $recentBlog->image) }}" 
                                                alt="{{ $recentBlog->title }}"
                                                class="w-full h-40 object-cover group-hover:scale-110 transition-transform duration-300">
                                        </div>
                                    @else
                                        <div class="w-full h-40 bg-gray-200 dark:bg-gray-700 rounded-lg flex items-center justify-center mb-3">
                                            <i class="fas fa-image text-gray-400 text-3xl"></i>
                                        </div>
                                    @endif
                                    <div class="text-sm text-gray-500 dark:text-gray-400 mb-2">
                                        <i class="fas fa-calendar-alt mr-1"></i>
                                        {{ $recentBlog->created_at->format('d/m/Y') }}
                                    </div>
                                    <h3 class="font-bold text-gray-900 dark:text-white group-hover:text-pink-600 dark:group-hover:text-pink-400 transition-colors duration-200 line-clamp-2">
                                        {{ $recentBlog->title }}
                                    </h3>
                                </a>
                            </article>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Back to Blog List -->
            <div class="mt-8 text-center">
                <a href="{{ route('blogs.index') }}"
                    class="inline-flex items-center px-6 py-3 bg-pink-600 hover:bg-pink-700 text-white font-medium rounded-lg transition-colors duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Quay lại danh sách tin tức
                </a>
            </div>
        </div>
    </div>

    <script>
        function copyToClipboard() {
            const url = window.location.href;
            navigator.clipboard.writeText(url).then(() => {
                alert('Đã sao chép link vào clipboard!');
            }).catch(err => {
                console.error('Lỗi khi sao chép:', err);
            });
        }
    </script>
@endsection
