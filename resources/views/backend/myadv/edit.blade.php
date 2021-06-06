@extends('backend.layout')
@section('content')
<div class="container-resp pt-20">

<h2>{{ $title }}</h2>

<section class="res-element bg-white">

@if (Session::has('message')) 
<div class="alert">{{ Session::get('message') }}</div>
@endif
@if ($advertisement->status == 2)
<div class="alert">Объявление одобрено модератором</div>
@elseif ($advertisement->status == 3)
<div class="alert">Объявление отклонено. Попробуйте изменить текст</div>
@endif

@if ($advertisement->status == 0)
<div class="alert">После одобрения модератором, объявление появится в поиске</div>
@elseif ($advertisement->status == 1)
<div class="alert">После одобрения модератором, объявление появится в поиске</div>
@elseif (!$advertisement->on_off)
<div class="alert">Чтобы шли показы, включите объявление!</div>
@endif

<form action="{{ route('myadv.update', $id) }}" enctype="multipart/form-data" method="POST">
@csrf
@method('PUT')
<input type="text" name="draft_header" maxlength="35" value="{{ $advertisement->draft_header }}" autocomplete="off" placeholder="Заголовок объявления" required><br />
<textarea rows="7" name="draft_advcontent" maxlength="2000" placeholder="Текст объявления" required>{{ $advertisement->draft_advcontent }}</textarea><br />
<select name="draft_category_id" required>
<option value=''>Выберите категорию</option>
@foreach ($categories as $category)
	<option value="{{ $category->id }}" {{ $category->id == $advertisement->draft_category_id ? 'selected' : '' }}>{{ $category->name }} - {{ $category->description }}</option>
@endforeach
</select>
<input type="text" name="draft_city" maxlength="50" value="{{ $advertisement->draft_city }}" autocomplete="off" placeholder="Город, район" required><br />
<input type="text" name="draft_phone" maxlength="25" value="{{ $advertisement->draft_phone }}" autocomplete="off" placeholder="Телефон для связи" required><br />
<input type="text" name="price" maxlength="8" onkeyup="isNum(this)" value="{{ $advertisement->price }}" autocomplete="off" placeholder="Цена в рублях"><br />
<input type="file" name="image" accept=".jpg, .png, .jpeg, .gif" placeholder="Выберите изображение"><br />
<input type="submit" id="update" value="Обновить" style="display: none;" />
</form>

@if ($advertisement->draft_image)
<img src="{{ asset('storage/images/'.$advertisement->draft_image) }}" class="mb-10" />
@endif

<form action="{{ route('myadv.destroy', $id) }}" method="POST" onsubmit="if(!confirm('Удалить безвозвратно? У Вас есть возможность просто отключить показы.')){return false;}">
@csrf
@method('DELETE')
<input type="submit" id="delete"  value="Удалить" style="display: none;" />
</form>

<form action="{{ route('myadv.up', $id) }}" method="POST">
@csrf
@method('POST')
<input type="submit" id="up" value="Поднять" style="display: none;" />
</form>

<form action="{{ route('myadv.on', $id) }}" method="POST">
@csrf
@method('POST')
<input type="submit" id="on" value="Включить" style="display: none;" />
</form>

<form action="{{ route('myadv.off', $id) }}" method="POST">
@csrf
@method('POST')
<input type="submit" id="off" value="Отключить" style="display: none;" />
</form>


 <label for="update">Обновить</label>
 <label for="delete">Удалить</label>
@if (strtotime($advertisement->up_adv)+604800 < strtotime(now()))
 <label for="up">Поднять</label>
@endif

@if ($advertisement->on_off)
 <label for="off">Отключить показы</label>
@else
 <label for="on">Включить показы</label>
@endif

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

