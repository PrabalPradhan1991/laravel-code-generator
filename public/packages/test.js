$(document).ready(function(){
  
  var roxyFileman = "http://localhost/techroadians/laravel-fresh/vendor/packages/fileman?integration=ckeditor";

  CKEDITOR.replace( '1',{filebrowserBrowseUrl:roxyFileman,
                               filebrowserImageBrowseUrl:roxyFileman+'&type=image',
                               removeDialogTabs: 'link:upload;image:upload'});
  CKEDITOR.replace( 'editor2',{filebrowserBrowseUrl:roxyFileman,
                               filebrowserImageBrowseUrl:roxyFileman+'&type=image',
                               removeDialogTabs: 'link:upload;image:upload'});
  CKEDITOR.replace( 'editor3',{filebrowserBrowseUrl:roxyFileman,
                               filebrowserImageBrowseUrl:roxyFileman+'&type=image',
                               removeDialogTabs: 'link:upload;image:upload'});
  CKEDITOR.replace( 'editor4',{filebrowserBrowseUrl:roxyFileman,
                               filebrowserImageBrowseUrl:roxyFileman+'&type=image',
                               removeDialogTabs: 'link:upload;image:upload'});
  

});