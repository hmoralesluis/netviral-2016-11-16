$(document).ready(function(){
$('#download').click(function() {
   location.href = "{{ path('download_file', { 'fileId': entity.id }) }}";
});
});

