<?php

namespace App\Http\Controllers;

use App\Models\Operator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'operator' => $this->resolveCurrentOperator($request),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();
        $operator = $this->resolveCurrentOperator($request);

        $data = $request->validate([
            'avatar' => ['nullable', 'image', 'max:2048'],
            'phone_number' => ['required', 'string', 'max:30'],
            'full_address' => ['required', 'string'],
            'mulai_upa_tahun' => ['nullable', 'string', 'max:100'],
            'current_password' => ['nullable', 'required_with:password', 'current_password'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        if ($request->hasFile('avatar')) {
            if ($operator->avatar_path) {
                Storage::disk('public')->delete($operator->avatar_path);
            }

            $operator->avatar_path = $request->file('avatar')->store('avatars', 'public');
        }

        $operator->phone_number = $data['phone_number'];
        $operator->full_address = $data['full_address'];
        $operator->mulai_upa_tahun = $data['mulai_upa_tahun'] ?? null;

        if (filled($data['password'] ?? null)) {
            $passwordHash = Hash::make($data['password']);
            $user->password = $passwordHash;
            $operator->password = $passwordHash;
            $user->save();
        }

        $operator->save();

        return redirect()
            ->route('profile.edit')
            ->with('success', 'Profil berhasil diperbarui.');
    }

    protected function resolveCurrentOperator(Request $request): Operator
    {
        $user = $request->user();

        return Operator::firstOrCreate([
            'user_id' => $user->id,
        ], [
            'name' => $user->name,
            'username' => $user->username,
            'password' => $user->password,
            'role' => $user->role,
            'permissions' => $user->permissions,
            'phone_number' => '-',
            'full_address' => 'Belum diisi',
            'mulai_upa_tahun' => null,
        ]);
    }
}