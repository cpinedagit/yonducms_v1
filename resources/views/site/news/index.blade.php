@extends('index')
@section('content')

<!-- Stack the columns on mobile by making one full-width and the other half-width -->
<div class="col-md-12">
  <div class="col-md-7">
  	@foreach ($results as $result)
  	<div>
  		<h3>{!! HTML::linkAction('Site\NewsController@show',  $result->news_title , array($result->news_id)) !!}</h3>
  		 <div class="col-md-12">
 		 	<div class="col-md-4">
  		  		{!! HTML::image("$result->image_path","alt",array("height"=>150,"width"=>150)) !!}
  			</div>
  			<div class="col-md-8">
  				{!! $result->description !!}
  			</div>
  		</div>
  	</div>
  	@endforeach
  </div>
  <div class="col-md-5">

    @include('site.news.news_archive_tool')
  	@include('site.news.news_tool')
  </div>

</div>

@stop