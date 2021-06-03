@extends('frontend.layout')
@section('content')

<div class="container-resp pt-20">
<section class="res-element bg-white">
<h2><?php echo $user->name ?></h2>

Телефон: <a href="tel:<?php echo $user->phone ?>"><?php echo $user->phone ?></a><br />
Город: <?php echo $user->city ?><br />
На сайте с <?php echo date_format($user->created_at, 'd/m/Y'); ?><br />
</section>
</div>



<?php 
// Осталось только вывести в профиле с пагинацией...
//echo"<xmp>";print_r($advertisements);echo"</xmp>"; 
// echo"<xmp>";print_r($user);echo"</xmp>"; 
?>

@endsection