@extends('layouts.app')

@section('title', 'Info Tunnel — SemiReg')

@section('content')
<section class="admin-page section-wrap">
    <div class="admin-heading"><div><p class="section-kicker">Uji koneksi publik</p><h1>Info <span>tunnel.</span></h1><p class="admin-subtitle">Bukti diagnostik untuk memastikan header dan HTTPS terdeteksi.</p></div></div>
    <div class="info-layout">
        <article class="info-card">
            <h2>Informasi request</h2>
            <dl class="info-list">
                <div><dt>Host</dt><dd>{{ $request->getHost() }}</dd></div>
                <div><dt>Scheme</dt><dd>{{ $request->getScheme() }}</dd></div>
                <div><dt>Terdeteksi HTTPS</dt><dd><span class="status-chip {{ $request->isSecure() ? 'status-ok' : 'status-warn' }}">{{ $request->isSecure() ? 'Ya' : 'Tidak' }}</span></dd></div>
                <div><dt>IP klien</dt><dd>{{ $request->ip() }}</dd></div>
                <div><dt>X-Forwarded-For</dt><dd>{{ $request->header('X-Forwarded-For', '—') }}</dd></div>
                <div><dt>X-Forwarded-Proto</dt><dd>{{ $request->header('X-Forwarded-Proto', '—') }}</dd></div>
                <div><dt>X-Forwarded-Host</dt><dd>{{ $request->header('X-Forwarded-Host', '—') }}</dd></div>
                <div><dt>CF-Connecting-IP</dt><dd>{{ $request->header('CF-Connecting-IP', '—') }}</dd></div>
                <div><dt>CF-Ray</dt><dd>{{ $request->header('CF-Ray', '—') }}</dd></div>
                <div><dt>APP_ENV</dt><dd>{{ config('app.env') }}</dd></div>
                <div><dt>APP_DEBUG</dt><dd>{{ config('app.debug') ? 'true' : 'false' }}</dd></div>
                <div><dt>Versi PHP</dt><dd>{{ PHP_VERSION }}</dd></div>
                <div><dt>Versi Laravel</dt><dd>{{ app()->version() }}</dd></div>
            </dl>
        </article>
        <aside class="checklist-card">
            <h2>Checklist pengujian</h2>
            <ul class="checklist">
                <li><span>✓</span><div><strong>Halaman terbuka</strong><p>URL publik memuat halaman utama.</p></div></li>
                <li><span>{{ $request->isSecure() ? '✓' : '!' }}</span><div><strong>HTTPS dikenali</strong><p>{{ $request->isSecure() ? 'Proxy meneruskan skema aman.' : 'Cek konfigurasi trusted proxy atau header tunnel.' }}</p></div></li>
                <li><span>{{ $request->header('CF-Ray') || $request->header('X-Forwarded-For') ? '✓' : '!' }}</span><div><strong>Header proxy diterima</strong><p>Cloudflare mengirim CF-Ray; tunnel meneruskan forwarded headers.</p></div></li>
                <li><span>✓</span><div><strong>Panel dilindungi</strong><p>Dashboard memerlukan autentikasi panitia.</p></div></li>
            </ul>
            <p class="info-warning">Jangan bagikan halaman diagnostik ini ke publik saat aplikasi sudah digunakan dengan data nyata.</p>
        </aside>
    </div>
</section>
@endsection
