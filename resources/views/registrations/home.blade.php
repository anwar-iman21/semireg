@extends('layouts.app')

@section('title', config('seminar.name') . ' — SemiReg')

@section('content')
<section class="hero" aria-labelledby="hero-title">
    <div class="hero-grid">
        <div class="hero-copy">
            <p class="hero-kicker"><span class="live-dot"></span> SINATEK 2026 · Politeknik Negeri Lampung</p>
            <h1 id="hero-title">Bangun skill.<br><span>Buka masa depan.</span></h1>
            <p class="hero-theme">{{ config('seminar.theme') }}</p>
            <div class="hero-marquee" aria-label="Topik seminar">
                <div class="hero-marquee-track"><span>AI & CAREER</span><i>✦</i><span>WEB DEVELOPMENT</span><i>✦</i><span>CYBERSECURITY</span><i>✦</i><span>BUILD & DEPLOY</span><i>✦</i><span>AI & CAREER</span><i>✦</i><span>WEB DEVELOPMENT</span><i>✦</i><span>CYBERSECURITY</span><i>✦</i><span>BUILD & DEPLOY</span><i>✦</i></div>
            </div>
            <div class="event-facts">
                <span><b class="fact-icon">◷</b>{{ config('seminar.date') }} · {{ config('seminar.time') }}</span>
                <span><b class="fact-icon">⌖</b>{{ config('seminar.location') }}</span>
            </div>
            <a href="#daftar" class="btn btn-yellow btn-large">Daftar sekarang <span aria-hidden="true">↘</span></a>
        </div>
        <aside class="quota-card" aria-label="Sisa kuota">
            <div class="quota-top"><span>Kuota peserta</span><span class="quota-pill">Pendaftaran dibuka</span></div>
            <p class="quota-number">{{ number_format($remaining) }}<small> / {{ number_format($quota) }}</small></p>
            <div class="progress-track" role="progressbar" aria-label="Kuota terisi" aria-valuenow="{{ $quota > 0 ? min(100, (int) round(($total / $quota) * 100)) : 100 }}" aria-valuemin="0" aria-valuemax="100">
                <span style="width: {{ $quota > 0 ? min(100, round(($total / $quota) * 100, 1)) : 100 }}%"></span>
            </div>
            <p class="quota-caption">kursi masih tersedia</p>
            <div class="quota-divider"></div>
            <p class="quota-foot"><strong>{{ $total }}</strong> peserta sudah bergabung</p>
        </aside>
    </div>
    <div class="hero-orbit" aria-hidden="true"><span></span><span></span><span></span></div>
    <div class="hero-signal" aria-hidden="true"><span></span><span></span><span></span></div>
</section>

@if(session('error'))
    <div class="alert alert-error container" role="alert">{{ session('error') }}</div>
@endif

<section class="agenda-section section-wrap" id="agenda" aria-labelledby="agenda-title">
    <div class="section-heading reveal">
        <div>
            <p class="section-kicker">Satu hari, banyak sudut pandang</p>
            <h2 id="agenda-title">Waktu untuk <span>berpikir lebih jauh.</span></h2>
        </div>
        <p class="section-intro">Pertemuan praktisi, akademisi, dan mahasiswa untuk membicarakan teknologi yang berdampak.</p>
    </div>
    <div class="agenda-list">
        @foreach(config('seminar.agenda') as $item)
            <article class="agenda-item reveal" style="--i: {{ $loop->index }}">
                <time class="agenda-time">{{ $item['time'] }}</time>
                <div class="agenda-marker" aria-hidden="true"></div>
                <div class="agenda-detail"><h3>{{ $item['title'] }}</h3><p>{{ $item['description'] }}</p></div>
            </article>
        @endforeach
    </div>
</section>

<section class="registration-section" id="daftar" aria-labelledby="registration-title">
    <div class="section-wrap">
        <div class="section-heading registration-heading reveal">
            <div><p class="section-kicker">Simpan tempatmu</p><h2 id="registration-title">Satu tiket untuk <span>ide besar.</span></h2></div>
            <p class="section-intro">Isi data dengan benar. Tiket digital akan langsung dikirimkan di halaman berikutnya.</p>
        </div>
        @if($remaining <= 0)
            <div class="alert alert-full"><strong>Kuota sudah penuh.</strong><br>Terima kasih atas antusiasme Anda. Pendaftaran untuk SINATEK tahun ini telah ditutup.</div>
        @else
        <div class="ticket-form reveal">
            <aside class="ticket-side">
                <div class="ticket-brand"><span class="brand-badge">SR</span> SEMIREG PRESENTS</div>
                <div class="ticket-side-copy"><p class="side-label">SEMINAR NASIONAL</p><h3>SINATEK<br>2026</h3><p>{{ config('seminar.theme') }}</p></div>
                <div class="ticket-side-bottom"><span>{{ config('seminar.date') }}</span><span>{{ config('seminar.location') }}</span></div>
                <span class="ticket-watermark" aria-hidden="true">S</span>
            </aside>
            <div class="ticket-perforation" aria-hidden="true"><i></i><i></i></div>
            <div class="form-panel">
                <div class="form-heading"><h3>Data peserta</h3><p>Semua kolom bertanda <span class="required-mark">*</span> wajib diisi.</p></div>
                <form action="{{ route('registration.store', [], false) }}" method="POST" novalidate>
                    @csrf
                    <div class="form-grid">
                        <div class="field field-full">
                            <label for="nama">Nama lengkap <span class="required-mark">*</span></label>
                            <input id="nama" name="nama" value="{{ old('nama') }}" autocomplete="name" required class="{{ $errors->has('nama') ? 'input-error' : '' }}" aria-describedby="nama-error">
                            @error('nama')<small class="field-error" id="nama-error">{{ $message }}</small>@enderror
                        </div>
                        <div class="field">
                            <label for="email">Email <span class="required-mark">*</span></label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" autocomplete="email" required class="{{ $errors->has('email') ? 'input-error' : '' }}" aria-describedby="email-error">
                            @error('email')<small class="field-error" id="email-error">{{ $message }}</small>@enderror
                        </div>
                        <div class="field">
                            <label for="no_hp">Nomor HP <span class="required-mark">*</span></label>
                            <input id="no_hp" name="no_hp" type="tel" value="{{ old('no_hp') }}" placeholder="081234567890" autocomplete="tel" required class="{{ $errors->has('no_hp') ? 'input-error' : '' }}" aria-describedby="no_hp-error">
                            @error('no_hp')<small class="field-error" id="no_hp-error">{{ $message }}</small>@enderror
                        </div>
                        <fieldset class="field field-full category-field">
                            <legend>Kategori peserta <span class="required-mark">*</span></legend>
                            <div class="segmented-control">
                                <label class="segment"><input type="radio" name="kategori" value="mahasiswa" {{ old('kategori', 'mahasiswa') === 'mahasiswa' ? 'checked' : '' }}><span>Mahasiswa</span></label>
                                <label class="segment"><input type="radio" name="kategori" value="umum" {{ old('kategori') === 'umum' ? 'checked' : '' }}><span>Umum</span></label>
                            </div>
                            @error('kategori')<small class="field-error">{{ $message }}</small>@enderror
                        </fieldset>
                        <div class="field nim-field {{ old('kategori', 'mahasiswa') === 'umum' ? 'is-hidden' : '' }}">
                            <label for="nim">NIM <span class="required-mark nim-required">*</span></label>
                            <input id="nim" name="nim" value="{{ old('nim') }}" autocomplete="off" class="{{ $errors->has('nim') ? 'input-error' : '' }}" aria-describedby="nim-error">
                            @error('nim')<small class="field-error" id="nim-error">{{ $message }}</small>@enderror
                        </div>
                        <div class="field {{ old('kategori', 'mahasiswa') === 'umum' ? 'field-full' : '' }}">
                            <label for="institusi">Asal institusi <span class="required-mark">*</span></label>
                            <input id="institusi" name="institusi" value="{{ old('institusi') }}" placeholder="Kampus, perusahaan, atau mandiri" required class="{{ $errors->has('institusi') ? 'input-error' : '' }}" aria-describedby="institusi-error">
                            @error('institusi')<small class="field-error" id="institusi-error">{{ $message }}</small>@enderror
                        </div>
                    </div>
                    <p class="privacy-note">Data Anda digunakan hanya untuk keperluan penyelenggaraan acara.</p>
                    <button type="submit" class="btn btn-blue btn-submit">Daftar sekarang <span aria-hidden="true">↗</span></button>
                </form>
            </div>
        </div>
        @endif
    </div>
</section>
@endsection

@push('scripts')
<script>
(() => {
    const radios = document.querySelectorAll('input[name="kategori"]');
    const nimField = document.querySelector('.nim-field');
    const nimInput = document.querySelector('#nim');
    const nimRequired = document.querySelector('.nim-required');
    if (!nimField || !nimInput) return;
    const syncCategory = () => {
        const student = document.querySelector('input[name="kategori"]:checked')?.value !== 'umum';
        nimField.classList.toggle('is-hidden', !student);
        nimInput.required = student;
        nimInput.disabled = !student;
        nimRequired.hidden = !student;
    };
    radios.forEach((radio) => radio.addEventListener('change', syncCategory));
    syncCategory();
})();

(() => {
    const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const revealItems = document.querySelectorAll('.reveal');

    if (!reduceMotion && 'IntersectionObserver' in window) {
        document.documentElement.classList.add('reveal-ready');
    }

    if (reduceMotion || !('IntersectionObserver' in window)) {
        revealItems.forEach((item) => item.classList.add('visible'));
    } else {
        const observer = new IntersectionObserver((entries, currentObserver) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    currentObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.12 });

        revealItems.forEach((item) => observer.observe(item));
    }

    const navbar = document.querySelector('.navbar');
    const syncNavbar = () => navbar?.classList.toggle('scrolled', window.scrollY > 12);
    window.addEventListener('scroll', syncNavbar, { passive: true });
    syncNavbar();
})();
</script>
@endpush
