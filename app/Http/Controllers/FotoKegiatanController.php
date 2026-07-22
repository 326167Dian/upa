<?php

namespace App\Http\Controllers;

use App\Models\FotoKegiatan;
use App\Models\Kegiatan;
use App\Models\Operator;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class FotoKegiatanController extends Controller
{
    protected const ALLOWED_MIMES = 'jpeg,jpg,png,webp';

    protected const MAX_FILE_SIZE_KB = 2048;

    public function index(): View
    {
        $fotoKegiatan = FotoKegiatan::with(['kegiatan', 'operator'])
            ->latest('id_foto_kegiatan')
            ->get()
            ->each(function (FotoKegiatan $item) {
                $item->file_exists = (bool) ($item->foto && Storage::disk('public')->exists($item->foto));
            });

        $groupedByDate = $fotoKegiatan
            ->groupBy(fn (FotoKegiatan $item) => $item->created_at?->format('Y-m-d') ?? 'unknown')
            ->map(fn ($items, $date) => [
                'date' => $date,
                'label' => $date !== 'unknown'
                    ? Carbon::parse($date)->locale('id')->translatedFormat('d F Y')
                    : 'Tanggal tidak diketahui',
                'items' => $items,
            ])
            ->values();

        $canEdit = (bool) auth()->user()?->hasFeatureAccess('foto_kegiatan.edit');
        $canDelete = (bool) auth()->user()?->hasFeatureAccess('foto_kegiatan.delete');

        $photosForJs = $fotoKegiatan->values()->map(fn (FotoKegiatan $item) => [
            'url' => $item->file_exists ? asset('storage/'.$item->foto) : null,
            'exists' => $item->file_exists,
            'kegiatan' => $item->kegiatan?->nama_kegiatan ?? '-',
            'keterangan' => trim(strip_tags((string) $item->keterangan)),
            'downloadUrl' => $item->file_exists ? route('foto-kegiatan.download', $item) : null,
            'editUrl' => $canEdit ? route('foto-kegiatan.edit', $item) : null,
            'deleteUrl' => $canDelete ? route('foto-kegiatan.destroy', $item) : null,
        ])->values();

        return view('foto-kegiatan.index', [
            'fotoKegiatan' => $fotoKegiatan,
            'groupedByDate' => $groupedByDate,
            'missingFileCount' => $fotoKegiatan->where('file_exists', false)->count(),
            'photosForJs' => $photosForJs,
            'canEdit' => $canEdit,
            'canDelete' => $canDelete,
        ]);
    }

    public function create(): View
    {
        return view('foto-kegiatan.create', [
            'fotoKegiatan' => new FotoKegiatan(),
            'kegiatanList' => Kegiatan::orderBy('nama_kegiatan')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse|JsonResponse
    {
        $data = $request->validate([
            'id_kegiatan' => ['required', 'exists:kegiatan,id_kegiatan'],
            'foto' => ['required', 'array', 'min:1'],
            'foto.*' => ['image', 'mimes:'.self::ALLOWED_MIMES, 'max:'.self::MAX_FILE_SIZE_KB],
            'keterangan' => ['required', 'string'],
        ]);

        $operatorId = $this->resolveCurrentOperator($request)->id;
        $storedPaths = [];

        try {
            DB::transaction(function () use ($request, $data, $operatorId, &$storedPaths) {
                foreach ($request->file('foto') as $file) {
                    $path = $file->store('foto-kegiatan', 'public');
                    $storedPaths[] = $path;

                    FotoKegiatan::create([
                        'id_kegiatan' => $data['id_kegiatan'],
                        'foto' => $path,
                        'keterangan' => $data['keterangan'],
                        'created_by' => $operatorId,
                    ]);
                }
            });
        } catch (\Throwable $e) {
            foreach ($storedPaths as $path) {
                Storage::disk('public')->delete($path);
            }

            throw $e;
        }

        $message = count($storedPaths).' foto kegiatan berhasil ditambahkan.';

        if ($request->wantsJson()) {
            return response()->json([
                'message' => $message,
                'redirect' => route('foto-kegiatan.index'),
            ]);
        }

        return redirect()
            ->route('foto-kegiatan.index')
            ->with('success', $message);
    }

    public function edit(FotoKegiatan $fotoKegiatan): View
    {
        return view('foto-kegiatan.edit', [
            'fotoKegiatan' => $fotoKegiatan,
            'kegiatanList' => Kegiatan::orderBy('nama_kegiatan')->get(),
        ]);
    }

    public function download(FotoKegiatan $fotoKegiatan): BinaryFileResponse
    {
        abort_unless($fotoKegiatan->foto && Storage::disk('public')->exists($fotoKegiatan->foto), 404);

        $extension = pathinfo($fotoKegiatan->foto, PATHINFO_EXTENSION);
        $filename = Str::slug($fotoKegiatan->kegiatan?->nama_kegiatan ?? 'foto-kegiatan');

        return response()->download(
            Storage::disk('public')->path($fotoKegiatan->foto),
            $filename.($extension ? '.'.$extension : '')
        );
    }

    public function update(Request $request, FotoKegiatan $fotoKegiatan): RedirectResponse
    {
        $data = $this->validatedData($request);

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
    protected function validatedData(Request $request): array
    {
        return $request->validate([
            'id_kegiatan' => ['required', 'exists:kegiatan,id_kegiatan'],
            'foto' => ['nullable', 'image', 'mimes:'.self::ALLOWED_MIMES, 'max:'.self::MAX_FILE_SIZE_KB],
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