@extends('cms.home')

@section('title')
<h2>User Management</h2>
{!! HTML::linkRoute('cms.role.create', 'Add New Role',array(),array('class'=>'btn btn-add')) !!}
@stop

@section('content')
<style>
.btn-delete {
	background-color: Transparent;
	background-repeat:no-repeat;
	border: none;
	cursor:pointer;
	overflow: hidden;
	outline:none;
	color: #7b8698;
	transition: all 0.3s ease-in-out;
}
</style>
<div class='main-container__content__info'>
	<div class="main-container__content__info__filter-container">
        <div class="main-container__content__info__search main-container__content__info__search--no-action">
           <div class="form-inline">
                <select name="" id="" class="form-control pull-left">
                   <option value="" disabled selected>Select</option>
                    @foreach($roles as $role)

                   	<option value="{!! $role->id !!}">{!! ucwords(strtolower($role->role_name)) !!}</option>

                   @endforeach
                <span class="pull-right">
                    <input type="text" class="form-control  main-container__content__info__search__option" placeholder="Search" id="searchText">
                    <input type="submit" class='btn btn-filter' value="Search">
                </span>
             </div>
        </div>
        <table id="example" class="table table-striped table--data table--noaction table--lastaction">
            <thead>
                <tr>
                    <th>Role</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>              
            	@foreach($roles as $role)  
                <tr>
                    <td>
                    	{!! $role->role_name !!}
                    </td>
                    <td>
                    	{!! $role->role_description !!}
                    </td>
                    <td>
                    	@if($role->role_active == 1)
                    		Active
                    	@else
                    		Inactive
                    	@endif
                    </td>
                    @if(\Auth()->user()->role_id != $role->id)
                    <td class='action'>
                        <i class="fa fa-chevron-left"></i>
                        <ul class="list-unstyled action-list">
                            <li>
                            	{!! HTML::linkRoute('cms.role.edit', 'Modify', $role->id) !!}
                            </li>
                            <li>
                            	{!! Form::open(array('route' => array('cms.role.destroy', $role->id), 'method' => 'delete')) !!}
								    {!! Form::submit('Delete', array('class' => 'btn-delete')) !!}
								{!! Form::close() !!}
                            </li>
                        </ul>
                    </td>
                    @else
                    <td class='action'>
                        Not allowed
                    </td>
                    @endif
                </tr>
                @endforeach                
            </tbody>
        </table>
    </div>
</div>
 <script>
    $(document).ready(function() {
        var table = $('#example').DataTable({
            aaSorting: [0],
            bInfo: false,
            columnDefs: [
               { orderable: false, targets: -1 }
            ],
            "dom":'<"top">rt<"bottom"lp>',
            "oLanguage": {
                "sSearch": "<span class='lbl-filter'>Search</span> ",
                "oPaginate": {
                    "sPrevious": '<i class="fa fa-chevron-left"></i>',
                    "sNext": '<i class="fa fa-chevron-right"></i>'
                }
                
            }
        });

        $('#searchText').on('keyup change', function () {                
                table.search(this.value)
                    .draw();
            });

        $( ".datepicker" ).datepicker();
    } );
</script>

@endsection
@stop