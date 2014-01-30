@extends('layouts.scaffold')

@section('main')

<h1>All EmployeesAttendances</h1>

<p>{{ link_to_route('EmployeesAttendances.create', 'Add new EmployeesAttendance') }}</p>

@if ($EmployeesAttendances->count())
	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>UserId</th>
				<th>TimeIn</th>
				<th>TimeOut</th>
				<th>ReasonLeave</th>
				<th>HoursWorked</th>
			</tr>
		</thead>

		<tbody>
			@foreach ($EmployeesAttendances as $EmployeesAttendance)
				<tr>
					<td>{{{ $EmployeesAttendance->UserId }}}</td>
					<td>{{{ $EmployeesAttendance->TimeIn }}}</td>
					<td>{{{ $EmployeesAttendance->TimeOut }}}</td>
					<td>{{{ $EmployeesAttendance->ReasonLeave }}}</td>
					<td>{{{ $EmployeesAttendance->HoursWorked }}}</td>
                    <td>{{ link_to_route('EmployeesAttendances.edit', 'Edit', array($EmployeesAttendance->id), array('class' => 'btn btn-info')) }}</td>
                    <td>
                        {{ Form::open(array('method' => 'DELETE', 'route' => array('EmployeesAttendances.destroy', $EmployeesAttendance->id))) }}
                            {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                    </td>
				</tr>
			@endforeach
		</tbody>
	</table>
@else
	There are no EmployeesAttendances
@endif

@stop
