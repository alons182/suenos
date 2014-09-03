@extends('layouts.layout')
@section('meta-title')
Sueños de vida | Contáctenos
@stop
@section('content')


<section class="main contact">
    <h1>Contáctenos</h1>
    <p class="intro">"Llamános o escribínos para solucionar cualquier duda o consulta que tengas, en <b>Sueños de vida</b>
        estamos para servirle !!"</p>
    <address class="contact-address">
        <span>info@sueñosdevida.com</span><br/>
        <span>2666 6666</span>
    </address>

    <div class="col-1">


        {{ Form::open(['route'=>'contact.store','class'=>'form-contact']) }}

        <div class="form-group">
            <div class="label-container">
                {{ Form::label('name','Nombre:')}}
            </div>
            <div class="input-container">
                {{ Form::text('name',null,['class'=>'form-control','required'=>'required'])}}
                {{ errors_for('name',$errors) }}
            </div>

        </div>
        <div class="form-group">
            <div class="label-container">
                {{ Form::label('email','Email:')}}
            </div>
            <div class="input-container">
                {{ Form::email('email',null,['class'=>'form-control','required'=>'required'])}}
                {{ errors_for('email',$errors) }}
            </div>
        </div>
        <div class="form-group">

            {{ Form::textarea('comment',null,['class'=>'form-control']) }}
            {{ errors_for('comment',$errors) }}
        </div>
        <div class="form-group">
            {{ Form::submit('Enviar',['class'=>'btn btn-primary'])}}
        </div>

        {{ Form::close() }}
    </div>


</section>


@stop