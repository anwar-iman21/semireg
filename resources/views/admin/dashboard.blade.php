@extends('layouts.app')

@section('title', 'Dashboard Panitia — SemiReg')

@section('content')
<section class="admin-page section-wrap">
    <div class="admin-heading">
        <div><p class="section-kicker">Panel penyelenggara</p><h1>Peserta <span>SINATEK.</span></h1><p class="admin-subtitle">Kelola pendaftaran dan pantau kuota acara.</p></div>
        <a href="{{ route('admin.export', [], false) }}" class="btn btn-blue"><span aria-hidden="true">↓</span> Unduh CSV</a>
    </div>
    @if(session('success'))<div class="alert alert-success" role="status">{{ session('success') }}</div>@endif
    <div class="stats-grid">
        <article class="stat-card stat-primary"><span>Total peserta</span><strong>{{ number_format($totalAll) }}</strong><small>dari {{ number_format(config('seminar.quota')) }} kuota</small></article>
        <article class="stat-card"><span>Mahasiswa</span><strong>{{ number_format($totalMhs) }}</strong><small>peserta terdaftar</small></article>
        <article class="stat-card"><span>Umum</span><strong>{{ number_format($totalUmum) }}</strong><small>peserta terdaftar</small></article>
        <article class="stat-card"><span>Sisa kuota</span><strong>{{ number_format($remaining) }}</strong><small>kursi tersedia</small></article>
    </div>
    <div class="table-card">
        <div class="table-toolbar">
            <div><h2>Daftar peserta</h2><p>{{ $registrations->count() }} peserta di halaman ini</p></div>
            <form class="search-form" method="GET" action="{{ route('admin.dashboard', [], false) }}">
                <label class="sr-only" for="search">Cari peserta</label>
                <input id="search" type="search" name="search" placeholder="Cari nama, email, kode…" value="{{ $search }}">
                <button type="submit" class="btn btn-blue btn-sm">Cari</button>
                @if($search)<a class="clear-search" href="{{ route('admin.dashboard', [], false) }}">Hapus</a>@endif
            </form>
        </div>
        @if($registrations->isEmpty())
            <div class="empty-state"><span aria-hidden="true">⌕</span><h3>{{ $search ? 'Peserta tidak ditemukan' : 'Belum ada pendaftar' }}</h3><p>{{ $search ? 'Coba kata kunci lain.' : 'Peserta yang mengisi formulir akan muncul di sini.' }}</p></div>
        @else
            <div class="table-scroll"><table class="attendee-table">
                <thead><tr><th>Peserta</th><th>Kode tiket</th><th>Kategori</th><th>Institusi</th><th>Terdaftar</th><th><span class="sr-only">Aksi</span></th></tr></thead>
                <tbody>
                @foreach($registrations as $registration)
                    <tr>
                        <td><strong>{{ $registration->nama }}</strong><small>{{ $registration->email }}</small></td>
                        <td><code class="ticket-code">{{ $registration->kode_tiket }}</code></td>
                        <td><span class="category-badge {{ $registration->kategori === 'mahasiswa' ? 'badge-student' : 'badge-public' }}">{{ ucfirst($registration->kategori) }}</span></td>
                        <td>{{ $registration->institusi }}</td>
                        <td>{{ $registration->created_at->format('d/m/Y') }}</td>
                        <td><form method="POST" action="{{ route('admin.destroy', [$registration->id], false) }}" onsubmit="return confirm(@js('Hapus peserta ' . $registration->nama . '?'))">@csrf @method('DELETE')<button type="submit" class="btn-delete">Hapus</button></form></td>
                    </tr>
                @endforeach
                </tbody>
            </table></div>
            <div class="pagination-bar"><span>{{ $registrations->count() }} peserta ditampilkan</span><div>
                @if($registrations->previousPageUrl())<a href="{{ $registrations->previousPageUrl() }}" class="page-link">← Sebelumnya</a>@else<span class="page-link disabled">← Sebelumnya</span>@endif
                @if($registrations->nextPageUrl())<a href="{{ $registrations->nextPageUrl() }}" class="page-link">Berikutnya →</a>@else<span class="page-link disabled">Berikutnya →</span>@endif
            </div></div>
        @endif
    </div>
</section>
@endsection
