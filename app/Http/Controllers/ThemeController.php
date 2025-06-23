<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ThemeController extends Controller
{
    public function index()
    {
        $preferences = auth()->user()->preference;
        return view('dashboard.theme.index', compact('preferences'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'accent_color' => 'nullable|string',
            'font' => 'nullable|string',
            'theme_mode' => 'nullable|in:light,dark,auto',
            'font_size' => 'nullable|in:text-sm,text-base,text-lg,text-xl',
            'logo_image' => 'nullable|image|max:2048',
            'profile_image' => 'nullable|image|max:2048',
            'background_color' => 'nullable|string',
            'table_header_color' => 'nullable|string',
        ]);

        if ($request->hasFile('logo_image')) {
            $path = $request->file('logo_image')->store('logos', 'public');
            $data['logo_image'] = basename($path);
        }

        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('profiles', 'public');
            $data['profile_image'] = basename($path);
        }

        auth()->user()->preference()->updateOrCreate([], $data);

        return redirect()->back()->with('success', 'Preferencias actualizadas correctamente.');
    }

    public function removeLogo()
    {
        $preferences = auth()->user()->preference;
        if ($preferences && $preferences->logo_image) {
            Storage::disk('public')->delete('logos/' . $preferences->logo_image);
            $preferences->update(['logo_image' => null]);
        }

        return redirect()->back()->with('success', 'Logo eliminado correctamente.');
    }

    public function removeProfile()
    {
        $preferences = auth()->user()->preference;
        if ($preferences && $preferences->profile_image) {
            Storage::disk('public')->delete('profiles/' . $preferences->profile_image);
            $preferences->update(['profile_image' => null]);
        }

        return redirect()->back()->with('success', 'Imagen de perfil eliminada correctamente.');
    }
}
