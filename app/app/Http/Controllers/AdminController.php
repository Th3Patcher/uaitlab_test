<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AdminController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();

        //Replace old token on new
        $token = $user->tokens()->where('name', 'API_SERVICE')->first();

        if ($token) {
            $token->delete();
        }

        return Inertia::render('Admin/Dashboard', [
            'token' => $user->createToken('API_SERVICE')->plainTextToken
        ]);
    }


    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->route('dashboard');
    }

    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
