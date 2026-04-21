<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Models\Operator;
use App\Models\Pengumuman;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PengumumanController extends Controller
{
    public function index(): View
    {
        return view('pengumuman.index', [
            'pengumuman' => Pengumuman::with('operator')->latest('id_pengumuman')->get(),
        ]);
    }

    public function create(Request $request): View|RedirectResponse
    {
        return view('pengumuman.create', [
            'pengumuman' => new Pengumuman(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);
        $data['id_operator'] = $this->resolveCurrentOperator($request)->id;

        Pengumuman::create($data);

        return redirect()
            ->route('pengumuman.index')
            ->with('success', 'Pengumuman berhasil ditambahkan.');
    }

    public function edit(Request $request, Pengumuman $pengumuman): View|RedirectResponse
    {
        return view('pengumuman.edit', [
            'pengumuman' => $pengumuman,
        ]);
    }

    public function update(Request $request, Pengumuman $pengumuman): RedirectResponse
    {
        $data = $this->validatedData($request);
        $data['id_operator'] = $this->resolveCurrentOperator($request)->id;

        $pengumuman->update($data);

        return redirect()
            ->route('pengumuman.index')
            ->with('success', 'Pengumuman berhasil diperbarui.');
    }

    public function destroy(Request $request, Pengumuman $pengumuman): RedirectResponse
    {
        $pengumuman->delete();

        return redirect()
            ->route('pengumuman.index')
            ->with('success', 'Pengumuman berhasil dihapus.');
    }

    public function uploadImage(Request $request): JsonResponse
    {
        if (! $request->user()?->hasFeatureAccess('pengumuman.create') && ! $request->user()?->hasFeatureAccess('pengumuman.edit')) {
            return response()->json([
                'message' => 'Anda tidak memiliki akses untuk mengunggah gambar pada pengumuman.',
            ], 403);
        }

        $data = $request->validate([
            'upload' => ['required', 'image', 'max:2048'],
        ]);

        $path = $data['upload']->store('pengumuman', 'public');

        return response()->json([
            'url' => asset('storage/'.$path),
        ]);
    }

    /**
     * @return array<string, string>
     */
    protected function validatedData(Request $request): array
    {
        return $request->validate([
            'berita' => ['required', 'string'],
        ]);
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
            'phone_number' => '-',
            'full_address' => 'Belum diisi',
        ]);
    }

}