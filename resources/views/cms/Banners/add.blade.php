@extends('cms.home')
@section('title')
<h2>Banner</h2>
@stop
@section('content')
<div class="main-container__content__reminder">
    <i class="fa fa-exclamation-circle"></i>
    <small>Reminder: Fields with asterisk(*) are required.</small>
</div>    
<div class='main-container__content__info'>
    <div class="row">  
        {!! Form::open(array('url'=> 'cms/banners', 'files' => 'true')) !!} 
        <div class="col-sm-9">
            <div class="form-group">
                <label for="banner-title" class='form-title'>Banner Title *</label>
                {!! Form::text('name',null,['class' => 'form-control','id'=>'banner-title','placeholder'=>'Enter title here']) !!}  
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="banner-type" class='form-title'>Type *</label>
                        {!! Form::select('type',array('Standard' => 'Standard', 'Advanced' => 'Advanced'), null, array('class' => 'form-control')) !!}
                    </div>
                </div>
            </div>
            <div class="btn-holder with-border-top">
                <div class="pull-right">
                    {!! Form::reset('Reset',['class'=> 'btn btn-reset']) !!}
                    {!! Form::submit('Save',['class'=> 'btn btn-add']) !!}
                </div>
            </div>
        </div>
        {!! Form::close() !!} 
    </div>
</div>
@stop