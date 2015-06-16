@extends('cms.home')
@section('title')
<h2>Media</h2>
{!! HTML::linkRoute('cms.media.create', 'Add New',array(),array('class'=>'btn btn-add')) !!}
@stop
@section('content')
@if((Session::has('message')))
  <!-- Flash Update Your Password Message -->
      <div class="alert alert-success" role="alert">{{ Session::get('message') }} <div class="glyphicon glyphicon-remove" id="close-symbol"> </div> </div>
  <!-- Flash Update Your Password Message -->
@endif
<div class='main-container__content__info'>
	<div class="main-container__content__info__summary">
		<span>
			<strong>All</strong> ({{$all}})
		</span>
		<span>
			<strong>Photo</strong> ({{ $images[0]->c_img }})
		</span>
		<span>
			<strong>Video</strong> ({{ $videos[0]->c_vid }})
		</span>
	</div>
	<div class="main-container__content__info__filter">
		<select name="" id="" class="form-control">
			<option value="" disabled selected>Choose Action</option>
			<option value="">Delete</option>
		</select>
		<input type="button" onclick="deleteSelected()" class='btn btn-filter' value="Apply">
		
	</div>
	<table class="superTable table-striped table--data table--lastaction table--thumbnail">
		<thead>
			<tr>
				<th><input type="checkbox" id='selecctall'></th>
				<th>&nbsp;</th>
				<th>File Name</th>
				<th>File Size</th>
				<th>Date Created</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($files as $file)
			<tr>
				<td><input type="checkbox" name="cbox" id="{!! $file->media_id !!}"></td>
				<td>
					@if ($file->media_type == 1) 
					{!! HTML::image($file->media_path,'alt',array('class'=>'tbl-img-thumbnail')) !!}
					@else
					{!! HTML::image("css/video_icon.jpg",'alt',array('class'=>'tbl-img-thumbnail')) !!}
					@endif
				</td>
				<td>{{ after_last('/',$file->media_path) }}</td>
				<td> {{ (round(File::size($file->media_path) /1024,1))}} bytes </td>
				<td>{{ date('F d, Y', (File::lastModified($file->media_path))) }} </td>
				<td class='action'>
					<i class="fa fa-chevron-left"></i>
					<ul class="list-unstyled action-list">
						<li>{!! HTML::linkRoute('cms.media.show', 'Edit',$file->media_id) !!}</li>
						<li>
							<a href="#" onclick="deleteThis({{ $file->media_id }})">Delete</a>
							{!! Form::open(array('route'=>array('cms.media.destroy', $file->media_id),'method'=>'DELETE')) !!}
							{!! Form::close() !!}
						</li>
					</ul>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>

</div>

<script>
function deleteSelected(){

	if (confirm('Are your sure you want to delete the files') == true)
	{
		var selected = new Array();
		$("input:checkbox[name=cbox]:checked").each(function() {
			selected.push(this.id);
		});

		$.post(
			'{!! URL::route("cms.media.deleteSelected") !!}',
			{
				"_token": $('[name=_token').val(),
				"selected": selected
			},
			function(data){
				location.reload();
			},
			'json'
			);
	} else{
		return false;
	}

}

function deleteThis(id){

	if (confirm('Are your sure you want to delete the news') == true)
	{
		$.post(
			'{!! URL::route("cms.media.destroy","") !!}/' +id,
			{
				"_token": $('[name=_token').val(),
				"_method": "delete"
			},
			function(data){
				location.reload();
			},
			'json'
			);
	} else{
		return false;
	}

}

</script>
@stop