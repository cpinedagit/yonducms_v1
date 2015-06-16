@extends('cms.home')
@section('content')
<ul class="nav nav-pills nav-tabs">
    <li role="presentation">{!! HTML::link('cms/editor', 'Code Editor') !!}</li>
    <li role="presentation" class='active'>{!! HTML::link('cms/image','Images') !!}</li>
    <li role="presentation">{!! HTML::link('cms/banners','Banner Management') !!}</li> 
    <li role="presentation">{!! HTML::link('cms/pages','Page Management') !!}</li> 
</ul>
<div class="border">
    <h2>Images</h2>           
    <table border='1'>
        <thead>
            <tr>
                <th> ID</th>
                <th> Name</th>
                <th> Image</th>
                <th> Filename</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>                   
            @foreach($images as $image)
            <tr>
                <td>{!! $image->id !!}</td>
                <td> {!! $image->name !!}</td>
                <td>{!! HTML::image('images/'.$image['image'],null,['width' => '100', 'height' => '50']) !!}</td>
                <td>{!! $image['image'] !!}</td>
                <td><a href="image/{{ $image->id }}/edit" class="edit" id = "">edit</a> | <a href ="#" onclick ="del({{ $image->id }})">del</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <button id ='addImage' type='button' class="btn btn-success">Add Image</button>
</div>
{!! HTML::script('js/jquery.js') !!}
{!! HTML::script('js/bootstrap.min.js') !!}
<script>
    function del(id){
        if (confirm('do you really want to delete this image?') == true){
            $.ajax({
            type:"DELETE",
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url:  'image' + "/" + id,
                    dataType: "json",
                    success:(function(data) {
                        window.location = ("image");
                    })
            });
        }else{return false;}

    }
$(document).ready(function(){
    $(document).on('click', '#addImage', function(){
        window.location = ('addImage');
    });
});


</script>
@stop