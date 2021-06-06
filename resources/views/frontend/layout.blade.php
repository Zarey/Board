<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
   
        @if (isset($title))
        <title>{{ $title }}</title>
        @endif

        @if (isset($description))
        <meta name="description" content="{{ $description }}" />
        @endif

        <link rel="icon" href="{{ e(asset('storage/favicon-32x32.png')) }}" type="image/png" sizes="32x32" />
        <link rel="apple-touch-icon" href="{{ e(asset('storage/favicon-114x114.png')) }}" type="image/png" sizes="114x114" />

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('storage/css/style.css') }}?v=1">

    </head>

<nav class="">
<div class="container-resp">
<div class="menu-1">
<span class="menu-1__button">МЕНЮ</span>
<a href="{{ url('/') }}" class="menu-1__link">Главная</a>
@if (Auth::check())
<a href="{{ url('/myadv') }}" class="menu-1__link">Личный кабинет</a>
<a href="{{ url('/myadv/create') }}" class="menu-1__link">Добавить объявление</a>
@endif

@if (Auth::check())
<a href="{{ url('/logout') }}" class="menu-1__link">Выйти</a>
@else
<a href="{{ url('/login') }}" class="menu-1__link">Войти</a>
<a href="{{ url('/register') }}" class="menu-1__link">Зарегистрироваться</a>
@endif
</div>
</div>
</nav>

<header class="bg-blue text-white">
<div class="container-resp">
<div class="frontend-header">
<h1>Доска бесплатных объявлений Сочи</h1>
</div>
</div>
</header>

<main class="bg-light-gray">
@yield('content')
</main>

<footer class="bg-black text-light-gray">
<div class="container-resp py-20">
<small>Доска объявлений Сочи LYNG.RU © 2021</small>
</div>
</footer>

<!-- Scripts -->
<script type="text/javascript" src="{{ asset('storage/js/menu.js') }}" charset="UTF-8"></script>

@extends('metrika')