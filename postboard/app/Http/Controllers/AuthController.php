<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Step 1: Validate input
        $request->validate([
            'login' => 'required|string',
            'password' => 'required',
        ]);

        // Step 2: Determine if login is email or username
        $loginField = filter_var($request->login, FILTER_VALIDATE_EMAIL)
            ? 'email'
            : 'username';

        // Step 3: Find active user
        $user = User::where($loginField, $request->login)
            ->where('is_active', true)
            ->first();

        // Step 4: Verify credentials
        if (! $user || ! Hash::check($request->password, $user->password)) {
            return back()
                ->withErrors(['login' => 'Invalid credentials'])
                ->withInput();
        }

        // Step 5: Login user (session)
        Auth::guard('web')->login($user);


        return redirect()->route('posts.index');
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:users,email',
            'username' => 'required|string|max:255|unique:users,username',
            'phone_number' => 'required|string|max:20|unique:users,phone_number',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'email' => $validated['email'],
            'username' => $validated['username'],
            'phone_number' => $validated['phone_number'],
            'password' => Hash::make($validated['password']),
            'is_active' => true,
        ]);

        Auth::guard('web')->login($user);

        return redirect()->route('posts.index');
    }

    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $token = Str::random(64);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'token' => $token,
                'created_at' => Carbon::now(),
            ]
        );
        // Temporary: redirect directly to reset page
        return redirect()
            ->route('password.reset', $token)
            ->with('success', 'Reset link generated');
    }

    public function showResetForm($token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|confirmed|min:6',
            'token' => 'required',
        ]);

        $record = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (! $record) {
            return back()->withErrors(['email' => 'Invalid reset token']);
        }

        User::where('email', $request->email)
            ->update([
                'password' => Hash::make($request->password),
            ]);

        DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->delete();

        return redirect()->route('login')->with('success', 'Password reset succesfully');
    }
}
