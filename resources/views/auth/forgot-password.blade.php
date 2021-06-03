@extends('backend.layout')
@section('content')
<div class="container-resp pt-20">

<h2>Восстановить пароль</h2>
<section class="res-element bg-white">
@if (session('status'))
<div class="alert">{{ session('status') }}</div>
@endif

<form method="POST" action="{{ route('password.email') }}">
@csrf

<input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Адрес электронной почты" required autocomplete="email" autofocus>

@error('email')
<div class="alert">{{ $message }}</div>
@enderror

<input type="submit" id="send" value="Отправить ссылку для восстановления" style="display: none;" />
<label for="send">Отправить ссылку для восстановления пароля</label>

</form>
</section>
@endsection
</div>