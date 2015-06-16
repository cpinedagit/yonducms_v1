<div class="col-md-12">
Archives
	<ul>
  	@foreach ($archive as $key=>$value)
  		<li>{{ $key }}</li>
  		<li>
  			<ul>
  				@foreach ($value as $keyMonth =>$valueMonth)
  				<li>{{ $keyMonth }}</li>
  				<li>
  					<ul>
  						@foreach ($valueMonth as $news)
  						<li>{!! HTML::linkAction('Site\NewsController@preview',  $news->news_title , array($slug,$news->slug)) !!}</li>
  						@endforeach
  					</ul>
  				</li>
  				@endforeach
  			</ul>
  		<li/>
  	@endforeach
  </ul>
</div>