@extends('layouts.layout')

@section('content')
@include('layouts/partials/_banner')
<section class="main">
    <div class="featured-products">
        <h1>Productos Destacados</h1>
        @include('layouts.partials._list_products')
    </div>
</section>
@include('layouts/partials/_section_bottom')
@stop
