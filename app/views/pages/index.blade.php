@extends('layouts.layout')

@section('content')
@include('layouts/partials/_banner')
<section class="main">
    <div class="featured-products">

        <h1>Productos Destacados</h1>
        <div class="product">
            <figure class="img">
                <a href="#"><img src="img/products/product.jpg" alt="product" /></a>
            </figure>
            <div class="min-description">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit.
            </div>
            <div class="price">
                $288.86
            </div>
            <a href="#" class="btn btn-purple">Agregar al carro</a>
        </div>
        <div class="product">
            <figure class="img">
                <a href="#"><img src="img/products/product2.jpg" alt="product" /></a>
            </figure>
            <div class="min-description">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit.
            </div>
            <div class="price">
                $328.86
            </div>
            <a href="#" class="btn btn-purple">Agregar al carro</a>
        </div>
        <div class="product">
            <figure class="img">
                <a href="#"><img src="img/products/product3.jpg" alt="product" /></a>
            </figure>
            <div class="min-description">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit.
            </div>
            <div class="price">
                $408.86
            </div>
            <a href="#" class="btn btn-purple">Agregar al carro</a>
        </div>
        <div class="product">
            <figure class="img">
                <a href="#"><img src="img/products/product.jpg" alt="product" /></a>
            </figure>
            <div class="min-description">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit.
            </div>
            <div class="price">
                $408.86
            </div>
            <a href="#" class="btn btn-purple">Agregar al carro</a>
        </div>
    </div>
</section>
@include('layouts/partials/_section_bottom')
@stop
