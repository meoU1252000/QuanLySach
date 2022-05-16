
"use strict";

function checkCart(){
  if (JSON.parse(localStorage.getItem("items"))[0] === null || JSON.parse(localStorage.getItem("items")).length === 0) {
    Swal.fire({
      icon: "error",
      title: "Lỗi...",
      text: "Hiện Chưa Có Sản Phẩm Trong Giỏ Hàng! Vui lòng thêm sản phẩm để truy cập trang này",
      showConfirmButton: true,
      timer: 1500,
    });
     setTimeout(() => {
        window.location.href = "http://localhost/B1809227_Quan_Ly_Sach/assets/index.php";
      }, 1500);
    
    return;
  }
}


function renderCartPage() {
  //Add Cart
  // var addItem = document.createElement("li");
  var tableList = document.querySelector("tbody");
  var tableContent = "";
  var priceAll = 0;
  var priceAllOrder = 0;
  var tablePrice = document.querySelector(".priceAll");
  var tablePriceContent = "";
  tablePrice.innerHTML = "";
  tableList.innerHTML = "";
  if (JSON.parse(localStorage.getItem("items"))[0] === null) {
    tableList.innerHTML = "";
    Swal.fire({
      icon: "error",
      title: "Lỗi...",
      text: "Hiện Chưa Có Sản Phẩm Trong Giỏ Hàng! Vui lòng thêm sản phẩm để truy cập trang này",
      showConfirmButton: false,
      timer: 1500,
    });
     setTimeout(() => {
        window.location.href = "http://localhost/B1809227_Quan_Ly_Sach/assets/index.php";
      }, 1500);
    
    return;
  } else {
    JSON.parse(localStorage.getItem("items")).map((data) => {
      
      tableContent +=
        ' <tr class="cart_page"><td><h4 class="header_cart-item-id hidden id_product">' +
        data.id +
        '</h4><h4 class="header_cart-item-id hidden id_sell">'+ data.idSell +'</h4><img src="' +
        data.img +
        '" alt="" class="img_product"></td><td class="name_product">' +
        data.name +
        '</td> <td class="cartPage_price">' +
        (parseFloat(data.price) *1000).toLocaleString(
          "de-De"
        ) +
        '</td><td><div class="detail-box_wrap"><div class="input-box"><button class="decrementQuantity"> - </button><input type="number" min="1" max="'+ data.maxNumber +'" step="1" value="' +
        data.number +
        '" class="product_quantity" readonly><button class="incrementQuantity"> + </button></div></div><td>' +
        (parseInt(data.number) * parseFloat(data.price) * 1000).toLocaleString(
          "de-De"
        ) +
        '</td><td><span class="cartPage-remove" style="padding-left: 35px;"><i class="fa-solid fa-trash"></i></span></td></tr>';
        priceAll += (parseInt(data.number) * parseFloat(data.price) * 1000);
       
    });
    priceAllOrder = parseFloat(priceAll) + parseInt(30000);
    tablePriceContent = '<tbody class="priceAll"><tr><td scope="col">Tạm Tính</td><td scope="col"><input type="text"name="totalPriceProduct" value="'+ priceAll +'" hidden><span class="priceOrder">'+ priceAll.toLocaleString("de-De") +'</span><span class="priceOrderAfter"></span></td></tr><tr><td scope="col">Phí Ship</td><td scope="col">30.000</td></tr><tr><td scope="col ">Tổng</td><td scope="col"><span class="totalOrder">'+ priceAllOrder.toLocaleString("de-De") +'</span><span class="totalOrderAfter"></span></td></tr></tbody>';
    tablePrice.innerHTML = tablePriceContent;
    tableList.innerHTML = tableContent;
  }
  cartQuantityEdit();
  deleteCartPage();
};

function deleteCartPage() {
  var cartItem = document.querySelectorAll(".cart_page");
  for (var i = 0; i < cartItem.length; i++) {
    var productDelete = document.querySelectorAll(".cartPage-remove");
    productDelete[i].addEventListener("click", function (event) {
      // Get Id Product
      var cartDelete = event.target;
      var cartItemR =
        cartDelete.parentElement.parentElement.parentElement;
      var id = cartItemR.querySelector(".header_cart-item-id").innerText;
      // console.log(id);

      // Find id equals item.id in localStorage
      const localItems = JSON.parse(localStorage.getItem("items"));
      localItems.map((data) => {
        if (id == data.id) {
          // Loc ID chi giu lai nhung id nao trong localStorage khac voi id lay tu event click chuot
          let items = localItems.filter((data) => data.id !== id);
          // console.log(items);
          localStorage.setItem("items", JSON.stringify(items));
        }
        // Render lai gio hang
        renderCartPage();
      });
      // console.log(cartItemR);
      // cartItemR.remove();
      // cartTotal();
      // deleteCart();
    });
  };
  if (cartItem.length == 0) {
    Swal.fire({
      icon: "error",
      title: "Lỗi...",
      text: "Hiện Chưa Có Sản Phẩm Trong Giỏ Hàng! Vui lòng thêm sản phẩm để truy cập trang này",
      showConfirmButton: false,
      timer: 1500,
    });
     setTimeout(() => {
        window.location.href = "http://localhost/B1809227_Quan_Ly_Sach/assets/index.php";
      }, 1500);
    
    return;
  }
}

/* Edit Input Custom */
function cartQuantityEdit(){
  var myInputCartPage = document.querySelectorAll(".cart_page");
  for (var i = 0; i < myInputCartPage.length; i++) {
    var incrementEdit = document.querySelectorAll(".incrementQuantity");
    var decrementEdit = document.querySelectorAll(".decrementQuantity");
    incrementEdit[i].addEventListener("click", function (event) {
      event.preventDefault();
      var eventListener = event.target;
      var eventParent = eventListener.parentElement;
      // console.log(eventParent);
      const myInput = eventParent.querySelector(".product_quantity");
      let id = eventParent.querySelector(".incrementQuantity").innerText;
      let min = myInput.getAttribute("min");
      let max = myInput.getAttribute("max");
      let step = myInput.getAttribute("step");
      let val = myInput.getAttribute("value");
      let calcStep = id == "+" ? step * 1 : step * -1;
      let newValue = parseInt(val) + calcStep;
      if (newValue >= min && newValue <= max) {
        myInput.setAttribute("value", newValue);
      }
    });
    decrementEdit[i].addEventListener("click", function (event) {
      event.preventDefault();
      var eventListener = event.target;
      var eventParent = eventListener.parentElement;
      // console.log(eventParent);
      const myInput = eventParent.querySelector(".product_quantity");
      let id = eventParent.querySelector(".decrementQuantity").innerText;
      let min = myInput.getAttribute("min");
      let max = myInput.getAttribute("max");
      let step = myInput.getAttribute("step");
      let val = myInput.getAttribute("value");
      let calcStep = id == "-" ? step * -1 : step * 1;
      let newValue = parseInt(val) + calcStep;
      if (newValue >= min && newValue <= max) {
        myInput.setAttribute("value", newValue);
      }
    });
  };
  
}

/* Edit Cart */
var btnEditCart = document.querySelector(".edit_cart");
btnEditCart.addEventListener("click", function (event) {
  event.preventDefault();
  var cartInfo = document.querySelectorAll(".cart_page");
  let items = [];
  for (var i = 0; i < cartInfo.length; i++) {
    var productImg = cartInfo[i].querySelector(".img_product").src;
    var productName = cartInfo[i].querySelector(".name_product").innerText;
    var productPrice = cartInfo[i].querySelector(".cartPage_price").innerText;
    var productId = cartInfo[i].querySelector(".id_product").innerText;
    var productNumber = cartInfo[i].querySelector(".product_quantity").value;
    var productIdSell = cartInfo[i].querySelector(".id_sell").innerText;
    var inputProduct = cartInfo[i].querySelector(".product_quantity");
    var maxProductNumber = inputProduct.getAttribute("max");
    let item = {
      id: productId,
      idSell: productIdSell,
      name: productName,
      price: productPrice,
      number: productNumber,
      maxNumber: maxProductNumber,
      img: productImg,
    };
    const localItems = JSON.parse(localStorage.getItem("items"));
    localItems.map((data) => {
      if (item.id === data.id) {
        if(item.number <= data.maxNumber) {
          item.number = productNumber;

        }else{
          Swal.fire({
            icon: "error",
            title: "Lỗi...",
            text: "Số lượng sản phẩm quý khách vừa chọn vượt quá số lượng hiện có! Vui lòng thử lại sau...",
          });
          return;
        }
      }
    });
    items.push(item);
    localStorage.setItem("items", JSON.stringify(items));
    // setTimeout(() => {
    //   window.location.reload();
    // }, 1500);
  }
  Swal.fire({
    icon: "success",
    title: "Cập Nhật Thành Công !",
    text: "",
    showConfirmButton: false,
    timer: 1500,
  });
  renderCartPage();
});

const codeSubmit = document.querySelector(".code_submit");
codeSubmit.addEventListener("click",function(e){
    var event = e.target;
    var eventParent = event.parentElement.parentElement;
    var inputValue = eventParent.querySelector(".code_event").value;
    var priceAll = document.querySelector(".priceOrder").innerText;
    $.ajax({
        url: "../assets/codeDiscount.php",
        method: "POST",
        data: {
          codeEvent: inputValue,
          priceOrder: (priceAll.replaceAll('.',''))
        },
        success: function (res) {
          Swal.fire({
            icon: "success",
            title: "Áp Dụng Mã Giảm Giá Thành Công",
            showConfirmButton: false,
            timer: 1500,
          });
            document.querySelector(".priceOrder").style="text-decoration: line-through; font-size:14px";
            document.querySelector(".totalOrder").style="text-decoration: line-through; font-size:14px";
            document.querySelector(".priceOrderAfter").innerText =  (parseInt(res)).toLocaleString("de-De");
            document.querySelector(".totalOrderAfter").innerText = ((parseInt(res)) + 30000 ).toLocaleString("de-De");
           
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

// const purchaseButton = document.querySelector('.purchase');
// purchaseButton.addEventListener('click', function (e) {
//   let event = e.target;
//   let eventParent = event.parentElement.parentElement;
//   let inputValue = eventParent.querySelector(".code_event").value;
//   let priceAll = document.querySelector(".priceOrder").innerText;
//   $.ajax({
//     url: "../assets/purchaseAction.php",
//     method: "POST",
//     data: {
//       codeEvent: inputValue,
//       priceOrder: (priceAll.replaceAll('.',''))
//     },
//     success: function () {
//        location.href='index.php?page_layout=checkOut'
//     },
   
//   });
// })
