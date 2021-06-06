@extends('backend.layout')
@section('content')

Ссылки на смену телефона, на профиль, загрузку фото и другие данные

<a href="{{ route('card.edit', $user->id) }}">Заполнить публичные данные</a><br />
<a href="{{ url('/user/profile') }}" target="_blank">Редактировать профиль</a><br />




@endsection