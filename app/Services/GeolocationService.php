<?php
// app/Services/GeolocationService.php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use App\Models\Setting;

class GeolocationService
{
    /**
     * Calculate distance between two coordinates using Haversine formula
     */
    public function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000; // Radius bumi dalam meter

        $latFrom = deg2rad($lat1);
        $lonFrom = deg2rad($lon1);
        $latTo = deg2rad($lat2);
        $lonTo = deg2rad($lon2);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
            cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));

        return $angle * $earthRadius;
    }

    /**
     * Check if location is within allowed radius
     */
    public function isWithinRadius($userLat, $userLon, $allowedLat, $allowedLon, $radius)
    {
        $distance = $this->calculateDistance($userLat, $userLon, $allowedLat, $allowedLon);
        return $distance <= $radius;
    }

    /**
     * Get setting value safely
     */
    private function getSettingValue($settings, $key, $default)
    {
        $setting = $settings->where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    /**
     * Get location settings
     */
    public function getLocationSettings()
    {
        return Cache::remember('location_settings', 3600, function () {
            $settings = Setting::where('group', 'location')->get();

            return [
                'latitude' => (float) $this->getSettingValue($settings, 'attendance_location_latitude', -8.224409),
                'longitude' => (float) $this->getSettingValue($settings, 'attendance_location_longitude', 114.372973),
                'radius' => (int) $this->getSettingValue($settings, 'attendance_radius_meters', 100),
                'enabled' => (bool) $this->getSettingValue($settings, 'enable_location_restriction', true),
                'location_name' => $this->getSettingValue($settings, 'location_name', 'MISNTV | Mav Entertainment Corporation')
            ];
        });
    }

    /**
     * Validate user location for attendance
     */
    public function validateLocation($userLat, $userLon)
    {
        $settings = $this->getLocationSettings();

        if (!$settings['enabled']) {
            return [
                'valid' => true,
                'message' => 'Pembatasan lokasi tidak aktif'
            ];
        }

        $isWithinRadius = $this->isWithinRadius(
            $userLat,
            $userLon,
            $settings['latitude'],
            $settings['longitude'],
            $settings['radius']
        );

        $distance = $this->calculateDistance(
            $userLat,
            $userLon,
            $settings['latitude'],
            $settings['longitude']
        );

        return [
            'valid' => $isWithinRadius,
            'distance' => round($distance, 2),
            'max_distance' => $settings['radius'],
            'required_location' => $settings['location_name'],
            'message' => $isWithinRadius
                ? "Anda berada dalam radius absensi (" . round($distance, 2) . "m dari {$settings['location_name']})"
                : "Anda berada di luar radius absensi. Jarak: " . round($distance, 2) . "m, Maksimal: {$settings['radius']}m"
        ];
    }

    /**
     * Update location settings
     */
    public function updateLocationSettings($data)
    {
        Cache::forget('location_settings');

        $settingsToUpdate = [
            'attendance_location_latitude' => $data['latitude'] ?? -8.224409,
            'attendance_location_longitude' => $data['longitude'] ?? 114.372973,
            'attendance_radius_meters' => $data['radius'] ?? 100,
            'enable_location_restriction' => $data['enabled'] ?? true,
            'location_name' => $data['location_name'] ?? 'MISNTV | Mav Entertainment Corporation'
        ];

        foreach ($settingsToUpdate as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                [
                    'value' => $value,
                    'type' => in_array($key, ['attendance_radius_meters']) ? 'number' : 'text',
                    'group' => 'location',
                    'description' => $this->getSettingDescription($key)
                ]
            );
        }

        return true;
    }

    /**
     * Get setting description
     */
    private function getSettingDescription($key)
    {
        $descriptions = [
            'attendance_location_latitude' => 'Latitude lokasi absensi',
            'attendance_location_longitude' => 'Longitude lokasi absensi',
            'attendance_radius_meters' => 'Radius absensi dalam meter',
            'enable_location_restriction' => 'Aktifkan pembatasan lokasi absensi',
            'location_name' => 'Nama lokasi absensi'
        ];

        return $descriptions[$key] ?? 'Location setting';
    }

    public function handleLocationFormSubmission($requestData)
    {
        $this->updateLocationSettings([
            'latitude' => $requestData['latitude'],
            'longitude' => $requestData['longitude'],
            'radius' => $requestData['radius'],
            'location_name' => $requestData['location_name'],
            'enabled' => isset($requestData['enabled'])
        ]);

        return $this->getLocationSettings();
    }
}
