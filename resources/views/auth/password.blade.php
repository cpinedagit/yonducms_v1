@extends('auth')

@section('content')
<div class="container">
	
	{!! Form::open(['url'=>url('/password/reset'), 'id'=>'ResetPasswordForm', 'class'=>'login-holder-form', 'role'=>'form']) !!}
		<div class="login-holder-form__container" id="login-form">
			<h3 class="login-holder-form_title">Forgot Password?</h3>
				{!! Form::text('username', old('username'), ['class'=>'form-control', 'placeholder'=>'Username', 'data-parsley-required'=>'true','data-parsley-error-message'=>'Username is required.', 'data-parsley-errors-container'=>'.front-end-error'] ) !!}
				{!! Form::text('captcha', old('captcha'), ['class'=>'form-control','placeholder'=>'Captcha', 'data-parsley-required'=>'true', 'data-parsley-error-message'=>'Captcha is required.', 'data-parsley-errors-container'=>'.front-end-error'] ) !!}
				<div class="login-holder-form__captcha clearfix">
                    {!! "<div id='capthca-img'>". captcha_img('flat') ."</div> <div class='glyphicon glyphicon-refresh' id='refresh-captcha-button'> <label>Refresh</label></div>" !!}
                </div>
				<div class="btn-holder">
					{!! Form::button('SUBMIT', ['id'=>'ResetPasswordFormBtn' ,'class'=>'btn btn-add btn-add--login']) !!}
                    <input type="button" class="btn btn-add btn-add--login" id="go-to-log-in-page" value="CANCEL">
                </div>
                <!-- Backend Error-->
				@if (count($errors) > 0)
					<div class="alert alert-danger alert-danger--login text-center back-end-error" role="alert">
						@foreach ($errors->all() as $error)
							@if ($error=='validation.captcha')
								The captcha field is incorrect.<br/>
							@elseif(($error==''))
								
							@else
								<?php print_r($error); ?>
							@endif
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
	//Validate forgot Password Form
	$('#ResetPasswordFormBtn').on('click',function(){
	if($('#ResetPasswordForm').parsley().validate()){
		$('#ResetPasswordForm').submit();
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
	}
</style>
@endsection

