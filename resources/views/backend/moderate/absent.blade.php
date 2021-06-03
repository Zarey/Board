@extends('backend.layout')
@section('content')

<div class="container-resp pt-20">




@if (Session::has('message')) 
<div class="alert">{{ Session::get('message') }}</div>
@else
<div class="alert">{{ $title }}</div>
@endif

</div>

@endsection

