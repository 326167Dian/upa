<?php

namespace App\Http\Controllers;

use App\Models\Catatan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Illuminate\View\View;

class CatatanController extends Controller
{
    public function index(): View
    {
        return view('catatan.index', [
            'catatan' => Catatan::with('user')->orderByDesc('tgl')->orderByDesc('id_catatan')->get(),
        ]);
    }

    public function create(): View
    {
        return view('catatan.create', [
            'catatan' => new Catatan(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);
        $data['user_id'] = $request->user()->id;
        $data['petugas'] = $request->user()->name;
        unset($data['lampiran']);

        $attachments = $this->storeUploadedAttachments($request->file('lampiran', []));
        if (! empty($attachments)) {
            $data['attachments'] = $attachments;
            $data['file_path'] = $attachments[0]['path'];
            $data['file_name'] = $attachments[0]['name'];
        }

        Catatan::create($data);

        return redirect()
            ->route('catatan.index')
            ->with('success', 'Catatan berhasil ditambahkan.');
    }

    public function show(Catatan $catatan): View
    {
        return view('catatan.show', compact('catatan'));
    }

    public function edit(Request $request, Catatan $catatan): View|RedirectResponse
    {
        $user = $request->user();

        if ($catatan->user_id !== $user->id && $user->role !== \App\Models\User::ROLE_ADMIN) {
            return redirect()
                ->route('catatan.index')
                ->with('error', 'Catatan hanya bisa diedit oleh pembuat atau admin.');
        }

        return view('catatan.edit', compact('catatan'));
    }

    public function update(Request $request, Catatan $catatan): RedirectResponse
    {
        $user = $request->user();

        if ($catatan->user_id !== $user->id && $user->role !== \App\Models\User::ROLE_ADMIN) {
            return redirect()
                ->route('catatan.index')
                ->with('error', 'Catatan hanya bisa diedit oleh pembuat atau admin.');
        }

        $data = $this->validatedData($request);
        unset($data['lampiran']);
        $attachments = $this->attachmentsFor($catatan);

        foreach ($request->input('hapus_lampiran', []) as $index) {
            $index = (int) $index;
            if (isset($attachments[$index]['path'])) {
                Storage::disk('public')->delete($attachments[$index]['path']);
                unset($attachments[$index]);
            }
        }

        $newAttachments = $this->storeUploadedAttachments($request->file('lampiran', []));
        if (! empty($newAttachments)) {
            $attachments = array_merge(array_values($attachments), $newAttachments);
        }

        $attachments = array_values($attachments);
        $data['attachments'] = empty($attachments) ? null : $attachments;
        $data['file_path'] = $attachments[0]['path'] ?? null;
        $data['file_name'] = $attachments[0]['name'] ?? null;

        $catatan->update($data);

        return redirect()
            ->route('catatan.index')
            ->with('success', 'Catatan berhasil diperbarui.');
    }

    public function destroy(Request $request, Catatan $catatan): RedirectResponse
    {
        $user = $request->user();

        if ($catatan->user_id !== $user->id && $user->role !== \App\Models\User::ROLE_ADMIN) {
            return redirect()
                ->route('catatan.index')
                ->with('error', 'Catatan hanya bisa dihapus oleh pembuat atau admin.');
        }

        foreach ($this->attachmentsFor($catatan) as $attachment) {
            if (! empty($attachment['path'])) {
                Storage::disk('public')->delete($attachment['path']);
            }
        }

        if ($catatan->file_path && empty($catatan->attachments)) {
            Storage::disk('public')->delete($catatan->file_path);
        }

        $catatan->delete();

        return redirect()
            ->route('catatan.index')
            ->with('success', 'Catatan berhasil dihapus.');
    }

    protected function validatedData(Request $request): array
    {
        return $request->validate([
            'tgl'       => ['required', 'date'],
            'deskripsi' => ['required', 'string'],
            'lampiran' => ['nullable', 'array'],
            'lampiran.*'  => ['file', 'max:10240'],
        ]);
    }

    public function download(Catatan $catatan, int $index): BinaryFileResponse
    {
        $attachments = $this->attachmentsFor($catatan);
        abort_unless(isset($attachments[$index]), 404);

        $attachment = $attachments[$index];

        abort_unless(
            ! empty($attachment['path']) && Storage::disk('public')->exists($attachment['path']),
            404
        );

        $filename = $attachment['name']
            ?? (Str::slug('catatan-'.$catatan->tgl?->format('Y-m-d')).'.'.pathinfo($attachment['path'], PATHINFO_EXTENSION));

        return response()->download(
            Storage::disk('public')->path($attachment['path']),
            $filename
        );
    }

    /**
     * @param array<int, UploadedFile>|UploadedFile|null $files
     * @return array<int, array{name: string, path: string}>
     */
    protected function storeUploadedAttachments(array|UploadedFile|null $files): array
    {
        if ($files instanceof UploadedFile) {
            $files = [$files];
        }

        if (! is_array($files)) {
            return [];
        }

        $stored = [];

        foreach ($files as $file) {
            if (! $file instanceof UploadedFile) {
                continue;
            }

            $stored[] = [
                'name' => $file->getClientOriginalName(),
                'path' => $file->store('catatan/lampiran', 'public'),
            ];
        }

        return $stored;
    }

    /**
     * @return array<int, array{name: string, path: string}>
     */
    protected function attachmentsFor(Catatan $catatan): array
    {
        $attachments = $catatan->attachments;

        if (is_array($attachments) && ! empty($attachments)) {
            return array_values(array_filter($attachments, function ($item) {
                return is_array($item) && ! empty($item['path']);
            }));
        }

        if ($catatan->file_path) {
            return [[
                'name' => $catatan->file_name ?? basename($catatan->file_path),
                'path' => $catatan->file_path,
            ]];
        }

        return [];
    }
}
