<div class="form-group">
	{{ Form::submit(isset($buttonText) ? $buttonText : 'Crear Usuario',['class'=>'btn btn-primary'])}}
	{{ link_to_route('users', 'Cancelar', null, ['class'=>'btn btn-default'])}}

</div>
<div class="col-xs-12 col-sm-6">
		 <!-- Patrocinador Form Input -->
        {{ Form::hidden('parent_id', isset($parent_user) ? $parent_user->id : null, ['class' => 'form-control']) }}
		<div class="form-group">
			{{ Form::label('username','Username:')}}
			{{ Form::text('username',null,['class'=>'form-control','required'=>'required'])}}
			{{ errors_for('username',$errors) }}

		</div>
		<div class="form-group">
			{{ Form::label('email','Email:')}}
			{{ Form::email('email',null,['class'=>'form-control','required'=>'required'])}}
			{{ errors_for('email',$errors) }}
		</div>
		<div class="form-group">
			{{ Form::label('role','Tipo:')}}
			{{ Form::select('role',['1'=>'Administrator','2'=>'Regular'], (isset($user))? $user->roles->first()->id : null,['class'=>'form-control','required'=>'required'])}}
			{{ errors_for('user_type',$errors) }}
		</div>
		<div class="form-group">
			{{ Form::label('password','Password:')}}
			{{ Form::password('password',['class'=>'form-control'])}}
			{{ errors_for('password',$errors) }}

		</div>
		<div class="form-group">
			{{ Form::label('password_confirmation','Confirmación de Password:')}}
			{{ Form::password('password_confirmation',['class'=>'form-control'])}}

		</div>
		
</div>