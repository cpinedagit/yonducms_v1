@extends('cms.home')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Change Password</div>
				<div class="panel-body">
					@if (count($errors) > 0)
						<div class="alert alert-success">
							<strong>Messages:</strong><br><br>
							<ul>
								@foreach ($errors->all() as $error)
										@if ($error=='validation.captcha')
											<li>The captcha field is incorrect.</li>
										@elseif(($error==''))
											
										@else
											<li><?php print_r($error); ?></li>
										@endif
								@endforeach
							</ul>
						</div>
					@endif
					
					{!! Form::open(['url'=>url('/cms/change_password_user/update'), 'method'=>'PUT', 'id'=>'ChangePasswordForm', 'class'=>'form-horizontal', 'role'=>'form']) !!}
					 	<div class="form-group">	
					 		{!! Form::label('username', 'Username:', ['class' =>'col-md-4 control-label']) !!}
					 		<div class="col-md-6">
					 			{!! Form::text('username', $username, ['class'=>'form-control', 'data-parsley-required'=>'true'] ) !!}
					 		</div>
						</div>
						<div class="form-group">	
					 		{!! Form::label('password', 'Current Password:', ['class' =>'col-md-4 control-label']) !!}
					 		<div class="col-md-6">
					 			{!! Form::password('password', ['class'=>'form-control', 'data-parsley-required'=>'true'] ) !!}
					 		</div>
						</div>
						<div class="form-group">	
					 		{!! Form::label('new_password', 'New Password:', ['class' =>'col-md-4 control-label']) !!}
					 		<div class="col-md-6">
					 			{!! Form::password('new_password', ['id'=>'new_password','class'=>'form-control', 'data-parsley-required'=>'true', 'data-parsley-minlength'=>'6'] ) !!}
					 		</div>
						</div>
						<div class="form-group">	
					 		{!! Form::label('confirm_new_password', 'Confirm New Password:', ['class' =>'col-md-4 control-label']) !!}
					 		<div class="col-md-6">
					 			{!! Form::password('confirm_new_password', ['class'=>'form-control', 'data-parsley-required'=>'true', 'data-parsley-minlength'=>'6', 'data-parsley-equalto'=>'#new_password'] ) !!}
					 		</div>
						</div>
				 		{!! Form::label('captcha', 'CAPTCHA Field:', ['class' =>'col-md-4 control-label']) !!}
				 		<div class="col-md-6">
				 			{!! Form::text('captcha', old('captcha'), ['class'=>'form-control', 'data-parsley-required'=>'true'] ) !!}
				 		</div>
				 		{!! Form::label('captcha', ' ', ['class' =>'col-md-4 control-label']) !!}
				 		<div class="col-md-6">
				 			{!! "<div id='capthca-img'>". captcha_img('flat') ."</div> <div class='glyphicon glyphicon-refresh' id='refresh-captcha-button'> Refresh</div>" !!}
				 		</div>
						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								{!! Form::button('Submit', ['id'=>'ChangePasswordFormBtn' ,'class'=>'btn btn-primary']) !!}
							</div>
						</div>
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	// Log in Form Validation
	$('#ChangePasswordFormBtn').on('click',function(){
		if($('#ChangePasswordForm').parsley().validate()){
			$('#ChangePasswordForm').submit();
		}
	});


	//Refresh Captcha 
	$('#refresh-captcha-button').on('click', function(){
		$.ajax({
			type: 'GET',
			url: "{{ URL() }}"+"/captcha-generator",
			dataType: 'json',
			success: (function(data){
				$('#capthca-img').html(data['captcha_img']); 
			 })
		});
	});
</script>
@endsection
