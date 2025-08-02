<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class SettingsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Skip in console to speed up commands
        if ($this->app->runningInConsole()) {
            return;
        }

        // Try to load settings from cache or database
        try {
            // Check if settings table exists
            if (\Schema::hasTable('settings')) {
                $settings = Setting::all();

                foreach ($settings as $setting) {
                    $key = $setting->key;
                    $value = $setting->value;

                    // Store in cache
                    Cache::rememberForever("setting.{$key}", function () use ($value) {
                        return $value;
                    });

                    // Apply settings to configuration
                    switch ($key) {
                        case 'site_name':
                            Config::set('app.name', $value);
                            break;
                        case 'site_description':
                            Config::set('app.description', $value);
                            break;
                        case 'contact_email':
                            Config::set('mail.from.address', $value);
                            break;
                        case 'timezone':
                            Config::set('app.timezone', $value);
                            break;
                        case 'items_per_page':
                            Config::set('app.items_per_page', (int) $value);
                            break;
                        case 'currency':
                            Config::set('app.currency', $value);
                            break;
                        // Add more mappings as needed
                    }
                }
            }
        } catch (\Exception $e) {
            // Log the error but don't crash the application
            \Log::error('Error loading settings: ' . $e->getMessage());
        }
    }
}
