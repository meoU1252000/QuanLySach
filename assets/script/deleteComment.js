const deleteComment = document.getElementsByName("deleteComment");
    for(i=0;i< deleteComment.length;i++){
      deleteComment[i].addEventListener("click", function(event){
        let eventTarget = event.target;
        let elementTarget = eventTarget.parentElement.parentElement;
        let idComment = elementTarget.getAttribute("id");
        console.log(idComment);
           Swal.fire({
            title: 'Chắc chắn xóa?',
            text: "Sau khi xóa bình luận của khách hàng này, sẽ không thể khôi phục. Vẫn tiếp tục ?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Delete'
          }).then((result) => {
            if (result.isConfirmed) {
              $.ajax({
                 url:"../assets/deleteComment.php",  
                 method:"POST",  
                 data:{idComment:idComment},  
                 dataType:"text",  
                 success:function(data)  
                 {  
                        if(data != '')  
                        {  
                           
                               Swal.fire({
                                icon: "success",
                                title: "Thành Công",
                                text: "Xóa Bình Luận Thành Công!",
                               }).then(function(){
                                   location.reload();
                               });
                          
                        }else  
                            {  
                             Swal.fire({
                                icon: "error",
                                title: "Lỗi...",
                                text: "Vui lòng thử lại sau!",
                           });
                           }  
                 }  
             });
              
            }
          })
      })

    }
