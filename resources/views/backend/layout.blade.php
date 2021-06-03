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

        <link rel="icon" href="{{ asset('storage/favicon-32x32.png') }}" type="image/png" sizes="32x32" />
		<link rel="apple-touch-icon" href="{{ asset('storage/favicon-114x114.png') }}" type="image/png" sizes="114x114" />

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('storage/css/style.css') }}?v=1">

    </head>


<header class="bg-light-gray">
<div class="container-resp py-10">
<h2>Личный кабинет</h2>
</div>
</header>
<nav>

<div class="container-resp">
<div class="menu-1">
<span class="menu-1__button">МЕНЮ</span>
<a href="<?php echo url('/'); ?>" class="menu-1__link">Главная</a>
<?php if (Auth::id() == 1) { ?>
<a href="<?php echo url('/moderate'); ?>" class="menu-1__link">Ждут одобрения</a>
 <a href="<?php echo url('/moderate/approved'); ?>" class="menu-1__link">Одобренные</a>
 <a href="<?php echo url('/moderate/rejected'); ?>" class="menu-1__link">Отклоненные</a>
 <a href="<?php echo url('/category'); ?>" class="menu-1__link">Категории</a>
<?php } ?>

<?php if (Auth::id()) { ?>
<a href="<?php echo url('/myadv'); ?>" class="menu-1__link">Мои объявления</a>
<a href="<?php echo url('/myadv/create'); ?>" class="menu-1__link">Добавить новое</a> 
<a href="<?php echo route('card.edit', Auth::id()); ?>" class="menu-1__link">Контакты для объявлений</a>
<?php } ?> 

<?php if (Auth::check()) { ?>
<a href="<?php echo url('/logout'); ?>" class="menu-1__link">Выйти</a>
<?php } else { ?>
<a href="<?php echo url('/login'); ?>" class="menu-1__link">Войти</a>
<a href="<?php echo url('/register'); ?>" class="menu-1__link">Зарегистрироваться</a>
<?php } ?>
</div>
</div>
</nav>

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