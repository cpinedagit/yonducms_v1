@extends('auth')

@section('content')
<div class="container">

	{!! Form::open(['url'=>url('/change_password/update'), 'method'=>'PUT', 'id'=>'ChangePasswordForm', 'class'=>'login-holder-form', 'role'=>'form']) !!}
		<div class="login-holder-form__container" id="login-form">
			<h3 class="login-holder-form_title">Update Password</h3>
				{!! Form::text('username', old('username'), ['class'=>'form-control', 'placeholder'=>'Username', 'data-parsley-required'=>'true', 'data-parsley-error-message'=>'Username is required.', 'data-parsley-errors-container'=>'.front-end-error'] ) !!}
				{!! Form::password('password', ['class'=>'form-control', 'placeholder'=>'Password', 'data-parsley-required'=>'true', 'data-parsley-error-message'=>'Password is required.', 'data-parsley-errors-container'=>'.front-end-error'] ) !!}
				{!! Form::password('new_password', ['id'=>'new_password','class'=>'form-control', 'placeholder'=>'New Password', 'data-parsley-required'=>'true', 'data-parsley-minlength'=>'6', 'data-parsley-error-message'=>'New password is required and must have at least 6 characters.', 'data-parsley-errors-container'=>'.front-end-error'] ) !!}
				{!! Form::password('confirm_new_password', ['class'=>'form-control', 'placeholder'=>'Confirm New Password', 'data-parsley-required'=>'true', 'data-parsley-minlength'=>'6','data-parsley-error-message'=>'Confirm New password is required and must be equal to new password.', 'data-parsley-errors-container'=>'.front-end-error', 'data-parsley-equalto'=>'#new_password'] ) !!}

				<div class="btn-holder">
					{!! Form::button('SUBMIT', ['id'=>'ChangePasswordFormBtn' ,'class'=>'btn btn-add btn-add--login']) !!}
                    <input type="button" class="btn btn-add btn-add--login" id="go-to-log-in-page" value="CANCEL">
                </div>

                <!-- Backend Error-->
				@if (count($errors) > 0)
					<div class="alert alert-danger alert-danger--login text-center back-end-error" role="alert">
						@foreach ($errors->all() as $error)
							<?php print_r($error); ?><br/>
						@endforeach
					</div>
				@endif
				<!-- Backend Error-->
				<!-- Front End Error-->
		        <div class="alert alert-danger alert-danger--login text-center front-end-error hide" role="alert">
		        </div>
				<!-- Front End Error-->
		</div>
		<footer class="login-holder-form__footer">
	        &copy; 2015 <a href="//www.yondu.com">Yondu</a> Website Service
	    </footer>
	{!! Form::close() !!}
					
	
</div>
<script type="text/javascript">
	// Log in Form Validation
	$('#ChangePasswordFormBtn').on('click',function(){
		if($('#ChangePasswordForm').parsley().validate()){
			$('#ChangePasswordForm').submit();
		}else{
			//Hide backend error to show front-end side error list
			$('.back-end-error').addClass('hide');
			//Show Front-end error
			$('.front-end-error').removeClass('hide');
		}
	});

	//Whenever there is no error message hide error list div
	$(document).keypress(function(e) {
	 	//Find front-end-error 
	 	var error_ctr = $('ul.parsley-errors-list.filled');
	 	
	 	if(error_ctr.length<=1)
	 		$('.front-end-error').addClass('hide');
	});

	//Cancel button
	//Goto log-in page
	$("#go-to-log-in-page").on('click', function(){
		location.href = "{{ URL('auth/login') }}";
	});

</script>
<style type="text/css">
	.parsley-custom-error-message
	{
		font-size: 14px;
		padding: 10px; 	
		line-height: 15px;
	}
</style>
@endsection

