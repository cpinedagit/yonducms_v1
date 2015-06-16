@extends('cms.home')
@section('content')
<ul class="nav nav-pills nav-tabs">
    <li role="presentation">{!! HTML::link('cms/editor', 'Code Editor') !!}</li>
    <li role="presentation" class='active'>{!! HTML::link('cms/image','Images') !!}</li>
    <li role="presentation">{!! HTML::link('cms/banners','Banner Management') !!}</li> 
    <li role="presentation">{!! HTML::link('cms/pages','Page Management') !!}</li> 
</ul>
<div class="border">
    <h2>Edit Image</h2>
    {!! Form::model($images,array('method'=>'PUT','url'=>'cms/image/'.$images['id'],'files'=>'true')) 	!!}
    {!! Form::label('name', 'Name:') !!} 
    {!! Form::text('name', $images['name'],['class' => 'form-control Nform-control ']) !!}
    {!! Form::label('image','Image:') !!}
    {!! Form::file('image',['class' => 'form-control Nform-control']) !!}
    {!! Form::label('','Current Image:') !!}<br>
    {!! HTML::image('images/'.$images['image'],null,['width' => '310','height' => '180','style=margin-left:100px:']) !!}<br><br>
    {!! Form::submit('Save',['class' => 'btn btn-success']) !!}
    {!! Form::button('Cancel',['id' => 'cancel', 'class' => 'btn btn-danger']) !!}
    {!! Form::close() !!}
</div>
<script>
    $(document).ready(function () {

        $(document).on("click", "#cancel", function () {

            window.location = ("http://localhost/lwebservice_2/public/cms/mage");
        });

    });
</script>
@stop

