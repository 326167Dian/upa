@extends('layouts.espire-app')

@section('content')
    <div class="main">
        <div class="page-header no-gutters has-tab">
            <div class="d-md-flex align-items-center justify-content-between w-100">
                <h2 class="font-weight-normal mb-3 mb-md-0">Jenis Transaksi Jurnal</h2>
                @if (auth()->user()?->hasFeatureAccess('jurnal_kas.create'))
                    <a href="{{ route('jurnal-kas.types.create') }}" class="btn btn-primary">Tambah Jenis Transaksi</a>
                @endif
            </div>
        </div>

        @include('jurnal-kas.partials.toolbar')

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover" data-datatable="true" data-disable-last-column-sort="true">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Transaksi</th>
                                <th>Arus Kas</th>
                                <th>Operator Terakhir</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($types as $type)
                                <tr>
                                    <td>{{ $type->idjenis }}</td>
                                    <td>{{ $type->nm_jurnal }}</td>
                                    <td>{{ $type->tipe === 1 ? 'Keluar' : 'Masuk' }}</td>
                                    <td>{{ $type->operator?->name ?? '-' }}</td>
                                    <td class="text-end">
                                        @if (auth()->user()?->hasFeatureAccess('jurnal_kas.edit'))
                                            <a href="{{ route('jurnal-kas.types.edit', $type) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                        @endif
                                        @if (auth()->user()?->hasFeatureAccess('jurnal_kas.delete'))
                                            <form method="POST" action="{{ route('jurnal-kas.types.destroy', $type) }}" class="d-inline-block" onsubmit="return confirm('Hapus jenis transaksi ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if ($types->isEmpty())
                    <div class="text-center text-muted py-3">Belum ada jenis transaksi.</div>
                @endif
            </div>
        </div>
    </div>
@endsection