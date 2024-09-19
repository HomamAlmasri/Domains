<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{

    public function create():View
    {

        return view('login');
    }
    public function store(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->validated();

        if (!Auth::attempt($credentials)) {
            logger()->warning('Failed login attempt', ['email' => $credentials['email']]);

            return redirect()->back()->withErrors([
                'email' => 'Email or password is incorrect.'
            ])->withInput();
        }

        $request->session()->regenerate();

        return redirect()->intended('/domains');
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
