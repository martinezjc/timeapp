@extends('layouts.scaffold')

@section('main')

<h1>Edit Info</h1>
{{ Form::model($info, array('method' => 'PATCH', 'route' => array('infos.update', $info->id))) }}
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
			{{ link_to_route('infos.show', 'Cancel', $info->id, array('class' => 'btn')) }}
		</li>
	</ul>
{{ Form::close() }}

@if ($errors->any())
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
@endif

@stop
