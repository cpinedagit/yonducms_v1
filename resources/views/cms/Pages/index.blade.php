@extends('cms.home')
@section('title')
<h2>Pages</h2>
<a href="{!! URL::route('cms.pages.addPage') !!}" class="btn btn-add">Add New</a>
@stop
@section('content')
<div class='main-container__content__info'>
    <div class="main-container__content__info__summary">
        <span>
            <strong>All</strong> ({{ $pagesCount }})
        </span>
        <span>
            <strong>Published</strong> ({{ $publishedCount }})
        </span>
    </div>
    <div class="main-container__content__info__filter">
        <select id="action" class="form-control">
            <option value="" disabled selected>Choose Action</option>
            <option value="Delete">Delete</option>
        </select>
        <input type="submit" id ="apply" class='btn btn-filter' value="Apply">
    </div>
    <table id="example" class="superTable table table-striped table--data table--lastaction ">
        <thead>
            <tr>
                <th><input type="checkbox" id='selecctall'></th>
                <th>Page Title</th>
                <th>Status</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pages as $page)
            <tr>
                <td><input name ="checkbox" type="checkbox" value ="{{ $page['id']}}"></td>
                <td>{!! $page['title'] !!}</td>
                <td>{!! $page['status'] !!}</td>
                <td><?php echo date('M d, Y', strtotime($page['created_at'])); ?></td>
                <td class='action'>
                    <i class="fa fa-chevron-left"></i>
                    <ul class="list-unstyled action-list">
                        <li><a href ="pages/{!! $page['id'] !!}/edit">edit</a><a href ="#" onclick = ""></a></li>                          
                        <li>{!! HTML::link(URL::to('/site').'/'.$page['slug'],'preview',['target' => '_blank']) !!}</li>
                    </ul>
                </td>
            </tr>
            @endforeach 
        </tbody>
    </table>
</div>
<script>
    $(document).ready(function () {

        $(document).on('click', '#addPage', function () {
            window.location = ('addPage');
        });
    });

    $(document).on("click", '#apply', function () {
        var action = $('#action').val();
        if (action === 'Delete') {
            var checked = new Array();
            $("input:checkbox[name=checkbox]:checked").each(function () {
                checked.push($(this).val());
                console.log(checked);
            });
            if (confirm('do you really want to delete the selected page(s)?')) {
                $.ajax({
                    type: "DELETE",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {checked: checked},
                    url: "{!! URL::to('/') !!}" + '/cms/delPage',
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
</script>
@stop