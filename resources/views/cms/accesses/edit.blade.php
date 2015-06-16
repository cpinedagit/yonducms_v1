@extends('cms.home')

@section('content')
	<h5>Modify Role Access for {!! $role[0]->role_name !!}</h5>
		{!! Form::open(array('route' => array('cms.access.modifyAccess'), 'method' => 'post')) !!}
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
						@foreach($access as $acc)
							@if($module->id == $acc->module_id)
								<tr>
									<td>
										{!! strtoupper($module->module_name) !!}
									</td>
									<td style="width: 200px;">							
											<table>
												<tbody>

													@foreach(submenus() as $sub)

														@if($module->id == $sub->module_id)
															@foreach($subAccess as $subAcc)
																@if($sub->id == $subAcc->submenu_id)
																	<tr>
																		<td>
																			{!! $sub->submenu_name; !!}
																		</td>
																		<td>
																			{!! Form::checkbox('sub_enabled' . $sub->id, $subAcc->is_enabled, $subAcc->is_enabled,
																				array('class' => 'module_checkbox')); !!} 
																		</td>
																	</tr>
																@endif
															@endforeach
														@endif

													@endforeach

												</tbody>
											</table>


									</td>
									<td>
										{!! Form::checkbox('module_enabled' . $module->id, $acc->is_enabled, $acc->is_enabled, array('class' => 'module_checkbox')); !!} 
									</td>
								</tr>
							@endif
						@endforeach
					@endforeach

				</tbody>
			</table>
		</p>

		<p>
			{!! Form::submit('Submit') !!}
		</p>
		{!! Form::close() !!}

@stop
<script type="text/javascript" src="{{ asset('https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js') }}"></script>
<script>

	$(document).ready(function(){
		$('.module_checkbox').click(function(e){
			if(parseInt(this.value) == 0) {
				this.value = 1;
			} else {
				this.value = 0;
			}
		});
	});

</script>