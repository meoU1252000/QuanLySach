
<script type="text/javascript">
    
"use strict";

function checkCart() {
  if (
    JSON.parse(localStorage.getItem("items"))[0] === null ||
    JSON.parse(localStorage.getItem("items")).length === 0
  ) {
    Swal.fire({
      icon: "error",
      title: "Lỗi...",
      text: "Hiện Chưa Có Sản Phẩm Trong Giỏ Hàng! Vui lòng thêm sản phẩm để truy cập trang này",
      showConfirmButton: true,
      timer: 1500,
    });
    setTimeout(() => {
      window.location.href =
        "http://localhost/B1809227_Quan_Ly_Sach/assets/index.php";
    }, 1500);

    return;
  }
}

function renderCartPurchase() {
  //Add Cart
  // var addItem = document.createElement("li");
  var tableList = document.querySelector(".cartPurchase");
  var priceAll = 0;
  var tablePrice = document.querySelector(".priceAll");
  var tablePriceContent = "";
  var tableContent = "";
  tablePrice.innerHTML = "";
  tableList.innerHTML = "";
  var totalPrice = 0;
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
      window.location.href =
        "http://localhost/B1809227_Quan_Ly_Sach/assets/index.php";
    }, 1500);

    return;
  } else {
    
       JSON.parse(localStorage.getItem("items")).map((data) => {
         tableContent +=
           ' <tr class="cartPurchaseContent"><td hidden><h4 class="id_product" name="idProduct">' +
           data.id +
           '</h4></td><th><span name="nameProduct">' +
           data.name +
           '</span> x <span class = "numberProduct" name="quantityProduct">' +
           data.number +
           "</span></th>" +
           "<td>" +
           (parseInt(data.number) * parseFloat(data.price) * 1000).toLocaleString(
             "de-De"
           ) +
           "</td>";
         priceAll += parseInt(data.number) * parseFloat(data.price) * 1000;
       });
       totalPrice = parseFloat(priceAll) + parseInt(30000);
       <?php if(!isset($_POST['codeEvent']) || $_POST['codeEvent'] == NULL ){
            
        ?>
         tablePriceContent =
           ' <tr><th scope="row">Tạm Tính</th><td id="totalPrice">' +
           priceAll.toLocaleString("de-De") +
           '</td></tr> <tr><th scope="row">Phí Ship</th><td>30.000</td></tr> <tr><th scope="row">Tổng</th><td id="totalOrder">'+
           totalPrice.toLocaleString("de-De") +
           "</td></tr>";
         tablePrice.innerHTML = tablePriceContent;
         tableList.innerHTML = tableContent;
       
       <?php }else{
           $price = $_POST['totalPriceProduct'];
           $code = $_POST['codeEvent'];
           $select = mysqli_query($conn,"SELECT * from codediscount where code_event = '$code'");
        if(mysqli_num_rows($select) > 0 ){
            $row = mysqli_fetch_array($select);
            $valueDiscount = $row['discount_value'];
            $valueDiscount = $valueDiscount/100;
        ?>
        tablePriceContent =
           ' <tr><th scope="row">Tạm Tính</th><td id="totalPrice">' +
           (<?php echo ($price); ?>).toLocaleString("de-De") +
           '</td></tr><tr><th scope="row">Giảm Giá</th><td><input type="text" id="idCode" value="'+ <?php echo $row['id_code']; ?> +'" hidden>'+ (<?php echo ($price*$valueDiscount); ?>).toLocaleString("de-De") +'</td></tr> <tr><th scope="row">Phí Ship</th><td>30.000</td></tr> <tr><th scope="row">Tổng</th><td id="totalOrder">'+ (<?php echo (($price - ($price * $valueDiscount)))+30000; ?>).toLocaleString("de-De") +'</td></tr><tr hidden><th scope="row">Tổng</th><td id="revenue">'+ (<?php echo (($price - ($price * $valueDiscount))); ?>).toLocaleString("de-De") +'</td></tr>';
         tablePrice.innerHTML = tablePriceContent;
         tableList.innerHTML = tableContent;
       <?php }}?>
  }
}

const btnClickSubmit = document.querySelector(".submitCart");
btnClickSubmit.addEventListener("click", function (event) {
  event.preventDefault();
  let item = JSON.parse(localStorage.getItem("items"));
  var eventListener = event.target;
  var eventParent = eventListener.parentElement.parentElement.parentElement;
  var address = eventParent.querySelector("#id_address").value;
  var note = eventParent.querySelector("#note_order").innerText;
  var totalPriceOrder = eventParent.querySelector("#totalOrder").innerText;
  var totalPrice = eventParent.querySelector("#totalPrice").innerText;
  if(eventParent.querySelector("#idCode") !== null ){
    var idCodeEvent = eventParent.querySelector("#idCode").value;
    var totalPrice = eventParent.querySelector("#revenue").innerText;
  }
  

  $.ajax({
    url: "../assets/submitCart.php",
    method: "POST",
    <?php if(!isset($_POST['codeEvent']) || $_POST['codeEvent'] == NULL ){ ?> 
    data: {
      items: JSON.stringify(item),
      addressCus: address,
      noteOrder: note,
      totalOrderAll: (totalPriceOrder.replaceAll('.','')),
      totalOrder: (totalPrice.replaceAll('.','')),
      idCustomer : <?php echo $_SESSION['id_customer']; ?>
    },
    <?php }else{?>
      data: {
      items: JSON.stringify(item),
      addressCus: address,
      noteOrder: note,
      totalOrderAll: (totalPriceOrder.replaceAll('.','')),
      totalOrder: (totalPrice.replaceAll('.','')) ,
      idCode: idCodeEvent,
      idCustomer : <?php echo $_SESSION['id_customer']; ?>
    },
    <?php }?>
    success: function () {
      Swal.fire({
        icon: "success",
        title: "Đặt Hàng Thành Công",
        text: "Cảm Ơn Quý Khách Đẵ Mua Hàng!",
        showConfirmButton: false,
        timer: 1500,
      });
      localStorage.removeItem("items");
      setTimeout(() => {
        window.location.href =
          "http://localhost/B1809227_Quan_Ly_Sach/assets/index.php?page_layout=orderCustomer";
      }, 1500);
    },
    error: function () {
      Swal.fire({
        icon: "error",
        title: "Đặt Hàng Thất Bại",
        text: "Xin Quý Khách Vui Lòng Thử Lại Sau Vài Phút!",
        showConfirmButton: false,
        timer: 1500,
      });
      localStorage.removeItem("items");
      setTimeout(() => {
        window.location.href =
          "http://localhost/B1809227_Quan_Ly_Sach/assets/index.php";
      }, 1500);
    },
  });
});


</script>