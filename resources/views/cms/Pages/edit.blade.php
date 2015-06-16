@extends('cms.home')
@section('content')
{!! Form::model($pages,array('method'=>'PUT','url'=>'cms/pages/'.$pages['id'],'files'=>'true')) !!}
<div class='main-container__content__title'>
    <h2>Pages</h2>
</div>
<div class="main-container__content__breadcrumbs">
    <ol class="breadcrumb">
        <li><a href="#">Home</a></li>
        <li><a href="#">Pages</a></li>
        <li class="active">Edit</li>
    </ol>
</div>
<div class="main-container__content__reminder">
    <i class="fa fa-exclamation-circle"></i>
    <small>Reminder: Fields with asterisk(*) are required.</small>
</div>
<!-- 
    Choose color using these classes:
     1. alert-success
     2. alert-info
     3. alert-warning
     4. alert-danger

     then use "open" class to show the alert
-->

<!--<div class="alert alert-danger alert-danger--login show" role="alert">
    Invalid Username/Password
     sample list of errors
    <div class="error-list">
        <h5><strong>Message:</strong> </h5>
        <ul>
            <li>Invalid Username/Password</li>
            <li>Invalid Username/Password</li>
        </ul>
    </div>
</div>-->
<div class='main-container__content__info'>
    <div class="row">
        <div class="col-sm-9">
            <div class="form-group">
                <label for="page-title" class='form-title'>Edit Page *</label>
                {!! Form::text('title', $pages['title'],['class' => 'form-control Nform-control', 'placeholder' => 'Enter title here']) !!}
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="page-title" class='form-title'>Parent Page *</label>
                        {!! Form::hidden('hideParent',$getParentId) !!}                   
                        <select name ='parent' class='form-control'>
                             @if(empty($getParent))
                            <option value='0' style='color:red;'>no parent</option>
                            @else
                            <option disabled selected>{{ $getParent }}</option>
                            <option value='0' style='color:red;'>no parent</option>
                            @endif
                            
                            @foreach($getAllPages as $getPages)
                            <option value="{!! $getPages->id !!}">{!! $getPages->title !!}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="form-group no-margin-bottom">
                        <label for="page-url" class='form-title'>URL Key</label>
                        <div class="form-inline">
                            <div class="form-group" id ="nonEditableUrl">
                                <label>{!! URL::to('/site')!!}/</label>
                                <input type="text" name ="slug" class="form-control textbox--editable" value="{!! $pages['slug'] !!}" id="texturlkey" disabled style='cursor:pointer;'>
                                <button id="edit" type="button" class="btn btn-reset">Edit</button>
                            </div>
                            <div class="form-group" id="editableUrl">
                                <label>{!! URL::to('/site')!!}/</label>
                                <input type="text" name="slug" class="form-control" value="{!! $pages['slug'] !!}" id="texturlkey">
                                <button id="cancel" type="button" class="btn btn-reset">cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">



                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="editor1" class='form-title'>Content *</label>
                        {!! Form::textarea('Editor1',$pages['content'],['cols' => '100','rows' => '100','class' => 'ckeditor','id' => 'Editor1']) !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="main-container__content__info__options">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" checked> Publish Page
                    </label>
                </div>
                <!--                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" checked> Include Widget
                                    </label>
                                </div>-->
                <div class="main-container__content__info__options__action-holder btn-holder">
                    <button class="btn btn-reset" onclick = "cancel()">Cancel</button>
                    <input type="submit" class="btn btn-add" value="Save">
                </div>
            </div>


            <h3>Plugin</h3>
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                <div class="panel panel-default">
                    <div class="panel-heading" style="cursor:pointer" role="tab" id="headingOne" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        <h4 class="panel-title">
                            Banner
                        </h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                        <div class="panel-body">
                            <table class="table table--banner">
                                <tbody>
                                    @foreach($banners as $banner)
                                    <tr>
                                        <td>{{ $banner->title}}</td>
                                        @if($banner->type === 'Standard')
                                        <td><button type="button" class="btn btn-add addOnCk" var="[StandardBanner({{ $banner->id}})]"><span  class="glyphicon glyphicon-plus"></span></button></td>
                                        @else
                                        <td><button type="button" class="btn btn-add addOnCk" var="[AdvancedBanner({{ $banner->id}})]"><span  class="glyphicon glyphicon-plus"></span></button></td>
                                        @endif
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading" style="cursor:pointer" role="tab" id="headingTwo" class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        <h4 class="panel-title">
                            News
                        </h4>
                    </div>
                    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                        <div class="panel-body">
                            <table class="table table--banner">
                                <tbody>
                                    <tr>
                                        <td> News List </td>
                                        <td>
                                            <button class="btn btn-add addOnCk" type="button" var="[news_list()]"><span  class="glyphicon glyphicon-plus"></span></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td> News Archive</td>
                                        <td>
                                            <button type="button" class="btn btn-add addOnCk" var="[news_archive()]"><span  class="glyphicon glyphicon-plus"></span></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td> Featured News</td>
                                        <td>
                                            <button type="button" class="btn btn-add addOnCk" var="[featured_news()]"><span  class="glyphicon glyphicon-plus"></span></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div> 

        </div>

    </div>
</div>
{!! Form::close() !!}
<script>
    $('#editableUrl').hide();
    $(document).on("click", "#edit", function (e) {

        $('#editableUrl').show();
        $('#nonEditableUrl').hide();
        $('#slug').focus();
        $('#slug').focusTextToEnd();
        e.stopPropagation();
    });

    $(document).on("dblclick", "#nonEditableUrl", function () {
        $('#editableUrl').show();
        $('#nonEditableUrl').hide();
        $('#slug').focus();
    });

    $(document).on("click", "#cancel", function () {
        $('#editableUrl').hide();
        $('#nonEditableUrl').show();
    });

    function cancel() {
        window.location = ("{!!URL::to('/')!!}" + "/cms/pages");
    }

    function focusTextToEnd() {
        this.focus();
        var $thisVal = this.val();
        this.val('').val($thisVal);
        return this;
    }
</script>
@include('cms.media.media_tool')
<script>

    $('.addOnCk').on('click', function () {
        text = $(this).attr('var');
        editor.insertHtml(text);
    })
</script>

@stop
