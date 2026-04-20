<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Models\Operator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KegiatanController extends Controller
{
    public function index(): View
    {
        return view('kegiatan.index', [
            'kegiatan' => Kegiatan::with('operator')->latest('id_kegiatan')->get(),
        ]);
    }

    public function create(): View
    {
        return view('kegiatan.create', [
            'kegiatan' => new Kegiatan(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);
        $data['id'] = $this->resolveCurrentOperator($request)->id;

        Kegiatan::create($data);

        return redirect()
            ->route('kegiatan.index')
            ->with('success', 'Kegiatan berhasil ditambahkan.');
    }

    public function edit(Kegiatan $kegiatan): View
    {
        return view('kegiatan.edit', [
            'kegiatan' => $kegiatan,
        ]);
    }

    public function update(Request $request, Kegiatan $kegiatan): RedirectResponse
    {
        $data = $this->validatedData($request);
        $data['id'] = $this->resolveCurrentOperator($request)->id;

        $kegiatan->update($data);

        return redirect()
            ->route('kegiatan.index')
            ->with('success', 'Kegiatan berhasil diperbarui.');
    }

    public function destroy(Kegiatan $kegiatan): RedirectResponse
    {
        $kegiatan->delete();

        return redirect()
            ->route('kegiatan.index')
            ->with('success', 'Kegiatan berhasil dihapus.');
    }

    /**
     * @return array<string, string>
     */
    protected function validatedData(Request $request): array
    {
        return $request->validate([
            'nama_kegiatan' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string'],
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