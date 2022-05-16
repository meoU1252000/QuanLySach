<?php 
if(isset($_SESSION['id_customer'])){
  $id_customer = $_SESSION['id_customer'];
  $sql = mysqli_query($conn, "SELECT * FROM customeraddress where id_customer = '$id_customer' order by id_address");
  $query_book = mysqli_query($conn,"SELECT * from viewproduct where product_id = '$id'");
  $row_book = mysqli_fetch_array($query_book);
}else{
    $_SESSION['title'] = "Truy Cập Thất Bại !";
    $_SESSION['icon']= "error";
    $_SESSION['text']= "Vui lòng đăng nhập để truy cập trang này";
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
    .table_product  tbody {
     display: block;
     max-height: 500px;
     overflow-y: scroll;
    }  

   .table_product  thead, table tbody tr {
     display: table;
     width: 100%;
     table-layout: fixed;  
   }
   .table_product  tbody::-webkit-scrollbar {
      width: 10px;
    }

    .table_product  tbody::-webkit-scrollbar-track {
      background-color: #eee;
      border-radius: 100rem;
    }
    
    .table_product  tbody::-webkit-scrollbar-thumb {
      border-radius: 100rem;
      background-image: linear-gradient(to bottom, #063547, #44b89d);
      height: 50px;
    }
</style>

<section class="body_section layout_padding" style="margin-top:36px">
    <div class="container">
      <form action="index.php?page_layout=checkOut" method="post" enctype="multipart/form-data">
        <div class="row header_page">
          <i class="fa-solid fa-bag-shopping"></i>
          <h4>Giỏ Hàng Của Bạn</h4>
        </div>
        <div class="row">
             <div class="col-md-12">
                   <table class="table table_product">
                       <thead>
                         <tr>
                           <th scope="col">Sản Phẩm</th>
                           <th scope="col">Tên</th>
                           <th scope="col">Giá</th>
                           <th scope="col">Số Lượng</th>
                           <th scope="col">Tạm Tính</th>
                           <th scope="col">Tác Vụ</th>
                         </tr>
                       </thead>
                       <tbody >
                          
                         <!-- <tr>
                           <td><img src="" alt=""></td>
                           <td class="name_product">Mark</td>
                           <td>Otto</td>
                           <td>
                                 <div class="detail-box_wrap">
                                    <div class="input-box">
                                      <button id="decrement" onclick="stepper(this)"> - </button>
                                      <input type="number" min="1" max="100" step="1" value="1" id="my-input"  readonly>
                                      <button id="increment" onclick="stepper(this)"> + </button>
                                    </div>
                                  </div>
                           </td>
                         </tr> -->
                       </tbody>
                      
                   </table>

                   <table class="table">
                          <thead>
                             <tr>
                               <th scope="col">
                                    <div class="input-group mb-3" style="transform: translateY(-50%)">
                                       <input type="text" class="form-control code_event" placeholder="Mã Khuyến Mãi" aria-label="Recipient's username" aria-describedby="basic-addon2" name="codeEvent">
                                       <div class="input-group-append">
                                         <button class="btn btn-outline-secondary code_submit" type="button">Áp Dụng</button>
                                       </div>
                                    </div>
                               </th>
                               <th scope="col" style="width:60%;text-align:right">
                                    <button class="btn edit_cart">Cập Nhật Giỏ hàng</button>
                               </th>
                             </tr>
                         </thead>
                     </table>

             </div>

          
        </div>
        <div class="row">
           <div class="col-md-12">
              
           </div>
        </div>

        <div class="row">
           <div class="col-md-6">
                <table class="table table-bordered">
                    <thead class="table-active">
                      <tr>
                        <th scope="col">Địa Chỉ Giao Hàng</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>
                          <?php if(mysqli_num_rows($sql) > 0){?>
                            <div class="form-group row">
                              <label for="staticAddress" class="col-sm-2 col-form-label">Địa Chỉ</label>
                              <div class="col-sm-10">
                                <select class="form-control" id="exampleFormControlSelect1" name="id_address">
                                  <?php while ($row = mysqli_fetch_array($sql)){
                                    ?>
                                  <option value="<?php echo $row['id_address'];?>"><?php echo $row['address_receive']; ?></option>
                                
                                  <?php }?>
                                </select>
                              </div>
                           <?php }else{?>
                             Chưa Có Địa Chỉ Giao Hàng ? <a href="index.php?page_layout=addAddress"> Thêm Tại Đây</a>
                            <?php }?>
                        </td>
                      
                      </tr>
                    
                    </tbody>
              </table>
           </div>
           
            <div class="col-md-6" style="padding-top:19px;">
                  <table class="table table-bordered">
                        <thead class="table-active">
                           <tr>
                             <th scope="col">Tổng Giá Trị Giỏ Hàng</th>
                           </tr>
                        </thead>
                        <tbody class="priceAll">
                          <tr>
                              <td scope="col">Phí Ship</td>
                              <td scope="col"></td>
                          </tr>
                          <tr>
                              <td scope="col">Tổng</td>
                              <td scope="col"></td>
                          </tr>
                        </tbody>
                   </table>
                 
            </div>

        </div>

        <div class="row header_page">
          <button class="purchase btn btn-primary">Thanh Toán</button>
        </div>

        </form>
    </div>
    
</section>

<script src="../assets/script/cartPage.js"></script>

<script>
    renderCartPage();
    
</script>