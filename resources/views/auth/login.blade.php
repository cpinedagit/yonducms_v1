@extends('auth')

@section('content')
<div class="container">
	
	
	{!! Form::open(['url'=>url('/auth/login'), 'id'=>'LogInForm', 'class'=>'login-holder-form', 'role'=>'form']) !!}
		<div class="login-holder-form__container" id="login-form">
			{!! HTML::image('public/images/'.env('APP_LOGO'), 'Yondu Web Service', ['class'=>'login-holder-form__logo']) !!}
		 		{!! Form::text('username', old('username'), ['class'=>'form-control', 'placeholder'=>'Username', 'data-parsley-required'=>'true','data-parsley-error-message'=>'Username is required.', 'data-parsley-errors-container'=>'.front-end-error'] ) !!}
		 		{!! Form::password('password', ['class'=>'form-control', 'placeholder'=>'Password', 'data-parsley-required'=>'true', 'data-parsley-error-message'=>'Password is required.', 'data-parsley-errors-container'=>'.front-end-error'] ) !!}
				<div class="clearfix">
		 			{!! Form::button('Sign in', ['id'=>'LogInFormBtn' ,'class'=>'btn btn-add btn-add--login pull-left']) !!}
					<a class="forgot-password pull-right" href="{{ url('/password/reset') }}">Forgot Password</a>
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
	$('#LogInFormBtn').on('click',function(){
		if($('#LogInForm').parsley().validate()){
			$('#LogInForm').submit();
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

	
</script>
<style type="text/css">
	.parsley-custom-error-message
	{
		font-size: 14px;
		padding: 10px; 	
	}
</style>
@endsection
