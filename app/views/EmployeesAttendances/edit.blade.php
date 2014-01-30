@extends('layouts.scaffold')

@section('main')

<h1>Edit EmployeesAttendance</h1>
{{ Form::model($EmployeesAttendance, array('method' => 'PATCH', 'route' => array('EmployeesAttendances.update', $EmployeesAttendance->id))) }}
	<ul>
        <li>
            {{ Form::label('UserId', 'UserId:') }}
            {{ Form::input('number', 'UserId') }}
        </li>

        <li>
            {{ Form::label('TimeIn', 'TimeIn:') }}
            {{ Form::text('TimeIn') }}
        </li>

        <li>
            {{ Form::label('TimeOut', 'TimeOut:') }}
            {{ Form::text('TimeOut') }}
        </li>

        <li>
            {{ Form::label('ReasonLeave', 'ReasonLeave:') }}
            {{ Form::text('ReasonLeave') }}
        </li>

        <li>
            {{ Form::label('HoursWorked', 'HoursWorked:') }}
            {{ Form::text('HoursWorked') }}
        </li>

		<li>
			{{ Form::submit('Update', array('class' => 'btn btn-info')) }}
			{{ link_to_route('EmployeesAttendances.show', 'Cancel', $EmployeesAttendance->id, array('class' => 'btn')) }}
		</li>
	</ul>
{{ Form::close() }}

@if ($errors->any())
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
@endif

@stop
