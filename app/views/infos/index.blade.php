@extends('layouts.scaffold')

@section('main')

<h1>All Infos</h1>

<p>{{ link_to_route('infos.create', 'Add new info') }}</p>

@if ($infos->count())
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
			@foreach ($infos as $info)
				<tr>
					<td>{{{ $info->UserId }}}</td>
					<td>{{{ $info->TimeIn }}}</td>
					<td>{{{ $info->TimeOut }}}</td>
					<td>{{{ $info->ReasonLeave }}}</td>
					<td>{{{ $info->HoursWorked }}}</td>
                    <td>{{ link_to_route('infos.edit', 'Edit', array($info->id), array('class' => 'btn btn-info')) }}</td>
                    <td>
                        {{ Form::open(array('method' => 'DELETE', 'route' => array('infos.destroy', $info->id))) }}
                            {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                    </td>
				</tr>
			@endforeach
		</tbody>
	</table>
@else
	There are no infos
@endif

@stop
