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
<label onclick="update({{$category->id}})">Сохранить изменения</label> <label onclick="on({{$category->id}})">Включить</label> <label onclick="off({{$category->id}})">Выключить</label> <label for="" onclick="if(confirm('Удалить безвозвратно?')){destroy({{$category->id}})}">Удалить</label>
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
	document.getElementById('createNewCategory').onclick = function() {
		let NewCategoryName = document.getElementById('NewCategoryName').value;
		let NewCategoryDescription = document.getElementById('NewCategoryDescription').value;
		if (NewCategoryName != '' && NewCategoryDescription != '') {
			let newCategory = {
				name: NewCategoryName,
				description: NewCategoryDescription,
			};
			//
			loadDoc(newCategory)
		}
	}
}

function loadDoc(data) {
  let xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      console.log(this.responseText);
      window.location.reload();
      // А вообще нужно получить ID и другие данные созданной страницы и добавлять снизу
    }
  };
  xhttp.open("POST", "<?php echo url('/category/create'); ?>", true);
  xhttp.setRequestHeader("Accept", "application/json");
  xhttp.setRequestHeader("Content-type", "application/json;charset=utf-8");
  xhttp.setRequestHeader("X-CSRF-Token", "{{ csrf_token() }}");
  xhttp.send(JSON.stringify(data));
}

function update(id) {
	let name = document.getElementById('category-name-'+id).value;
	let description = document.getElementById('category-descpiption-'+id).value;

	let newData = { 
		name: name,
		description: description,
	};
	console.log(newData)
	
  let xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      console.log(this.responseText);
      document.getElementById('category-alert-'+id).innerHTML = '<div class="alert">Изменения сохранены!</div>';
    }
  };
  xhttp.open("POST", "<?php echo url('/category'); ?>/"+id+"/update", true);
  xhttp.setRequestHeader("Accept", "application/json");
  xhttp.setRequestHeader("Content-type", "application/json;charset=utf-8");
  xhttp.setRequestHeader("X-CSRF-Token", "{{ csrf_token() }}");
  xhttp.send(JSON.stringify(newData));
}

function destroy(id) {
  let url = "<?php echo url('/category'); ?>/"+id+"/destroy";
  let message = "Категория удалена";
  if (ajaxHelper(url, id, message)) {
    document.getElementById('category-id-'+id).remove();
  }
}

function on(id) {
  let url = "<?php echo url('/category'); ?>/"+id+"/on";
  let message = "Категория включена и показывается";
  ajaxHelper(url, id, message);
}

function off(id) {
  let url = "<?php echo url('/category'); ?>/"+id+"/off";
  let message = "Категория выключена из показов";
  ajaxHelper(url, id, message);
}

function ajaxHelper(url, id, message) {
  let xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      console.log(this.responseText);
      document.getElementById('category-alert-'+id).innerHTML = '<div class="alert">'+message+'</div>';
    }
  };
  xhttp.open("POST", url, true);
  xhttp.setRequestHeader("Accept", "application/json");
  xhttp.setRequestHeader("Content-type", "application/json;charset=utf-8");
  xhttp.setRequestHeader("X-CSRF-Token", "{{ csrf_token() }}");
  xhttp.send();
}
</script>