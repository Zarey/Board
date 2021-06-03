@extends('backend.layout')
@section('content')
<div class="container-resp pt-20">

<h2>Зарегистрироваться</h2>

<section class="res-element bg-white">

<form method="POST" action="{{ route('register') }}">
@csrf

<input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Имя" required autocomplete="name" autofocus>

@error('name')
<div class="alert">{{ $message }}</div>
@enderror

<input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Email" required autocomplete="email">

@error('email')
<div class="alert">{{ $message }}</div>
@enderror

<input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Пароль" required autocomplete="new-password">

@error('password')
<div class="alert">{{ $message }}</div>
@enderror

<input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Пароль ещё раз" required autocomplete="new-password">

<input type="submit" id="register" value="Зарегистрироваться" style="display: none;" />
<label for="register">Зарегистрироваться</label>

</form>
</section>
@endsection
</div>