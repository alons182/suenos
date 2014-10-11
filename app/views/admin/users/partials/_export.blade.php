<div class="export-users">
{{ Form::open(['route' => 'users_excel','method' => 'get']) }}
           <div class="form-group">

                <div class="controls">
                   {{ Form::selectMonth('month', $currentMonth, ['class' => 'form-control']) }}
                </div>
                <div class="controls">
                   {{ Form::selectYear('year', 2014, 2020, $currentYear, ['class' => 'form-control']) }}
                </div>
                {{ Form::submit('Exportar Reporte',['class'=>'btn btn-info btn-report'])}}
            </div>
        {{ Form::close() }}
</div>
