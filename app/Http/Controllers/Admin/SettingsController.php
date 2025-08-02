<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = [
            'site_name' => config('app.name', 'Flower Shop'),
            'site_description' => config('app.description', 'Cửa hàng hoa tươi đẹp nhất'),
            'contact_email' => config('mail.from.address', 'admin@flowershop.com'),
            'contact_phone' => config('app.contact_phone', ''),
            'address' => config('app.address', ''),
            'facebook_url' => config('app.facebook_url', ''),
            'instagram_url' => config('app.instagram_url', ''),
            'twitter_url' => config('app.twitter_url', ''),
            'maintenance_mode' => config('app.maintenance_mode', false),
            'allow_registration' => config('app.allow_registration', true),
            'items_per_page' => config('app.items_per_page', 12),
            'currency' => config('app.currency', 'VND'),
            'timezone' => config('app.timezone', 'Asia/Ho_Chi_Minh'),
        ];

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'site_name' => 'required|string|max:255',
            'site_description' => 'nullable|string|max:500',
            'contact_email' => 'required|email|max:255',
            'contact_phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'facebook_url' => 'nullable|url|max:255',
            'instagram_url' => 'nullable|url|max:255',
            'twitter_url' => 'nullable|url|max:255',
            'maintenance_mode' => 'boolean',
            'allow_registration' => 'boolean',
            'items_per_page' => 'required|integer|min:5|max:100',
            'currency' => 'required|string|max:10',
            'timezone' => 'required|string|max:50',
        ], [
            'site_name.required' => 'Tên website là bắt buộc',
            'contact_email.required' => 'Email liên hệ là bắt buộc',
            'contact_email.email' => 'Email liên hệ không hợp lệ',
            'facebook_url.url' => 'URL Facebook không hợp lệ',
            'instagram_url.url' => 'URL Instagram không hợp lệ',
            'twitter_url.url' => 'URL Twitter không hợp lệ',
            'items_per_page.required' => 'Số sản phẩm mỗi trang là bắt buộc',
            'items_per_page.integer' => 'Số sản phẩm mỗi trang phải là số',
            'items_per_page.min' => 'Số sản phẩm mỗi trang tối thiểu là 5',
            'items_per_page.max' => 'Số sản phẩm mỗi trang tối đa là 100',
            'currency.required' => 'Đơn vị tiền tệ là bắt buộc',
            'timezone.required' => 'Múi giờ là bắt buộc',
        ]);

        // Store settings in cache for quick access
        $settings = $request->only([
            'site_name',
            'site_description',
            'contact_email',
            'contact_phone',
            'address',
            'facebook_url',
            'instagram_url',
            'twitter_url',
            'maintenance_mode',
            'allow_registration',
            'items_per_page',
            'currency',
            'timezone'
        ]);

        // Convert checkboxes to boolean
        $settings['maintenance_mode'] = $request->has('maintenance_mode');
        $settings['allow_registration'] = $request->has('allow_registration');

        foreach ($settings as $key => $value) {
            Cache::forever("setting.{$key}", $value);
        }

        // Update app config temporarily (in production, you might want to write to a config file)
        Config::set('app.name', $settings['site_name']);
        Config::set('app.description', $settings['site_description']);
        Config::set('mail.from.address', $settings['contact_email']);

        return redirect()->route('admin.settings.index')->with('success', 'Cài đặt đã được cập nhật thành công!');
    }

    public function clearCache()
    {
        Cache::flush();

        return redirect()->route('admin.settings.index')->with('success', 'Cache đã được xóa thành công!');
    }
}
