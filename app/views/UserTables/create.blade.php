@extends('layouts.scaffold')

@section('main')

<h1>Create UserTable</h1>

{{ Form::open(array('route' => 'UserTables.store')) }}
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
			{{ Form::submit('Submit', array('class' => 'btn btn-info')) }}
		</li>
	</ul>
{{ Form::close() }}

@if ($errors->any())
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
@endif

@stop


