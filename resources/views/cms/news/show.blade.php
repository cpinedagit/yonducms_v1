    @extends('cms.home')
    @section('title')
<h2>News Management</h2>
@stop
    @section('content')
    <div class="main-container__content__reminder">
        <i class="fa fa-exclamation-circle"></i>
        <small>Reminder: Fields with asterisk(*) are required.</small>
    </div>
    <div class='main-container__content__info'>
       <div class="row main-container__content__info__row-custom">
          {!! Form::open(array('route'=>array('cms.news.update', $result->news_id),'method'=>'PUT','id'=>'news','files'=>true, 'data-parsley-validate')) !!}
          <div class="col-sm-9 main-container__content__info__panel-custom">
            <div class="form-group">
                <label for="news_title" class="form-title">News Title *</label>
                {!! Form::text('news_title',$result->news_title,array('class'=>'form-control','placeholder'=>'Enter title', 'required' )) !!}
            </div>
            <div class="row">

                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="news-date" class='form-title'>Date *</label>
                        <div class="input-group">
                         {!! Form::text('news_date',$result->news_date,array('class'=>'form-control datepicker', 'required')) !!}
                         <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                     </div>

                 </div>
             </div>




             <div class="col-sm-8">
                <div class="form-group">
                    <label for="page-url" class='form-title'>URL Key</label>
                    <div class="form-group" id="editableUrl">
                    <label>{!! URL::to('/site/news')!!}/</label>
                     {!! Form::text('slug',$result->slug,array('class'=>'form-control', 'required' )) !!}
                  </div>
            </div>
            </div>


            <div class="col-sm-12">
                <div class="form-group">
                    <label for="news_content" class='form-title'>Description *</label>
                    {!! Form::textarea('description',$result->description,array('class' =>'ckeditor invisible')) !!} 
                </div> 
            </div>
            <div class="col-sm-12">
             <div class="form-group">
                <label for="editor2" class='form-title'>Content *</label>
                {!! Form::textarea('news_content',$result->news_content,array('id'=>'Editor1','class' =>'invisible ckeditor')) !!} 
            </div>
        </div>

    </div>
</div>
<div class="col-sm-3">


    <div class="main-container__content__info__photo">
     <h4 class='main-container__content__info__photo__title'>Photo</h4>
     <div id="photo" class="main-container__content__info__photo__uploaded-photo-container">
        {!! HTML::image($imagePath.$result->image_filename,"alt",array("id"=>"blah","class"=>"show", 'required')) !!}
    </div>
    <div class="main-container__content__info__photo__delete">
     <a href="#" id='deleteimage' role="button">Delete</a>
 </div>
 {!! Form::file('file', array('class'=>'show','multiple'=>false,'id'=>'imgInp','accept'=>'image/*')) !!}
 <small class="main-container__content__info__photo__limitations">
    File type: {{ env('APP_MEDIA_FORMATS') }} <br>
    Maximum file size: {{ env('APP_MEDIA_MAX_FILE_SIZE') }}MB <br>
    Recommended image dimension: 600 x 600
</small>
</div>



<div class="main-container__content__info__options">
    <div class="checkbox">
        <div class="form-group">
            <label for="published">
                {!! Form::checkbox('published',$result->published, ($result->published == 1) ? true : false,array('class' =>'cbox')) !!} 
                Published</label>
            </div> 
        </div>
        <div class="checkbox">
            <div class="form-group">
                <label for="featured">
                    {!! Form::checkbox('featured',$result->featured,($result->featured == 1) ? true : false,array('class' =>'cbox')) !!} 
                    Featured</label>

                </div>  
            </div>
            <div class="main-container__content__info__options__action-holder btn-holder">
                <button class="btn btn-reset">Cancel</button>
                {!! Form::submit('Save', array('class'=>'btn btn-add')) !!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
</div>

@include('cms.media.media_tool')
<script>
$('.cbox').on('click',function(){
    val = $(this).val();
    if (val == 1) {
        $(this).val('0');
    }
    else
    {
        $(this).val('1');        
    }
});

var loadFile = function(event) {
    var output = document.getElementById('img');
    output.src = URL.createObjectURL(event.target.files[0]);
};
</script> 

@stop