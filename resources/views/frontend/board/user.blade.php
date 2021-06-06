@extends('frontend.layout')
@section('content')

<div class="container-resp pt-20">
<section class="res-element bg-white">
<h2>{{ $user->name }}</h2>

Телефон: <a href="tel:{{ $user->phone }}">{{ $user->phone }}</a><br />
Город: {{ $user->city }}<br />
На сайте с {{ date_format($user->created_at, 'd/m/Y') }}<br />
</section>
</div>

@endsection