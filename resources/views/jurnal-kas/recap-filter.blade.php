@extends('layouts.espire-app')

@section('content')
    <div class="main">
        <div class="page-header no-gutters has-tab">
            <h2 class="font-weight-normal">Rekapitulasi Jurnal Kas</h2>
        </div>

        @include('jurnal-kas.partials.toolbar')

        <div class="card">
            <div class="card-body">
                <form method="GET" action="{{ route('jurnal-kas.recap.index') }}">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="tgl_awal" class="form-label">Tanggal Awal</label>
                                <input id="tgl_awal" name="tgl_awal" type="date" class="form-control @error('tgl_awal') is-invalid @enderror" value="{{ old('tgl_awal') }}">
                                @error('tgl_awal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-4">
                                <label for="tgl_akhir" class="form-label">Tanggal Akhir</label>
                                <input id="tgl_akhir" name="tgl_akhir" type="date" class="form-control @error('tgl_akhir') is-invalid @enderror" value="{{ old('tgl_akhir') }}">
                                @error('tgl_akhir')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <a href="{{ route('jurnal-kas.index') }}" class="btn btn-light border">Kembali</a>
                        <button type="submit" class="btn btn-primary">Tampilkan Rekap</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection