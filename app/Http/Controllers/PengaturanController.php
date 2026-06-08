<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PengaturanController extends Controller
{
    public function index()
    {
        return view('dashboard.pengaturan');;
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            'jurusan' => 'nullable|string|max:255',
            'foto'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'name.required'  => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.unique'   => 'Email sudah digunakan akun lain.',
            'foto.image'     => 'File harus berupa gambar.',
            'foto.max'       => 'Ukuran foto maksimal 2MB.',
        ]);

        // Handle upload foto baru
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($user->foto) {
                Storage::disk('public')->delete($user->foto);
            }
            $path = $request->file('foto')->store('foto-profil', 'public');
            $user->foto = $path;
        }

        // Handle hapus foto
        if ($request->input('hapus_foto') == '1' && $user->foto) {
            Storage::disk('public')->delete($user->foto);
            $user->foto = null;
        }

        $user->name    = $request->name;
        $user->email   = $request->email;
        $user->jurusan = $request->jurusan;
        $user->save();

        return back()->with('success', 'Perubahan berhasil disimpan! 🎉');
    }
}