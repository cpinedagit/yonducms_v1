<!doctype html>
<html lang="en">
<head>
	<title>Website</title>
	@include('site.partials.meta')
	@include('site.partials.styles')
	@include('site.partials.scripts')
</head>
<body>
	<div class="page-container">
		<h3>Website</h3>
		@yield('content')
	</div>
</body>
</html>