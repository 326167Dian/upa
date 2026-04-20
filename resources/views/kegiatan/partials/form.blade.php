<div class="mb-3">
    <label for="nama_kegiatan" class="form-label">Nama Kegiatan</label>
    <input
        id="nama_kegiatan"
        name="nama_kegiatan"
        type="text"
        class="form-control @error('nama_kegiatan') is-invalid @enderror"
        value="{{ old('nama_kegiatan', $kegiatan->nama_kegiatan) }}"
        placeholder="Masukkan nama kegiatan"
    >
    @error('nama_kegiatan')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-4">
    <label for="deskripsi" class="form-label">Deskripsi</label>
    <textarea
        id="deskripsi"
        name="deskripsi"
        rows="6"
        data-rich-text="ckeditor"
        class="form-control @error('deskripsi') is-invalid @enderror"
        placeholder="Masukkan deskripsi kegiatan"
    >{{ old('deskripsi', $kegiatan->deskripsi) }}</textarea>
    @error('deskripsi')
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>

<div class="d-flex gap-2">
    <a href="{{ route('kegiatan.index') }}" class="btn btn-light border">Batal</a>
    <button type="submit" class="btn btn-primary">{{ $submitLabel }}</button>
</div>