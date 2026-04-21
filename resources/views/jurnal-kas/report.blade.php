@extends('layouts.espire-app')

@section('content')
    @php
        $rupiah = fn ($value) => 'Rp '.number_format((float) $value, 0, ',', '.');
    @endphp

    <div class="main">
        <div class="page-header no-gutters has-tab">
            <h2 class="font-weight-normal">Jurnal {{ $startDate->format('d-m-Y') }} s/d {{ $endDate->format('d-m-Y') }}</h2>
        </div>

        @include('jurnal-kas.partials.toolbar')

        <div class="card mb-4">
            <div class="card-body d-md-flex gap-5">
                <div>
                    <div class="text-muted">Pengeluaran</div>
                    <div class="font-size-lg font-weight-semibold">{{ $rupiah($summary['total_debit']) }}</div>
                </div>
                <div>
                    <div class="text-muted">Pemasukan</div>
                    <div class="font-size-lg font-weight-semibold">{{ $rupiah($summary['total_kredit']) }}</div>
                </div>
                <div>
                    <div class="text-muted">Saldo</div>
                    <div class="font-size-lg font-weight-semibold">{{ $rupiah($summary['saldo']) }}</div>
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
                                        @if (auth()->user()?->hasFeatureAccess('jurnal_kas.edit'))
                                            <a href="{{ route('jurnal-kas.edit', $entry) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                        @endif
                                        @if (auth()->user()?->hasFeatureAccess('jurnal_kas.delete'))
                                            <form method="POST" action="{{ route('jurnal-kas.destroy', $entry) }}" class="d-inline-block" onsubmit="return confirm('Hapus jurnal ini?');">
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
                @if ($entries->isEmpty())
                    <div class="text-center text-muted py-3">Tidak ada jurnal pada rentang tanggal ini.</div>
                @endif
            </div>
        </div>
    </div>
@endsection