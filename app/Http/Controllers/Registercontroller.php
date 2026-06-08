<?php
 
namespace App\Http\Controllers;
 
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
 
class RegisterController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }
 
    public function register(Request $request)
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:100'],
            'username' => [
                'required',
                'string',
                'min:3',
                'max:30',
                'unique:users,username',
                'regex:/^[a-z0-9_]+$/',
            ],
            'email'    => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(8)],
            'terms'    => ['accepted'],
        ], [
            'name.required'       => 'Nama lengkap wajib diisi.',
            'username.required'   => 'Username wajib diisi.',
            'username.min'        => 'Username minimal 3 karakter.',
            'username.max'        => 'Username maksimal 30 karakter.',
            'username.unique'     => 'Username sudah digunakan, coba yang lain.',
            'username.regex'      => 'Username hanya boleh huruf kecil, angka, dan underscore.',
            'email.required'      => 'Email wajib diisi.',
            'email.email'         => 'Format email tidak valid.',
            'email.unique'        => 'Email sudah terdaftar.',
            'password.required'   => 'Password wajib diisi.',
            'password.confirmed'  => 'Konfirmasi password tidak cocok.',
            'password.min'        => 'Password minimal 8 karakter.',
            'terms.accepted'      => 'Kamu harus menyetujui syarat & ketentuan.',
        ]);
 
        $user = User::create([
            'name'     => $request->name,
            'username' => strtolower($request->username),
            'email'    => strtolower($request->email),
            'password' => Hash::make($request->password),
            'role'     => 'student',
        ]);
 
        Auth::login($user);
 
        return redirect()->route('dashboard')->with('status', 'Akun berhasil dibuat! Selamat datang di Mappy Path 🎉');
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('landing');
    }
}