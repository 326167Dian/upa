<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Models\Kehadiran;
use App\Models\Operator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KehadiranController extends Controller
{
    public function index(): View
    {
        return view('kehadiran.index', [
            'kehadiran' => Kehadiran::with(['operator', 'kegiatan'])
                ->latest('id_kehadiran')
                ->paginate(10),
        ]);
    }

    public function create(): View
    {
        return view('kehadiran.create', [
            'kehadiran' => new Kehadiran(),
            'operators' => Operator::orderBy('name')->get(),
            'kegiatanList' => Kegiatan::orderBy('nama_kegiatan')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        Kehadiran::create($this->validatedData($request));

        return redirect()
            ->route('kehadiran.index')
            ->with('success', 'Data kehadiran berhasil ditambahkan.');
    }

    public function edit(Kehadiran $kehadiran): View
    {
        return view('kehadiran.edit', [
            'kehadiran' => $kehadiran,
            'operators' => Operator::orderBy('name')->get(),
            'kegiatanList' => Kegiatan::orderBy('nama_kegiatan')->get(),
        ]);
    }

    public function update(Request $request, Kehadiran $kehadiran): RedirectResponse
    {
        $kehadiran->update($this->validatedData($request));

        return redirect()
            ->route('kehadiran.index')
            ->with('success', 'Data kehadiran berhasil diperbarui.');
    }

    public function destroy(Kehadiran $kehadiran): RedirectResponse
    {
        $kehadiran->delete();

        return redirect()
            ->route('kehadiran.index')
            ->with('success', 'Data kehadiran berhasil dihapus.');
    }

    /**
     * @return array<string, mixed>
     */
    protected function validatedData(Request $request): array
    {
        return $request->validate([
            'id' => ['required', 'exists:operators,id'],
            'id_kegiatan' => ['required', 'exists:kegiatan,id_kegiatan'],
            'waktu' => ['required', 'date'],
            'hadir' => ['required', 'in:0,1'],
            'keterangan' => ['nullable', 'string'],
        ]);
    }
}