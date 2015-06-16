@extends('cms.home')
@section('title')
<h2>Banner</h2>
@stop
@section('content')
<div class='main-container__content__info'>
    <div role="tabpanel" class="tabpanel-custom">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#details" aria-controls="home" role="tab" data-toggle="tab">Details</a></li>
            <li role="presentation"><a href="#content" aria-controls="profile" role="tab" data-toggle="tab">Current Images</a></li>
            <li role="presentation"><a href="#upload" aria-controls="messages" role="tab" data-toggle="tab">Upload</a></li>
            @if($type == 'Advanced')
            <li role="presentation"><a href="#editor" aria-controls="messages" role="tab" data-toggle="tab">Animation</a></li>
            @endif
        </ul> 
        <!-- Tab panes --> 
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="details">
                <div class="main-container__content__reminder">
                    <i class="fa fa-exclamation-circle"></i>
                    <small>Reminder: Fields with asterisk(*) are required.</small>
                </div>
                {!! Form::model($banners,array('method'=>'PUT','url'=>'cms/banners/'.$banners['id'],'files'=>'true')) 	!!}
                <div class="row">
                    <div class="col-sm-9">
                        <div class="form-group">
                            {!! Form::label('name', 'Name *') !!} 
                            {!! Form::text('name', $banners['title'],['class' => 'form-control Nform-control ']) !!}
                            {!! Form::hidden('curType',$type) !!}
                            {!! Form::hidden('id',$banners['id'],['id' => 'id']) !!}  
                            {!! Form::hidden('defaultAnimation','{$Duration:700,$Opacity:2,$Brother:{$Duration:1000,$Opacity:2}}') !!}
                            {!! Form::hidden('animationTitle',null,['id' => 'animationTitle']) !!}                                                 {!! Form::hidden('CurrentCode',$bannerCurrentAnimation,['id' => 'currentCode']) !!}
                            <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                        </div>
                        <div class="row">
                            <div class="col-sm-5">
                                <div class="form-group">
                                    {!! Form::label('type','Type *') !!}
                                    <select name ='type' class ='form-control Nform-control'>
                                        <option value="{{ $banners['type']}}" selected disabled>{{ $banners['type']}}</option>                                 
                                        {!! $listtypebanner = ($banners['type'] == 'Standard')? 'Advanced' : 'Standard'; !!}
                                        <option value="{{ $listtypebanner }}">{{$listtypebanner}}</option>
                                    </select>  
                                </div>
                            </div>
                        </div>
                    </div>
                </div>                        
            </div>
            <div role="tabpanel" class="tab-pane" id="content">
                <div class="main-container__content__info__filter">
                    <label>
                        <input type="checkbox" id='selecctall-banner'>
                        Select All
                    </label>
                    <select name="" id="action" class="form-control">
                        <option value="" disabled selected>Choose Action</option>
                        <option value="Delete">Delete</option>
                    </select>
                    {!! Form::button('Apply',['class' => 'btn btn-filter', "id" => "apply"]) !!}
                </div>
                <ul class="list-unstyled banner-content-list">
                    @foreach($currentImages as $currentImage)
                    <li>
                        @if($currentImage->media_path === null)                        
                        @else
                        <input type="checkbox" name ="checkbox" value="{!! $currentImage->id !!}">
                        @endif
                        @if($currentImage->media_path === null)
                        no image available
                        @else
                        <div class="banner-content-list__image-container">
                            {!! HTML::image($currentImage->media_path,null) !!}     
                        </div>

                        @endif
                        @if($currentImage->media_path === null)                      
                        @else

                        <a href='#' id='{!!$currentImage->id!!}' title ='delete this one?' class="glyphicon glyphicon-trash delCur" aria-hidden="true"></a>
                        @endif
                    </li>
                    @endforeach
                </ul>
            </div>
            <div role="tabpanel" class="tab-pane" id="upload">
                <div class="main-container__content__reminder">
                    <i class="fa fa-exclamation-circle"></i>
                    <small>File Type: JPG, GIF, PNG <br>
                        Maximum File Size: 2MB <br>
                        Recommended size: 1140 x 442
                    </small>
                </div>
                <div class="upload-image-container">
                    <div class="upload-image-container__label">
                        Click "<strong>Add Photo</strong>" button to select an image for upload
                    </div>
                    @include('cms.media.photo_tool')
                </div>
            </div>
            @if($type == 'Advanced')
            {!! HTML::script('public/slide/js/slideshow-transition-builder-controller.min.js') !!}
            <div role="tabpanel" class="tab-pane" id="editor">
                <!-- Slideshow Transition Controller Form Begine -->
                <table cellpadding="0" cellspacing="0" border="0" bgcolor="#EEEEEE" align="center" style="color:#000;">
                    <tr>
                        <td width="10"></td>
                        <td width="110">
                            <b>&nbsp; Select Transition</b>
                        </td>
                        <td width="320" height="40">
                            <select name="ssTransition" id="ssTransition" style="width: 300px">
                            </select>
                        </td>
                        <td width="490">
                            <input type="button" value="Play" id="sButtonPlay" style="width: 110px" name="sButtonPlay" disabled="disabled">
                        </td>
                        <td width="30">
                        </td>
                    </tr>
                </table>
                <input id="stTransition" style="width: 833px; height: 25px;" type="hidden" name="stTransition">
                <!-- Slideshow Transition Controller Form End -->
                <table cellpadding="0" cellspacing="0" border="0" align="center">
                    <tr>
                        <td width="850" height="50"></td>
                    </tr>
                </table>
                <table border="0" cellpadding="0" cellspacing="0" width="600" height="300" align="center" bgcolor="#EEEEEE">
                    <tr>
                        <td>
                            <!-- Jssor Slider Begin -->
                            <!-- You can move inline styles to css file or css block. -->
                            <div style="position: relative; width: 600px; height: 300px;" id="slider1_container">

                                <!-- Loading Screen -->
                                <div u="loading" style="position: absolute; top: 0px; left: 0px;">
                                    <div style="filter: alpha(opacity=70); opacity:.7; position: absolute; display: block;
                                         background-color: #000000; top: 0px; left: 0px;width: 100%;height:100%;">
                                    </div>
                                    <div style="position: absolute; display: block; background: url(../public/slide/img/loading.gif) no-repeat center center;
                                         top: 0px; left: 0px;width: 100%;height:100%;">
                                    </div>
                                </div>

                                <div u="slides" style="cursor: move; position: absolute; width: 600px; height: 300px;top:0px;left:0px;overflow:hidden;">
                                    <!-- Slide -->
                                    @foreach($currentImages as $currentImage)
                                    <div>
                                        {!! HTML::image($currentImage->media_path, null, array('style' => 'width:600px;height:300px;')) !!}
                                    </div>
                                    @endforeach                                    
                                </div>
                            </div>
                            </div>
                            <!-- Jssor Slider End -->
                        </td>
                    </tr>
                </table>
                <script>
                    slideshow_transition_controller_starter("slider1_container");
                    var code = $('#currentCode').val();
                    $('#ssTransition').val(code);
                    $('#stTransition').val(code);
                    $('#sButtonPlay').click();
                </script>
                @endif
            </div><br><br><br>
            <div class="btn-holder pull-left">
                <input type="submit" class="btn btn-add" value="Save">
                {!! Form::button('Cancel',['class' => 'btn btn-reset','id' => 'cancel']) !!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            //        code editor for banner effects
            var filename = 'public/css/banner.css';
            $.get('../../../' + filename, function (data)//Remember, same domain
            {
                var _data = data;
                $('#codeEditor').val(data);
            });
            $(document).on("click", "#cancel", function () {
                window.location = ("{!! URL::to('/') !!}" + "/cms/banners");
            });
            $(document).on("click", '#apply', function () {
                var action = $('#action').val();
                if (action === 'Delete') {
                    var selected = new Array();
                    $("input:checkbox[name=checkbox]:checked").each(function () {
                        selected.push($(this).val());
                        console.log(selected);
                    });
                    if (confirm('do you really want to delete the selected image(s) for this banner?')) {
                        $.ajax({
                            type: "DELETE",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {selected: selected},
                            url: "{!! URL::to('/') !!}" + '/cms/delImage',
                            dataType: "json",
                            success: (function (data) {
                                location.reload();
                            })
                        });
                    } else {
                        return false;
                    }
                }
            });

            $(document).on("click", '.delCur', function () {
                var id = this.id;
                if (confirm('do you really want to delete this current image for this banner?')) {
                    $.ajax({
                        type: "DELETE",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: "{!! URL::to('/') !!}" + "/cms/delCurrentImage/" + id,
                        dataType: "json",
                        success: (function (data) {
                            location.reload();
                        })
                    });
                }
            });

            $('#ssTransition').on('change', function () {
                var e = document.getElementById("ssTransition");
                var strUser = e.options[e.selectedIndex].text;
                $('#animationTitle').val(strUser);
            });

        });
    </script>
    @stop

