<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="idjenis" class="form-label">Jenis Transaksi</label>
            <select id="idjenis" name="idjenis" class="form-control @error('idjenis') is-invalid @enderror">
                <option value="">Pilih jenis transaksi</option>
                @foreach ($transactionTypes as $type)
                    <option value="{{ $type->idjenis }}" @selected((string) old('idjenis', $entry->idjenis) === (string) $type->idjenis)>{{ $type->nm_jurnal }}</option>
                @endforeach
            </select>
            @error('idjenis')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <label for="carabayar" class="form-label">Cara Bayar</label>
            <select id="carabayar" name="carabayar" class="form-control @error('carabayar') is-invalid @enderror">
                <option value="TUNAI" @selected(old('carabayar', $entry->carabayar) === 'TUNAI')>TUNAI</option>
                <option value="TRANSFER" @selected(old('carabayar', $entry->carabayar) === 'TRANSFER')>TRANSFER</option>
            </select>
            @error('carabayar')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<div class="mb-3">
    <label for="ket" class="form-label">Keterangan Detail</label>
    <textarea id="ket" name="ket" rows="4" class="form-control @error('ket') is-invalid @enderror" placeholder="Masukkan keterangan transaksi">{{ old('ket', $entry->ket) }}</textarea>
    @error('ket')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

@if (isset($transactionType))
    <div class="mb-4">
        <label for="nominal" class="form-label">Nilai Transaksi</label>
        <input id="nominal" name="nominal" type="number" min="1" class="form-control @error('nominal') is-invalid @enderror" value="{{ old('nominal') }}" placeholder="Masukkan nominal transaksi">
        @error('nominal')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
@else
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="debit" class="form-label">Nilai Pengeluaran</label>
                <input id="debit" name="debit" type="number" min="0" class="form-control @error('debit') is-invalid @enderror" value="{{ old('debit', $entry->debit) }}">
                @error('debit')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="col-md-6">
            <div class="mb-4">
                <label for="kredit" class="form-label">Nilai Pemasukan</label>
                <input id="kredit" name="kredit" type="number" min="0" class="form-control @error('kredit') is-invalid @enderror" value="{{ old('kredit', $entry->kredit) }}">
                @error('kredit')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
@endif

<div class="d-flex gap-2">
    <a href="{{ route('jurnal-kas.index') }}" class="btn btn-light border">Batal</a>
    <button type="submit" class="btn btn-primary">{{ $submitLabel }}</button>
</div>