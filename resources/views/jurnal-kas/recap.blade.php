@extends('layouts.espire-app')

@section('content')
    @php
        $rupiah = fn ($value) => 'Rp '.number_format((float) $value, 0, ',', '.');
    @endphp

    <div class="main">
        <div class="page-header no-gutters has-tab">
            <h2 class="font-weight-normal">Rekap {{ $startDate->format('d-m-Y') }} s/d {{ $endDate->format('d-m-Y') }}</h2>
        </div>

        @include('jurnal-kas.partials.toolbar')

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Jenis Jurnal</th>
                                <th>Arus Kas</th>
                                <th class="text-end">Debit</th>
                                <th class="text-end">Kredit</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recap as $item)
                                <tr>
                                    <td>{{ $item->nm_jurnal }}</td>
                                    <td>{{ $item->tipe === 1 ? 'Keluar' : 'Masuk' }}</td>
                                    <td class="text-end">{{ $rupiah($item->total_debit ?? 0) }}</td>
                                    <td class="text-end">{{ $rupiah($item->total_kredit ?? 0) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">Belum ada jenis transaksi untuk direkap.</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr class="font-weight-semibold">
                                <td colspan="2">Total</td>
                                <td class="text-end">{{ $rupiah($grandDebit) }}</td>
                                <td class="text-end">{{ $rupiah($grandKredit) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection