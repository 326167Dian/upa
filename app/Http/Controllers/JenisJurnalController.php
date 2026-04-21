<?php

namespace App\Http\Controllers;

use App\Models\JenisJurnal;
use App\Models\Operator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class JenisJurnalController extends Controller
{
    public function index(Request $request): View|RedirectResponse
    {
        return view('jurnal-kas.jenis.index', [
            'types' => JenisJurnal::query()->orderBy('idjenis')->get(),
        ]);
    }

    public function create(Request $request): View|RedirectResponse
    {
        return view('jurnal-kas.jenis.create', [
            'type' => new JenisJurnal(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $operator = $this->resolveCurrentOperator($request);
        $data = $this->validatedData($request);

        JenisJurnal::create([
            ...$data,
            'created_by' => now(),
            'update_at' => $operator->id,
        ]);

        return redirect()
            ->route('jurnal-kas.types.index')
            ->with('success', 'Jenis transaksi berhasil ditambahkan.');
    }

    public function edit(Request $request, JenisJurnal $type): View|RedirectResponse
    {
        return view('jurnal-kas.jenis.edit', [
            'type' => $type,
        ]);
    }

    public function update(Request $request, JenisJurnal $type): RedirectResponse
    {
        $operator = $this->resolveCurrentOperator($request);
        $type->update([
            ...$this->validatedData($request, $type),
            'update_at' => $operator->id,
        ]);

        return redirect()
            ->route('jurnal-kas.types.index')
            ->with('success', 'Jenis transaksi berhasil diperbarui.');
    }

    public function destroy(Request $request, JenisJurnal $type): RedirectResponse
    {
        if ($type->jurnal()->exists()) {
            return redirect()
                ->route('jurnal-kas.types.index')
                ->with('error', 'Jenis transaksi tidak dapat dihapus karena sudah dipakai pada jurnal.');
        }

        $type->delete();

        return redirect()
            ->route('jurnal-kas.types.index')
            ->with('success', 'Jenis transaksi berhasil dihapus.');
    }

    protected function validatedData(Request $request, ?JenisJurnal $type = null): array
    {
        return $request->validate([
            'nm_jurnal' => ['required', 'string', 'max:100', Rule::unique('jenis_jurnal', 'nm_jurnal')->ignore($type?->idjenis, 'idjenis')],
            'tipe' => ['required', Rule::in([1, 2])],
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