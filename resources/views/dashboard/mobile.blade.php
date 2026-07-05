<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
    <meta name="theme-color" content="#1D4ED8" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>Dashboard Mobile</title>

    @php
        $mobileAsset = fn (string $path) => asset('Mobilekit/HTML/assets/'.$path);
        $espireBase = 'Espire/espireadmin-10/Espire - Bootstrap Admin Template/html/demo/app';
        $espireAsset = fn (string $path) => url(str_replace('%2F', '/', rawurlencode($espireBase.'/assets/'.$path)));
        $operator = auth()->user()?->operator;
        $avatar = $operator?->avatar_path ? asset('storage/'.$operator->avatar_path) : asset('images/cakep.png');
    @endphp

    <link rel="icon" type="image/png" href="{{ $mobileAsset('img/favicon.png') }}" sizes="32x32" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ $mobileAsset('img/icon/192x192.png') }}" />
    <link rel="stylesheet" href="{{ $mobileAsset('css/style.css') }}" />

    <style>
        .mini-stat {
            padding: 14px;
            border-radius: 12px;
            background: #f8fafc;
            border: 1px solid #e5e7eb;
            margin-bottom: 10px;
        }

        .mini-stat .label {
            display: block;
            color: #6b7280;
            font-size: 12px;
            margin-bottom: 4px;
        }

        .mini-stat .value {
            font-size: 24px;
            font-weight: 700;
            line-height: 1;
            color: #111827;
        }

        .announcement-preview {
            line-height: 1.6;
            color: #374151;
            word-wrap: break-word;
        }

        .announcement-preview p:last-child,
        .announcement-preview ul:last-child,
        .announcement-preview ol:last-child {
            margin-bottom: 0;
        }

        .mobile-chart {
            min-height: 240px;
        }
    </style>
</head>

<body>
    <div id="loader">
        <div class="spinner-border text-primary" role="status"></div>
    </div>

    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="#" class="headerButton" data-bs-toggle="offcanvas" data-bs-target="#sidebarPanel">
                <ion-icon name="menu-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Dashboard UPA</div>
        <div class="right">
            <a href="{{ route('dashboard', array_merge(request()->except('mode'), ['mode' => 'desktop'])) }}" class="headerButton" title="Tampilan Desktop">
                <ion-icon name="desktop-outline"></ion-icon>
            </a>
        </div>
    </div>

    <div id="appCapsule">
        <div class="section mt-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <h3 class="card-title mb-0">Pengumuman Terbaru</h3>
                        @if (auth()->user()->hasFeatureAccess('pengumuman.view'))
                            <a href="{{ route('pengumuman.index') }}" class="btn btn-sm btn-outline-primary">Lihat</a>
                        @endif
                    </div>

                    @if ($latestAnnouncement)
                        <p class="text-muted mb-2">
                            {{ $latestAnnouncement->created_at?->format('d-m-Y H:i') ?? '-' }}
                            | {{ $latestAnnouncement->operator?->name ?? '-' }}
                        </p>
                        <div class="announcement-preview">{!! html_entity_decode($latestAnnouncement->berita) !!}</div>
                    @else
                        <p class="text-muted mb-0">Belum ada pengumuman terbaru.</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="section mt-2">
            <div class="wallet-card">
                <div class="balance">
                    <div class="left">
                        <span class="title">Halo, {{ auth()->user()->name }}</span>
                        <h1 class="total">Ringkasan Hari Ini</h1>
                    </div>
                </div>
                <div class="wallet-footer">
                    <div class="item">
                        <a href="{{ route('dashboard', array_merge(request()->except('mode'), ['mode' => 'desktop'])) }}">
                            <div class="icon-wrapper bg-warning">
                                <ion-icon name="laptop-outline"></ion-icon>
                            </div>
                            <strong>Desktop</strong>
                        </a>
                    </div>
                    @if (auth()->user()->hasFeatureAccess('pengumuman.view'))
                        <div class="item">
                            <a href="{{ route('pengumuman.index') }}">
                                <div class="icon-wrapper bg-success">
                                    <ion-icon name="megaphone-outline"></ion-icon>
                                </div>
                                <strong>Pengumuman</strong>
                            </a>
                        </div>
                    @endif
                    @if (auth()->user()->hasFeatureAccess('kehadiran.view'))
                        <div class="item">
                            <a href="{{ route('kehadiran.index') }}">
                                <div class="icon-wrapper">
                                    <ion-icon name="checkmark-done-outline"></ion-icon>
                                </div>
                                <strong>Kehadiran</strong>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="section mt-2">
                <div class="alert alert-success mb-0" role="alert">{{ session('success') }}</div>
            </div>
        @endif

        @if (session('error'))
            <div class="section mt-2">
                <div class="alert alert-danger mb-0" role="alert">{{ session('error') }}</div>
            </div>
        @endif

        <div class="section mt-3">
            <div class="mini-stat">
                <span class="label">Total Operator</span>
                <span class="value">{{ $operatorCount }}</span>
            </div>
            <div class="mini-stat">
                <span class="label">Total Kegiatan</span>
                <span class="value">{{ $kegiatanCount }}</span>
            </div>
            <div class="mini-stat mb-0">
                <span class="label">Total Kehadiran</span>
                <span class="value">{{ $kehadiranCount }}</span>
            </div>
        </div>

        <div class="section mt-3 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h3 class="card-title mb-0">Grafik Kehadiran</h3>
                    </div>

                    @if (count($attendancePeriodOptions) > 0)
                        <form method="GET" action="{{ route('dashboard') }}" class="mb-3">
                            <input type="hidden" name="mode" value="mobile">
                            @if ($recapStartDate)
                                <input type="hidden" name="recap_tanggal_mulai" value="{{ $recapStartDate }}">
                            @endif
                            @if ($recapEndDate)
                                <input type="hidden" name="recap_tanggal_selesai" value="{{ $recapEndDate }}">
                            @endif
                            @if ($selectedAbsensiDate)
                                <input type="hidden" name="absensi_date" value="{{ $selectedAbsensiDate }}">
                            @endif
                            <select id="period" name="period" class="form-select" onchange="this.form.submit()">
                                @foreach ($attendancePeriodOptions as $period)
                                    <option value="{{ $period['value'] }}" @selected($selectedAttendancePeriod === $period['value'])>{{ $period['label'] }}</option>
                                @endforeach
                            </select>
                        </form>
                    @endif

                    @if (count($attendanceChartLabels) > 0)
                        <div id="attendance-chart-mobile" class="mobile-chart"></div>
                    @else
                        <p class="text-muted mb-0">Belum ada data kehadiran.</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="section mt-3 mb-2">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h3 class="card-title mb-0">Rekap Kehadiran</h3>
                        <small class="text-muted">{{ $attendanceRecapPeriodLabel }}</small>
                    </div>

                    <form method="GET" action="{{ route('dashboard') }}" class="mb-3">
                        <input type="hidden" name="mode" value="mobile">
                        @if ($selectedAttendancePeriod)
                            <input type="hidden" name="period" value="{{ $selectedAttendancePeriod }}">
                        @endif
                        @if ($selectedAbsensiDate)
                            <input type="hidden" name="absensi_date" value="{{ $selectedAbsensiDate }}">
                        @endif
                        <div class="row g-2">
                            <div class="col-6">
                                <input name="recap_tanggal_mulai" type="date" value="{{ $recapStartDate }}" class="form-control">
                            </div>
                            <div class="col-6">
                                <input name="recap_tanggal_selesai" type="date" value="{{ $recapEndDate }}" class="form-control">
                            </div>
                            <div class="col-6 d-grid">
                                <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                            </div>
                            <div class="col-6 d-grid">
                                <a href="{{ route('dashboard', array_filter([
                                    'mode' => 'mobile',
                                    'period' => $selectedAttendancePeriod ?: null,
                                    'absensi_date' => $selectedAbsensiDate ?: null,
                                ])) }}" class="btn btn-outline-secondary btn-sm">Reset</a>
                            </div>
                        </div>
                    </form>

                    @if ($attendanceRecapRows->isNotEmpty())
                        <ul class="listview image-listview flush transparent no-line">
                            @foreach ($attendanceRecapRows as $row)
                                <li>
                                    <div class="item">
                                        <div class="in">
                                            <div>
                                                <strong>{{ $row['operator_name'] }}</strong>
                                                <div class="text-muted mt-1">
                                                    Hadir: {{ $row['hadir'] }} | Tidak hadir: {{ $row['tidak_hadir'] }}
                                                </div>
                                            </div>
                                            <a href="{{ route('operators.personal-attendance', array_filter([
                                                'operator' => $row['operator_id'],
                                                'tanggal_mulai' => $recapStartDate ?: null,
                                                'tanggal_selesai' => $recapEndDate ?: null,
                                            ])) }}" class="btn btn-outline-primary btn-sm">Detail</a>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted mb-0">Belum ada data rekap operator.</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="section mt-3 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h3 class="card-title mb-0">Absensi UPA</h3>
                    </div>

                    @if (count($absensiDates) > 0)
                        <form method="GET" action="{{ route('dashboard') }}" class="mb-3">
                            <input type="hidden" name="mode" value="mobile">
                            @if ($selectedAttendancePeriod)
                                <input type="hidden" name="period" value="{{ $selectedAttendancePeriod }}">
                            @endif
                            @if ($recapStartDate)
                                <input type="hidden" name="recap_tanggal_mulai" value="{{ $recapStartDate }}">
                            @endif
                            @if ($recapEndDate)
                                <input type="hidden" name="recap_tanggal_selesai" value="{{ $recapEndDate }}">
                            @endif
                            <select id="absensi_date" name="absensi_date" class="form-select" onchange="this.form.submit()">
                                @foreach ($absensiDates as $date)
                                    <option value="{{ $date }}" @selected($selectedAbsensiDate === $date)>
                                        {{ \Illuminate\Support\Carbon::parse($date)->locale('id')->isoFormat('DD MMMM YYYY') }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                    @endif

                    @if ($absensiList->isNotEmpty())
                        <ul class="listview image-listview flush transparent no-line">
                            @foreach ($absensiList as $i => $item)
                                <li>
                                    <div class="item">
                                        <div class="in">
                                            <div>
                                                <strong>{{ $i + 1 }}. {{ $item->operator?->name ?? '-' }}</strong>
                                                <div class="text-muted mt-1">{{ $item->keterangan ?? '-' }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @elseif (count($absensiDates) === 0)
                        <p class="text-muted mb-0">Belum ada data absensi.</p>
                    @else
                        <p class="text-muted mb-0">Tidak ada peserta yang tidak hadir pada tanggal ini.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="appBottomMenu">
        <a href="{{ route('dashboard', array_merge(request()->except('mode'), ['mode' => 'mobile'])) }}" class="item active">
            <div class="col">
                <ion-icon name="home-outline"></ion-icon>
                <strong>Home</strong>
            </div>
        </a>
        @if (auth()->user()->hasFeatureAccess('kehadiran.view'))
            <a href="{{ route('kehadiran.index') }}" class="item">
                <div class="col">
                    <ion-icon name="checkmark-circle-outline"></ion-icon>
                    <strong>Hadir</strong>
                </div>
            </a>
        @endif
        @if (auth()->user()->hasFeatureAccess('pengumuman.view'))
            <a href="{{ route('pengumuman.index') }}" class="item">
                <div class="col">
                    <ion-icon name="megaphone-outline"></ion-icon>
                    <strong>Info</strong>
                </div>
            </a>
        @endif
        <a href="#sidebarPanel" class="item" data-bs-toggle="offcanvas">
            <div class="col">
                <ion-icon name="menu-outline"></ion-icon>
                <strong>Menu</strong>
            </div>
        </a>
    </div>

    <div class="offcanvas offcanvas-start" tabindex="-1" id="sidebarPanel">
        <div class="offcanvas-body">
            <div class="profileBox">
                <div class="image-wrapper">
                    <img src="{{ $avatar }}" alt="avatar" class="imaged rounded" />
                </div>
                <div class="in">
                    <strong>{{ auth()->user()->name }}</strong>
                    <div class="text-muted">{{ auth()->user()->username }}</div>
                </div>
                <a href="#" class="close-sidebar-button" data-bs-dismiss="offcanvas">
                    <ion-icon name="close"></ion-icon>
                </a>
            </div>

            <ul class="listview flush transparent no-line image-listview mt-2">
                <li>
                    <a href="{{ route('dashboard', array_merge(request()->except('mode'), ['mode' => 'mobile'])) }}" class="item">
                        <div class="icon-box bg-primary"><ion-icon name="home-outline"></ion-icon></div>
                        <div class="in">Dashboard Mobile</div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('dashboard', array_merge(request()->except('mode'), ['mode' => 'desktop'])) }}" class="item">
                        <div class="icon-box bg-warning"><ion-icon name="desktop-outline"></ion-icon></div>
                        <div class="in">Tampilan Desktop</div>
                    </a>
                </li>

                @if (auth()->user()->hasFeatureAccess('operators.view'))
                    <li>
                        <a href="{{ route('operators.index') }}" class="item">
                            <div class="icon-box bg-primary"><ion-icon name="people-outline"></ion-icon></div>
                            <div class="in">Operator</div>
                        </a>
                    </li>
                @endif

                @if (auth()->user()->hasFeatureAccess('kegiatan.view'))
                    <li>
                        <a href="{{ route('kegiatan.index') }}" class="item">
                            <div class="icon-box bg-primary"><ion-icon name="calendar-outline"></ion-icon></div>
                            <div class="in">Kegiatan</div>
                        </a>
                    </li>
                @endif

                @if (auth()->user()->hasFeatureAccess('kehadiran.view'))
                    <li>
                        <a href="{{ route('kehadiran.index') }}" class="item">
                            <div class="icon-box bg-primary"><ion-icon name="checkmark-done-outline"></ion-icon></div>
                            <div class="in">Kehadiran</div>
                        </a>
                    </li>
                @endif

                @if (auth()->user()->hasFeatureAccess('jurnal_kas.view'))
                    <li>
                        <a href="{{ route('jurnal-kas.index') }}" class="item">
                            <div class="icon-box bg-primary"><ion-icon name="book-outline"></ion-icon></div>
                            <div class="in">Jurnal Kas</div>
                        </a>
                    </li>
                @endif

                @if (auth()->user()->hasFeatureAccess('pengumuman.view'))
                    <li>
                        <a href="{{ route('pengumuman.index') }}" class="item">
                            <div class="icon-box bg-primary"><ion-icon name="megaphone-outline"></ion-icon></div>
                            <div class="in">Pengumuman</div>
                        </a>
                    </li>
                @endif

                @if (auth()->user()->hasFeatureAccess('foto_kegiatan.view'))
                    <li>
                        <a href="{{ route('foto-kegiatan.index') }}" class="item">
                            <div class="icon-box bg-primary"><ion-icon name="images-outline"></ion-icon></div>
                            <div class="in">Foto Kegiatan</div>
                        </a>
                    </li>
                @endif

                @if (auth()->user()->hasFeatureAccess('catatan.view'))
                    <li>
                        <a href="{{ route('catatan.index') }}" class="item">
                            <div class="icon-box bg-primary"><ion-icon name="reader-outline"></ion-icon></div>
                            <div class="in">Catatan Harian</div>
                        </a>
                    </li>
                @endif
            </ul>
        </div>

        <div class="sidebar-buttons">
            <a href="{{ route('profile.edit') }}" class="button"><ion-icon name="person-outline"></ion-icon></a>
            <a href="{{ route('dashboard', array_merge(request()->except('mode'), ['mode' => 'desktop'])) }}" class="button"><ion-icon name="laptop-outline"></ion-icon></a>
            <button type="button" class="button" onclick="document.getElementById('mobile-logout-form').submit();">
                <ion-icon name="log-out-outline"></ion-icon>
            </button>
        </div>
    </div>

    <form id="mobile-logout-form" method="POST" action="{{ route('logout') }}" class="d-none">
        @csrf
    </form>

    <script src="{{ $mobileAsset('js/lib/bootstrap.min.js') }}"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script src="{{ $mobileAsset('js/base.js') }}"></script>
    <script src="{{ $espireAsset('vendors/apexcharts/dist/apexcharts.min.js') }}"></script>

    @if (count($attendanceChartLabels) > 0)
        <script>
            (function () {
                const chartElement = document.querySelector('#attendance-chart-mobile');
                if (!chartElement || typeof ApexCharts === 'undefined') {
                    return;
                }

                const labels = @json($attendanceChartLabels);
                const values = @json($attendanceChartValues);

                const chart = new ApexCharts(chartElement, {
                    chart: {
                        type: 'line',
                        height: 240,
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
                        labels: {
                            rotate: -30,
                        },
                    },
                    yaxis: {
                        min: 0,
                        forceNiceScale: true,
                    },
                    stroke: {
                        curve: 'smooth',
                        width: 3,
                    },
                    markers: {
                        size: 3,
                    },
                    dataLabels: {
                        enabled: false,
                    },
                    colors: ['#1D4ED8'],
                    grid: {
                        borderColor: '#e5e7eb',
                    },
                });

                chart.render();
            })();
        </script>
    @endif
</body>

</html>
