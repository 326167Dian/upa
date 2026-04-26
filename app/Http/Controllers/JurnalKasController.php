<?php

namespace App\Http\Controllers;

use App\Models\Jurnal;
use App\Models\JenisJurnal;
use App\Models\Kas;
use App\Models\Operator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class JurnalKasController extends Controller
{
    public function index(): View
    {
        $currentYear = Carbon::now()->year;
        $entries = Jurnal::query()
            ->with('jenisJurnal')
            ->whereYear('tanggal', $currentYear)
            ->latest('id_jurnal')
            ->get();

        return view('jurnal-kas.index', [
            'entries' => $entries,
            'summary' => $this->buildSummary($entries),
            'currentBalance' => $this->currentKasBalance(),
            'currentYear' => $currentYear,
        ]);
    }

    public function createExpense(): View
    {
        return $this->formView(new Jurnal(), 1, 'Tambah Pengeluaran', 'jurnal-kas.expenses.store');
    }

    public function createIncome(): View
    {
        return $this->formView(new Jurnal(), 2, 'Tambah Pemasukan', 'jurnal-kas.incomes.store');
    }

    public function storeExpense(Request $request): RedirectResponse
    {
        return $this->storeEntry($request, 1);
    }

    public function storeIncome(Request $request): RedirectResponse
    {
        return $this->storeEntry($request, 2);
    }

    public function edit(Jurnal $jurnal): View
    {
        return view('jurnal-kas.edit', [
            'entry' => $jurnal,
            'transactionTypes' => JenisJurnal::query()->orderBy('nm_jurnal')->get(),
        ]);
    }

    public function update(Request $request, Jurnal $jurnal): RedirectResponse
    {
        if (! $this->canMutateEntry($request, $jurnal)) {
            return redirect()
                ->route('jurnal-kas.index')
                ->with('error', 'Jurnal hanya dapat diubah oleh operator yang terakhir menyimpan data atau admin.');
        }

        $operator = $this->resolveCurrentOperator($request);
        $data = $request->validate([
            'idjenis' => ['required', Rule::exists('jenis_jurnal', 'idjenis')],
            'ket' => ['required', 'string'],
            'carabayar' => ['required', Rule::in(['TUNAI', 'TRANSFER'])],
            'debit' => ['required', 'integer', 'min:0'],
            'kredit' => ['required', 'integer', 'min:0'],
        ]);

        DB::transaction(function () use ($jurnal, $data, $operator, $request): void {
            $jurnal->update([
                ...$data,
                'tanggal' => $jurnal->tanggal,
                'petugas' => $request->user()->name,
                'current' => now(),
                'update_at' => $operator->id,
            ]);

            $this->syncKasBalance($operator->id);
        });

        return redirect()
            ->route('jurnal-kas.index')
            ->with('success', 'Data jurnal kas berhasil diperbarui.');
    }

    public function destroy(Request $request, Jurnal $jurnal): RedirectResponse
    {
        if (! $this->canMutateEntry($request, $jurnal)) {
            return redirect()
                ->route('jurnal-kas.index')
                ->with('error', 'Jurnal hanya dapat dihapus oleh operator yang terakhir menyimpan data atau admin.');
        }

        $operator = $this->resolveCurrentOperator($request);

        DB::transaction(function () use ($jurnal, $operator): void {
            $jurnal->delete();
            $this->syncKasBalance($operator->id);
        });

        return redirect()
            ->route('jurnal-kas.index')
            ->with('success', 'Data jurnal kas berhasil dihapus.');
    }

    public function reportFilter(Request $request): View|RedirectResponse
    {
        return view('jurnal-kas.report-filter');
    }

    public function report(Request $request): View|RedirectResponse
    {
        $data = $request->validate([
            'tgl_awal' => ['required', 'date'],
            'tgl_akhir' => ['required', 'date', 'after_or_equal:tgl_awal'],
        ]);

        $entries = $this->betweenDatesQuery($data['tgl_awal'], $data['tgl_akhir'])
            ->get();

        return view('jurnal-kas.report', [
            'entries' => $entries,
            'summary' => $this->buildSummary($entries),
            'startDate' => Carbon::parse($data['tgl_awal']),
            'endDate' => Carbon::parse($data['tgl_akhir']),
        ]);
    }

    public function recapFilter(Request $request): View|RedirectResponse
    {
        return view('jurnal-kas.recap-filter');
    }

    public function recap(Request $request): View|RedirectResponse
    {
        $data = $request->validate([
            'tgl_awal' => ['required', 'date'],
            'tgl_akhir' => ['required', 'date', 'after_or_equal:tgl_awal'],
        ]);

        $recap = JenisJurnal::query()
            ->withSum(['jurnal as total_debit' => function (Builder $query) use ($data) {
                $query->whereBetween('tanggal', [$data['tgl_awal'], $data['tgl_akhir']]);
            }], 'debit')
            ->withSum(['jurnal as total_kredit' => function (Builder $query) use ($data) {
                $query->whereBetween('tanggal', [$data['tgl_awal'], $data['tgl_akhir']]);
            }], 'kredit')
            ->orderBy('nm_jurnal')
            ->get();

        return view('jurnal-kas.recap', [
            'recap' => $recap,
            'startDate' => Carbon::parse($data['tgl_awal']),
            'endDate' => Carbon::parse($data['tgl_akhir']),
            'grandDebit' => (int) $recap->sum('total_debit'),
            'grandKredit' => (int) $recap->sum('total_kredit'),
        ]);
    }

    protected function formView(Jurnal $entry, int $type, string $title, string $routeName): View
    {
        return view('jurnal-kas.create', [
            'entry' => $entry,
            'pageTitle' => $title,
            'routeName' => $routeName,
            'transactionType' => $type,
            'transactionTypes' => JenisJurnal::query()
                ->where('tipe', $type)
                ->orderBy('nm_jurnal')
                ->get(),
        ]);
    }

    protected function storeEntry(Request $request, int $type): RedirectResponse
    {
        $operator = $this->resolveCurrentOperator($request);
        $field = $type === 1 ? 'debit' : 'kredit';
        $data = $request->validate([
            'idjenis' => [
                'required',
                Rule::exists('jenis_jurnal', 'idjenis')->where(fn ($query) => $query->where('tipe', $type)),
            ],
            'ket' => ['required', 'string'],
            'carabayar' => ['required', Rule::in(['TUNAI', 'TRANSFER'])],
            'nominal' => ['required', 'integer', 'min:1'],
        ]);

        DB::transaction(function () use ($request, $operator, $field, $data): void {
            Jurnal::create([
                'tanggal' => today(),
                'ket' => $data['ket'],
                'petugas' => $request->user()->name,
                'idjenis' => $data['idjenis'],
                'debit' => $field === 'debit' ? $data['nominal'] : 0,
                'kredit' => $field === 'kredit' ? $data['nominal'] : 0,
                'carabayar' => $data['carabayar'],
                'current' => now(),
                'created_by' => now(),
                'update_at' => $operator->id,
            ]);

            $this->syncKasBalance($operator->id);
        });

        return redirect()
            ->route('jurnal-kas.index')
            ->with('success', 'Data jurnal kas berhasil ditambahkan.');
    }

    protected function buildSummary($entries): array
    {
        $totalDebit = (int) $entries->sum('debit');
        $totalKredit = (int) $entries->sum('kredit');
        $debitTunai = (int) $entries->where('carabayar', 'TUNAI')->sum('debit');
        $debitTransfer = (int) $entries->where('carabayar', 'TRANSFER')->sum('debit');
        $kreditTunai = (int) $entries->where('carabayar', 'TUNAI')->sum('kredit');
        $kreditTransfer = (int) $entries->where('carabayar', 'TRANSFER')->sum('kredit');

        return [
            'total_debit' => $totalDebit,
            'total_kredit' => $totalKredit,
            'saldo' => $totalKredit - $totalDebit,
            'debit_tunai' => $debitTunai,
            'debit_transfer' => $debitTransfer,
            'kredit_tunai' => $kreditTunai,
            'kredit_transfer' => $kreditTransfer,
            'saldo_tunai' => $kreditTunai - $debitTunai,
            'saldo_transfer' => $kreditTransfer - $debitTransfer,
        ];
    }

    protected function betweenDatesQuery(string $startDate, string $endDate): Builder
    {
        return Jurnal::query()
            ->with('jenisJurnal')
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->latest('id_jurnal');
    }

    protected function syncKasBalance(?int $operatorId = null): void
    {
        $totals = Jurnal::query()
            ->selectRaw('COALESCE(SUM(kredit), 0) as total_kredit, COALESCE(SUM(debit), 0) as total_debit')
            ->first();

        $saldo = (int) $totals->total_kredit - (int) $totals->total_debit;

        Kas::query()->updateOrCreate([
            'id_kas' => 1,
        ], [
            'saldo' => $saldo,
            'created_by' => now(),
            'update_at' => $operatorId,
        ]);
    }

    protected function currentKasBalance(): float
    {
        return (float) Kas::query()->firstOrCreate([
            'id_kas' => 1,
        ], [
            'saldo' => 0,
            'created_by' => now(),
            'update_at' => $this->resolveCurrentOperator(request())->id,
        ])->saldo;
    }

    protected function canMutateEntry(Request $request, Jurnal $jurnal): bool
    {
        $operator = $this->resolveCurrentOperator($request);

        return $request->user()?->role === 'admin'
            || $jurnal->update_at === $operator->id
            || $jurnal->petugas === $request->user()?->name;
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