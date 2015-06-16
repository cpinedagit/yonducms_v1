<!doctype html>
<html lang="en">
<head>
	<title>YONDU Web Services</title>
	@include('cms.partials.meta')
	@include('cms.partials.styles')
	@include('cms.partials.scripts')
</head>
<body class="login">
	<!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. 
        Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
	@yield('content')
</body>
</html>
