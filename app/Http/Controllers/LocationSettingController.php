<?php

namespace App\Http\Controllers;

use App\Services\GeolocationService;
use Illuminate\Http\Request;

class LocationSettingController extends Controller
{
    protected $geolocationService;

    public function __construct(GeolocationService $geolocationService)
    {
        $this->geolocationService = $geolocationService;
    }

    public function index()
    {
        $locationSettings = $this->geolocationService->getLocationSettings();

        return view('admin.settings.location', compact('locationSettings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'radius' => 'required|integer|min:10|max:1000',
            'location_name' => 'required|string|max:255',
            'enabled' => 'boolean'
        ]);

        try {
            $this->geolocationService->updateLocationSettings([
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'radius' => $request->radius,
                'location_name' => $request->location_name,
                'enabled' => $request->has('enabled')
            ]);

            return redirect()->back()->with('success', 'Pengaturan lokasi berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui pengaturan lokasi: ' . $e->getMessage());
        }
    }

    public function testLocation(Request $request)
    {
        $request->validate([
            'test_latitude' => 'required|numeric',
            'test_longitude' => 'required|numeric'
        ]);

        $validation = $this->geolocationService->validateLocation(
            $request->test_latitude,
            $request->test_longitude
        );

        return response()->json($validation);
    }
}
