@extends('layouts.layout')

@section('content')
<section class="main payments">
    <h1>Balance | <small>Movimientos en tu red de afiliados</small></h1> {{ link_to_route('payments.create', 'Realizar Pago',null,['class'=>'btn btn-primary']) }}

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


            </tr>
            @empty
             <tr><td colspan="7" style="text-align: center;">No hay movimientos en tu red de afiliados</td></tr>
            @endforelse
            </tbody>
            <tfoot>

            @if ($payments['payments'])
                <td  colspan="7" class="pagination-container">{{$payments['payments']->links()}}</td>
            @endif


            </tfoot>
        </table>
        <h2>Ganancia : {{ money($payments->first(),'₡') }}</h2>

    </div>
</section>

@stop