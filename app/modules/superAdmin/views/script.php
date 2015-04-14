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
		
		/*******************************************************************************************************/
		/************************* This is for set-temporary-permissions.blade.php only ************************/
		//might have issues with same id conflict
		$("#controller_name").change(function()
		{
			var currentElement = $(this);
			var url = $("form").attr("action");
			var admin_id = $("#admin_id").val()
			url = url + "?admin_id=" + admin_id + "&" + "controller_id=" + currentElement.val();
			
			window.location.replace(url);
		});
		/*******************************************************************************************************/

		});
</script>';