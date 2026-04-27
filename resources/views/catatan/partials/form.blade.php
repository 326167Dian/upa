<div class="mb-4">
    <label for="tgl" class="form-label">Tanggal</label>
    <input
        type="date"
        id="tgl"
        name="tgl"
        value="{{ old('tgl', $catatan->tgl?->format('Y-m-d') ?? date('Y-m-d')) }}"
        class="form-control @error('tgl') is-invalid @enderror"
    >
    @error('tgl')
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>

<div class="mb-4">
    <label for="deskripsi" class="form-label">Catatan</label>
    <textarea
        id="deskripsi"
        name="deskripsi"
        rows="8"
        data-rich-text="ckeditor"
        class="form-control @error('deskripsi') is-invalid @enderror"
        placeholder="Masukkan isi catatan harian"
    >{{ old('deskripsi', $catatan->deskripsi) }}</textarea>
    @error('deskripsi')
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>

@php
    $existingAttachments = [];

    if (is_array($catatan->attachments) && !empty($catatan->attachments)) {
        $existingAttachments = array_values(array_filter($catatan->attachments, fn ($item) => is_array($item) && !empty($item['path'])));
    } elseif (!empty($catatan->file_path)) {
        $existingAttachments = [[
            'name' => $catatan->file_name ?? basename($catatan->file_path),
            'path' => $catatan->file_path,
        ]];
    }
@endphp

<div class="mb-4">
    <label class="form-label" for="lampiran">Lampiran File</label>

    @if (!empty($existingAttachments))
        <div class="mb-3 p-3 border rounded bg-light">
            <div class="fw-semibold mb-2">Lampiran Saat Ini</div>
            @foreach ($existingAttachments as $index => $attachment)
                <div class="form-check mb-1">
                    <input
                        class="form-check-input"
                        type="checkbox"
                        value="{{ $index }}"
                        id="hapus_lampiran_{{ $index }}"
                        name="hapus_lampiran[]"
                    >
                    <label class="form-check-label" for="hapus_lampiran_{{ $index }}">
                        Hapus {{ $attachment['name'] ?? ('Lampiran '.($index + 1)) }}
                    </label>
                </div>
            @endforeach
            <small class="text-muted">Centang file yang ingin dihapus saat simpan.</small>
        </div>
    @endif

    <input
        type="file"
        id="lampiran"
        name="lampiran[]"
        multiple
        class="form-control @error('lampiran') is-invalid @enderror @error('lampiran.*') is-invalid @enderror"
    >
    <div class="form-text">Bisa pilih lebih dari satu file. Maksimal 10 MB per file.</div>

    @error('lampiran')
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
    @error('lampiran.*')
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>

<div class="d-flex gap-2">
    <a href="{{ route('catatan.index') }}" class="btn btn-light border">Batal</a>
    <button type="submit" class="btn btn-primary">{{ $submitLabel }}</button>
</div>
