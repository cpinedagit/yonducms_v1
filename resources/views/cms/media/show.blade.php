@extends('cms.home')
@section('title')
<h2>Media</h2>
@stop
@section('content')
<div class="main-container__content__reminder">
  <i class="fa fa-exclamation-circle"></i>
  <small>Reminder: Fields with asterisk(*) are required.</small>
</div>

<div class='main-container__content__info'>
  {!! Form::open(array('route'=>array('cms.media.update', $file->media_id),'method'=>'PUT','id'=>'upload', 'files'=>true)) !!}


  <div class="row">
    <div class="col-sm-9">
      <div class="form-group">
        <label for="page-title" class='form-title'>File Name *</label>
        {!! Form::text('image_file_name',$filename, array('id'=>'page-title','class'=>'form-control')) !!}
      </div>
      <div class="form-group">
        <div class="upload-image-container">
         <div class="upload-image-container__upload">
           <i class="fa fa-times-circle show" id="deleteimage"></i>
           <input type='file' id="imgInp" name="file" class="hide"/>
           <!-- ADD SHOW class to show the image -->
           @if ($file->media_type == 1) 
           {!! HTML::image($file->media_path,"your image",array('id'=>'blah','class'=>'show')) !!}
           @else
           <video id="blah" class="show">
            <source src="../{{ $file->media_path }}" type="video/mp4" >
              <source src="../{{ $file->media_path }}" type="video/ogg">
                <source src="../{{ $file->media_path }}" type="video/wmv">
                  Your browser does not support the video tag.
                </video>
                @endif
                {!! Form::hidden('image_file_name_orig',$filename) !!}
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-3">
         <div class="main-container__content__info__options main-container__content__info__photo__limitations">
           <h4 class="main-container__content__info__options__title">
             Details
           </h4>
           <table class="main-container__content__info__option__table">
             <tbody>
               <tr>
                 <td>File Type:</td>
                 <td class="file-type">{{ File::extension($file->media_path) }}</td>
               </tr>
               <tr>
                 <td>File Size:</td>
                 <td class="file-size">{{ File::size($file->media_path) }} bytes</td>
               </tr>
               <tr>
                 <td>Dimensions:</td>
                 <td class="file-dimension">{{ $width.'x'.$height }}</td>
               </tr>
             </tbody>
           </table>
           <div class="main-container__content__info__options__action-holder btn-holder">
            <button class="btn btn-reset">Cancel</button>
            {!! Form::button('Submit', array('class'=>'btn btn-add save','id'=>$file->media_id)) !!}
            {!! Form::submit('Submit', array('class'=>'btn btn-add submit','id'=>$file->media_id)) !!}
          </div>
        </div>
      </div>

    </div>
    <div class="row">

      <div class="col-sm-12">
       <div class="form-group">
        <label for="editor1" class='form-title'>Caption</label>
        <textarea name="caption" class='form-control' rows="3">{{$file->caption}}</textarea>
      </div>
      <div class="form-group">
        <label for="alt" class='form-title'>Alternative Text</label>
        {!! Form::text('alternative_text',$file->alternative_text,array('class'=>'form-control')) !!}
      </div>
      <div class="form-group">
        <label for="editor2" class='form-title'>Description</label>
        {!! Form::textarea('description',$file->description,array('id'=>'Editor1','class' =>'ckeditor form-control')) !!} 
      </div>

    </div>
  </div>

  {!! Form::close() !!}

  <script>
  $(document).ready(function(){
    $('.save').show();
    $('.submit').hide();
  });
  $('#imgInp').on('change',function(){
    if($('#imgInp').val() == ''){
    } 
    else
    {
      $('.save').hide();
      $('.submit').show();
    } 
  });

  $('.save').on('click',function(){

    $( "#blah" ).attr("src", "");
    $.ajax({
      type: "PUT",
      url: '{!! URL::route("cms.media.update", '') !!}/' +this.id,
      data:  $('#upload').serialize(),
      dataType: 'json', 
      success:(function(data) {
        window.location.replace("../media");
      })
    });
  })
  </script>























</div>


@stop