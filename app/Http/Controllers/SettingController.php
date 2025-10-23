<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::orderBy('group')->orderBy('key')->get();
        $groups = $settings->groupBy('group');

        return view('settings.index', compact('settings', 'groups'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'settings' => 'required|array',
            'settings.*' => 'nullable'
        ]);

        foreach ($validated['settings'] as $key => $value) {
            Setting::setValue($key, $value ?? '');
        }

        return redirect()->route('settings.index')
            ->with('success', 'Pengaturan berhasil diperbarui!');
    }

    public function getSetting($key, $default = null)
    {
        return Setting::getValue($key, $default);
    }
}
