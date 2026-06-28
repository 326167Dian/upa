@extends('layouts.espire-app')

@section('content')
    <div class="main">
        <div class="page-header no-gutters has-tab">
            <div class="d-md-flex align-items-center justify-content-between w-100">
                <h2 class="font-weight-normal mb-3 mb-md-0">Data Operator</h2>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-secondary" id="btnExportPdf" title="Export data operator ke PDF">
                        <i class="feather icon-download"></i> Export PDF
                    </button>
                    @if (auth()->user()->hasFeatureAccess('operators.create'))
                        <a href="{{ route('operators.create') }}" class="btn btn-primary">Tambah Operator</a>
                    @endif
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <form method="GET" action="{{ route('operators.index') }}" class="row mb-4">
                    <div class="col-md-6">
                        <label for="search" class="form-label">Pencarian</label>
                        <input
                            id="search"
                            name="search"
                            type="text"
                            class="form-control"
                            value="{{ $filters['search'] }}"
                            placeholder="Cari nama, username, no telp, atau alamat"
                        >
                    </div>
                    <div class="col-md-4">
                        <label for="role" class="form-label">Filter Role</label>
                        <select id="role" name="role" class="form-control">
                            <option value="">Semua role</option>
                            <option value="admin" @selected($filters['role'] === 'admin')>Admin</option>
                            <option value="user" @selected($filters['role'] === 'user')>User</option>
                            <option value="custom" @selected($filters['role'] === 'custom')>Akses Terbatas</option>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <div class="w-100 d-flex operator-toolbar">
                            <button type="submit" class="btn btn-primary">Filter</button>
                            <a href="{{ route('operators.index') }}" class="btn btn-light border">Reset</a>
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-hover" data-datatable="true" data-disable-last-column-sort="true">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Username</th>
                                <th>Role</th>
                                <th>Hak Akses</th>
                                <th>No Telp</th>
                                <th>Alamat Lengkap</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($operators as $operator)
                                <tr>
                                    <td>{{ $operator->name }}</td>
                                    <td>{{ $operator->username ?? '-' }}</td>
                                    <td><span class="badge bg-info text-dark text-uppercase">{{ $operator->role === 'custom' ? 'akses terbatas' : $operator->role }}</span></td>
                                    <td>
                                        @if ($operator->role === 'admin')
                                            <span class="badge bg-success">Semua Akses</span>
                                        @elseif ($operator->role === 'user')
                                            <span class="badge bg-primary">Semua Aksi Standar</span>
                                        @else
                                            @forelse (($permissionSummaries[$operator->id] ?? []) as $summary)
                                                <div class="small mb-1">
                                                    <strong>{{ $summary['module'] }}:</strong>
                                                    {{ implode(', ', $summary['actions']) }}
                                                </div>
                                            @empty
                                                <span class="text-muted">Belum ada hak akses.</span>
                                            @endforelse
                                        @endif
                                    </td>
                                    <td>{{ $operator->phone_number }}</td>
                                    <td>{{ \Illuminate\Support\Str::limit(trim(strip_tags($operator->full_address)), 90) }}</td>
                                    <td class="text-end">
                                        @if (auth()->user()->hasFeatureAccess('kehadiran.view') || auth()->user()->hasFeatureAccess('operators.edit') || auth()->user()->hasFeatureAccess('operators.delete'))
                                            <div class="dropdown d-inline-block">
                                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="operator-action-{{ $operator->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                    Aksi
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="operator-action-{{ $operator->id }}">
                                                    @if (auth()->user()->hasFeatureAccess('kehadiran.view'))
                                                        <li class="px-2 py-1">
                                                            <a href="{{ route('operators.personal-attendance', $operator) }}" class="dropdown-item rounded d-flex align-items-center gap-2" style="background-color: #d9f3ff; color: #0b7285;">
                                                                <i class="feather icon-calendar"></i>
                                                                <span>Kehadiran Personal</span>
                                                            </a>
                                                        </li>
                                                    @endif
                                                    @if (auth()->user()->hasFeatureAccess('operators.edit'))
                                                        <li class="px-2 py-1">
                                                            <a href="{{ route('operators.edit', $operator) }}" class="dropdown-item rounded d-flex align-items-center gap-2" style="background-color: #fff3bf; color: #7a4b00;">
                                                                <i class="feather icon-edit-2"></i>
                                                                <span>Edit</span>
                                                            </a>
                                                        </li>
                                                    @endif
                                                    @if (auth()->user()->hasFeatureAccess('operators.delete'))
                                                        <li class="px-2 py-1">
                                                            <form method="POST" action="{{ route('operators.destroy', $operator) }}" onsubmit="return confirm('Hapus operator ini?');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="dropdown-item rounded d-flex align-items-center gap-2 w-100" style="background-color: #ffd6d6; color: #a61e1e;">
                                                                    <i class="feather icon-trash-2"></i>
                                                                    <span>Hapus</span>
                                                                </button>
                                                            </form>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">Belum ada data operator.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('btnExportPdf').addEventListener('click', function() {
            const btn = this;
            const originalText = btn.innerHTML;
            
            btn.disabled = true;
            btn.innerHTML = '<i class="feather icon-loader"></i> Membuat PDF...';

            fetch('{{ route("operators.exportPdf") }}')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        generatePDF(data.data, data.filename);
                    } else {
                        alert('Gagal membuat PDF');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat membuat PDF');
                })
                .finally(() => {
                    btn.disabled = false;
                    btn.innerHTML = originalText;
                });
        });

        function generatePDF(operators, filename) {
            // Create PDF content using simple HTML
            let html = `
                <html>
                <head>
                    <meta charset="UTF-8">
                    <title>Data Operator</title>
                    <style>
                        body { font-family: Arial, sans-serif; margin: 20px; }
                        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #000; padding-bottom: 15px; }
                        .header h1 { margin: 0; font-size: 24px; font-weight: bold; }
                        .header p { margin: 5px 0 0 0; font-size: 12px; color: #666; }
                        .operator-item { margin-bottom: 20px; padding: 15px; border: 1px solid #ddd; page-break-inside: avoid; }
                        .operator-item .name { font-weight: bold; font-size: 14px; margin-bottom: 8px; }
                        .info-row { margin-bottom: 6px; }
                        .label { font-weight: bold; display: inline-block; width: 120px; }
                        .value { display: inline-block; flex: 1; }
                        .footer { margin-top: 40px; padding-top: 15px; border-top: 1px solid #ddd; font-size: 11px; color: #999; text-align: center; }
                    </style>
                </head>
                <body>
                    <div class="header">
                        <h1>Data Operator UPA</h1>
                        <p>Laporan Data Operator</p>
                        <p>Tanggal: ${new Date().toLocaleDateString('id-ID', { year: 'numeric', month: 'long', day: 'numeric' })}</p>
                    </div>
                    <div class="content">
            `;

            operators.forEach(operator => {
                html += `
                    <div class="operator-item">
                        <div class="name">${operator.nama}</div>
                        <div class="info-row">
                            <span class="label">Telp/Wa</span>
                            <span class="value">${operator.telp_wa}</span>
                        </div>
                        <div class="info-row">
                            <span class="label">Alamat</span>
                            <span class="value">${operator.alamat}</span>
                        </div>
                        <div class="info-row">
                            <span class="label">Mulai UPA</span>
                            <span class="value">${operator.mulai_upa}</span>
                        </div>
                    </div>
                `;
            });

            html += `
                    </div>
                    <div class="footer">
                        <p>Total Operator: ${operators.length} | Dicetak: ${new Date().toLocaleString('id-ID')}</p>
                    </div>
                </body>
                </html>
            `;

            // Open in new window for printing to PDF
            const printWindow = window.open('', '', 'width=800,height=600');
            printWindow.document.write(html);
            printWindow.document.close();
            
            // Auto-trigger print dialog
            setTimeout(() => {
                printWindow.print();
            }, 250);
        }
    </script>
@endsection