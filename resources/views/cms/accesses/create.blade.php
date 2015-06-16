@extends('cms.home')

@section('content')

	<h5>Modify Role Access for {!! $role[0]->role_name !!}</h5>

		{!! Form::open(array('route' => array('cms.access.store'), 'method' => 'post')) !!}
		{!! Form::hidden('role', $role[0]->id) !!}
		<p>
			<table>
				<thead>
					<tr>
						<th>Module</th>
						<th></th>
						<th>Enabled</th>
					</tr>
				</thead>
				<tbody>

					@foreach(modules() as $module)

					<tr>
						<td>
							{!! strtoupper($module->module_name) !!}
						</td>
						<td style="width: 200px;">							
								<table>
									<tbody>

										@foreach(submenus() as $sub)

											@if($module->id == $sub->module_id)
												<tr>
													<td>
														{!! $sub->submenu_name; !!}
													</td>
													<td>
														{!! Form::checkbox('sub_enabled' . $sub->id); !!} 
													</td>
												</tr>
											@endif

										@endforeach

									</tbody>
								</table>


						</td>
						<td>
							{!! Form::checkbox('module_enabled' . $module->id); !!} 
						</td>
					</tr>

					@endforeach

				</tbody>
			</table>
		</p>

		<p>
			{!! Form::submit('Submit') !!}
		</p>
		{!! Form::close() !!}

@stop