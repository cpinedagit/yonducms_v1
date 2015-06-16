<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.3.min.js"><\/script>')</script>

	{!! HTML::script('public/js/jquery.js') !!}	
	{!! HTML::script('public/js/jquery.dataTables.min.js') !!}
	{!! HTML::script('public/js/bootstrap.min.js'); !!}
	{!! HTML::script('public/ckeditor/ckeditor.js'); !!}
	{!! HTML::script('public/ckeditor/adapters/jquery.js'); !!}
	{!! HTML::script('public/js/jquery-ui.min.js'); !!}
	{!! HTML::script('public/js/bootstrap-switch.min.js'); !!}

	{!! HTML::script('public/js/plugins.js') !!}
	{!! HTML::script('public/js/parsley/parsley.js'); !!}
	{!! HTML::script('public/js/parsley/parsley.remote.js'); !!}
	{!! HTML::script('public/js/dataTables.js') !!}
	{!! HTML::script('public/js/vendor/modernizr-2.8.3.min.js'); !!}

	<script>
	var formats = "{{ env('APP_MEDIA_FORMATS') }}";
  	formats = formats.split(',');
  	var default_size = "{{ env('APP_MEDIA_MAX_FILE_SIZE') }}";
  	</script>
        <!--menu cms-->
	{!! HTML::script('public/js/main.js') !!}
	{!! HTML::script('public/js/menu_cms/jquery.nestable.js') !!}
	{!! HTML::script('public/js/menu_cms/menu_app.js') !!}
	{!! HTML::script('public/js/menu_cms/classie.js') !!}
	{!! HTML::script('public/js/menu_cms/notificationFx.js') !!}
        <!--menu cms-->
	
	<!-- CodeMirror -->
	{!! HTML::script('public/js/codemirror/lib/codemirror.js'); !!}
	{!! HTML::script('public/js/codemirror/addon/search/searchcursor.js'); !!}
	{!! HTML::script('public/js/codemirror/addon/search/search.js'); !!}
	{!! HTML::script('public/js/codemirror/addon/dialog/dialog.js'); !!}
	{!! HTML::script('public/js/codemirror/addon/edit/matchbrackets.js'); !!}
	{!! HTML::script('public/js/codemirror/addon/edit/closebrackets.js'); !!}
	{!! HTML::script('public/js/codemirror/addon/comment/comment.js'); !!}
	{!! HTML::script('public/js/codemirror/addon/wrap/hardwrap.js'); !!}
	{!! HTML::script('public/js/codemirror/addon/fold/foldcode.js'); !!}
	{!! HTML::script('public/js/codemirror/addon/fold/brace-fold.js'); !!}
	{!! HTML::script('public/js/codemirror/addon/fold/foldcode.js'); !!}
	{!! HTML::script('public/js/codemirror/mode/javascript/javascript.js'); !!}
	{!! HTML::script('public/js/codemirror/keymap/sublime.js'); !!}
	<!-- CodeMirror -->

<script>

	$(document).ready(function() {
		$('.datepicker').datepicker();
	})
</script>	