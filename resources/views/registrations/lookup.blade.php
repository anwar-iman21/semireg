@extends('layouts.app')

@section('title', 'Cek Tiket — ' . config('seminar.name'))

@section('content')
<section class="section-wrap" style="max-width: 640px; margin: 0 auto;">
    <div style="text-align: center; margin-bottom: 32px;">
        <p class="section-kicker">Status pendaftaran</p>
        <h1 style="color: var(--navy); font: 800 clamp(32px, 5vw, 44px)/1.1 var(--display); letter-spacing: -.04em; margin: 0 0 12px;">Cek <span>tiket Anda.</span></h1>
        <p style="color: var(--muted); margin: 0;">Masukkan email dan kode tiket yang Anda terima saat mendaftar.</p>
    </div>

    <div style="background: #fff; border: 1px solid var(--line); border-radius: 18px; padding: 32px; box-shadow: var(--soft-shadow);">
        <form method="GET" action="{{ route('registration.lookup', [], false) }}">
            <div class="field" style="margin-bottom: 18px;">
                <label for="email">Email terdaftar</label>
                <input id="email" type="email" name="email" value="{{ request('email') }}" placeholder="nama@email.com" autocomplete="email" required autofocus class="{{ $errors->has('email') ? 'input-error' : '' }}">
                @error('email')<small class="field-error">{{ $message }}</small>@enderror
            </div>

            <div class="field" style="margin-bottom: 22px;">
                <label for="kode_tiket">Kode tiket</label>
                <input id="kode_tiket" name="kode_tiket" value="{{ request('kode_tiket') }}" placeholder="SMR-XXXXXX" autocomplete="off" required style="font-family: var(--mono); text-transform: uppercase;" class="{{ $errors->has('kode_tiket') ? 'input-error' : '' }}">
                <small style="color: var(--muted); font-size: 12px; margin-top: 4px; display: block;">Format kode: <code>SMR-</code> diikuti 6 karakter.</small>
                @error('kode_tiket')<small class="field-error">{{ $message }}</small>@enderror
            </div>

            <button type="submit" class="btn btn-blue btn-submit">Lihat tiket</button>
        </form>
    </div>

    @if($searched && !$errors->any())
        <div style="margin-top: 32px;">
            @if($registration)
                <div class="alert alert-success" style="margin-bottom: 24px;">
                    <strong>Tiket ditemukan!</strong> Data pendaftaran cocok dengan sistem kami.
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

                <div class="success-actions no-print" style="margin-top: 24px;">
                    <a href="{{ route('registration.success', [$registration->kode_tiket], false) }}" class="btn btn-blue">Buka halaman cetak</a>
                    <a href="{{ route('home', [], false) }}" class="btn btn-quiet">Kembali ke beranda</a>
                </div>
            @else
                <div class="alert alert-error" style="text-align: center;">
                    <strong>Tiket tidak ditemukan.</strong><br>
                    Kombinasi email dan kode tiket tidak cocok. Silakan periksa kembali data Anda atau <a href="{{ route('home', [], false) }}#daftar" style="text-decoration: underline;">daftar baru</a>.
                </div>
            @endif
        </div>
    @endif
</section>
@endsection
