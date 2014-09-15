@extends('layouts.layout')

@section('content')
<section class="main payments">
    <h1>Balance | <small>Movimientos en tu red de afiliados</small></h1> {{ link_to_route('payments.create', 'Realizar Pago',null,['class'=>'btn btn-primary']) }}

    <div class="gains-container">
        <small>Ganancias</small>
        <div class="gains">
            <h2>Bruta : <span class="amount">{{ money($payments->first(),'₡') }}</span></h2>
            <h2>Neta (Membresia mensual) : <span class="amount">{{ money($payments['gain_neta'],'₡') }}</span></h2>
        </div>

    </div>
    <div class="filters">
        {{ Form::open(['route' => 'payments.index', 'method' => 'get']) }}
        <!-- Mes Form Input -->
        <div class="form-group">
            {{ Form::label('Mes', 'Mes:') }}
            {{ Form::selectMonth('month', $selectedMonth, ['class' => 'form-control']) }}

        </div>
        {{ Form::close() }}
    </div>


    <div class="table-responsive payments-table">

        <table class="table table-striped  ">
            <thead>
            <tr>

                <th>#</th>
                <th>Nombre Afiliado</th>
                <th>Monto</th>
                <th>Ganancia</th>
                <th>Correo</th>
                <th>Telefono</th>
                <th>Tipo de pago</th>
                <th>Fecha</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($payments['payments'] as $payment)
            <tr>

                <td>{{ $payment->id }}</td>
                <td>{{ $payment->users->profiles->present()->fullname }}</td>
                <td>{{ money($payment->amount,'₡') }}</td>
                <td>{{ money($payment->gain,'₡') }}</td>
                <td>
                   {{ $payment->users->email }}
                </td>
                <td> {{ $payment->users->profiles->telephone }}</td>
                <td> {{ $payment->present()->paymentType }}</td>
                <td> {{ $payment->created_at }}</td>

            </tr>
            @empty
             <tr><td colspan="8" style="text-align: center;">No hay movimientos en tu red de afiliados</td></tr>
            @endforelse
            </tbody>
            <tfoot>

            @if ($payments['payments'])
                <td  colspan="7" class="pagination-container">{{$payments['payments']->appends(['month' => $selectedMonth])->links()}}</td>
            @endif


            </tfoot>
        </table>


    </div>
</section>

@stop