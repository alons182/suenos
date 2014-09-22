@extends('layouts.layout')
@section('meta-title')
    Sueños de vida | Products
@stop
@section('content')
    <section class="main">
        <h1>{{ $category }}</h1>
        @include('layouts.partials._list_products')
    </section>
@stop