<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http; // <-- Wajib ditambahkan
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // 1. Cek apakah user sudah mencentang captcha sebelum tembak API Google
        $request->validate([
            'g-recaptcha-response' => ['required'],
        ], [
            'g-recaptcha-response.required' => 'Silakan centang verifikasi reCAPTCHA terlebih dahulu.',
        ]);

        // 2. Verifikasi token ke server Google menggunakan config()
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => config('services.recaptcha.secret_key'),
            'response' => $request->input('g-recaptcha-response'),
            'remoteip' => $request->ip(),
        ]);

        if (! ($response->json()['success'] ?? false)) {
            return back()->withErrors([
                'g-recaptcha-response' => 'Verifikasi reCAPTCHA gagal atau kedaluwarsa. Coba lagi.',
            ])->withInput($request->only('email', 'remember'));
        }

        // 3. Lanjut proses autentikasi Laravel Breeze
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended('/');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}