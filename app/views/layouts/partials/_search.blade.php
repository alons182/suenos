<div class="search">
    {{ Form::open(['route' => 'products_search','method' => 'get','class'=>'form-search']) }}

       <i class="icon-search"></i>
        {{ Form::text('q',isset($search) ? $search : null ,['class'=>'form-control','placeholder'=>'Buscar'])}}

     {{ Form::close() }}


</div>