@extends('cms.home')
@section('title')
<h2>Media</h2>
@stop
@section('content')
<style>
.btn-file {
    position: relative;
    overflow: hidden;
}
.btn-file input[type=file] {
    position: absolute;
    top: 0;
    right: 0;
    min-width: 100%;
    min-height: 100%;
    font-size: 100px;
    text-align: right;
    filter: alpha(opacity=0);
    opacity: 0;
    outline: none;
    background: white;
    cursor: inherit;
    display: block;
}
</style>

<div class="main-container__content__reminder">
    <i class="fa fa-exclamation-circle"></i>
    <small>Reminder: Allowed file types: {{ env('APP_MEDIA_FORMATS') }}.</small>
    <small>Maximum file size: {{ env('APP_MEDIA_MAX_FILE_SIZE') }}MB</small>
</div>
<div class='main-container__content__info'>
 {!! Form::open(array('route'=>'cms.media.store','method'=>'POST','id'=>'upload', 'files'=>true)) !!}
 <div class="row">
    <div class="col-sm-12">
     <div class="form-group">
        <label for="media-upload" class='form-title'>Add New Media</label>
        <div class="control-group">
          <div class="controls controls--upload">
            
            <div class="filedrag-holder">
                <div id="filedrag">
                    <h3>Drop files here</h3>
                    or <br>
                    <span class="btn btn-add filedrag__modal btn-file">
                        Select Files{!! Form::file('fileselect[]', array('multiple'=>true,'id'=>'fileselect','accept'=>'image/*,video/*')) !!}
                    </span>
                    
                </div>
            </div>
        </div>
    </div>
    <div class="preview-drag-drop "></div>
    <div id="messages">
        <div class="uploadfiles-multiple">
        </div>
    </div>
    
</div>     
</div>
</div>
{!! Form::close() !!}
</div>


<script>
var formats = "{{ env('APP_MEDIA_FORMATS') }}";
formats = formats.split(',');
var default_size = "{{ env('APP_MEDIA_MAX_FILE_SIZE') }}";	
</script>
{!! HTML::script('public/js/upload.js') !!}

@stop