@extends('cms.home')
@section('title')
<h2>User Management</h2>
@stop
@section('content')

	<div class='main-container__content__info'>
       <div class="row">
           <div class="col-sm-12">
               <h3>Edit {!! ucwords(strtolower($user->username)) !!}</h3>
           </div>
       </div>
       <div class="row">

       	 {!! Form::model($user, array('route' => array('cms.user.update', $user->id), 'method' => 'put', 'enctype' => 'multipart/form-data')) !!}
            
            <div class="col-sm-7">               
           
                <div class="form-group">
                   {!! Form::label('rolelabel', 'User Role', array('class' => 'form-title')) !!}
                   <div class="profile-role-holder">
                       <div class="profile-role-holder__role col-sm-9">                            
		                    <select name='role_id' class='form-control'>				
								@foreach(roles() as $role)
									<option value='{!! $role->id !!}'>{!! ucwords(strtolower($role->role_name)) !!}</option>
								@endforeach

								@if(!empty($user->role_id) && $user->role_id != '' && $user->role_id != NULL)

									<option value='{!! $user->role_id !!}' selected>{!! ucwords(strtolower($role->role_name)) !!}</option>
								@endif
							</select>
                       </div>
                       {!! Form::submit('Update Profile', array('class' => 'btn btn-add pull-right')) !!}                       
                   </div>
                </div>

                <div class="form-group">
                    {!! Form::label('username', 'Username', array('class' => 'form-title')) !!}
                    {!! Form::text('username', null, array('class' => 'form-control', 'placeholder' => 'Enter username')) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('firstname', 'Firstname', array('class' => 'form-title')) !!}
                    {!! Form::text('first_name', null, array('class' => 'form-control', 'placeholder' => 'Enter first name')) !!}
                </div>
				
				<div class="form-group">
                    {!! Form::label('lastname', 'Lastname', array('class' => 'form-title')) !!}
                    {!! Form::text('last_name', null, array('class' => 'form-control', 'placeholder' => 'Enter last name')) !!}
                </div>
            	
            	<div class="form-group">
                    {!! Form::label('email', 'Email', array('class' => 'form-title')) !!}
                    {!! Form::email('email', null, array('class' => 'form-control', 'placeholder' => 'Enter email address')) !!}
                </div>
            	
            	<div class="form-group">
                    {!! Form::label('password', 'Password', array('class' => 'form-title')) !!}
                    {!! Form::password('password', array('class' => 'form-control', 'placeholder' => 'Type password')) !!}
                </div>
            	
            	<div class="form-group">
                    {!! Form::label('password', 'Confirm Password', array('class' => 'form-title')) !!}
                    {!! Form::password('password', array('class' => 'form-control', 'placeholder' => 'Re-type the password')) !!}
                </div>
            	            	
            </div>

            <div class="col-sm-3 col-sm-offset-1">
              <h4>Profile Picture</h4>
               <div class="main-container__content__info__photo--profile">
                   <div class="main-container__content__info__photo__uploaded-photo-container main-container__content__info__photo__uploaded-photo--profile">
                        {!! HTML::image('public/images/profile/' . $user->profile_pic, $user->username, array('class' => 'show', 'id' => 'blah')) !!}
                   </div>
                  	{!! Form::file('profile_pic', array('class' => 'show', 'id' => 'imgInp')) !!}
               </div>
            </div>

            {!! Form::close() !!}

        </div>
   </div>

		@if($errors->any())

			@foreach($errors->all() as $error)
				<li>{!! $error !!}</li>
			@endforeach

		@endif
<script type = "text/javascript">
	$('#UserCreateUpdate').on('click', function(){
		if($('#UserCreateForm').parsley().validate()) {
			$('#UserCreateForm').submit();
		}
	});
</script>
@endsection
@stop