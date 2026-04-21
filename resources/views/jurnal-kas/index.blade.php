@extends('layouts.espire-app')

@section('content')
    @php
        $rupiah = fn ($value) => 'Rp '.number_format((float) $value, 0, ',', '.');
    @endphp

    <div class="main">
        <div class="page-header no-gutters has-tab">
            <div class="d-md-flex align-items-center justify-content-between w-100">
                <div>
                    <h2 class="font-weight-normal mb-1">Jurnal Kas</h2>
                    <p class="text-muted mb-0">Catatan kas harian tanggal {{ $today->format('d-m-Y') }}</p>
                </div>
                <div class="text-md-end mt-3 mt-md-0">
                    <div class="font-size-sm text-muted">Saldo Saat Ini</div>
                    <div class="font-size-lg font-weight-semibold">{{ $rupiah($currentBalance) }}</div>
                </div>
            </div>
        </div>

        @include('jurnal-kas.partials.toolbar')

        <div class="row">
            <div class="col-md-4 mb-3">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="text-muted">Pengeluaran</div>
                        <h3 class="mb-2">{{ $rupiah($summary['total_debit']) }}</h3>
                        <div class="small text-muted">Tunai {{ $rupiah($summary['debit_tunai']) }} | Transfer {{ $rupiah($summary['debit_transfer']) }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="text-muted">Pemasukan</div>
                        <h3 class="mb-2">{{ $rupiah($summary['total_kredit']) }}</h3>
                        <div class="small text-muted">Tunai {{ $rupiah($summary['kredit_tunai']) }} | Transfer {{ $rupiah($summary['kredit_transfer']) }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="text-muted">Saldo Hari Ini</div>
                        <h3 class="mb-2">{{ $rupiah($summary['saldo']) }}</h3>
                        <div class="small text-muted">Tunai {{ $rupiah($summary['saldo_tunai']) }} | Transfer {{ $rupiah($summary['saldo_transfer']) }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover" data-datatable="true" data-disable-last-column-sort="true">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Keterangan</th>
                                <th>Petugas</th>
                                <th>Jenis Transaksi</th>
                                <th>Cara Bayar</th>
                                <th class="text-end">Debit</th>
                                <th class="text-end">Kredit</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($entries as $entry)
                                <tr>
                                    <td>{{ $entry->tanggal?->format('d-m-Y') }}</td>
                                    <td>{{ $entry->ket }}</td>
                                    <td>{{ $entry->petugas }}</td>
                                    <td>{{ $entry->jenisJurnal?->nm_jurnal ?? '-' }}</td>
                                    <td>{{ $entry->carabayar }}</td>
                                    <td class="text-end">{{ $rupiah($entry->debit) }}</td>
                                    <td class="text-end">{{ $rupiah($entry->kredit) }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('jurnal-kas.edit', $entry) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                        <form method="POST" action="{{ route('jurnal-kas.destroy', $entry) }}" class="d-inline-block" onsubmit="return confirm('Hapus jurnal ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if ($entries->isEmpty())
                    <div class="text-center text-muted py-3">Belum ada transaksi jurnal kas hari ini.</div>
                @endif
            </div>
        </div>
    </div>
@endsection