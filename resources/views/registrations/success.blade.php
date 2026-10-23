@extends('layouts.app')

@section('title', 'Tiket Anda — ' . config('seminar.name'))

@section('content')
<section class="success-page section-wrap">
    <div class="success-heading">
        <span class="success-check" aria-hidden="true">✓</span>
        <p class="section-kicker">Pendaftaran berhasil</p>
        <h1>Sampai jumpa di<br><span>SINATEK 2026.</span></h1>
        <p>Tiket digital Anda siap. Simpan atau cetak halaman ini untuk ditunjukkan saat registrasi acara.</p>
    </div>
    <article class="success-ticket">
        <div class="success-ticket-main">
            <div class="ticket-brand dark-brand"><span class="brand-badge">SR</span> SEMIREG PRESENTS</div>
            <div class="success-ticket-content">
                <p class="side-label">SEMINAR NASIONAL TEKNOLOGI</p>
                <h2>{{ $registration->nama }}</h2>
                <dl class="attendee-details">
                    <div><dt>Email</dt><dd>{{ $registration->email }}</dd></div>
                    <div><dt>Kategori</dt><dd>{{ ucfirst($registration->kategori) }}</dd></div>
                    @if($registration->nim)<div><dt>NIM</dt><dd>{{ $registration->nim }}</dd></div>@endif
                    <div><dt>Institusi</dt><dd>{{ $registration->institusi }}</dd></div>
                </dl>
                <p class="success-event">{{ config('seminar.date') }} · {{ config('seminar.location') }}</p>
            </div>
        </div>
        <div class="success-ticket-code">
            <span>KODE TIKET</span>
            <strong>{{ $registration->kode_tiket }}</strong>
            <small>Tunjukkan kode ini saat check-in</small>
            <div class="ticket-code-bars" aria-hidden="true"></div>
        </div>
    </article>
    <div class="success-actions no-print">
        <button type="button" class="btn btn-blue btn-large" onclick="window.print()"><span aria-hidden="true">▤</span> Cetak tiket</button>
        <a href="{{ route('home', [], false) }}" class="btn btn-quiet btn-large">Kembali ke beranda</a>
    </div>
</section>
@endsection
