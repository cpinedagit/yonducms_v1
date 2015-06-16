@extends('cms.home')
@section('title')
<h2>Editor</h2>
@stop
@section('content')
 <div class="alert alert-success hidden" role="alert">File has been saved. <div class="glyphicon glyphicon-remove" id="close-symbol"> </div> </div>

<div class='main-container__content__info'>
    <div class="row">
        <div class="col-sm-9">
            <div class="form-group">
                <label for="edit-themes" class='form-title'>Edit Themes</label>
                {!! Form::open(array('url' => 'cms/editor/updateFile','method' => 'post')) !!}
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <article></article>
                <input name ='content' type='hidden' value=''>
                <input id ='hidden' name ='hidden' type='hidden' value=''> <br/>
                <input id ='update' class="btn btn-add" type="button" value="Update File" class="btn btn-success">
                {!! Form::close() !!}
            </div>
        </div>
        <div class="col-sm-3">
            <div class="main-container__content__info__photo main-container__content__info__photo--editor">
                @foreach($parents as $parent)
                <ul class=mtree>
                    <li class="has-submenu" data-folder='js'>
                        <a href="#">{{ $parent->name}} </a>
                        <button type="button" class="btn fa fa-plus pull-right btn-add-folder" data-path ='{{ $parent->path }}' data-parent='{{$parent->id}}' data-toggle="modal" data-target="#add-folder" title="add file or folder?"></button>
                        <ul>
                            <?php $folderFiles = File::files($parent->path) ?> 
                            @foreach($folderFiles as $files)
                            <li>                           
                                <a class="linkFile" data-ext ='{!! File::name($files) !!}' id ='{!! $files !!}' style="cursor: pointer;">{!! File::name($files) !!}.{!! File::extension($files) !!}</a>
                                <input id ="ext" type='hidden' value ="{!! File::extension($files) !!}">
                            </li>
                            @endforeach
                            <?php $directories = File::directories($parent->path); ?>
                            @foreach($directories as $dir)
                            @if(File::isDirectory($dir))
                            <li class="has-submenu" data-folder='plugins'>
                                <a href="#">{!! basename($dir) !!} </a>
                                <button id ="addFileToSubButton" type="button" class="btn fa fa-plus pull-right btn-add-folder" data-path ='{{ $parent->path.'/'. basename($dir) }}' data-toggle="modal" data-target="#addFileInSubFolder" title ="add file?"></button>
                                <?php $files = File::files($parent->path . '/' . basename($dir)); ?>
                                <ul>
                                    @foreach($files as $file)
                                    <li style="margin-left:10px;">                           
                                        <a class="linkFile" id ='{!! $file !!}' style='cursor: pointer;'>{!! File::name($file) !!}.{!! File::extension($file) !!}</a>
                                        <input id ="ext2" type='hidden' value ="{!! File::extension($file) !!}">
                                    </li>
                                    @endforeach
                                </ul>
                            </li>
                            @endif
                            @endforeach
                        </ul>
                    </li>
                </ul>
                @endforeach
            </div>
        </div>   
    </div>
    <!-- MODAL -->
    {!! Form::open(array('id' => 'addFolderForm')) !!}
    <div class="modal fade" id="add-folder" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content modal-content--changepassword">
                <div class="modal-header modal-header--changepassword">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Add Folder/File</h4>
                </div>
                <div class="modal-body modal-body--changepassword">
                    <div role="tabpanel" class="tabpanel-custom">
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#addFolder" aria-controls="addFolder" role="tab" data-toggle="tab">Add Folder</a></li>
                            <li role="presentation"><a href="#addFile" aria-controls="profile" role="tab" data-toggle="tab">Upload file</a></li>
                        </ul>
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="addFolder">
                                <div class="form-group">
                                    <label for="folder-name" class='form-title'>Folder Name</label>
                                    <input name='foldername' type="text" class="form-control" id="folder-name" placeholder="Folder name">
                                    {!! Form::hidden('path',null,['id' => 'dataPath']) !!}
                                    {!! Form::hidden('parent',null,['id' => 'dataParent']) !!}
                                </div>
                                <button type="button" class="btn btn-add center-block" id='add-folder-action'>Add</button>
                            </div>
                            {!! Form::close() !!} 
                            <div role="tabpanel" class="tab-pane" id="addFile">
                                <div class="form-group">
                                    {!! Form::open(array('files' => 'true', 'method' => 'POST', 'url' => 'cms/editor/addEditorFile')) !!}
                                    {!! Form::file('file') !!}
                                    {!! Form::hidden('path',null,['id' => 'editorFilePath']) !!}
                                </div>
                                {!! Form::submit('Upload File',['class' => 'btn btn-add center-block']) !!}
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>                   
            </div>
        </div>
    </div>
    <!--        MODAL FOR ADD FILE IN SUBFOLDER -->
    <div class="modal fade" id="addFileInSubFolder" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content modal-content--changepassword">
                <div class="modal-header modal-header--changepassword">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Add File</h4>
                </div>
                <div class="modal-body modal-body--changepassword">
                    <div class="form-group">
                        {!! Form::open(array('files' => 'true', 'method' => 'POST', 'url' => 'cms/editor/addEditorFile')) !!}
                        {!! Form::file('file') !!}
                        {!! Form::hidden('path',null,['id' => 'editorFilePathSub']) !!}
                    </div>                    
                </div>
                <div class="modal-footer modal-footer--changepassword">
                    {!! Form::submit('Upload File',['class' => 'btn btn-add center-block']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div> 
    <div class="modal fade" id="warningInvalidFileFormat" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content modal-content--changepassword">
                <div class="modal-header modal-header--changepassword">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Warning</h4>
                </div>
                <div class="modal-body">
                    <p>Invalid file format: editor only read <b>php, css, js </b> and <b>html</b> file extension.</p>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </div>
        </div>
    </div> 
</div>
<script>
    $(document).on("click", '.btn-add-folder', function () {
        var parent = $(this).attr('data-parent');
        var path = $(this).attr('data-path');
        $('#dataParent').val(parent);
        $('#dataPath').val(path);
        $('#editorFilePath').val(path);
    });

    $(document).on("click", '#addFileToSubButton', function () {
        var path = $(this).attr('data-path');
        $('#editorFilePathSub').val(path);
    });

    $(document).on('click', '#add-folder-action', function () {
        var form = $('form#addFolderForm').serialize();
        $.ajax({
            type: 'get',
            url: 'editor/addFolder',
            data: form,
            dataType: 'json',
            success: (function (data) {
                location.reload();
            })

        });
    });

    //Intialize the CodeMirror
    $('document').ready(function(){

        var code_mirror = CodeMirror(document.body.getElementsByTagName("article")[0], {
                  value: "Welcome to {{ env('APP_TITLE') }} editor!",
                  lineNumbers: true,
                  mode: "javascript",
                  keyMap: "sublime",
                  autoCloseBrackets: true,
                  matchBrackets: true,
                  showCursorWhenSelecting: true,
                  theme: "monokai"
        });


        $('.linkFile').on('click', '', function (e) {
            $('.alert-success').addClass('hidden');
            var filename = this.id;
            
            $.ajax({
                    type:'POST',
                    url: "{{ URL().'/cms/editor/readFile' }}",
                    data: {
                        '_token':   $('[name=_token]').val(),
                        'file_dir': filename 
                    },
                    dataType: 'json',
                    success: function (data) {
                        var value='';
                        for(x in data)
                            value += data[x]; 

                        code_mirror.setValue(value); //Set code_mirror value
                        $('#hidden').val(filename); //Set file name to form
                        $('.form-title').html("Edit Themes: "+filename); //Set file name in the editor header
                    },error: function () { 
                        // if error occured
                        $('#warningInvalidFileFormat').modal('show') 
                    }
            });
        });

        //Update file using AJAX
        $('#update').on('click', function(){
            $.ajax({
                    type: 'POST',
                    url: "{{ URL().'/cms/editor/updateFile' }}",
                    data: {
                            'hidden': $('#hidden').val(), 
                            '_token': $('[name=_token]').val(),
                            'content': code_mirror.getValue()
                    },
                    success: function () {
                         $('.alert-success').removeClass('hidden');
                    },error: function () { 
                        // if error occured
                        alert("Error: try again");
                    }
            });
        }); 
    });   

    //Close message alert when click close
    $('#close-symbol').on('click', function(){
        $('.alert-success').addClass('hidden');
    });

</script>
@stop