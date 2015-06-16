@extends('cms.home')
@section('title')
<h2>User Management</h2>
{!! HTML::linkRoute('cms.user.create', 'Add New',array(),array('class'=>'btn btn-add')) !!}
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
	<div class="main-container__content__info__summary">

		@foreach($roles as $role)

			<span>
				<strong>{!! ucwords(strtolower($role->role_name)) !!}</strong> 

                @foreach($userCounts as $userCount)
                    @if($userCount->role_id == $role->id)
                        ({!! $userCount->c_user !!})
                    @endif
                @endforeach

			</span>

		@endforeach

	</div>

	<div class="main-container__content__info__filter-container">

		 <div class="main-container__content__info__search main-container__content__info__search--no-action">
           <div class="form-inline">
                <select name="" id="selectRole" class="form-control pull-left">
                   <option value="" disabled selected>Select</option>
                   
                   @foreach($roles as $role)

                   	<option value="{!! ucwords(strtolower($role->role_name)) !!}">{!! ucwords(strtolower($role->role_name)) !!}</option>

                   @endforeach

                </select>
                <span class="pull-right">
                    <input type="text" class="form-control  main-container__content__info__search__option" placeholder="Search" id="searchText">
                    <input type="submit" class='btn btn-filter' value="Search">
                </span>
             </div>
        </div>

        @if( !count($users) )
        	<h5>No entries</h5>
        @else
        <table id="example" class="table table-striped table--data table--noaction table--lastaction">
        	 <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>User Role</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            	@foreach($users as $user)
            	<tr>
	            	<td>
	            		{!! $user->first_name !!}
	            	</td>
	            	<td>
	            		{!! $user->last_name !!}
	            	</td>
	            	<td>
	            		{!! $user->username !!}
	            	</td>
	            	<td>
	            		{!! $user->email !!}
	            	</td>
	            	<td>
	            		@foreach($roles as $role)

	            			@if($role->id == $user->role_id)
	            				{!! $role->role_name !!}
	            			@endif

	            		@endforeach
	            	</td>
	            	 <td class='action'>
                        <i class="fa fa-chevron-left"></i>
                        <ul class="list-unstyled action-list">
                            <li>{!! HTML::linkRoute('cms.user.edit', 'Edit', $user->username) !!}</li>
                            <li>
                            	{!! Form::open(array('route' => array('cms.user.destroy', $user->id), 'method' => 'delete')) !!}
								    {!! Form::submit('Delete', array('class' => 'btn-delete')) !!}
								{!! Form::close() !!}
                            </li>
                        </ul>
                    </td>
	            </tr>
	            @endforeach
            </tbody>
		</table>
		@endif
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

        $('#selectRole').change(function(){
                var role = this.value;
                table.column(4).search(role)
                    .draw();
            });

        $( ".datepicker" ).datepicker();
    } );
</script>
@stop