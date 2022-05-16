<?php 
if(isset($_SESSION['id_customer'])){
  if(isset($_POST['id_address'])){
    $id_address = $_POST['id_address'];
    $id_customer = $_SESSION['id_customer'];
    $sql = "SELECT * FROM customers inner join customeraddress on customers.id_customer = customeraddress.id_customer WHERE customers.id_customer = '$id_customer' and customeraddress.id_address = '$id_address'";
    $query = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($query);
    if(isset($_POST['codeEvent'])){
      
    }
  }else{
    $id_customer = $_SESSION['id_customer'];
    $sql = "SELECT * FROM customers inner join customeraddress on customers.id_customer = customeraddress.id_customer order by customeraddress.id_address asc limit 1";
    $query = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($query);
  }
}else{
    $_SESSION['title'] = "Truy Cập Thất Bại !";
    $_SESSION['icon']= "error";
    $_SESSION['text']= "Vui lòng đăng nhập để thanh toán";
    //  echo "Lỗi. Vui lòng thử lại " . $sql . "<br>" . mysqli_error($conn);
    $conn -> rollback();
    $url = "index.php";
    if(headers_sent()){
        die('<script type ="text/javascript">window.location.href="'.$url.'" </script>');
    }else{
         header ("location: $url");
         die();
    }
}
?>



<style>
    .slider_section {
        display:none;
    }
    .cart{
        display:none;
    }
    .body_section .row{
      align-items: baseline;
    }
    .table th,
    .table td {
      padding: 0.75rem;
      vertical-align: top;
       border-top: none; 
    }
    .col-md-6{
      margin-bottom:36px;
    }
    table tr th{
      width: 51%;
    }
    table tr td{
      text-align: right;
    }
    .table tfoot th,
    .table tfoot td {
      padding: 0.75rem;
      vertical-align: top;
      border-top: 1px solid #dee2e6; 
    }
</style>

<section class="body_section layout_padding" style="margin-top:36px">
    <div class="container">
        <div class="row header_page">
          <h4>Thanh Toán</h4>
        </div>
        <form action="index.php" method="POST" enctype="multipart/form-data">
            <div class="row">
                 <div class="col-md-6">
                    <div class="mb-3">
                         <label for="exampleFormControlInput1" class="form-label">Họ Và Tên</label>
                         <input type="text" class="form-control"  placeholder="Nhập vào họ tên của bạn" name="name_customer" id="nameCus"  value="<?php 
                            if($row['name_receive'] !== ""){
                                echo $row['name_receive'];
                            }else{
                                echo "";
                            }
                         ?>" disabled>
                         <span class="form-group__message"></span>
                    </div>
                    <div class="mb-3">
                         <label for="exampleFormControlInput1" class="form-label">Số Điện Thoại</label>
                         <input type="text" class="form-control"  placeholder="Nhập vào số điện thoại của bạn" name="phone_customer" id="phoneCus" 
                         value="<?php 
                            if($row['phone_receive'] !== ""){
                                echo $row['phone_receive'];
                            }else{
                                echo "";
                            }
                         ?>" disabled>
                          <span class="form-group__message"></span>
                    </div>
                    <div class="mb-3">
                         <label for="exampleFormControlInput1" class="form-label">Địa Chỉ Email</label>
                         <input type="email" class="form-control"  placeholder="Nhập vào địa chỉ Email của bạn" name="email_customer" id="emailCus" value="<?php echo $row['email_customer'];?>" disabled>
                         <span class="form-group__message"></span>
                    </div>
                    <div class="mb-3">
                         <label for="exampleFormControlInput1" class="form-label">Địa Chỉ Giao Hàng</label>
                         <input type="text" hidden class="form-control" id ="id_address" value="<?php echo $row['id_address'];?>">
                         <input type="text" class="form-control"  placeholder="Nhập vào địa chỉ giao hàng của bạn" name="address_customer" id="addressCus" value="<?php echo $row['address_receive'];?>" disabled>
                         <span class="form-group__message"></span>
                    </div>
                   
                    <div class="form-group">
                       <label for="exampleFormControlTextarea1">Ghi Chú</label>
                       <textarea class="form-control" rows="6" name="order_notes" id="note_order"></textarea>
                     </div>
                 </div>
    
                 <div class="col-md-6">
                   <div class="">
                     <table class="table table-striped" style="border-top: none">
                       <thead>
                         <tr>
                           <th scope="col">Sản Phẩm</th>
                           <th scope="col" style="text-align: right">Tạm Tính</th>
                         </tr>
                       </thead>
                       <tbody class="cartPurchase">
                         <tr class="cartPurchaseContent">
                           
                       </tbody>
                       <tfoot class="priceAll">
                      
                       </tfoot>
                     
                     </table>
                   </div>
                      <div class="row_button">
                         <p>
                                Phương thức: <b>Giao hàng thanh toán tại nhà của bạn</b><br>
                                Chúng tôi sẽ liên hệ bạn trong 24 giờ kể từ khi bạn đặt hàng để xác nhận đơn hàng <br>
                                <span style="font-weight: bold">Lưu ý:</span> <i>nếu bạn không nhận được bất kỳ cuộc gọi nào trong 24 giờ, hãy chủ động gọi chúng tôi </i> <a href="" style="color:blue"><u>0984978407</u>&nbsp;</a>
                         </p>
                        <button type="submit" class="btn btn-primary submitCart" style="background-color: #212529;margin-top:12px;" >Xác Nhận</button>

                      </div>
            </div>
            
          </form>
 
    </div>
</section>

<?php include_once './purchaseAction.php';?>

<script>
    checkCart();
    renderCartPurchase();
</script>