<!doctype html>
<html lang="en">
<head>
	<title>{{ env('APP_TITLE') }}</title>
	@include('cms.partials.meta')
	@include('cms.partials.styles')
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	{!! HTML::script('public/ckeditor/ckeditor.js'); !!}
</head>
<body>
		@include('cms.partials.header')
		
		@include('cms.partials.container')
		
		@include('cms.partials.footer')
	
		
	@include('cms.partials.scripts')
	
	@yield('scripts')	<!-- Scripts used for module management -->

</body>
</html>
