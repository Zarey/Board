@extends('backend.layout')
@section('content')

@if (Session::has('message')) 
<div class="container-resp pt-20">
<div class="alert">{{ Session::get('message') }}</div>
</div>
@endif

<div class="container-resp pt-20">
<h2>{{ $title }}</h2>
<?php foreach ($categories as $category) { ?>
<section class="res-element bg-white" id="category-id-{{$category->id}}">
<input type="text" id="category-name-{{$category->id}}" placeholder="Название категории" value="{{$category->name}}">
<input type="text" id="category-descpiption-{{$category->id}}" placeholder="Описание категории" value="{{$category->description}}">
<div id="category-alert-{{$category->id}}"></div>
<label onclick="update({{$category->id}})">Сохранить изменения</label>
<label onclick="on({{$category->id}})">Включить</label>
<label onclick="off({{$category->id}})">Выключить</label>
<label for="" onclick="if(confirm('Удалить безвозвратно?')){destroy({{$category->id}})}">Удалить</label>
</section>
<?php } ?>

<section class="res-element bg-white">
<input type="text" id="NewCategoryName" name="name" placeholder="Название категории">
<input type="text" id="NewCategoryDescription" name="descpiption" placeholder="Описание категории">
<label id="createNewCategory">Добавить категорию</label>
</section>

{{ $categories->links('backend.pagination') }}
</div>
@endsection

<script type="text/javascript">
"use strict";

window.onload = function() {
  let url = "<?php echo url('/category'); ?>";
  console.log(url);

  // Создание новой категории
  document.getElementById('createNewCategory').onclick = function() {
    console.log('hello');
  }

}











</script>