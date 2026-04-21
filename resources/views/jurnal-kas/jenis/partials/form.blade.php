<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="nm_jurnal" class="form-label">Nama Transaksi</label>
            <input id="nm_jurnal" name="nm_jurnal" type="text" class="form-control @error('nm_jurnal') is-invalid @enderror" value="{{ old('nm_jurnal', $type->nm_jurnal) }}" placeholder="Masukkan nama transaksi">
            @error('nm_jurnal')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-4">
            <label for="tipe" class="form-label">Arus Kas</label>
            <select id="tipe" name="tipe" class="form-control @error('tipe') is-invalid @enderror">
                <option value="1" @selected((string) old('tipe', $type->tipe) === '1')>Keluar Kas</option>
                <option value="2" @selected((string) old('tipe', $type->tipe) === '2')>Masuk Kas</option>
            </select>
            @error('tipe')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<div class="d-flex gap-2">
    <a href="{{ route('jurnal-kas.types.index') }}" class="btn btn-light border">Batal</a>
    <button type="submit" class="btn btn-primary">{{ $submitLabel }}</button>
</div>