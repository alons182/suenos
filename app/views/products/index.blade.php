@extends('layouts.layout')
@section('meta-title')
    Sueños de vida | Products
@stop
@section('content')
    <section class="main">
        <h1>{{ $category }}</h1>
        @include('layouts.partials._filter_products')
        @include('layouts.partials._list_products')
        @if ($products)
           <div class="pagination-container">{{$products->appends(['subcat'=>$selected])->links()}}</div>
       @endif
    </section>
@stop