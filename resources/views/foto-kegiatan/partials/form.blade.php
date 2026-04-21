<div class="mb-3">
    <label for="id_kegiatan" class="form-label">Nama Kegiatan</label>
    <select id="id_kegiatan" name="id_kegiatan" class="form-control @error('id_kegiatan') is-invalid @enderror">
        <option value="">Pilih kegiatan</option>
        @foreach ($kegiatanList as $kegiatan)
            <option value="{{ $kegiatan->id_kegiatan }}" @selected((string) old('id_kegiatan', $fotoKegiatan->id_kegiatan) === (string) $kegiatan->id_kegiatan)>{{ $kegiatan->nama_kegiatan }}</option>
        @endforeach
    </select>
    @error('id_kegiatan')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="foto" class="form-label">Foto</label>
    <input id="foto" name="foto" type="file" accept="image/*" class="form-control @error('foto') is-invalid @enderror">
    <small class="text-muted">Upload foto maksimal 1 MB.</small>
    @error('foto')
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror

    @if ($fotoKegiatan->foto)
        <div class="mt-3">
            <img src="{{ asset('storage/'.$fotoKegiatan->foto) }}" alt="Foto kegiatan" class="img-fluid rounded border" style="max-height: 220px;">
        </div>
    @endif
</div>

<div class="mb-4">
    <label for="keterangan" class="form-label">Keterangan</label>
    <textarea id="keterangan" name="keterangan" rows="5" class="form-control @error('keterangan') is-invalid @enderror" placeholder="Masukkan uraian teks tentang foto">{{ old('keterangan', $fotoKegiatan->keterangan) }}</textarea>
    @error('keterangan')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="d-flex gap-2">
    <a href="{{ route('foto-kegiatan.index') }}" class="btn btn-light border">Batal</a>
    <button type="submit" class="btn btn-primary">{{ $submitLabel }}</button>
</div>