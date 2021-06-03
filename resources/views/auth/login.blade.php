@extends('backend.layout')
@section('content')
<div class="container-resp pt-20">

<h2>Войти</h2>

<section class="res-element bg-white">

<form action="{{ route('login') }}" method="POST">
@csrf

<input id="email" type="email" class="@error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Электронная почта" autofocus>

@error('email')
<div class="alert">{{ $message }}</div>
@enderror

<input id="password" type="password" class="@error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Пароль">

@error('password')
<div class="alert">{{ $message }}</div>
@enderror

<input type="submit" id="login" value="Войти" style="display: none;" />

@if (Session::has('message')) 
<div class="alert">{!! Session::get('message') !!}</div>
@endif

<input type="hidden" name="remember" id="remember" checked>

<label for="login">Войти</label>
</form>
</section>

<section class="res-element bg-white">
@if (Route::has('password.request'))
<a class="btn btn-link" href="{{ route('password.request') }}">
Забыли пароль?
</a>
@endif
</section>
@endsection
</div>


