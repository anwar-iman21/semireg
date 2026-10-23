@extends('layouts.app')

@section('title', 'Masuk Panitia — SemiReg')

@section('content')
<section class="login-page section-wrap">
    <div class="login-card">
        <span class="login-icon" aria-hidden="true">⌘</span>
        <p class="section-kicker">Area terbatas</p>
        <h1>Masuk sebagai<br><span>panitia.</span></h1>
        <p>Gunakan password admin yang disimpan di file <code>.env</code>.</p>
        @if(session('error'))<div class="alert alert-error" role="alert">{{ session('error') }}</div>@endif
        @if($errors->any())<div class="alert alert-error" role="alert">{{ $errors->first() }}</div>@endif
        <form method="POST" action="{{ route('admin.login.process', [], false) }}">
            @csrf
            <div class="field">
                <label for="password">Password admin</label>
                <input id="password" name="password" type="password" autocomplete="current-password" required autofocus>
            </div>
            <button class="btn btn-blue btn-submit" type="submit">Masuk ke panel</button>
        </form>
        <a class="login-back" href="{{ route('home', [], false) }}">← Kembali ke beranda</a>
    </div>
</section>
@endsection
