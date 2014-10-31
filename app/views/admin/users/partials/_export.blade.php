<div class="export-users">
    <div class="export-usersGains">
        {{ Form::open(['route' => 'users_gains_excel','method' => 'get']) }}
           <div class="form-group">

                <div class="controls">
                   {{ Form::selectMonth('month', $currentMonth, ['class' => 'form-control']) }}
                </div>
                <div class="controls">
                   {{ Form::selectYear('year', 2014, 2020, $currentYear, ['class' => 'form-control']) }}
                </div>
                {{ Form::submit('Exportar Reporte Ganacias',['class'=>'btn btn-info btn-report'])}}
            </div>
        {{ Form::close() }}
    </div>
    <div class="export-usersPayment">
    {{ Form::open(['route' => 'users_payments_excel','method' => 'get']) }}


               <div class="form-group">
                    <div class="controls">
                      {{ Form::text('payment_date', null, ['class' => 'form-control datepicker','placeholder'=>'Fecha']) }}
                   </div>
                    {{ Form::submit('Exportar Reporte Pago Diario',['class'=>'btn btn-info btn-report'])}}
                </div>

            {{ Form::close() }}
    </div>
</div>

