@extends('backend.layout')
@section('content')

@if (Session::has('message')) 
<div class="container-resp pt-20">
<div class="alert">{{ Session::get('message') }}</div>
</div>
@endif

<div class="container-resp pt-20">
<h2>{{ $title }}</h2>
<div id="categoriesList">
@foreach ($categories as $category)
<section class="res-element @if ($category->on_off) 'status-on' @endif" id="category-id-{{$category->id}}">
<input type="text" id="category-name-{{$category->id}}" placeholder="Название категории" value="{{$category->name}}">
<input type="text" id="category-descpiption-{{$category->id}}" placeholder="Описание категории" value="{{$category->description}}">
<div id="category-alert-{{$category->id}}"></div>
<label onclick="update({{$category->id}})">Сохранить изменения</label>
<label onclick="on({{$category->id}})">Включить</label>
<label onclick="off({{$category->id}})">Выключить</label>
<label for="" onclick="if(confirm('Удалить безвозвратно?')){destroy({{$category->id}})}">Удалить</label>
</section>
@endforeach
</div>

<section class="res-element bg-white">
<input type="text" id="NewCategoryName" name="name" placeholder="Название категории">
<input type="text" id="NewCategoryDescription" name="descpiption" placeholder="Описание категории">
<label id="createNewCategory" onclick="create()">Добавить категорию</label>
</section>

{{ $categories->links('backend.pagination') }}
</div>



<script type="text/javascript">
"use strict";

window.onload = function() {

  let baseUrl = "{{ url('/category') }}";
  let categoriesList = document.getElementById('categoriesList');

  // Создание новой категории
  window.create = function() {
    // Проверить, что поля заполнены
    let name = document.getElementById('NewCategoryName').value;
    let description = document.getElementById('NewCategoryDescription').value;

    if (!name || !description) return;

    let newData = { 
      name: name,
      description: description,
    };

    ajaxHelper(baseUrl+"/create", newData, 1);

    // После создания очистить поля
    document.getElementById('NewCategoryName').value = '';
    document.getElementById('NewCategoryDescription').value = '';
  }

  window.update = function(id) {
    let name = document.getElementById('category-name-'+id).value;
    let description = document.getElementById('category-descpiption-'+id).value;

    let newData = { 
      name: name,
      description: description,
    };

    let url = baseUrl+"/"+id+"/update";
    ajaxHelper(url, newData, null);
  }

  window.on = function(id) {
    let url = baseUrl+"/"+id+"/on";
    ajaxHelper(url, null, 2);
  }

  window.off = function(id) {
    let url = baseUrl+"/"+id+"/off";
    ajaxHelper(url, null, 3);
  }

  window.destroy = function(id) {
    console.log(id);
    let url = baseUrl+"/"+id+"/destroy";
    ajaxHelper(url, null, null);
    document.getElementById('category-id-'+id).remove();
  }

  function ajaxHelper(url, data, action) {
    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        console.log(this.responseText);
        if (action === 1) {
          createBlock(this.responseText, data.name, data.description);
        }
        if (action === 2) {
          document.getElementById('category-alert-'+this.responseText).innerHTML = '<div class="alert">Категория включена и показывается</div>';
          document.getElementById('category-id-'+this.responseText).classList.add("status-on");
        }
        if (action === 3) {
          document.getElementById('category-alert-'+this.responseText).innerHTML = '<div class="alert">Категория выключена из показов</div>';
          document.getElementById('category-id-'+this.responseText).classList.remove("status-on");
        }
      }
    };
    xhttp.open("POST", url, true);
    xhttp.setRequestHeader("Accept", "application/json");
    xhttp.setRequestHeader("Content-type", "application/json;charset=utf-8");
    xhttp.setRequestHeader("X-CSRF-Token", "{{ csrf_token() }}");
    xhttp.send(JSON.stringify(data));
  }

  // Создает динамический блок созданной категории
  function createBlock(id, name, description) {
    // Создаем блок категории
    let newCategory = document.createElement('section');
    newCategory.id = "category-id-"+id;
    newCategory.classList.add("res-element");

    // Создаем поле "Имя"
    let newCategoryNameField = document.createElement('input');
    newCategoryNameField.id = "category-name-"+id;
    newCategoryNameField.value = name;

    // Создаем поле "Описание"
    let newCategoryDescriptionField = document.createElement('input');
    newCategoryDescriptionField.id = "category-descpiption-"+id;
    newCategoryDescriptionField.value = description;

    // Создаем кнопку "Сохранить изменения"
    let newCategoryUpdateButton = document.createElement('label');
    newCategoryUpdateButton.onclick = function () {
      update(id);
    };
    newCategoryUpdateButton.innerHTML = "Сохранить изменения";

    // Создаем кнопку "Включить"
    let newCategoryOnButton = document.createElement('label');
    newCategoryOnButton.onclick = function () {
      on(id);
    };
    newCategoryOnButton.innerHTML = "Включить";

    // Создаем кнопку "Выключить"
    let newCategoryOffButton = document.createElement('label');
    newCategoryOffButton.onclick = function () {
      off(id);
    };
    newCategoryOffButton.innerHTML = "Выключить";

    // Создаем кнопку "Удалить"
    let newCategoryDeleteButton = document.createElement('label');
    newCategoryDeleteButton.onclick = function () {
      if(confirm('Удалить безвозвратно?')) {
        destroy(id);
      }
    };
    newCategoryDeleteButton.innerHTML = "Удалить";

    newCategory.appendChild(newCategoryNameField);
    newCategory.appendChild(newCategoryDescriptionField);
    newCategory.appendChild(newCategoryUpdateButton);
    newCategory.appendChild(newCategoryOnButton);
    newCategory.appendChild(newCategoryOffButton);
    newCategory.appendChild(newCategoryDeleteButton);
    categoriesList.appendChild(newCategory);
  }
};

</script>
@endsection