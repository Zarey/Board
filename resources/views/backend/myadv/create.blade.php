@extends('backend.layout')
@section('content')
<div class="container-resp pt-20">

<h2>{{ $title }}</h2>

<section class="res-element bg-white">

<form action="{{ route('myadv.store') }}" enctype="multipart/form-data" method="POST">
@csrf
@method('POST')
<input type="text" name="draft_header" value="{{ old('draft_header') }}" maxlength="35" autocomplete="off" placeholder="Заголовок объявления" required><br />
<textarea rows="7" name="draft_advcontent" maxlength="2000" placeholder="Текст объявления" required>{{ old('draft_advcontent') }}</textarea><br />
<select name="draft_category_id" required>
<option value=''>Выберите категорию</option>
@foreach ($categories as $category)
	<option value="{{ $category->id }}" {{ $category->id == old('draft_category_id') ? 'selected' : '' }}>{{ $category->name }} - {{ $category->description }}</option>
@endforeach
</select>
<input type="text" name="draft_city" maxlength="50" value="{{ old('draft_city') ? old('draft_city') : $user->city }}" placeholder="Город, район" required><br />
<input type="text" name="draft_phone" maxlength="25" value="{{ old('draft_phone') ? old('draft_phone') : $user->phone }}" placeholder="Телефон для связи" required><br />
<input type="text" name="price" value="{{ old('price') }}" maxlength="8" onkeyup="isNum(this)" autocomplete="off" placeholder="Цена в рублях"><br />
<input type="file" name="image" accept=".jpg, .png, .jpeg, .gif" placeholder="Выберите изображение"><br />
<input type="submit" id="create" value="Создать" style="display: none;"  />
</form>

<label for="create">Создать</label> 

</section>
</div>
<script>
"use strict";
function isNum(field) {
	let valArray = field.value.trim().split('');
	let res = '';
	for (let i in valArray) {
		res += !isNaN(Number(valArray[i])) ? valArray[i] : '' ;
	}
	field.value = res;
}
</script>
@endsection