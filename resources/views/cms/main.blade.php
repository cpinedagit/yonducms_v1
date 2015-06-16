<!doctype html>
<html lang="en">
<head>
	<title>Website Service CMS</title>
	@include('cms.partials.meta')
	@include('cms.partials.styles')
</head>
<body>
	<div class="page-container">
		<h1>Website Service CMS</h1>
	</div>

	@yield('content')
	
	@include('cms.partials.scripts')
</body>
</html>