@extends('cms.home')
@section('title')
<h2>Add Pages</h2>
@stop
@section('content')
<div class="main-container__content__reminder">
    <i class="fa fa-exclamation-circle"></i>
    <small>Reminder: Fields with asterisk(*) are required.</small>
</div>
{!! Form::open(array('url' => 'cms/pages', 'method' => 'post')) !!}
<div class='main-container__content__info'>
    <div class="row">
        <div class="col-sm-9">
            <div class="form-group">
                {!! Form::label('page','Add New Page *',['class' => 'form-title']) !!}
                {!! Form::text('page',null,['name' => 'title','class' => 'form-control','placeholder' => 'Enter title here']) !!}
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="page-title" class='form-title'>Parent Page</label>
                        <select name="parent" id="" class="form-control">
                            <option value="0" selected>Choose</option>
                            @foreach($pages as $page)
                            <option value="{!! $page->id !!}">{!! $page->title !!}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="form-group">
                        {!! Form::label('url','Default URL : ',['class' => 'form-title']) !!}
                        <i>{!! URL::to('/')!!}</i>{!! Form::text('slug',null,['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        {!! Form::label('Editor1','Content *',['class' => 'form-title']) !!}
                        {!! Form::textarea('Editor1',null,['cols' => '100','rows' => '10','class' => 'ckeditor']) !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="main-container__content__info__options">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name = "publish"> Publish Page
                    </label>
                </div>
                <div class="main-container__content__info__options__action-holder btn-holder">                       
                    {!! Form::reset('Reset',['class' => 'btn btn-reset']) !!}
                    {!! Form::submit('Save',['class' => 'btn btn-add']) !!}
                </div>
            </div>
        </div>
    </div>
</div>    
{!! Form::close() !!}
@stop


