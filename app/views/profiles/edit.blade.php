@extends('layouts.layout')

@section('content')
<section class="main profile">


        <h1>Edit Profile</h1>
        {{ Form::model($user->profiles, ['method' => 'PATCH', 'route' => ['profile.update', $user->username]]) }}
    <div class="col-1">
        <!-- First name Form Input -->
        <div class="form-group">
            {{ Form::label('first_name', 'Nombre:') }}
            {{ Form::text('first_name', null, ['class' => 'form-control']) }}
            {{ errors_for('first_name',$errors) }}
        </div>
        <!-- Last name Form Input -->
        <div class="form-group">
            {{ Form::label('last_name', 'Apellidos:') }}
            {{ Form::text('last_name', null, ['class' => 'form-control']) }}
            {{ errors_for('last_name',$errors) }}
        </div>
        <!-- Identification Form Input -->
        <div class="form-group">
            {{ Form::label('ide', 'Identificación:') }}
            {{ Form::text('ide', null, ['class' => 'form-control']) }}
            {{ errors_for('ide',$errors) }}
        </div>
        <!-- Address Form Input -->
        <div class="form-group">
            {{ Form::label('address', 'Dirección:') }}
            {{ Form::text('address', null, ['class' => 'form-control']) }}
            {{ errors_for('address',$errors) }}

        </div>
        <!-- Code Zip Form Input -->
        <div class="form-group">
            {{ Form::label('code_zip', 'Code Zip:') }}
            {{ Form::text('code_zip', null, ['class' => 'form-control']) }}
            {{ errors_for('code_zip',$errors) }}
        </div>
        <!-- Telephone Form Input -->
        <div class="form-group">
            {{ Form::label('telephone', 'Teléfono:') }}
            {{ Form::text('telephone', null, ['class' => 'form-control']) }}
            {{ errors_for('telephone',$errors) }}
        </div>
        <!-- Country Form Input -->
        <div class="form-group">
            {{ Form::label('country', 'País:') }}
            {{ Form::text('country', null, ['class' => 'form-control']) }}
            {{ errors_for('country',$errors) }}
        </div>


    </div>
    <div class="col-2">
        <!-- Estate Form Input -->
        <div class="form-group">
            {{ Form::label('estate', 'Provincia:') }}
            {{ Form::text('estate', null, ['class' => 'form-control']) }}
            {{ errors_for('estate',$errors) }}
        </div>
        <!-- City Form Input -->
        <div class="form-group">
            {{ Form::label('city', 'Ciudad:') }}
            {{ Form::text('city', null, ['class' => 'form-control']) }}
            {{ errors_for('city',$errors) }}
        </div>

        <!-- Bank Form Input -->
        <div class="form-group">
            {{ Form::label('bank', 'Banco:') }}
            {{ Form::text('bank', null, ['class' => 'form-control']) }}
            {{ errors_for('bank',$errors) }}
        </div>
        <!-- Type Account Form Input -->
        <div class="form-group">
            {{ Form::label('type_account', 'Tipo de cuenta bancaria:') }}
            {{ Form::text('type_account', null, ['class' => 'form-control']) }}
            {{ errors_for('type_account',$errors) }}
        </div>
        <!-- Number Account Form Input -->
        <div class="form-group">
            {{ Form::label('number_account', 'Numero de cuenta bancaria:') }}
            {{ Form::text('number_account', null, ['class' => 'form-control']) }}
            {{ errors_for('number_account',$errors) }}
        </div>
        <!-- Nit Form Input -->
        <div class="form-group">
            {{ Form::label('nit', 'Nit:') }}
            {{ Form::text('nit', null, ['class' => 'form-control']) }}
            {{ errors_for('nit',$errors) }}
        </div>
        <!-- Skype Form Input -->
        <div class="form-group">
            {{ Form::label('skype', 'Skype:') }}
            {{ Form::text('skype', null, ['class' => 'form-control']) }}
            {{ errors_for('skype',$errors) }}
        </div>
    </div>
       <div class="well">
           <!-- Update Profile Form Input -->
           <div class="form-group">
               {{ Form::submit('Actualizar Perfil', ['class' => 'btn btn-primary']) }}
           </div>

       <div>
        {{ Form::close() }}

</section>
@stop