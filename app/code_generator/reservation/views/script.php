<?php

echo '
<script src="'.VENDOR_PATH.'text-editor/ckeditor/ckeditor.js'.'"></script>
<script>
		$(document).ready(function()
		{
			var roxyFileman = "'.VENDOR_PATH.'text-editor/fileman?integration=ckeditor";
			$(function()
			{
				CKEDITOR.replace( "editor1",{filebrowserBrowseUrl:roxyFileman,
									filebrowserImageBrowseUrl:roxyFileman+"&type=image",
									removeDialogTabs: "link:upload;image:upload"});
			});
			$(".addNew").click(function()
			{
				var url = $("#url").val() + "?addNew=y";
				$("form").attr("action", url);
			});
		});
</script>';