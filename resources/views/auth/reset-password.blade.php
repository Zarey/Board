@extends('backend.layout')
@section('content')
<div class="container-resp pt-20">

<h2>Задать новый пароль</h2>
<section class="res-element bg-white">
<form method="POST" action="{{ route('password.update') }}">
@csrf
<input type="hidden" name="token" value="{{ request()->route('token') }}">

<input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ request()->get('email') ?? old('email') }}" required autocomplete="email" placeholder="Адрес электронной почты" autofocus>

@error('email')
<div class="alert">{{ $message }}</div>
@enderror

<input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required placeholder="Новый пароль" autocomplete="new-password">

@error('password')
<div class="alert">{{ $message }}</div>
@enderror

<input id="password-confirm" type="password" class="form-control" name="password_confirmation" required placeholder="Повторите новый пароль" autocomplete="new-password">

<input type="submit" id="reset" value="Обновить пароль" style="display: none;" />
<label for="reset">Обновить пароль</label>

</form>
</section>
@endsection
</div>