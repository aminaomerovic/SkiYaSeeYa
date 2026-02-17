<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials)) {
        $user = Auth::user();

        if ($user->status !== 'approved' && !$user->isAdmin()) {
            Auth::logout();
            return back()->withErrors(['email' => 'Vaš nalog još nije odobren.']);
        }

        $request->session()->regenerate();

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->isProvider()) {
            return redirect()->route('provider.dashboard');
        } else {
            return redirect()->route('customer.dashboard');
        }
    }

    return back()->withErrors([
        'email' => 'Uneti podaci se ne poklapaju sa našim evidencijama.',
    ]);
}

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
    public function showChangePasswordForm()
{
    return view('auth.change-password');
}

public function changePassword(Request $request)
{
    $request->validate([
        'current_password' => 'required',
        'new_password' => ['required', 'confirmed', 'min:8'],
    ]);

    $user = Auth::user();

    // Proveri da li je trenutna lozinka tačna
    if (!Hash::check($request->current_password, $user->password)) {
        return back()->withErrors(['current_password' => 'Trenutna lozinka nije tačna.']);
    }

    // Proveri da li se nova lozinka razlikuje od trenutne
    if (Hash::check($request->new_password, $user->password)) {
        return back()->withErrors(['new_password' => 'Nova lozinka mora biti različita od trenutne.']);
    }

    // Promeni lozinku
    $user->password = Hash::make($request->new_password);
    $user->save();

    return redirect()->route('customer.browse')->with('success', 'Lozinka uspešno promenjena!');
}
}