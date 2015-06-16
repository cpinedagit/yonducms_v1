<style>
    .btn-file {
        position: relative;
        overflow: hidden;
    }
    .btn-file input[type=file] {
        position: absolute;
        top: 0;
        right: 0;
        min-width: 100%;
        min-height: 100%;
        font-size: 100px;
        text-align: right;
        filter: alpha(opacity=0);
        opacity: 0;
        outline: none;
        background: white;
        cursor: inherit;
        display: block;
    }
    .controls--upload
    {
        height: 250px;
        margin-bottom: 0px;
        margin-top: 10px;
    }
</style>

<button type="button" class="btn btn-add" data-toggle="modal" data-target="#fileModal">
    Add Photo
</button>

<div class="modal modal-custom fade" id="fileModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Add Image</h4>
            </div>
            <div class="modal-body">

                <div role="tabpanel" class="modal-body__media">

                    <!-- Nav tabs -->
                    <ul id="myTab" class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#upload_file" aria-controls="upload_file" role="tab" data-toggle="tab">Upload Files</a></li>
                        <li role="presentation"><a href="#media_library" aria-controls="media_library" role="tab" data-toggle="tab">Media Library</a></li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="upload_file">
                            <div class="main-container__content__reminder">
                                <i class="fa fa-exclamation-circle"></i>
                                <small>Reminder: Allowed file types: {{ env('APP_MEDIA_FORMATS') }}.</small>
                                <small>Maximum file size: {{ env('APP_MEDIA_MAX_FILE_SIZE') }}MB</small>
                            </div>
                            <div class="control-group">
                                <div class="controls controls--upload">

                                    <div class="filedrag-holder">
                                        <div id="filedrag">
                                            <h3>Drop files here</h3>
                                            or <br>
                                            <span class="btn btn-add filedrag__modal btn-file">
                                                Select Files{!! Form::file('fileselect[]', array('multiple'=>true,'id'=>'fileselect','accept'=>'image/*,video/*')) !!}
                                            </span>

                                        </div>
                                    </div>
                                </div>
                            </div>



                        </div>
                        <div role="tabpanel" class="tab-pane" id="media_library">
                            <div class="medialibrary__container">
                                <ul class="list-unstyled medialibrary__list">
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>



            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-reset" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-add" id="insert">Add</button>
            </div>
        </div>
    </div>
</div>



<script>

    $(document).ready(function () {

        populateImgLibrary();


        $('#insert').on('click', function () {
            var selected = new Array();
            $("input:checkbox[name=cbfiles]:checked").each(function () {
                selected.push($(this).val());
            });
            var id = $('#id').val();
            console.log(selected);
            $.ajax({
                method: 'put',
                url: '{!! route("cms.banner.saveImage") !!}',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {id: id, selected: selected},
                cache: false,
                success: function (msg)
                {
                    location.reload();
                }
            })
            $('#fileModal').modal("hide");


        });

    });


    function DoneUpload() {
        populateImgLibrary();
        $('#myTab a[href="#media_library"]').tab('show');
    }

    function populateImgLibrary()
    {
        $('.medialibrary__list').empty();
        str = "";
        $.post(
                '{!! URL::route("cms.media.getAllimage") !!}',
                {
                    "_token": $('[name=_token').val()
                },
        function (data) {
            for (x in data[0])
            {
                str += '<li></label>'
                str += '<input type="checkbox" name="cbfiles" value="' + data[0][x]['media_id'] + '">';
                media_path = data[0][x]['media_path'];
                if (data[0][x]['media_type'] == 1)
                {
                    str += '{!! HTML::image("' + media_path + '","alt",array("class"=>"tbl-img-thumbnail-2x")) !!}';
                }
                else
                {
                    str += '{!! HTML::image("css/video_icon.jpg","alt",array("class"=>"tbl-img-thumbnail-2x")) !!}';
                }

                str += '</input>';
                str += '</label></li>'
            }
            $('.medialibrary__list').append(str);
        },
                'json'
                );
    }

    function FileSelectHandler(e) {
        var formats = "{{ env('APP_MEDIA_FORMATS') }}";
        formats = formats.split(',');
        var default_size = "{{ env('APP_MEDIA_MAX_FILE_SIZE') }}";
        FileDragHover(e);

        var files = e.target.files || e.dataTransfer.files;
        var formData = new FormData();
        for (var i = 0, f; f = files[i]; i++) {
            blob = f.type;
            blob = blob.split("/");
            if ((blob[0]) == "image") {

                filename = f.name;
                var ext = filename.split('.').pop();
                if (formats.indexOf(ext) < 0)
                {
                    alert("file type error");
                    return false;
                }
                else
                {
                    filesize = f.size;
                    filesize = filesize / 1024 / 1024;
                    if (filesize > default_size)
                    {
                        alert("cant upload file size is over " + default_size + "MB");
                        return false;
                    }
                    else
                    {
                        formData.append('fileselect[]', f);
                        formData.append('file', f);
                    }
                }
            }
            else
            {
                alert("image only");
                return false;
            }
        }
        $('[name=_token').val();
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '{!! URL::route("cms.media.store") !!}', true);
        xhr.onload = function () {
            if (xhr.status === 200) {
                DoneUpload();
            } else {
                console.log('Error');
            }
        };
        formData.append("_token", $('[name=_token').val());
        xhr.send(formData);
    }

</script>

{!! HTML::script('public/js/upload_tool.js') !!}



