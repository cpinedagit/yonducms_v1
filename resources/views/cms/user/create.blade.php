@extends('cms.home')
@section('title')
<h2>User Management</h2>
@stop
@section('content')

  @if (count($errors) > 0)
      <div class="alert alert-success">
        <strong>Messages:</strong><br><br>
        <ul>
          @foreach ($errors->all() as $error)              
              <li><?php print_r($error); ?></li>              
          @endforeach
        </ul>
      </div>
    @endif

	<div class='main-container__content__info'>
       <div class="row">

       	 {!! Form::open(array('route' => array('cms.user.store'), 'id' => 'UserCreateForm', 'method' => 'post', 'enctype' => 'multipart/form-data')) !!}
            
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
                    {!! Form::password('password', array('class' => 'form-control', 'placeholder' => 'Type password', 'data-parsley-minlength' => '6')) !!}
                </div>
            	
            	<div class="form-group">
                    {!! Form::label('password', 'Confirm Password', array('class' => 'form-title')) !!}
                    {!! Form::password('password', array('class' => 'form-control', 'placeholder' => 'Re-type the password', 'data-parsley-minlength' => '6')) !!}
                </div>
            	            	
            </div>

            <div class="col-sm-3 col-sm-offset-1">
              <h4>Profile Picture</h4>
               <div class="main-container__content__info__photo--profile">
                   <div class="main-container__content__info__photo__uploaded-photo-container main-container__content__info__photo__uploaded-photo--profile">
                         <img id="blah" src="images/1.jpg" alt="your image" class=""/>
                   </div>
                  	{!! Form::file('profile_pic', array('class' => 'show', 'id' => 'imgInp')) !!}
               </div>
            </div>

            {!! Form::close() !!}

        </div>
   </div>
<div class="modal fade" id="saveinfo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content modal-content--changepassword">
        <div class="modal-header modal-header--changepassword">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Save Information</h4>
        </div>
        <div class="modal-body modal-body--changepassword">
          Are you sure you want to save this information?

        </div>
        <div class="modal-footer modal-footer--changepassword">
          <button type="submit" class="btn btn-add">Yes</button>
          <button type="button" class="btn btn-reset" data-dismiss="modal" aria-label="Close">No</button>
        </div>
      </div>
    </div>
  </div>
                
<script type = "text/javascript">
	$('#UserCreateUpdate').on('click', function(){
		if($('#UserCreateForm').parsley().validate()) {
			$('#UserCreateForm').submit();
		}
	});
</script>

<script>
    $(document).ready(function() {
        $('#example').DataTable({
            aaSorting: [0],
            bInfo: false,
            columnDefs: [
               { orderable: false, targets: -1 }
            ],
            "dom":'<"top">rt<"bottom"lp>',
            "oLanguage": {
                "sSearch": "<span class='lbl-filter'>Search</span> ",
                "oPaginate": {
                    "sPrevious": '<i class="fa fa-chevron-left"></i>',
                    "sNext": '<i class="fa fa-chevron-right"></i>'
                }
                
            }
        });
        $( ".datepicker" ).datepicker();
    } );
</script>

@endsection
@stop