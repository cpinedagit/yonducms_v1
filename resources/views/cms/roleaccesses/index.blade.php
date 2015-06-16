@extends('cms.home')

@section('content')

	<h5>Role Access</h5>

	<p>
		{!! HTML::linkRoute('cms.roleaccess.create', 'Create Role Access')!!}
	</p>


@stop