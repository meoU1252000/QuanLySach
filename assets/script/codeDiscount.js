'use strict'
const codeSubmit = document.querySelector(".code_submit");
codeSubmit.addEventListener("click",function(e){
    var event = e.target;
    var eventParent = event.parentElement;
    var inputValue = eventParent.querySelector(".code_event").value;
    $.ajax({
        url: "../assets/codeDiscount.php",
        method: "POST",
        data: {
          codeEvent: inputValue
        },
        success: function (data) {
          if(data != ''){
            Swal.fire({
              icon: "success",
              title: "Áp Dụng Mã Giảm Giá Thành Công",
              showConfirmButton: false,
              timer: 1500,
            });

          }else{
            Swal.fire({
              icon: "error",
              title: "Thất Bại",
              text: "Mã Giảm Giá Không Tồn Tại Hoặc Đã Hết Thời Hạn Sử Dụng! Vui Lòng Thử Lại",
              showConfirmButton: false,
              timer: 1500,
            });
          }
         
        },
        error: function () {
          Swal.fire({
            icon: "error",
            title: "Thất Bại",
            text: "Mã Giảm Giá Không Tồn Tại Hoặc Đã Hết Thời Hạn Sử Dụng! Vui Lòng Thử Lại",
            showConfirmButton: false,
            timer: 1500,
          });
          
        },
      });
})