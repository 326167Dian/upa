<div class="mb-4">
    <label for="berita" class="form-label">Berita</label>
    <textarea
        id="berita"
        name="berita"
        rows="8"
        data-rich-text="ckeditor-image"
        class="form-control @error('berita') is-invalid @enderror"
        placeholder="Masukkan isi pengumuman"
    >{{ old('berita', $pengumuman->berita) }}</textarea>
    @error('berita')
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>

<div class="d-flex gap-2">
    <a href="{{ route('pengumuman.index') }}" class="btn btn-light border">Batal</a>
    <button type="submit" class="btn btn-primary">{{ $submitLabel }}</button>
</div>