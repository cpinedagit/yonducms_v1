@extends('cms.home')

@section('content')

	<h5>Modify Role Access for {!! $data->role[0]->role_name !!}</h5>

		{!! Form::open(array('route' => array('cms.roleaccess.modifyAccess'), 'method' => 'post')) !!}
		{!! Form::hidden('role', $data->role[0]->id) !!}
		<p>
			<table class="table">
				<thead>
					<tr>
						<td>Modules</td>
						<td>Add</td>
						<td>Edit</td>
						<td>Delete</td>
						<td>View</td>
					</tr>
				</thead>
				<tbody>
					@foreach($data->modules as $module)
						@foreach($data->roleAccesses as $access)
							@if($module->id == $access->module_id)
								<tr>
									<td>
										{!! $module->module_name !!}
									</td>
									<td>
										{!! Form::checkbox('add' . $module->id, $access->addflag, $access->addflag) !!}
									</td>
									<td>
										{!! Form::checkbox('edit' . $module->id, $access->editflag, $access->editflag) !!}
									</td>
									<td>
										{!! Form::checkbox('delete' . $module->id, $access->deleteflag, $access->deleteflag) !!}
									</td>
									<td>
										{!! Form::checkbox('isactive' . $module->id, $access->isactive, $access->isactive) !!}
									</td>
								</tr>
							@endif
						@endforeach
					@endforeach
					<tr>
					</tr>
				</tbody>
			</table>
		</p>

		<p>
			{!! Form::submit('Submit') !!}
		</p>
		{!! Form::close() !!}

@stop