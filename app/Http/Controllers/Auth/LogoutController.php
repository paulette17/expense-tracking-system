<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    public function logout(Request $request)
    {
        //  Log the user out
        Auth::logout();

        //  Invalidate the session
        $request->session()->invalidate();

        //  Regenerate CSRF token
        $request->session()->regenerateToken();

        // Redirect to login or homepage
        return redirect('/');
    }
}
