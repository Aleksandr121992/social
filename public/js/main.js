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
    	
    	
    	$.ajax({
    		method:'post',
    		url: "/comment-edit",
    		data:{id:id,comment:comment,_token:token},
    		success: function(result){
console.log(888)

		    window.location.reload();
		},
        error: function(xhr, status, error) {
            console.log(xhr, status, error)
          var err = eval("(" + xhr.responseText + ")");
          // alert(err.errors.comment);
          $('#edit_comment').addClass('is-invalid')
          $('#errorTxt').text(err.errors.comment)

          // $('#edit_comment').addClass('is-invalid')
        }
    });
    })
});