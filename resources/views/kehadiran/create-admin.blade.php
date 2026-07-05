@extends('layouts.espire-app')

@section('content')
    <div class="main">
        <div class="page-header no-gutters has-tab">
            <h2 class="font-weight-normal">Tambah Kehadiran Admin (Massal)</h2>
        </div>

        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('kehadiran.admin.store') }}">
                    @csrf

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="id_kegiatan" class="form-label">Kegiatan</label>
                            <select id="id_kegiatan" name="id_kegiatan" class="form-select @error('id_kegiatan') is-invalid @enderror" required>
                                <option value="">Pilih kegiatan</option>
                                @foreach ($kegiatanList as $kegiatan)
                                    <option value="{{ $kegiatan->id_kegiatan }}" @selected((string) old('id_kegiatan') === (string) $kegiatan->id_kegiatan)>
                                        {{ $kegiatan->nama_kegiatan }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_kegiatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="waktu" class="form-label">Tanggal & Waktu</label>
                            <input
                                id="waktu"
                                name="waktu"
                                type="datetime-local"
                                class="form-control @error('waktu') is-invalid @enderror"
                                value="{{ old('waktu', $defaultAttendanceDateTime) }}"
                                required
                            >
                            @error('waktu')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="lokasi" class="form-label">Lokasi</label>
                        <input
                            id="lokasi"
                            name="lokasi"
                            type="text"
                            class="form-control @error('lokasi') is-invalid @enderror"
                            value="{{ old('lokasi') }}"
                            placeholder="Contoh: Aula UPA"
                            required
                        >
                        @error('lokasi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan (opsional)</label>
                        <textarea
                            id="keterangan"
                            name="keterangan"
                            rows="3"
                            class="form-control @error('keterangan') is-invalid @enderror"
                            placeholder="Catatan tambahan"
                        >{{ old('keterangan') }}</textarea>
                        @error('keterangan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="mb-0">Checklist Kehadiran Operator</h5>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="check_all_operators">
                            <label class="form-check-label" for="check_all_operators">Pilih semua</label>
                        </div>
                    </div>

                    @error('selected_operators')
                        <div class="alert alert-danger py-2">{{ $message }}</div>
                    @enderror

                    <div class="table-responsive mb-4">
                        <table class="table table-bordered table-sm align-middle">
                            <thead>
                                <tr>
                                    <th style="width: 160px;">Ceklis Kehadiran</th>
                                    <th>Nama Operator</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($operators as $operator)
                                    <tr>
                                        <td class="text-center">
                                            <input
                                                type="checkbox"
                                                class="form-check-input operator-checkbox"
                                                name="selected_operators[]"
                                                value="{{ $operator->id }}"
                                                @checked(in_array((string) $operator->id, array_map('strval', old('selected_operators', [])), true))
                                            >
                                        </td>
                                        <td>{{ $operator->name }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex gap-2">
                        <a href="{{ route('kehadiran.index') }}" class="btn btn-light border">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan Kehadiran Massal</button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const checkAll = document.getElementById('check_all_operators');
                const checkboxes = document.querySelectorAll('.operator-checkbox');

                if (!checkAll || checkboxes.length === 0) {
                    return;
                }

                checkAll.addEventListener('change', function () {
                    checkboxes.forEach(function (checkbox) {
                        checkbox.checked = checkAll.checked;
                    });
                });
            });
        </script>
    </div>
@endsection
