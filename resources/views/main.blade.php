<!doctype html>
<html lang="en">
<head>
	<title>Website Service</title>
	@include('cms.partials.meta')
	@include('cms.partials.styles')
	@include('cms.partials.scripts')
</head>
<body>
	<div class="page-container">
		<h3>Website Service</h3>
		@yield('content');
	</div>
</body>
</html>
