@extends('cms.home')
@section('content')
<ul class="nav nav-pills nav-tabs">
    <li role="presentation">{!! HTML::link('cms/editor', 'Code Editor') !!}</li>
    <li role="presentation" class='active'>{!! HTML::link('cms/image','Images') !!}</li>
    <li role="presentation">{!! HTML::link('cms/banners','Banner Management') !!}</li> 
    <li role="presentation">{!! HTML::link('cms/pages','Page Management') !!}</li> 
</ul>
<div class="border">
    <h2>Add Image</h2>           
    {!! Form::open(array('url'=> 'cms/image', 'files' => 'true')) !!}

    {!! Form::label('iname', 'Name:') !!}
    {!! Form::text('name',null,['class' => 'form-control Nform-control']) !!}            
    {!! Form::label('image', 'Image:') !!}
    {!! Form::file('image',['class' => 'form-control Nform-control']) !!}
    {!! Form::submit('Save',['class'=> 'btn btn-default marginTop marginLeft']) !!}
    {!! Form::close() !!} 
</div>
@stop


