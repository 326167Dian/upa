<div class="mb-3">
    <label for="id" class="form-label">Operator</label>
    <select id="id" name="id" class="form-select @error('id') is-invalid @enderror">
        <option value="">Pilih operator</option>
        @foreach ($operators as $operator)
            <option value="{{ $operator->id }}" @selected((string) old('id', $kehadiran->id) === (string) $operator->id)>
                {{ $operator->name }}
            </option>
        @endforeach
    </select>
    @error('id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="id_kegiatan" class="form-label">Kegiatan</label>
    <select id="id_kegiatan" name="id_kegiatan" class="form-select @error('id_kegiatan') is-invalid @enderror">
        <option value="">Pilih kegiatan</option>
        @foreach ($kegiatanList as $kegiatan)
            <option value="{{ $kegiatan->id_kegiatan }}" @selected((string) old('id_kegiatan', $kehadiran->id_kegiatan) === (string) $kegiatan->id_kegiatan)>
                {{ $kegiatan->nama_kegiatan }}
            </option>
        @endforeach
    </select>
    @error('id_kegiatan')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="waktu" class="form-label">Waktu</label>
    <input
        id="waktu"
        name="waktu"
        type="datetime-local"
        class="form-control @error('waktu') is-invalid @enderror"
        value="{{ old('waktu', optional($kehadiran->waktu)->format('Y-m-d\TH:i')) }}"
    >
    @error('waktu')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="hadir" class="form-label">Status Kehadiran</label>
    <select id="hadir" name="hadir" class="form-select @error('hadir') is-invalid @enderror">
        <option value="">Pilih status</option>
        <option value="1" @selected((string) old('hadir', $kehadiran->hadir) === '1')>Hadir</option>
        <option value="0" @selected((string) old('hadir', $kehadiran->hadir) === '0')>Tidak Hadir</option>
    </select>
    @error('hadir')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-4">
    <label for="keterangan" class="form-label">Keterangan</label>
    <textarea
        id="keterangan"
        name="keterangan"
        rows="4"
        class="form-control @error('keterangan') is-invalid @enderror"
        placeholder="Tambahkan keterangan jika diperlukan"
    >{{ old('keterangan', $kehadiran->keterangan) }}</textarea>
    @error('keterangan')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="d-flex gap-2">
    <a href="{{ route('kehadiran.index') }}" class="btn btn-light border">Batal</a>
    <button type="submit" class="btn btn-primary">{{ $submitLabel }}</button>
</div>