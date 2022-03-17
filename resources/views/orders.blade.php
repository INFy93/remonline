@extends('layouts.app')

@section('title')Заказы@endsection

@section('content')

<h3 class=" mt-2 text-3xl flex sm:text-3xl text-gray-800 dark:text-white font-extrabold tracking-tight">
    Заказы</h3>
<div class="mt-5 mr-5">
<orders-component></orders-component>
</div>
@endsection
