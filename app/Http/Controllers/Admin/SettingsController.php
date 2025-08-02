<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->groupBy('group');

        // Organize settings for the view
        $generalSettings = $settings->get('general', collect());
        $contactSettings = $settings->get('contact', collect());
        $socialSettings = $settings->get('social', collect());
        $appearanceSettings = $settings->get('appearance', collect());
        $storeSettings = $settings->get('store', collect());

        return view('admin.settings.index', compact(
            'generalSettings',
            'contactSettings',
            'socialSettings',
            'appearanceSettings',
            'storeSettings'
        ));
    }

    public function update(Request $request)
    {
        $inputs = $request->except('_token', '_method');

        foreach ($inputs as $key => $value) {
            // Handle boolean values from checkboxes
            if (is_string($value) && ($value === 'on' || $value === 'off')) {
                $value = ($value === 'on') ? '1' : '0';
            }

            // Get the setting and update it
            $setting = Setting::where('key', $key)->first();
            if ($setting) {
                $setting->value = $value;
                $setting->save();

                // Update cache
                Cache::forever("setting.{$key}", $value);

                // Update config for important settings
                if ($key === 'site_name') {
                    Config::set('app.name', $value);
                }
                if ($key === 'contact_email') {
                    Config::set('mail.from.address', $value);
                }
            }
        }

        return redirect()->route('admin.settings')->with('success', 'Cài đặt đã được cập nhật thành công!');
    }

    public function clearCache()
    {
        Cache::flush();

        return redirect()->route('admin.settings')->with('success', 'Cache đã được xóa thành công!');
    }

    /**
     * Reset all settings to default values
     */
    public function resetToDefaults()
    {
        // Run the settings seeder to restore defaults
        $seeder = new \Database\Seeders\SettingsSeeder();
        $seeder->run();

        // Clear cache
        Cache::flush();

        return redirect()->route('admin.settings')->with('success', 'Cài đặt đã được khôi phục về mặc định!');
    }
}
