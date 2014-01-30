@extends('layouts.scaffold')

@section('main')

<h1>Edit UserTable</h1>
{{ Form::model($UserTable, array('method' => 'PATCH', 'route' => array('UserTables.update', $UserTable->id))) }}
	<ul>
        <li>
            {{ Form::label('UserName', 'UserName:') }}
            {{ Form::text('UserName') }}
        </li>

        <li>
            {{ Form::label('FirstName', 'FirstName:') }}
            {{ Form::text('FirstName') }}
        </li>

        <li>
            {{ Form::label('LastName', 'LastName:') }}
            {{ Form::text('LastName') }}
        </li>

        <li>
            {{ Form::label('Password', 'Password:') }}
            {{ Form::text('Password') }}
        </li>

		<li>
			{{ Form::submit('Update', array('class' => 'btn btn-info')) }}
			{{ link_to_route('UserTables.show', 'Cancel', $UserTable->id, array('class' => 'btn')) }}
		</li>
	</ul>
{{ Form::close() }}

@if ($errors->any())
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
@endif

@stop
