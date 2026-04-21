<?php

namespace App\Http\Controllers;

use App\Models\Operator;
use App\Models\User;
use App\Support\FeaturePermission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function createRegistration(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()
                ->withErrors([
                    'username' => 'Username atau password tidak valid.',
                ])
                ->onlyInput('username');
        }

        $request->session()->regenerate();

        return redirect()->intended(route($request->user()->landingRouteName()));
    }

    public function storeRegistration(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'username' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users', 'username'),
                Rule::unique('operators', 'username'),
            ],
            'name' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'string', 'max:30'],
            'full_address' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = DB::transaction(function () use ($data): User {
            $permissions = FeaturePermission::defaultUserPermissions();
            $passwordHash = Hash::make($data['password']);

            $user = User::create([
                'name' => $data['name'],
                'username' => $data['username'],
                'role' => User::ROLE_USER,
                'permissions' => $permissions,
                'email' => strtolower((string) $data['username']).'@upa.local',
                'password' => $passwordHash,
            ]);

            Operator::create([
                'user_id' => $user->id,
                'name' => $data['name'],
                'username' => $data['username'],
                'password' => $passwordHash,
                'role' => User::ROLE_USER,
                'permissions' => $permissions,
                'phone_number' => $data['phone_number'],
                'full_address' => $data['full_address'],
            ]);

            return $user;
        });

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route($user->landingRouteName());
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}