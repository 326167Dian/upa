@extends('layouts.espire-app')

@section('content')
    <div class="main">
        <div class="page-header no-gutters has-tab">
            <h2 class="font-weight-normal">Dashboard</h2>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="mb-0">Pengumuman Terbaru</h4>
                            <a href="{{ route('pengumuman.index') }}" class="btn btn-outline-primary btn-sm">Lihat Semua</a>
                        </div>

                        @if ($latestAnnouncement)
                            <p class="text-muted mb-2">
                                {{ $latestAnnouncement->created_at?->format('d-m-Y H:i') ?? '-' }}
                                | {{ $latestAnnouncement->operator?->name ?? '-' }}
                            </p>
                            <div class="wysiwyg-preview">{!! html_entity_decode($latestAnnouncement->berita) !!}</div>
                        @else
                            <p class="text-muted mb-0">Belum ada pengumuman terbaru.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
                            <h4 class="mb-0">Grafik Kehadiran</h4>

                            @if (count($attendancePeriodOptions) > 0)
                                <form method="GET" action="{{ route('dashboard') }}" class="d-flex align-items-center gap-2">
                                    <label for="period" class="mb-0 text-muted">Pilih Waktu</label>
                                    <select id="period" name="period" class="form-select form-select-sm" onchange="this.form.submit()">
                                        @foreach ($attendancePeriodOptions as $period)
                                            <option value="{{ $period['value'] }}" @selected($selectedAttendancePeriod === $period['value'])>
                                                {{ $period['label'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </form>
                            @endif
                        </div>

                        @if (count($attendanceChartLabels) > 0)
                            <div id="attendance-chart" style="min-height: 320px;"></div>
                        @else
                            <p class="text-muted mb-0">Belum ada data kehadiran.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Absensi UPA --}}
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        {{-- Filter Tanggal --}}
                        @if (count($absensiDates) > 0)
                            <form method="GET" action="{{ route('dashboard') }}" class="d-flex align-items-center gap-2 mb-3">
                                @if ($selectedAttendancePeriod)
                                    <input type="hidden" name="period" value="{{ $selectedAttendancePeriod }}">
                                @endif
                                <label for="absensi_date" class="mb-0 text-muted text-nowrap">Filter Tanggal</label>
                                <select id="absensi_date" name="absensi_date" class="form-select form-select-sm" style="max-width: 220px;" onchange="this.form.submit()">
                                    @foreach ($absensiDates as $date)
                                        <option value="{{ $date }}" @selected($selectedAbsensiDate === $date)>
                                            {{ \Illuminate\Support\Carbon::parse($date)->locale('id')->isoFormat('DD MMMM YYYY') }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                        @endif

                        {{-- Judul --}}
                        <h5 class="font-weight-bold text-center mb-3">
                            ABSENSI UPA PEKANAN TANGGAL
                            {{ $selectedAbsensiDate ? \Illuminate\Support\Carbon::parse($selectedAbsensiDate)->locale('id')->isoFormat('DD MMMM YYYY') : '-' }}
                        </h5>

                        @if ($absensiList->isNotEmpty())
                            <table class="table table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <th style="width: 50px;">No.</th>
                                        <th>Nama Peserta</th>
                                        <th>Keterangan tidak Hadir</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($absensiList as $i => $item)
                                        <tr>
                                            <td class="text-center">{{ $i + 1 }}</td>
                                            <td>{{ $item->operator?->name ?? '-' }}</td>
                                            <td>{{ $item->keterangan ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @elseif (count($absensiDates) === 0)
                            <p class="text-muted mb-0">Belum ada data absensi.</p>
                        @else
                            <p class="text-muted mb-0">Tidak ada peserta yang tidak hadir pada tanggal ini.</p>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (count($attendanceChartLabels) > 0)
        <script>
            function renderAttendanceChart() {
                if (typeof ApexCharts === 'undefined') {
                    console.warn('ApexCharts library not loaded yet, retrying...');
                    setTimeout(renderAttendanceChart, 500);
                    return;
                }

                const chartElement = document.querySelector('#attendance-chart');
                if (!chartElement) {
                    console.warn('Chart element not found');
                    return;
                }

                const labels = @json($attendanceChartLabels);
                const values = @json($attendanceChartValues);

                console.log('Attendance Chart Data:', { labels, values });

                try {
                    const chart = new ApexCharts(chartElement, {
                        chart: {
                            type: 'line',
                            height: 320,
                            toolbar: {
                                show: false,
                            },
                        },
                        series: [{
                            name: 'Total Kehadiran',
                            data: values,
                        }],
                        xaxis: {
                            categories: labels,
                            title: {
                                text: 'Tanggal',
                            },
                        },
                        yaxis: {
                            min: 0,
                            forceNiceScale: true,
                            title: {
                                text: 'Total Hadir',
                            },
                        },
                        stroke: {
                            curve: 'smooth',
                            width: 3,
                        },
                        markers: {
                            size: 4,
                        },
                        dataLabels: {
                            enabled: false,
                        },
                        colors: ['#1f6feb'],
                        grid: {
                            borderColor: '#e9edf2',
                        },
                    });

                    chart.render();
                    console.log('Chart rendered successfully');
                } catch (error) {
                    console.error('Error rendering chart:', error);
                }
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', renderAttendanceChart);
            } else {
                renderAttendanceChart();
            }
        </script>
    @endif
@endsection