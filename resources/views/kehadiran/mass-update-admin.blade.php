@extends('layouts.espire-app')

@section('content')
    <div class="main">
        <div class="page-header no-gutters has-tab">
            <h2 class="font-weight-normal">Update Kehadiran Massal Admin</h2>
        </div>

        <div class="card mb-3">
            <div class="card-body">
                <form method="GET" action="{{ route('kehadiran.admin.mass-update') }}" class="row g-2 align-items-end">
                    <div class="col-md-5">
                        <label for="id_kegiatan" class="form-label">Kegiatan</label>
                        <select id="id_kegiatan" name="id_kegiatan" class="form-select @error('id_kegiatan') is-invalid @enderror" required>
                            <option value="">Pilih kegiatan</option>
                            @foreach ($kegiatanList as $kegiatan)
                                <option value="{{ $kegiatan->id_kegiatan }}" @selected((string) $selectedKegiatanId === (string) $kegiatan->id_kegiatan)>
                                    {{ $kegiatan->nama_kegiatan }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_kegiatan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input
                            id="tanggal"
                            type="date"
                            name="tanggal"
                            class="form-control @error('tanggal') is-invalid @enderror"
                            value="{{ old('tanggal', $selectedDate) }}"
                            required
                        >
                        @error('tanggal')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 d-flex gap-2">
                        <button type="submit" class="btn btn-outline-primary">Muat Data</button>
                        <a href="{{ route('kehadiran.index') }}" class="btn btn-light border">Kembali</a>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('kehadiran.admin.mass-update.process') }}">
                    @csrf
                    <input type="hidden" name="id_kegiatan" value="{{ old('id_kegiatan', $selectedKegiatanId) }}">
                    <input type="hidden" name="tanggal" value="{{ old('tanggal', $selectedDate) }}">

                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label for="jam" class="form-label">Jam</label>
                            <input
                                id="jam"
                                name="jam"
                                type="time"
                                class="form-control @error('jam') is-invalid @enderror"
                                value="{{ old('jam', $defaultTime) }}"
                                required
                            >
                            @error('jam')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-5 mb-3">
                            <label for="lokasi" class="form-label">Lokasi</label>
                            <input
                                id="lokasi"
                                name="lokasi"
                                type="text"
                                class="form-control @error('lokasi') is-invalid @enderror"
                                value="{{ old('lokasi', $defaultLokasi) }}"
                                placeholder="Contoh: Aula UPA"
                                required
                            >
                            @error('lokasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="keterangan" class="form-label">Keterangan (opsional)</label>
                            <input
                                id="keterangan"
                                name="keterangan"
                                type="text"
                                class="form-control @error('keterangan') is-invalid @enderror"
                                value="{{ old('keterangan', $defaultKeterangan) }}"
                                placeholder="Catatan tambahan"
                            >
                            @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    @php
                        $checkedOperatorIds = array_map('strval', old('selected_operators', $checkedOperatorIds));
                    @endphp

                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="mb-0">Checklist Kehadiran Operator</h5>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="check_all_operators_update">
                            <label class="form-check-label" for="check_all_operators_update">Pilih semua</label>
                        </div>
                    </div>

                    <div class="alert alert-info py-2">
                        Operator yang dicentang akan disimpan sebagai <strong>Hadir</strong>, yang tidak dicentang sebagai <strong>Tidak Hadir</strong>.
                    </div>

                    <div class="table-responsive mb-4">
                        <table class="table table-bordered table-sm align-middle">
                            <thead>
                                <tr>
                                    <th style="width: 160px;">Ceklis Kehadiran</th>
                                    <th>Nama Operator</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($operators as $operator)
                                    <tr>
                                        <td class="text-center">
                                            <input
                                                type="checkbox"
                                                class="form-check-input operator-checkbox-update"
                                                name="selected_operators[]"
                                                value="{{ $operator->id }}"
                                                @checked(in_array((string) $operator->id, $checkedOperatorIds, true))
                                            >
                                        </td>
                                        <td>{{ $operator->name }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center text-muted">Tidak ada data operator.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex gap-2">
                        <a href="{{ route('kehadiran.index') }}" class="btn btn-light border">Batal</a>
                        <button type="submit" class="btn btn-warning">Simpan Update Massal</button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const checkAll = document.getElementById('check_all_operators_update');
                const checkboxes = document.querySelectorAll('.operator-checkbox-update');

                if (!checkAll || checkboxes.length === 0) {
                    return;
                }

                const syncMasterCheckbox = function () {
                    checkAll.checked = Array.from(checkboxes).every(function (checkbox) {
                        return checkbox.checked;
                    });
                };

                checkAll.addEventListener('change', function () {
                    checkboxes.forEach(function (checkbox) {
                        checkbox.checked = checkAll.checked;
                    });
                });

                checkboxes.forEach(function (checkbox) {
                    checkbox.addEventListener('change', syncMasterCheckbox);
                });

                syncMasterCheckbox();
            });
        </script>
    </div>
@endsection
