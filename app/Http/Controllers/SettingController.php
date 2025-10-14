<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Setting;

class SettingController extends Controller
{
    /**
     * Tampilkan halaman pengaturan.
     */
    public function index()
    {
        // Ambil semua setting dalam bentuk array key => value
        $settings = Setting::pluck('value', 'key_name')->toArray();

        return view('setting.index', compact('settings'));
    }

    /**
     * Update atau simpan pengaturan baru.
     */
    public function update(Request $request)
    {
        // Validasi input biar aman
        $request->validate([
            'pos_name' => 'nullable|string|max:100',
            'store_address' => 'nullable|string|max:255',
            'store_phone' => 'nullable|string|max:20',
            'diskon_global' => 'nullable|numeric|min:0|max:100',
            'footer_note' => 'nullable|string|max:255',
        ]);

        // Data yang akan disimpan ke tabel settings
        $settings = [
            'pos_name' => $request->pos_name,
            'store_address' => $request->store_address,
            'store_phone' => $request->store_phone,
            'diskon_global' => $request->diskon_global,
            'footer_note' => $request->footer_note,
        ];

        // Loop dan simpan satu-satu (updateOrCreate)
        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(
                ['key_name' => $key],
                ['value' => $value]
            );
        }

        return back()->with('success', 'Pengaturan berhasil diperbarui!');
    }
}
