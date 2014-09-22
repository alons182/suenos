@extends('admin.layouts.layout')

@section('content') 
     
     @include('admin/users/partials/_search')

	<div class="table-responsive">
        {{ link_to_route('user_register','Nuevo Usuario',null,['class'=>'btn btn-success']) }}
        <table class="table table-striped  ">
        <thead>
            <tr>
                <th>#</th>
                <th>Username</th>
                <th>Email</th>
                <th>Tipo</th>
                <th>Creado</th>
                <th><i class="icon-cog"></i></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ link_to_route('store.admin.users.edit', $user->username, $user->id) }}
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->user_type }}</td>
                    <td>{{ $user->created_at }}</td>
                    <td>
                                             
                       
                    {{ Form::open(['route' => ['store.admin.users.destroy', $user->id ], 'method' => 'delete', 'data-confirm' => 'Estas seguro?']) }}
                        <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                    {{ Form::close() }}
                         

                        
                    </td>
                    
                </tr>
            @endforeach
        </tbody>
       <tfoot>

             @if ($users) 
                <td  colspan="10" class="pagination-container">{{$users->appends(['q' => $search])->links()}}</td>
            @endif 
             
        </tfoot>
    </table>
    </div>  


@stop