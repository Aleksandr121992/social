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

    // $('#edit_comment_Changes').click(function(){
        $('body').on('click', '#edit_comment_Changes', function () {
    	var token = $('meta[name="csrf-token"]').attr('content')
    	var id = $(this).data('id');
    	var comment = $('#edit_comment').val()
    	
    	
    	$.ajax({
    		method:'post',
    		url: "/comment-edit",
    		data:{id:id,comment:comment,_token:token},
    		success: function(result){
            // console.log(888)
    
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
    });
// alert()


    $('.commentCom_edit').click(function(){
        // alert();
        var id = $(this).data('id');
        var commentCom = $('#childComment_'+id).html();
        console.log(commentCom)
        $('#edit_comment').val(commentCom)
        $('#edit_comment_Changes').attr('data-id',id)
        $('#Comment_Edit_Modal').modal('show')
        // $('#Post_Edit_Modal').modal('show');
    });

    // $('#edit_comment_Changes').click(function(){
        $('body').on('click', '#edit_commentCom_Changes', function () {
        var token = $('meta[name="csrf-token"]').attr('content')
        var id = $(this).data('id');
        var commentCom = $('#edit_commentCom').val()
        
        
        $.ajax({
            method:'post',
            url: "/commentCom-edit",
            data:{id:id,commentCom:commentCom,_token:token},
            success: function(result){
// console.log(888)

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
    });


    $('.delete_path').click(function(){
         
        var id = $(this).data('id');
        var post_id = $('#post_id').val();
        var image = $('#image_'+id).html();
        $('#delete_image').val(image)      
        // $('#Post_Edit_Modal').modal('show');
           $.ajax(
        {

            url: "/deletePath/"+id+'/'+post_id,
            type: 'get',
            dataType: "JSON",
          
            success: function (response)
            {
                if (response.success == true) {
                    $('#img'+id+'').hide()
                }else{          
                    $('#error_Delete').modal('show')
                }
            }
        });

        console.log("It failed");
    });

    $('.addLike').click(function(){ 
        var token = $('meta[name="csrf-token"]').attr('content')
        // console.log(token)
         var id = $(this).data('id');
         var type = $(this).data('type');
         var liked = $('#likeImg'+id+'').data('liked');
         var likesCount = $('#likeImg'+id+'').data('count');
         var disliked = $('#disLikeImg'+id+'').data('disliked');
         var disLikesCount = $('#disLikeImg'+id+'').data('count');
         console.log(disliked)
         console.log(liked)
          $.ajax({
            url: "/add-like",
            type: 'POST',
            data:{id:id,liked:liked,disliked:disliked,disLikesCount:disLikesCount,likesCount:likesCount,type:type,_token:token},
          
            success: function (response)
            {
                if (response.success == true) {
                    if(type=='like'){
                        if(disliked==0){
                            console.log('undisliked')
                            disLikesCount =parseInt(disLikesCount)-1
                            $('#disLikeImg'+id+'').attr('src','/images/dislike_1.png')
                            $('#disLikeImg'+id+'').data('disliked','1')
                            $('#disLikeImg'+id+'').data('count',''+disLikesCount+'')
                            $('#disLikeCount'+id+'').empty()
                            $('#disLikeCount'+id+'').html(''+disLikesCount+'')  
                        }
                        if (liked==1){
                            console.log('liked')
                            likesCount =parseInt(likesCount) + 1
                            $('#likeImg'+id+'').attr('src','/images/like_2.png')
                            $('#likeImg'+id+'').data('liked','0')
                            $('#likeImg'+id+'').data('count',''+likesCount+'')  
                            $('#likeCount'+id+'').empty()    
                            $('#likeCount'+id+'').html(''+likesCount+'')    
                        }else{
                            console.log('unliked')
                            likesCount =parseInt(likesCount)-1
                            $('#likeImg'+id+'').attr('src','/images/like_1.png')
                            $('#likeImg'+id+'').data('liked','1')
                            $('#likeImg'+id+'').data('count',''+likesCount+'')
                            $('#likeCount'+id+'').empty()     
                            $('#likeCount'+id+'').html(''+likesCount+'')     
                        }  
                    }else{
                        if(liked==0){
                            console.log('unliked')
                            likesCount =parseInt(likesCount)-1
                            $('#likeImg'+id+'').attr('src','/images/like_1.png')
                            $('#likeImg'+id+'').data('liked','1')
                            $('#likeImg'+id+'').data('count',''+likesCount+'')
                            $('#likeCount'+id+'').empty()     
                            $('#likeCount'+id+'').html(''+likesCount+'') 

                        }
                        if(disliked==1){
                            console.log('disliked')
                            disLikesCount =parseInt(disLikesCount)+1
                            $('#disLikeImg'+id+'').attr('src','/images/dislike_2.png')
                            $('#disLikeImg'+id+'').data('disliked','0')
                            $('#disLikeImg'+id+'').data('count',''+disLikesCount+'')  
                            $('#disLikeCount'+id+'').empty()  
                            $('#disLikeCount'+id+'').html(''+disLikesCount+'')  
                        }else{
                            console.log('undisliked')
                            disLikesCount =parseInt(disLikesCount)-1
                            $('#disLikeImg'+id+'').attr('src','/images/dislike_1.png')
                            $('#disLikeImg'+id+'').data('disliked','1')
                            $('#disLikeImg'+id+'').data('count',''+disLikesCount+'')
                            $('#disLikeCount'+id+'').empty()
                            $('#disLikeCount'+id+'').html(''+disLikesCount+'')     

                        }    
                    }
                }else{ 

                }
            }
        });  
    });

    
    // $('.addCommentLike').click(function(){ 
        $('body').on('click', '.addCommentLike', function () {
        var token = $('meta[name="csrf-token"]').attr('content')
        // console.log(token)
         var id = $(this).data('id');
         var type = $(this).data('type');
         var liked = $('#likeImg'+id+'').data('liked');
         var likesCount = $('#likeImg'+id+'').data('count');
         var disliked = $('#disLikeImg'+id+'').data('disliked');
         var disLikesCount = $('#disLikeImg'+id+'').data('count');
         console.log(disliked)
         console.log(liked)
          $.ajax({
            url: "/add-comment-like",
            type: 'POST',
            data:{id:id,liked:liked,disliked:disliked,disLikesCount:disLikesCount,likesCount:likesCount,type:type,_token:token},
          
            success: function (response)
            {
                if (response.success == true) {
                    if(type=='like'){
                        if(disliked==0){
                            console.log('undisliked')
                            disLikesCount =parseInt(disLikesCount)-1
                            $('#disLikeImg'+id+'').attr('src','/images/dislike_1.png')
                            $('#disLikeImg'+id+'').data('disliked','1')
                            $('#disLikeImg'+id+'').data('count',''+disLikesCount+'')
                            $('#disLikeCount'+id+'').empty()
                            $('#disLikeCount'+id+'').html(''+disLikesCount+'')  
                        }
                        if (liked==1){
                            console.log('liked')
                            likesCount =parseInt(likesCount) + 1
                            $('#likeImg'+id+'').attr('src','/images/like_2.png')
                            $('#likeImg'+id+'').data('liked','0')
                            $('#likeImg'+id+'').data('count',''+likesCount+'')  
                            $('#likeCount'+id+'').empty()    
                            $('#likeCount'+id+'').html(''+likesCount+'')    
                        }else{
                            console.log('unliked')
                            likesCount =parseInt(likesCount)-1
                            $('#likeImg'+id+'').attr('src','/images/like_1.png')
                            $('#likeImg'+id+'').data('liked','1')
                            $('#likeImg'+id+'').data('count',''+likesCount+'')
                            $('#likeCount'+id+'').empty()     
                            $('#likeCount'+id+'').html(''+likesCount+'')     
                        }  
                    }else{
                        if(liked==0){
                            console.log('unliked')
                            likesCount =parseInt(likesCount)-1
                            $('#likeImg'+id+'').attr('src','/images/like_1.png')
                            $('#likeImg'+id+'').data('liked','1')
                            $('#likeImg'+id+'').data('count',''+likesCount+'')
                            $('#likeCount'+id+'').empty()     
                            $('#likeCount'+id+'').html(''+likesCount+'') 

                        }
                        if(disliked==1){
                            console.log('disliked')
                            disLikesCount =parseInt(disLikesCount)+1
                            $('#disLikeImg'+id+'').attr('src','/images/dislike_2.png')
                            $('#disLikeImg'+id+'').data('disliked','0')
                            $('#disLikeImg'+id+'').data('count',''+disLikesCount+'')  
                            $('#disLikeCount'+id+'').empty()  
                            $('#disLikeCount'+id+'').html(''+disLikesCount+'')  
                        }else{
                            console.log('undisliked')
                            disLikesCount =parseInt(disLikesCount)-1
                            $('#disLikeImg'+id+'').attr('src','/images/dislike_1.png')
                            $('#disLikeImg'+id+'').data('disliked','1')
                            $('#disLikeImg'+id+'').data('count',''+disLikesCount+'')
                            $('#disLikeCount'+id+'').empty()
                            $('#disLikeCount'+id+'').html(''+disLikesCount+'')     

                        }    
                    }
                }else{ 

                }
            }
        });  
    });
  


  // $(".flip").click(function(){
     $('body').on('click', '.flip', function () {
     var id = $(this).data('id');
    $('.panel'+id+'').slideToggle("slow");
  });


  // $(".flip1").click(function(){
         $('body').on('click', '.flip1', function () {
    // alert($(this).data("id"));
     var id = $(this).data('id');
    $('.panel1'+id+'').slideToggle("slow");
  });
  
   

    $('.addFriend').click(function(){ 
        var follower_id = $(this).data('id');

         console.log(follower_id)
        
         $.ajax({
            url: "/addFriend/" + follower_id,
            type: 'get',
        
          
            success: function (response)
            {              
                        window.location.reload();               
            }
        });
    });


    $('.undoRequest').click(function(){ 
        var follower_id = $(this).data('id');

         console.log(follower_id)
        
         $.ajax({
            url: "/undoRequest/" + follower_id,
            type: 'get',
        
          
            success: function (response)
            {              
                window.location.reload();               
            }

        });

    });
    $('.deleteFriend').click(function(){ 
        var follower_id = $(this).data('id');

         console.log(follower_id)
        
         $.ajax({
            url: "/deleteFriend/" + follower_id,
            type: 'get',
        
          
            success: function (response)
            {              
                        window.location.reload();               
            }

        });     
    });


    $('.acceptRequest').click(function(){ 
        var follower_id = $(this).data('id');
   
         console.log(follower_id)
        
         $.ajax({
            url: "/acceptFriend/" + follower_id,
            type: 'get',
        
          
            success: function (response)
            {              
                        window.location.reload();               
            }
        });
    });



});




