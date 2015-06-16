@extends('cms.home')
@section('title')
<h2>Banner</h2>
<a href="{!! URL::route('cms.Banners.add') !!}" class="btn btn-add">Add New</a>
@stop
@section('content')
<!-- Add your site or application content here -->
<div class="main-container">
    <div class='main-container__content__info'>
        <div class="main-container__content__info__summary">
            <span>
                <strong>All</strong> ({{ $bannersCount }})
            </span>
            <span>
                <strong>Main Banner</strong> ({{ $getAllMainBannerCount }})
            </span>
            <span>
                <strong>Sub Banner</strong> ({{ $getAllSubBannerCount }})
            </span>
        </div>
        
        <div class="main-container__content__info__filter">
            <select name="" id="" class="form-control">
                <option value="" disabled selected>Choose Action</option>
                <option value="">Delete</option>
            </select>
            <input type="button" onclick="deleteSelected()" class='btn btn-filter' value="Apply">
        </div>

        <table id="example" class="superTable table table-striped table--data table--lastaction ">
            <thead>
                <tr>
                    <th><input type="checkbox" id='selecctall'></th>
                    <th> Title</th>
                    <th> Type</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($banners as $banner)
                <tr>
                    <td><input type="checkbox" name="cbox" id="{!! $banner->id !!}"></td>
                    <td> {!! $banner->title !!}</td>
                    <td> {!! $banner->type !!}</td>
                    <td class='action'>
                        <i class="fa fa-chevron-left"></i>
                        <ul class="list-unstyled action-list">
                            <li><a href="banners/{{ $banner->id }}/edit" class="edit" id = "">edit</a></li>
                            <li><a href ="#" onclick ="del({{ $banner->id }})">delete</a></li>
                        </ul>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
</form>
<script>
            function del(id){
//            console.log($('meta[name="csrf-token"]').attr('content'));
            if (confirm('do you really want to delete this banner') == true)
            {
            $.ajax({
            type:"DELETE",
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url:  'banners' + "/" + id,
                    dataType: "json",
                    success:(function(data) {
                    window.location = ("banners");
                    })
            });
            } else{
            return false;
            }

            }
    $(document).ready(function(){

    $(document).on('click', '#addBanner', function(){

    window.location = ('addBanner');
    });
    });


</script>


@stop