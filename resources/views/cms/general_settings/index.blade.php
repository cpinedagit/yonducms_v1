@extends('cms.home')

@section('title')
  <h2>General Settings</h2>
@stop

@section('content')
@if((Session::has('message')))
  <!-- Flash Update Your Password Message -->
      <div class="alert alert-success" role="alert">{{ Session::get('message') }} <div class="glyphicon glyphicon-remove" id="close-symbol"> </div> </div>
  <!-- Flash Update Your Password Message -->
@endif

	<!-- Settings Controller-->
	<div class='main-container__content__info'>
	   {!! Form::open(['url'=>url('/general_settings/update'), 'id'=>'GeneralSettingsForm', 'method'=>'PUT', 'class'=>'form-horizontal', 'enctype' => 'multipart/form-data']) !!}
           <div class="row">
                <div class="col-sm-12">
                   <div role="tabpanel" class="modal-body__media">
                      <!-- Nav tabs -->
                      <ul class="nav nav-tabs nav-tabs--settings" role="tablist">
                        <li role="presentation" class="active">
                            <a href="#website" aria-controls="website" role="tab" data-toggle="tab">Website</a></li>
                        <li role="presentation">
                            <a href="#mail" aria-controls="mail" role="tab" data-toggle="tab">Mail</a>
                        </li>
                        <li role="presentation">
                            <a href="#password" aria-controls="password" role="tab" data-toggle="tab">Password</a>
                        </li>
                        <li role="presentation">
                            <a href="#rssfeed" aria-controls="rssfeed" role="tab" data-toggle="tab">RSS Feed</a>
                        </li>
                        <li role="presentation">
                            <a href="#timezone" aria-controls="timezone" role="tab" data-toggle="tab">Time Zone</a>
                        </li>
                        <li role="presentation">
                            <a href="#media" aria-controls="media" role="tab" data-toggle="tab">Media</a>
                        </li>
                        <li role="presentation">
                            <a href="#cleanup" aria-controls="cleanup" role="tab" data-toggle="tab">Clean Up</a>
                        </li>                        
                      </ul>
                      <!-- Tab panes -->
                      <div class="tab-content tab-content--settings">
                        <div role="tabpanel" class="tab-pane active" id="website">
                            <div class="form-horizontal form-horizontal--settings">
                                    <div class="form-group">
                                        <label for="website-title" class="col-sm-2 control-label">Website Logo</label>
                                        <div class="col-sm-10">
                                          <div class="APP_LOGO_container">
                                            {!! HTML::image('public/images/'.str_replace('APP_LOGO=', '', $env[32]), 'App Logo', array('class' => 'show', 'id' => 'APP_LOGO_img')) !!}
                                          </div>
                                           {!! Form::file('APP_LOGO', array('class' => 'show', 'id' => 'APP_LOGO_selector', 'accept'=>'image/*')) !!}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="website-title" class="col-sm-2 control-label">Website Favicon</label>
                                        <div class="APP_FavIconDiv">
                                            {!! HTML::image('public/images/'.str_replace('APP_FAVICON=', '', $env[33]), 'Favicon', array('class' => 'show', 'id' => 'APP_Favicon')) !!}
                                          </div>
                                           {!! Form::file('APP_FAVICON', array('class' => 'show', 'id' => 'APP_FAVICON_selector', 'accept'=>'ico')) !!}
                                        </div>
                                    <div class="form-group">
                                        <label for="website-title" class="col-sm-2 control-label">Website Title</label>
                                        <div class="col-sm-10">
                                          {!! Form::text('APP_TITLE', str_replace('APP_TITLE=', '', $env[3]), ['class'=>'form-control', 'placeholder'=>'Enter website title', 'data-parsley-required'=>'true'] ) !!}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="website-tagline" class="col-sm-2 control-label">Website Tag Line</label>
                                        <div class="col-sm-10">
                                            {!! Form::text('APP_TAG_LINE', str_replace('APP_TAG_LINE=', '', $env[4]), ['class'=>'form-control', 'placeholder'=>'Enter Tag Line', 'data-parsley-required'=>'true'] ) !!}
                                            <small><em>in a few words, explain what this site is about.</em></small>
                                        </div>
                                    </div>
                                   
                               </div>   
                        </div>
                        <div role="tabpanel" class="tab-pane" id="mail">
                            <div class="form-horizontal form-horizontal--settings">
                                <div class="form-group">
                                    <label for="mail-driver" class="col-sm-2 control-label">Mail Driver</label>
                                    <div class="col-sm-10">
                                      {!! Form::text('MAIL_DRIVER', str_replace('MAIL_DRIVER=', '', $env[15]), ['class'=>'form-control', 'placeholder'=>'Enter Mail Driver', 'data-parsley-required'=>'true'] ) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="mail-host" class="col-sm-2 control-label">Mail Host</label>
                                    <div class="col-sm-10">
                                      {!! Form::text('MAIL_HOST', str_replace('MAIL_HOST=', '', $env[16]), ['class'=>'form-control', 'placeholder'=>'Enter Mail Host', 'data-parsley-required'=>'true'] ) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="mail-port" class="col-sm-2 control-label">Mail Port</label>
                                    <div class="col-sm-10">
                                      {!! Form::text('MAIL_PORT', str_replace('MAIL_PORT=', '', $env[17]), ['class'=>'form-control', 'data-parsley-required'=>'true', 'placeholder'=>'Enter Mail Port', 'data-parsley-type'=>'integer'] ) !!}
                                    </div>
                                </div>
								                <div class="form-group">
                                    <label for="mail-port" class="col-sm-2 control-label">Mail Username</label>
                                    <div class="col-sm-10">
                                     {!! Form::text('MAIL_USERNAME', str_replace('MAIL_USERNAME=', '', $env[18]), ['class'=>'form-control', 'data-parsley-required'=>'true', 'placeholder'=>'Mail Username', 'data-parsley-type'=>'email'] ) !!}
                                    </div>
                                </div>
                                <div class="alert alert-danger alert-danger--settings" role="alert">
                                    Do you have a new password? set it here , else just leave it blank.
                                </div>
                                <div class="form-group">
                                    <label for="mail-passport" class="col-sm-2 control-label">Mail Password</label>
                                    <div class="col-sm-10">
                                      {!! Form::hidden('MAIL_PASSWORD_ORIG', str_replace('MAIL_PASSWORD=', '', $env[19])) !!}
			 						                  {!! Form::password('MAIL_PASSWORD_NEW',  ['class'=>'form-control', 'data-parsley-required'=>'false'] ) !!}
                                    </div>
                                </div>
                            </div> 
                        </div>
                        <div role="tabpanel" class="tab-pane" id="password">
                            <div class="form-horizontal form-horizontal--settings" style="width:120%">
                                <div class="form-group" style="width:92%">
                                    <label for="password-before" class="col-sm-2 control-label">Days Before Password Expires</label>
                                    <div class="col-sm-10">
                                      {!! Form::text('DAYS_BEFORE_PASSWORD_EXPIRES', str_replace('DAYS_BEFORE_PASSWORD_EXPIRES=', '', $env[28]), ['class'=>'form-control', 'data-parsley-required'=>'true', 'data-parsley-type'=>'integer'] ) !!}
                                    </div>
                                </div>
                                 <div class="form-group" style="width:92%">
                                    <label for="password-days" class="col-sm-2 control-label">Password Auto Expiration in Days</label>
                                    <div class="col-sm-10">
                                     {!! Form::text('DAYS_BEFORE_PASSWORD_NEEDS_TO_BE_CHANGE', str_replace('DAYS_BEFORE_PASSWORD_NEEDS_TO_BE_CHANGE=', '', $env[29]), ['class'=>'form-control', 'data-parsley-required'=>'true', 'data-parsley-type'=>'integer'] ) !!}
                                    </div>
                                </div>

                           </div>  
                        </div>
                        <div role="tabpanel" class="tab-pane" id="rssfeed">
                            <div class="form-horizontal form-horizontal--settings">
                                <div class="form-group">
                                    <label for="rss-link" class="col-sm-2 control-label">RSS Link</label>
                                    <div class="col-sm-10">
                                      {!! Form::text('APP_RSS_FEED', str_replace('APP_RSS_FEED=', '', $env[21]), ['class'=>'form-control', 'data-parsley-required'=>'true', 'data-parsley-type'=>'url'] ) !!}
                                    </div>
                                </div>
                           </div>  
                        </div>
                        <div role="tabpanel" class="tab-pane" id="timezone">
                            <div class="form-horizontal form-horizontal--settings">
                                <div class="form-group">
                                    <label for="timezone" class="col-sm-2 control-label">Timezone</label>
                                    <div class="col-sm-10">
                                    {!! Form::select('APP_TIME_ZONE', DateTimeZone::listIdentifiers(), App::make("App\Http\Controllers\CMS\GeneralSettingsController")->getTimeZone(str_replace('APP_TIME_ZONE=', '', $env[23]),'index'), ['class'=>'form-control', 'data-parsley-required'=>'true'] ) !!}
                                    <small><em>Choose a city with the same timezone as you.</em></small>
                                    </div>
                                </div>
                           </div> 
                        </div>
                        <div role="tabpanel" class="tab-pane" id="media">
                            <div class="form-horizontal form-horizontal--settings">
                                <div class="form-group">
                                    <label for="media-format" class="col-sm-2 control-label">Media Format</label>
                                    <div class="col-sm-10">
                                    	{!! Form::text('APP_MEDIA_FORMATS', str_replace('APP_MEDIA_FORMATS=', '', $env[25]), ['class'=>'form-control', 'data-parsley-required'=>'true'] ) !!}
                                    </div>
                                </div>
                                 <div class="form-group">
                                    <label for="media-maxsize" class="col-sm-2 control-label">Maximum file size in MB</label>
                                    <div class="col-sm-10">
                                      {!! Form::text('APP_MEDIA_MAX_FILE_SIZE', str_replace('APP_MEDIA_MAX_FILE_SIZE=', '', $env[26]), ['class'=>'form-control', 'data-parsley-required'=>'true', 'data-parsley-type'=>'integer'] ) !!}
                                    </div>
                                </div>

                           </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="cleanup">
                          <div class="form-horizontal form-horizontal--settings">
                                <div class="form-group">
                                  <h3>Clear all data from database?</h3>
                                    {!! HTML::linkAction('CMS\GeneralSettingsController@truncateData', 'Clear Data', array(), ['class' => 'btn btn-all pull-left']) !!}
                                </div>
                          </div>
                        </div>
                      </div>
                                  
                      <div class="tab-footer">
							{!! Form::button('Save Changes', ['id'=>'GeneralSettingsFormBtn', 'class'=>'btn btn-add pull-right']) !!}
                      </div>
                    </div>
                </div>
            </div>
       
		{!! Form::close() !!}
    </div>
    <!-- Settings Controller-->

<script type="text/javascript">
	//General Setting Form Validation
	$('#GeneralSettingsFormBtn').on('click',function(){
		if($('#GeneralSettingsForm').parsley().validate()){
			//console.log(1);
			$('#GeneralSettingsForm').submit();
		}
	});

  //Close message alert when click close
  $('#close-symbol').on('click', function(){
    $('.alert-success').toggle();
  });

</script>
@endsection
