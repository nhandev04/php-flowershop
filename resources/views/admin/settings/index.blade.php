@extends('layouts.admin')

@section('title', ' - Cài đặt hệ thống')
@section('page-title', 'Cài đặt hệ thống')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Cài đặt hệ thống</h1>
                <p class="text-gray-600 dark:text-gray-400">Quản lý cấu hình và tùy chọn hệ thống</p>
            </div>
            <div class="flex gap-3">
                <form action="{{ route('admin.settings.clear-cache') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-orange-600 hover:bg-orange-700 text-white font-medium rounded-lg transition-colors duration-200"
                        onclick="return confirm('Bạn có chắc chắn muốn xóa cache?')">
                        <i class="fas fa-trash mr-2"></i>
                        Xóa Cache
                    </button>
                </form>
            </div>
        </div>

        <!-- Settings Form -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-gradient-to-r from-green-500 to-blue-600 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-cog text-white"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Cấu hình hệ thống</h2>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Tùy chỉnh các thiết lập cho website</p>
                    </div>
                </div>
            </div>
            <div class="p-6">
                @if ($errors->any())
                    <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4 mb-6">
                        <div class="flex items-center mb-2">
                            <i class="fas fa-exclamation-triangle text-red-500 mr-2"></i>
                            <h3 class="text-red-800 dark:text-red-200 font-medium">Có lỗi xảy ra:</h3>
                        </div>
                        <ul class="text-red-700 dark:text-red-300 text-sm space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>• {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-8">
                    @csrf
                    @method('PUT')

                    <!-- Website Information -->
                    <div class="space-y-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-2">
                            <i class="fas fa-globe mr-2 text-blue-500"></i>
                            Thông tin website
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Site Name -->
                            <div>
                                <label for="site_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Tên website <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                    class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-colors duration-200 @error('site_name') !border-red-500 dark:!border-red-500 @enderror" 
                                    id="site_name" name="site_name" value="{{ old('site_name', $settings['site_name']) }}" required>
                                @error('site_name')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Currency -->
                            <div>
                                <label for="currency" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Đơn vị tiền tệ <span class="text-red-500">*</span>
                                </label>
                                <select 
                                    class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-colors duration-200 @error('currency') !border-red-500 dark:!border-red-500 @enderror" 
                                    id="currency" name="currency" required>
                                    <option value="VND" {{ old('currency', $settings['currency']) == 'VND' ? 'selected' : '' }}>VND - Việt Nam Đồng</option>
                                    <option value="USD" {{ old('currency', $settings['currency']) == 'USD' ? 'selected' : '' }}>USD - US Dollar</option>
                                    <option value="EUR" {{ old('currency', $settings['currency']) == 'EUR' ? 'selected' : '' }}>EUR - Euro</option>
                                </select>
                                @error('currency')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Site Description -->
                            <div class="md:col-span-2">
                                <label for="site_description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Mô tả website
                                </label>
                                <textarea 
                                    class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-colors duration-200 @error('site_description') !border-red-500 dark:!border-red-500 @enderror" 
                                    id="site_description" name="site_description" rows="3">{{ old('site_description', $settings['site_description']) }}</textarea>
                                @error('site_description')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="space-y-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-2">
                            <i class="fas fa-phone mr-2 text-green-500"></i>
                            Thông tin liên hệ
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Contact Email -->
                            <div>
                                <label for="contact_email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Email liên hệ <span class="text-red-500">*</span>
                                </label>
                                <input type="email" 
                                    class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-colors duration-200 @error('contact_email') !border-red-500 dark:!border-red-500 @enderror" 
                                    id="contact_email" name="contact_email" value="{{ old('contact_email', $settings['contact_email']) }}" required>
                                @error('contact_email')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Contact Phone -->
                            <div>
                                <label for="contact_phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Số điện thoại liên hệ
                                </label>
                                <input type="tel" 
                                    class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-colors duration-200 @error('contact_phone') !border-red-500 dark:!border-red-500 @enderror" 
                                    id="contact_phone" name="contact_phone" value="{{ old('contact_phone', $settings['contact_phone']) }}">
                                @error('contact_phone')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Address -->
                            <div class="md:col-span-2">
                                <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Địa chỉ
                                </label>
                                <textarea 
                                    class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-colors duration-200 @error('address') !border-red-500 dark:!border-red-500 @enderror" 
                                    id="address" name="address" rows="3">{{ old('address', $settings['address']) }}</textarea>
                                @error('address')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Social Media -->
                    <div class="space-y-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-2">
                            <i class="fas fa-share-alt mr-2 text-purple-500"></i>
                            Mạng xã hội
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Facebook -->
                            <div>
                                <label for="facebook_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Facebook URL
                                </label>
                                <input type="url" 
                                    class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-colors duration-200 @error('facebook_url') !border-red-500 dark:!border-red-500 @enderror" 
                                    id="facebook_url" name="facebook_url" value="{{ old('facebook_url', $settings['facebook_url']) }}">
                                @error('facebook_url')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Instagram -->
                            <div>
                                <label for="instagram_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Instagram URL
                                </label>
                                <input type="url" 
                                    class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-colors duration-200 @error('instagram_url') !border-red-500 dark:!border-red-500 @enderror" 
                                    id="instagram_url" name="instagram_url" value="{{ old('instagram_url', $settings['instagram_url']) }}">
                                @error('instagram_url')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Twitter -->
                            <div>
                                <label for="twitter_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Twitter URL
                                </label>
                                <input type="url" 
                                    class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-colors duration-200 @error('twitter_url') !border-red-500 dark:!border-red-500 @enderror" 
                                    id="twitter_url" name="twitter_url" value="{{ old('twitter_url', $settings['twitter_url']) }}">
                                @error('twitter_url')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- System Settings -->
                    <div class="space-y-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-2">
                            <i class="fas fa-cogs mr-2 text-orange-500"></i>
                            Cài đặt hệ thống
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Items per page -->
                            <div>
                                <label for="items_per_page" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Số sản phẩm mỗi trang <span class="text-red-500">*</span>
                                </label>
                                <input type="number" min="5" max="100"
                                    class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-colors duration-200 @error('items_per_page') !border-red-500 dark:!border-red-500 @enderror" 
                                    id="items_per_page" name="items_per_page" value="{{ old('items_per_page', $settings['items_per_page']) }}" required>
                                @error('items_per_page')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Timezone -->
                            <div>
                                <label for="timezone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Múi giờ <span class="text-red-500">*</span>
                                </label>
                                <select 
                                    class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-colors duration-200 @error('timezone') !border-red-500 dark:!border-red-500 @enderror" 
                                    id="timezone" name="timezone" required>
                                    <option value="Asia/Ho_Chi_Minh" {{ old('timezone', $settings['timezone']) == 'Asia/Ho_Chi_Minh' ? 'selected' : '' }}>Asia/Ho_Chi_Minh</option>
                                    <option value="Asia/Bangkok" {{ old('timezone', $settings['timezone']) == 'Asia/Bangkok' ? 'selected' : '' }}>Asia/Bangkok</option>
                                    <option value="UTC" {{ old('timezone', $settings['timezone']) == 'UTC' ? 'selected' : '' }}>UTC</option>
                                </select>
                                @error('timezone')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Toggle Settings -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <div>
                                    <label for="maintenance_mode" class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Chế độ bảo trì
                                    </label>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Tạm khóa website để bảo trì</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" id="maintenance_mode" name="maintenance_mode" value="1" 
                                        {{ old('maintenance_mode', $settings['maintenance_mode']) ? 'checked' : '' }}
                                        class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-300 dark:peer-focus:ring-green-800 rounded-full peer dark:bg-gray-600 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-600"></div>
                                </label>
                            </div>
                            <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <div>
                                    <label for="allow_registration" class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Cho phép đăng ký
                                    </label>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Cho phép người dùng tạo tài khoản mới</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" id="allow_registration" name="allow_registration" value="1" 
                                        {{ old('allow_registration', $settings['allow_registration']) ? 'checked' : '' }}
                                        class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-300 dark:peer-focus:ring-green-800 rounded-full peer dark:bg-gray-600 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-600"></div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <button type="submit" 
                            class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-green-500 to-blue-600 hover:from-green-600 hover:to-blue-700 text-white font-medium rounded-lg shadow-sm hover:shadow-md transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                            <i class="fas fa-save mr-2"></i>
                            Lưu cài đặt
                        </button>
                        <button type="reset" 
                            class="inline-flex items-center justify-center px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg shadow-sm hover:shadow-md transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                            <i class="fas fa-undo mr-2"></i>
                            Đặt lại
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    // Add loading state to submit button
    document.querySelector('button[type="submit"]').addEventListener('click', function() {
        const btn = this;
        const originalHTML = btn.innerHTML;
        
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Đang lưu...';
        
        // Re-enable after 5 seconds to prevent permanent lock
        setTimeout(() => {
            btn.disabled = false;
            btn.innerHTML = originalHTML;
        }, 5000);
    });

    // Preview settings changes
    document.getElementById('site_name').addEventListener('input', function() {
        // Could update a preview here
        console.log('Site name changed to:', this.value);
    });

    // Validate URLs
    const urlInputs = ['facebook_url', 'instagram_url', 'twitter_url'];
    urlInputs.forEach(inputId => {
        const input = document.getElementById(inputId);
        if (input) {
            input.addEventListener('blur', function() {
                if (this.value && !this.value.startsWith('http')) {
                    this.value = 'https://' + this.value;
                }
            });
        }
    });
</script>
@endsection
