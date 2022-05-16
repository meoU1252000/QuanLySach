$(document).ready(function(){  
    $(document).on('click', '#btn_more', function(){  
      let btn = document.querySelector("#btn_more");
      if(btn.getAttribute("data-typegroup") === null && btn.getAttribute("data-type") === null){
         let last_id = $(this).data("book");  
         $('#btn_more').html("Loading...");  
         $.ajax({  
              url:"../assets/loadData.php",  
              method:"POST",  
              data:{last_id:last_id},  
              dataType:"text",  
              success:function(data)  
              {  
                   if(data != '')  
                   {  
                        let timerInterval
                            Swal.fire({
                              title: 'Loading....',
                              html: '<b></b> milliseconds.',
                              timer: 400,
                              timerProgressBar: true,
                              didOpen: () => {
                                Swal.showLoading()
                                const b = Swal.getHtmlContainer().querySelector('b')
                                timerInterval = setInterval(() => {
                                  b.textContent = Swal.getTimerLeft()
                                }, 100)
                                setTimeout(() => {
                                    $('#readMore').remove();   
                                    $('#row').append(data);  
                                }, 400);
                              },
                              willClose: () => {
                                clearInterval(timerInterval)
                              }
                            });
                   }else  
                       {  
                            $('#btn_more').remove();  
                      }  
              }  
         });  
      
         
        }else  if(btn.getAttribute("data-typegroup") !== null){
               let last_id = $(this).data("book");
               let id = $(this).data("typegroup");
               $('#btn_more').html("Loading..."); 
               $.ajax({  
                    url:"../assets/loadData.php",  
                    method:"POST",  
                    data:{idGroup:id,last_id:last_id},  
                    dataType:"text",  
                    success:function(data)  
                    {  
                         if(data != '')  
                         {  
                            let timerInterval
                            Swal.fire({
                              title: 'Loading....',
                              html: '<b></b> milliseconds.',
                              timer: 400,
                              timerProgressBar: true,
                              didOpen: () => {
                                Swal.showLoading()
                                const b = Swal.getHtmlContainer().querySelector('b')
                                timerInterval = setInterval(() => {
                                  b.textContent = Swal.getTimerLeft()
                                }, 100)
                                setTimeout(() => {
                                    $('#readMore').remove();   
                                    $('#row').append(data);  
                                }, 400);
                              },
                              willClose: () => {
                                clearInterval(timerInterval)
                              }
                            });
                         }else  
                          {    
                            $('#btn_more').remove(); 
                            
                          }  
                    }  
               });  

           }else if(btn.getAttribute("data-type") !== null) {
                 let last_id = $(this).data("book");
                 let id = $(this).data("type");
                 console.log(id);
                 $('#btn_more').html("Loading..."); 
                 $.ajax({  
                      url:"../assets/loadData.php",  
                      method:"POST",  
                      data:{idType:id,last_id:last_id},  
                      dataType:"text",  
                      success:function(data)  
                      {  
                           if(data != '')  
                           {  
                              let timerInterval
                              Swal.fire({
                                title: 'Loading....',
                                html: '<b></b> milliseconds.',
                                timer: 400,
                                timerProgressBar: true,
                                didOpen: () => {
                                  Swal.showLoading()
                                  const b = Swal.getHtmlContainer().querySelector('b')
                                  timerInterval = setInterval(() => {
                                    b.textContent = Swal.getTimerLeft()
                                  }, 100)
                                  setTimeout(() => {
                                      $('#readMore').remove();   
                                      $('#row').append(data);  
                                  }, 400);
                                },
                                willClose: () => {
                                  clearInterval(timerInterval)
                                }
                              });
                           }else  
                            {    
                              $('#btn_more').remove(); 
                              
                            }  
                      }  
                 });  
           }
       
    });  
}); 

var category = document.getElementsByName("category");
var length = category.length;
for(i=0 ; i<length ; i++){
   category[i].addEventListener("click",function(event){
       let eventElement = event.target;
       let id = eventElement.getAttribute("id");  
          $.ajax({  
               url:"../assets/loadData.php",  
               method:"POST",  
               data:{idType:id},  
               dataType:"text",  
               success:function(data)  
               {  
                    if(data != '')  
                    {  
                       let timerInterval
                       Swal.fire({
                         title: 'Loading....',
                         html: '<b></b> milliseconds.',
                         timer: 400,
                         timerProgressBar: true,
                         didOpen: () => {
                           Swal.showLoading()
                           const b = Swal.getHtmlContainer().querySelector('b')
                           timerInterval = setInterval(() => {
                             b.textContent = Swal.getTimerLeft()
                           }, 100)
                           setTimeout(() => {
                               removeProduct();
                               $('#readMore').remove();   
                               $('#row').append(data);  
                              if(document.querySelector(".category-item--active")){
                                  document.querySelector(".category-item--active").classList.add("category-item");
                                  document.querySelector(".category-item--active").classList.remove("category-item--active");
                                  eventElement.classList.add("category-item--active");
                                  eventElement.classList.remove("category-item");
                              }else{
                                   eventElement.classList.add("category-item--active");
                                    eventElement.classList.remove("category-item");
                              }
                           }, 400);
                         },
                         willClose: () => {
                           clearInterval(timerInterval)
                         }
                       })
                   
                    }else  
                     {  
                       Swal.fire({
                         icon: "error",
                         title: "Lỗi...",
                         text: "Hiện Không Có Sản Phẩm Thuộc Thể Loại Này!",
                       });
                       
                     };  
               }  
          });  
      
      
   })
}
var categoryGroup = document.getElementsByName("categoryGroup");
var lengthG = categoryGroup.length;
for(i=0 ; i<lengthG ; i++){
   categoryGroup[i].addEventListener("click",function(event){
       let eventElement = event.target;
       let id = eventElement.getAttribute("id");  
          $.ajax({  
               url:"../assets/loadData.php",  
               method:"POST",  
               data:{idGroup:id},  
               dataType:"text",  
               success:function(data)  
               {  
                    if(data != '')  
                    {  
                       let timerInterval
                       Swal.fire({
                         title: 'Loading....',
                         html: '<b></b> milliseconds.',
                         timer: 400,
                         timerProgressBar: true,
                         didOpen: () => {
                           Swal.showLoading()
                           const b = Swal.getHtmlContainer().querySelector('b')
                           timerInterval = setInterval(() => {
                             b.textContent = Swal.getTimerLeft()
                           }, 100)
                           setTimeout(() => {
                               removeProduct();
                               $('#readMore').remove();   
                               $('#row').append(data);  
                              
                               if(document.querySelector(".category-item--active")){
                                  document.querySelector(".category-item--active").classList.add("category-item");
                                  document.querySelector(".category-item--active").classList.remove("category-item--active");
                                  eventElement.classList.add("category-item--active");
                                  eventElement.classList.remove("category-item");
                              }else{
                                   eventElement.classList.add("category-item--active");
                                    eventElement.classList.remove("category-item");
                              }
                           }, 400);
                         },
                         willClose: () => {
                           clearInterval(timerInterval)
                         }
                       })
                   
                    }else  
                     {  
                       Swal.fire({
                         icon: "error",
                         title: "Lỗi...",
                         text: "Hiện Không Có Sản Phẩm Thuộc Thể Loại Này!",
                       });
                       
                     }  
               }  
          });  
      
      
   })
}
var categoryAll = document.getElementById("categoryAll");
categoryAll.addEventListener("click",function(event) {
  let eventElement = event.target;
  $.ajax({  
    url:"../assets/loadData.php",  
    method:"POST",  
    data:{idAll:"all"},  
    dataType:"text",  
    success:function(data)  
    {  
         if(data != '')  
         {  
            let timerInterval
            Swal.fire({
              title: 'Loading....',
              html: '<b></b> milliseconds.',
              timer: 400,
              timerProgressBar: true,
              didOpen: () => {
                Swal.showLoading()
                const b = Swal.getHtmlContainer().querySelector('b')
                timerInterval = setInterval(() => {
                  b.textContent = Swal.getTimerLeft()
                }, 100)
                setTimeout(() => {
                    removeProduct();
                    $('#readMore').remove();   
                    $('#row').append(data);  
                   
                    if(document.querySelector(".category-item--active")){
                       document.querySelector(".category-item--active").classList.add("category-item");
                       document.querySelector(".category-item--active").classList.remove("category-item--active");
                       eventElement.classList.add("category-item--active");
                       eventElement.classList.remove("category-item");
                   }else{
                        eventElement.classList.add("category-item--active");
                         eventElement.classList.remove("category-item");
                   }
                }, 400);
              },
              willClose: () => {
                clearInterval(timerInterval)
              }
            })
        
         }else  
          {  
            Swal.fire({
              icon: "error",
              title: "Lỗi...",
              text: "Hiện Không Có Sản Phẩm Thuộc Thể Loại Này!",
            });
            
          }  
      }  
    });  
});
function removeProduct(){
   let ele = document.getElementsByName("productCol");
   for(i=ele.length-1;i>=0;i--)
   {
       ele[i].remove();
   }
}