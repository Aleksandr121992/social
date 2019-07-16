//   $(document).ready(function(){
//   	var id = $('#post_id').val()
//  	setInterval(function(){ 
//  		$.ajax({
//     		method:'post',
//     		url: "/view/"+id,
//     		data:{id:id,comment:comment,_token:token},
//     		success: function(result){


// 		   $('.post_comments').html(result.html)
// 		},
//         error: function(xhr, status, error) {

//         }
//     });
//  	}, 3000);

// });