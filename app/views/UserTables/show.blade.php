@extends('layouts.scaffold')

@section('main')

<h1>Show UserTable</h1>

<p>{{ link_to_route('UserTables.index', 'Return to all UserTables') }}</p>

<table class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>UserName</th>
				<th>FirstName</th>
				<th>LastName</th>
				<th>Password</th>
		</tr>
	</thead>

	<tbody>
		<tr>
			<td>{{{ $UserTable->UserName }}}</td>
					<td>{{{ $UserTable->FirstName }}}</td>
					<td>{{{ $UserTable->LastName }}}</td>
					<td>{{{ $UserTable->Password }}}</td>
                    <td>{{ link_to_route('UserTables.edit', 'Edit', array($UserTable->id), array('class' => 'btn btn-info')) }}</td>
                    <td>
                        {{ Form::open(array('method' => 'DELETE', 'route' => array('UserTables.destroy', $UserTable->id))) }}
                            {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                    </td>
		</tr>
	</tbody>
</table>

@stop
