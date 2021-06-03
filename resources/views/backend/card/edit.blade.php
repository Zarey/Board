@extends('backend.layout')
@section('content')
<div class="container-resp pt-20">

<h2>{{ $title }}</h2>

<section class="res-element bg-white">

<form action="{{ route('card.update', $id) }}" method="POST">
@csrf
@method('PUT')
<input type="text" name="name" value="<?= $user->name ?>" placeholder="Имя" required><br />
<input type="text" name="phone" value="<?= $user->phone ?>" placeholder="Телефон для связи" required><br />
<input type="text" name="city" value="<?= $user->city ?>" placeholder="Город, район"><br />
<input type="submit" id="update" value="Обновить" style="display: none;" />
</form>

@if (Session::has('message')) 
<div class="alert">{!! Session::get('message') !!}</div>
@endif

<label for="update">Обновить</label>

</section>
</div>
@endsection