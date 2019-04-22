$( document ).ready(function() {
    $('.comment_edit').click(function(){
    	// alert();
    	var id = $(this).data('id');
    	var comment = $('#comment_'+id).html();
        console.log(comment)
    	$('#edit_comment').val(comment)
    	$('#edit_comment_Changes').attr('data-id',id)
    	$('#Comment_Edit_Modal').modal('show')
    	// $('#Post_Edit_Modal').modal('show');
    });

    $('#edit_comment_Changes').click(function(){

    	var token = $('meta[name="csrf-token"]').attr('content')
    	var id = $(this).data('id');
    	var comment = $('#edit_comment').val()
    	 alert(comment)
    	
    	$.ajax({
    		method:'post',
    		url: "/comment-edit",
    		data:{id:id,comment:comment,_token:token},
    		success: function(result){
		    window.location.reload();
		}});
    })
});