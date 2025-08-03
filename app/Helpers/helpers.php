<?php

use App\Models\Setting;

if (!function_exists('setting')) {
    /**
     * Get the value of a setting from the database.
     *
     * @param string $key
     * @param mixed|null $default
     * @return mixed
     */
    function setting($key, $default = null)
    {
        // Cache can be implemented here for better performance in the future
        $setting = Setting::where('key', $key)->first();
        
        return $setting ? $setting->value : $default;
    }
}