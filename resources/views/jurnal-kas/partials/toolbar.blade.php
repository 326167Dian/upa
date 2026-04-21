<div class="d-flex flex-wrap gap-2 mb-4">
    @if (auth()->user()?->hasFeatureAccess('jurnal_kas.create'))
        <a href="{{ route('jurnal-kas.expenses.create') }}" class="btn btn-danger">Input Pengeluaran</a>
        <a href="{{ route('jurnal-kas.incomes.create') }}" class="btn btn-info text-white">Input Pemasukan</a>
    @endif
    @if (auth()->user()?->hasFeatureAccess('jurnal_kas.view'))
        <a href="{{ route('jurnal-kas.types.index') }}" class="btn btn-warning">Jenis Transaksi</a>
        <a href="{{ route('jurnal-kas.report.filter') }}" class="btn btn-success">Pilih Hari</a>
        <a href="{{ route('jurnal-kas.recap.filter') }}" class="btn btn-primary">Rekapitulasi</a>
    @endif
</div>