<?php

namespace App\Http\Controllers;

use App\Models\FotoKegiatan;
use App\Models\Kegiatan;
use App\Models\Operator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class FotoKegiatanController extends Controller
{
    public function index(): View
    {
        return view('foto-kegiatan.index', [
            'fotoKegiatan' => FotoKegiatan::with(['kegiatan', 'operator'])
                ->latest('id_foto_kegiatan')
                ->get(),
        ]);
    }

    public function create(): View
    {
        return view('foto-kegiatan.create', [
            'fotoKegiatan' => new FotoKegiatan(),
            'kegiatanList' => Kegiatan::orderBy('nama_kegiatan')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request, false);
        $data['foto'] = $request->file('foto')->store('foto-kegiatan', 'public');
        $data['created_by'] = $this->resolveCurrentOperator($request)->id;

        FotoKegiatan::create($data);

        return redirect()
            ->route('foto-kegiatan.index')
            ->with('success', 'Foto kegiatan berhasil ditambahkan.');
    }

    public function edit(FotoKegiatan $fotoKegiatan): View
    {
        return view('foto-kegiatan.edit', [
            'fotoKegiatan' => $fotoKegiatan,
            'kegiatanList' => Kegiatan::orderBy('nama_kegiatan')->get(),
        ]);
    }

    public function update(Request $request, FotoKegiatan $fotoKegiatan): RedirectResponse
    {
        $data = $this->validatedData($request, true);

        if ($request->hasFile('foto')) {
            if ($fotoKegiatan->foto) {
                Storage::disk('public')->delete($fotoKegiatan->foto);
            }

            $data['foto'] = $request->file('foto')->store('foto-kegiatan', 'public');
        }

        $fotoKegiatan->update($data);

        return redirect()
            ->route('foto-kegiatan.index')
            ->with('success', 'Foto kegiatan berhasil diperbarui.');
    }

    public function destroy(FotoKegiatan $fotoKegiatan): RedirectResponse
    {
        if ($fotoKegiatan->foto) {
            Storage::disk('public')->delete($fotoKegiatan->foto);
        }

        $fotoKegiatan->delete();

        return redirect()
            ->route('foto-kegiatan.index')
            ->with('success', 'Foto kegiatan berhasil dihapus.');
    }

    /**
     * @return array<string, mixed>
     */
    protected function validatedData(Request $request, bool $isUpdate): array
    {
        return $request->validate([
            'id_kegiatan' => ['required', 'exists:kegiatan,id_kegiatan'],
            'foto' => [$isUpdate ? 'nullable' : 'required', 'image', 'max:1024'],
            'keterangan' => ['required', 'string'],
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
            'permissions' => $user->permissions,
            'phone_number' => '-',
            'full_address' => 'Belum diisi',
        ]);
    }
}