@extends('cms.home')

@section('content')

{!! Form::model(\Auth()->user(), array('route' => array('cms.user.update', \Auth()->user()->id), 'method' => 'put', 'enctype' => 'multipart/form-data')) !!}
<div class='main-container__content__title'>
    <div class="row">
       <div class="col-sm-11 my-profile">       	
            {!! Form::submit('Update Profile', array('class' => 'btn btn-add pull-left')) !!}                       
            {!! Form::button('Change Password', array('class' => 'btn btn-reset pull-right', 'data-toggle' => 'modal', 'data-target' => '#changepassword')) !!}                        
       </div>	
   </div>
</div>

<div class='main-container__content__info'>                   
    <div class="row">
        <div class="col-sm-7">
            <div class="form-group">
                {!! Form::label('username', 'Username', array('class' => 'form-title', 'for' => 'user-name')) !!}
                {!! Form::text('username', null, array('class' => 'form-control', 'placeholder' => 'Enter username', 'id' => 'user-name')) !!}

            </div>
            
            <div class="form-group">
                {!! Form::label('firstname', 'Firstname', array('class' => 'form-title', 'for' => 'user-firstname')) !!}
                {!! Form::text('first_name', null, array('class' => 'form-control', 'placeholder' => 'Enter first name', 'id' => 'user-firstname')) !!}
            </div>
            
            <div class="form-group">
                {!! Form::label('lastname', 'Lastname', array('class' => 'form-title', 'for' => 'user-lastname')) !!}
                {!! Form::text('last_name', null, array('class' => 'form-control', 'placeholder' => 'Enter last name', 'id' => 'user-lastname')) !!}
            </div>
            
            <div class="form-group">                
                {!! Form::label('email', 'Email', array('class' => 'form-title', 'for' => 'user-email')) !!}
                {!! Form::email('email', null, array('class' => 'form-control', 'placeholder' => 'Enter email address', 'id' => 'user-email')) !!}
            </div>

            {!! Form::hidden('role_id', \Auth()->user()->role_id) !!}

        </div>
        <div class="col-sm-3 col-sm-offset-1">
          <h4>Profile Picture</h4>
           <div class="main-container__content__info__photo--profile">
               <div class="main-container__content__info__photo__uploaded-photo-container main-container__content__info__photo__uploaded-photo--profile">
                   @if(\Auth()->user()->profile_pic != '' && \Auth()->user()->first_name != NULL)
                   		{!! HTML::image('public/images/profile/' . \Auth()->user()->profile_pic, \Auth()->user()->username, array('class' => 'show', 'id' => 'blah')) !!}
                   @else
                   		{!! HTML::image('images/1.jpg', array('class' => 'show', 'id' => 'blah')) !!}
                   @endif
               </div>
               {!! Form::file('profile_pic', array('class' => 'show', 'id' => 'imgInp')) !!}
           </div>
        </div>
            
    </div>    
</div>
{!! Form::close() !!}


<div class="modal fade" id="changepassword" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content modal-content--changepassword">
      <div class="modal-header modal-header--changepassword">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Change Password</h4>
      </div>
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

      {!! Form::open(['url'=>url('/change_password_user/update'), 'method'=>'PUT', 'id'=>'ChangePasswordForm', 'class'=>'form-horizontal', 'role'=>'form']) !!}
	    <div class="modal-body modal-body--changepassword">	      	
			<div class="form-group">	            
	            {!! Form::label('password', 'Current Password', ['class' =>'form-title', 'for' => 'password-current']) !!}	            
	            {!! Form::password('password', ['class'=>'form-control', 'data-parsley-required'=>'true', 'id' => 'password-current', 'placeholder' => 'Enter current password'] ) !!}
	        </div>
	        <div class="form-group">	            
	            {!! Form::label('new_password', 'New Password:', ['class' =>'form-title', 'for' => 'password-new']) !!}	            
	            {!! Form::password('new_password', ['id'=>'new_password','class'=>'form-control', 'data-parsley-required'=>'true', 'data-parsley-minlength'=>'6', 'placeholder' => 'Enter new password'] ) !!}
	        </div>
	        <div class="form-group">
	        	{!! Form::label('confirm_new_password', 'Confirm New Password:', ['class' =>'form-title', 'for' => 'password-confirm-password']) !!}	            	            
	            {!! Form::password('confirm_new_password', ['class'=>'form-control', 'data-parsley-required'=>'true', 'data-parsley-minlength'=>'6', 'data-parsley-equalto'=>'#new_password', 'placeholder' => 'Retype new password', 'id' => 'password-confirm-password'] ) !!}
	        </div>
	        
	        <div class="form-group login-holder-form__captcha">
	           {!! Form::label('captcha', 'CAPTCHA Field:', ['class' =>'form-title']) !!}
	           {!! Form::text('captcha', old('captcha'), ['class'=>'form-control', 'data-parsley-required'=>'true'] ) !!}
	        </div>

	        <div class="form-group">
	        	{!! Form::label('captcha', ' ', ['class' =>'col-md-4 control-label']) !!}
		 		<div class="col-md-6">
		 			{!! "<div id='capthca-img'>". captcha_img('flat') ."</div> <div class='glyphicon glyphicon-refresh' id='refresh-captcha-button'> Refresh</div>" !!}
		 		</div>
	        </div>
	        {!! Form::hidden('username', \Auth()->user()->username) !!}
	    </div>
	    <div class="modal-footer modal-footer--changepassword">
	        {!! Form::button('Submit', ['id'=>'ChangePasswordFormBtn' ,'class'=>'btn btn-add center-block']) !!}
	    </div>
      {!! Form::close() !!}
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

@stop