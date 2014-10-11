@extends('layouts.layout')

@section('content')
    <section class="main register">
        <h1>Formulario de pago</h1>
        <div class="col-1">
            {{ Form::open(['route' => 'cart_checkout.confirm']) }}
             <!-- First name Form Input -->
            <div class="form-group">
                {{ Form::label('first_name', 'Nombre:') }}
                {{ Form::text('first_name', $currentUser->profiles->first_name, ['class' => 'form-control']) }}
                {{ errors_for('first_name',$errors) }}
            </div>
            <!-- Last name Form Input -->
            <div class="form-group">
                {{ Form::label('last_name', 'Apellidos:') }}
                {{ Form::text('last_name', $currentUser->profiles->last_name, ['class' => 'form-control']) }}
                {{ errors_for('last_name',$errors) }}
            </div>
            <!-- Identification Form Input -->
            <div class="form-group">
                {{ Form::label('ide', 'Identificación:') }}
                {{ Form::text('ide', $currentUser->profiles->ide, ['class' => 'form-control']) }}
                {{ errors_for('ide',$errors) }}
            </div>
            <!-- Address Form Input -->
            <div class="form-group">
                {{ Form::label('address', 'Dirección:') }}
                {{ Form::text('address', $currentUser->profiles->address, ['class' => 'form-control']) }}
                {{ errors_for('address',$errors) }}

            </div>

            <!-- Telephone Form Input -->
            <div class="form-group">
                {{ Form::label('telephone', 'Teléfono:') }}
                {{ Form::text('telephone', $currentUser->profiles->telephone, ['class' => 'form-control']) }}
                {{ errors_for('telephone',$errors) }}
            </div>
            <!-- Email Form Input -->
            <div class="form-group">
                {{ Form::label('email', 'Email:') }}
                {{ Form::email('email', $currentUser->email, ['class' => 'form-control', 'required' => 'required']) }}
                {{ errors_for('email',$errors) }}
            </div>
             <!-- card_number Form Input -->
              <div class="form-group">
                 {{ Form::label('card_number', 'Numero de tarjeta:') }}
                 {{ Form::text('card_number', null, ['class' => 'form-control']) }}
                 {{ errors_for('card_number',$errors) }}
              </div>
               <!-- Exp_card Form Input -->
                <div class="form-group">
                   {{ Form::label('exp_card', 'Vencimiento de tarjeta:') }}
                   {{ Form::text('exp_card', null, ['class' => 'form-control','placeholder'=>'mm/yy']) }}
                    {{ errors_for('exp_card',$errors) }}
                </div>


            <!-- Create Account Form Input -->

            <div class="form-group">
                {{ Form::submit('Siguiente paso', ['class' => 'btn btn-primary']) }}
            </div>

            {{ Form::close() }}
        </div>

    </section>
@stop

