@extends('layouts.layout')

@section('content')
<h1>Resetea tu contraseña</h1>

{{ Form::open() }}
    {{ Form::hidden('token',$token) }}

<!-- Email Form Input -->
<div class="form-group">
    {{ Form::label('email', 'Email:') }}
    {{ Form::email('email', null, ['class' => 'form-control', 'required']) }}
</div>
<!-- Password Form Input -->
<div class="form-group">
    {{ Form::label('password', 'Contraseña:') }}
    {{ Form::password('password', ['class' => 'form-control', 'required']) }}
</div>
<!-- Password_confirmation Form Input -->
<div class="form-group">
    {{ Form::label('password_confirmation', 'Confirma la contraseña:') }}
    {{ Form::password('password_confirmation', ['class' => 'form-control', 'required']) }}
</div>
<!-- Enviar Form Input -->
<div class="form-group">
    {{ Form::submit('Enviar', ['class' => 'btn btn-primary']) }}
</div>
{{ Form::close() }}
@stop