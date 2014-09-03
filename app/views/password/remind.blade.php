@extends('layouts.layout')

@section('content')
    <h1>Necesitas resetear tu contraseña?</h1>

    {{ Form::open() }}
        <!-- Email Form Input -->
        <div class="form-group">
            {{ Form::label('email', 'Email:') }}
            {{ Form::email('email', null, ['class' => 'form-control','required']) }}
        </div>
        <!-- Resetear Contraseña Form Input -->
        <div class="form-group">
            {{ Form::submit('Resetear Contraseña', ['class' => 'btn btn-primary']) }}
        </div>
    {{ Form::close() }}
@stop