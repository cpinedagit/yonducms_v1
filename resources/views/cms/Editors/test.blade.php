@extends('cms.home')
@section('title')
<h2>Editor</h2>
@stop
@section('content')
<div class="row">
    <div class="col-sm-9">
        <div class="form-group">
            {!! Form::open(array('url' => 'cms/editor/updateFile','method' => 'post')) !!}
            <label for="edit-themes" class='form-title'><h4>Edit Themes</h4></label>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <textarea id='textarea' class="form-control editor-textarea" name="content" cols="100" rows="30"></textarea>
            <input id ='hidden' name ='hidden' type='hidden' value=''><br><br><br>
            <input id ='update' class="btn btn-add" type ="submit" value = "update file" class = "btn btn-success">
            {!! Form::close() !!}
        </div>
    </div>
    <div class="col-sm-3">
        <div class="main-container__content__info__photo">
            <div class="main-container__content__info__photo--js">
                <h5 class='main-container__content__info__photo__title'><i class="fa fa-folder-open-o"></i>JS FOLDER</h5>
                <ul class='file-list'>

                    @foreach($jsFiles as $jsFiles)
                    <li>                           
                        <a href="#" class="a" data-ext ='{!! File::name($jsFiles) !!}' id ='{!! $jsFiles !!}'>{!! File::name($jsFiles) !!}.{!! File::extension($jsFiles) !!}</a>                                
                        <input id ="ext" type='hidden' value ="{!! File::extension($jsFiles) !!}">
                    </li>
                    @endforeach                    
                </ul>
            </div>
            <div class="main-container__content__info__photo--css">
                <h5 class='main-container__content__info__photo__title'><i class="fa fa-folder-open-o"></i>CSS FOLDER</h5>
                <ul class='file-list'>
                    @foreach($cssFiles as $cssFiles)
                    <li>                           
                        <a href='#' class="b" id ='{!! $cssFiles !!}'>{!! File::name($cssFiles) !!}.{!! File::extension($cssFiles) !!}</a>
                        <input id ="ext2" type='hidden' value ="{!! File::extension($cssFiles) !!}">
                    </li>
                    @endforeach
                </ul>
            </div>
            <div class="main-container__content__info__photo--css">
                <h5 class='main-container__content__info__photo__title'><i class="fa fa-folder-open-o"></i>SITE FOLDER</h5>
                @foreach($directories as $directory)
                    @if(File::isDirectory($directory))                
                    <h6 class='main-container__content__info__photo__title' style='margin-left: 10px;'><i class="fa fa-folder-open-o"></i>{{ basename($directory)}}</h6>
                    <?php $files = File::files('resources/views/site/' . basename($directory)); ?>                        
                        @foreach($files as $file)
                        <ul class='file-list' margin-left:10px;>
                            <li style="margin-left:10px;">                           
                                <a href='#' class="c" id ='{!! $file !!}' style='margin-left: 10px;'>{!! File::name($file) !!}.{!! File::extension($file) !!}</a>
                                <input id ="ext2" type='hidden' value ="{!! File::extension($cssFiles) !!}">
                            </li>
                        </ul>
                        @endforeach
                    @endif    
                @endforeach
                <ul class='file-lis'>
                    @foreach($siteFiles as $siteFiles)
                    <li>                           
                        <a href='#' class="b" id ='{!! $siteFiles !!}'>{!! File::name($siteFiles) !!}.{!! File::extension($siteFiles) !!}</a>
                        <input id ="ext2" type='hidden' value ="{!! File::extension($cssFiles) !!}">
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
        {!! Form::open(array('action' => 'EditorController@addFile','files' => 'true', 'method' => 'post')) !!}
        <input style="float:right;"  type ="file" name ="file" title="upload file?"> 
        <input type ='submit' value ='upload file' class="btn btn-add center-block" style="float:right;margin-right: 10px">
        {!! Form::close() !!}
    </div>   
</div>
<script>
    $(document).on('click', '.a', function (e) {
        var filename = this.id;
//        alert(filename);
        $.get('../' + filename, function (data)//Remember, same domain
        {
            var _data = data;
            $('#textarea').val(data);
            $('#hidden').val(filename);
        });

    });

    $(document).on('click', '.b', function () {
        var filename = this.id;

        $.get('../' + filename, function (data)//Remember, same domain
        {
            var _data = data;
            $('#textarea').val(data);
            $('#hidden').val(filename);
        });

    });

    $(document).on('click', '.c', function () {
        var filename = this.id;
        $.get('../' + filename, function (data)//Remember, same domain
        {
            var _data = data;
            $('#textarea').val(data);
            $('#hidden').val(filename);
        });
    });
</script>

@stop