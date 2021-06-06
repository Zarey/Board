@extends('backend.layout')
@section('content')

@if (Session::has('message')) 
<div class="alert">{{ Session::get('message') }}</div>
@endif


<div class="container-resp pt-20">
<h2>{{ $title }} - {{ $count }}</h2>
@foreach ($advertisements as $advertisement)
<section class="res-element bg-white">
<h2>{{ $advertisement->draft_header }}</h2>
<a href="{{ url('/moderate/'.$advertisement->id) }}">Модерировать</a> | 
<a href="{{ url('/myadv/'.$advertisement->id.'/edit/') }}">Редактировать, как автор</a>
<br />Автор: <a href="{{ url('/user/'.$advertisement->author_id) }}">{{ $advertisement->author_name }}</a> (в дальнейшем из админки автора выдавать с данными о нем)
</section>
@endforeach

{{ $advertisements->links('backend.pagination') }}
</div>

@endsection