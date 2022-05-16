<?php 
include_once './delete.php';
if(isset($_SESSION['id_customer'])){
  $id_order = $_REQUEST['id'];
  $query = mysqli_query($conn,"SELECT * from orderdetails where id_order = '$id_order'");
  $query_order = mysqli_query($conn,"SELECT * from orders where id_order = '$id_order'");
  $row_order = mysqli_fetch_array($query_order);
  $id_code = $row_order['id_code'];
  $query_discount = mysqli_query($conn,"SELECT * from codediscount where id_code = '$id_code'");
  $row_discount = mysqli_fetch_array($query_discount);
  $id_address = $row_order['id_address'];
  $query_address = mysqli_query($conn,"SELECT * from customeraddress where id_address = '$id_address'");
  $row_address = mysqli_fetch_array($query_address);
  if(isset($_POST['id_delete'])){
    $location = $_GET['page_layout'];
    $id_delete = $_POST['id_delete'];
    $sql = "CALL xoaData('$location',$id_delete,'id_address')";
   if(mysqli_query($conn,$sql)){
        $_SESSION['title'] = "Xóa Thành Công!";
        $_SESSION['icon']= "success";
        if(isset($_POST['queryToBack'])){
            $url = "index.php?page_layout=" .$_GET['page_layout'];
            $url .="&id=" .$_POST['queryToBack'];
        }else{
            $url = "index.php?page_layout=" .$_GET['page_layout'];
        }
        if(headers_sent()){
           die('<script type ="text/javascript">window.location.href="'.$url.'" </script>');
        }else{
            header ("location: $url");
            die();
        }
    } else {
        $_SESSION['title'] = "Xóa Thất Bại!";
        $_SESSION['icon']= "error";
        $conn -> rollback();
        if(isset($_POST['queryToBack'])){
            $url = "index.php?page_layout=" .$_GET['page_layout'];
            $url .="&id=" .$_POST['queryToBack'];
        }else{
            $url = "index.php?page_layout=" .$_GET['page_layout'];
        }
        if(headers_sent()){
           die('<script type ="text/javascript">window.location.href="'.$url.'" </script>');
        }else{
            header ("location: $url");
            die();
        }
       
       // echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
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
    table tfoot th{
       border-bottom: 2px solid #dee2e6;
    }

    .table th, .table td{
        vertical-align:middle;
    }
    
</style>

<section class="body_section layout_padding" style="margin-top:36px">
    <div class="container">
        <div class="row header_page">
          <h4>Thông Tin Chi Tiết Đơn Hàng</h4>
        </div>
       
            <div class="row">
                 <div class="col-md-12">
                    <table class="table">
                        <thead>
                          <tr>
                            <th scope="col" >Sản Phẩm</th>
                            <th scope="col" style="text-align:center;">Tên Sản Phẩm</th>
                            <th scope="col" style="text-align:center;">Số Lượng</th>
                            <th scope="col" style="text-align:center;">Giá Đặt Hàng</th>
                            <th scope="col" style="text-align:center;">Tạm Tính</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php 
                         if(mysqli_num_rows($query) > 0 ){
                             $totalPriceAll = 0;
                            while($row = mysqli_fetch_array($query)){
                                $id_sell = $row['id_sell'];
                                $query_sell = mysqli_query($conn,"SELECT * from sellingprice where id_sell = '$id_sell'");
                                $row_sell = mysqli_fetch_array($query_sell);
                                $id_product = $row_sell['id_product'];
                                $query_product = mysqli_query($conn,"SELECT * from product where id_product = '$id_product'");
                                $row_product = mysqli_fetch_array($query_product);
                                $query_img = mysqli_query($conn,"SELECT * from productimage where id_product = '$id_product'");
                                $row_img = mysqli_fetch_array($query_img);
                         ?>
                          <tr>
                               <td><img src="<?php echo $row_img['link_img'] ;?>" alt=""></td>
                               <td style="text-align:center;"><?php echo $row_product['name_product'] ;?></td>
                               <td style="text-align:center;"><?php echo $row['number_order']; ?></td>
                               <td style="text-align:center;"><?Php  echo number_format($row_sell['selling_price']);?></td>
                               <td style="text-align:center;"><?Php  echo number_format($row_sell['selling_price'] * $row['number_order']); $totalPriceAll += $row_sell['selling_price'] * $row['number_order']; ?></td>
                          </tr>
                         <?php } } ?>
                         
                        </tbody>
                        <tfoot>
                            <tr>
                                <th scope="col" colspan="4">Tạm Tính</th>
                                <th scope="col" style="text-align:center;"><?php echo number_format($totalPriceAll);?></th>
                            </tr>
                           <?php if($row_discount != NULL){?>
                            <tr>
                                <th scope="col" colspan="4">Giảm Giá</th>
                                <th scope="col" style="text-align:center;">
                                <?php  
                                    $valueDiscount = $row_discount['discount_value'];
                                    $valueDiscount = $valueDiscount/100;
                                    echo number_format($totalPriceAll*$valueDiscount); 
                                ?>
                               
                                </th>
                            </tr>
                            <?php }?>
                            <tr>
                                <th scope="col" colspan="4">Phí Ship</th>
                                <th scope="col" style="text-align:center;">30,000</th>
                            </tr>
                            <tr>
                                <th scope="col" colspan="4">Tổng</th>
                                <?php if($row_discount != NULL){?>
                                <th scope="col" style="text-align:center;"><?php echo number_format($totalPriceAll - ($totalPriceAll*$valueDiscount) + 30000);?></th>
                                <?php }else{?>
                                    <th scope="col" style="text-align:center;"><?php echo number_format($totalPriceAll + 30000);?></th>
                                <?php }?>
                            </tr>
                        </tfoot>
                      </table>


                      

                 </div>
    
                
            </div>

    
            <div class="row">
                <div class="col-md-12">
                     <div class="row--content">
                             <span>Địa Chỉ Giao Hàng</span>
                    </div>
               </div>
           </div>


            <div class="row">
                <div class="col-md-12">
                    <table class="table">
                       <thead>
                          <tr>
                            <th scope="col">Địa Chỉ</th>
                            <th scope="col">Tên Người Nhận</th>
                            <th scope="col">Số Điện Thoại Người Nhận</th>
                          </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?php echo $row_address['address_receive']; ?></td>
                                <td><?php echo $row_address['name_receive']; ?></td>
                                <td><?php echo $row_address['phone_receive']; ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php if($row_order['order_status'] == "Đã Giao"){ ?>
            <div class="row">
                <div class="col-md-12">
                     <div class="row--content">
                             <span>Đánh Giá Đơn Hàng</span>
                    </div>
               </div>
           </div>
      
           <div class="row">
                 <div class="col-md-12">
                    
                         <table class="table">
                             <thead>
                               <tr>
                                 <th scope="col" >Sản Phẩm</th>
                                 <th scope="col" style="text-align:center;">Đánh Giá Sản Phẩm</th>
                               </tr>
                             </thead>
                             <tbody>
                                
                             <?php 
                              $query = mysqli_query($conn,"SELECT * from orderdetails where id_order = '$id_order'");
                              if(mysqli_num_rows($query) > 0 ){
                                  $totalPriceAll = 0;
                                 while($row = mysqli_fetch_array($query)){
                                     $id_sell = $row['id_sell'];
                                     $query_sell = mysqli_query($conn,"SELECT * from sellingprice where id_sell = '$id_sell'");
                                     $row_sell = mysqli_fetch_array($query_sell);
                                     $id_product = $row_sell['id_product'];
                                     $query_product = mysqli_query($conn,"SELECT * from product where id_product = '$id_product'");
                                     $row_product = mysqli_fetch_array($query_product);
                                     $query_img = mysqli_query($conn,"SELECT * from productimage where id_product = '$id_product'");
                                     $row_img = mysqli_fetch_array($query_img);
                                     

                                         $query_rating = mysqli_query($conn,"SELECT star_rating from productrating where id_product = '$id_product' and id_order = '$id_order' and id_customer = '$id_customer'");
                                     
                              ?>
                               <tr>
                                    <td><img src="<?php echo $row_img['link_img'] ;?>" alt=""></td>
                                    <td style="text-align:center;" name="<?php echo $row_product['name_product'];?>" id = "<?php echo $row_product['id_product'];?>" data-order="<?php echo $id_order; ?>"> 
                                    <?php
                                        
                                         if(mysqli_num_rows($query_rating) == 0){
                                    ?>
                                       
                                        <fieldset class="rate" style="font-size:24px;" >
                                                <input type="radio" id="rating5_<?php echo $row_product['id_product']; ?>" name="rating" value="5" /><label for="rating5_<?php echo $row_product['id_product']; ?>" title="5 stars"></label>
                                                <input type="radio" id="rating4_<?php echo $row_product['id_product']; ?>" name="rating" value="4" /><label for="rating4_<?php echo $row_product['id_product']; ?>" title="4 stars"></label>
                                                <input type="radio" id="rating3_<?php echo $row_product['id_product']; ?>" name="rating" value="3" /><label for="rating3_<?php echo $row_product['id_product']; ?>" title="3 stars"></label>
                                                <input type="radio" id="rating2_<?php echo $row_product['id_product']; ?>" name="rating" value="2" /><label for="rating2_<?php echo $row_product['id_product']; ?>" title="2 stars"></label>
                                                <input type="radio" id="rating1_<?php echo $row_product['id_product']; ?>" name="rating" value="1" /><label for="rating1_<?php echo $row_product['id_product']; ?>" title="1 star"></label>
                                        </fieldset>
                                       
                         
                                   <?php }else{
                                           $sum = 0;
                                           $cost =0;
                                           $totalStar = 5;
                                           $totalStarRating = 0;
                                           $averageRating = 0;
                                           $row_rating = mysqli_fetch_array($query_rating);
                                           $sum++;
                                           $star = $row_rating['star_rating']; 
                                           $totalStarRating += $star;
                                           $averageRating = ceil($totalStarRating / $totalStar);
                                             if(($totalStarRating%5) == 0){
                                                for($i = $star; $i > 0 ;$i--){
                                         ?>
                                         
                                                   <i class="fa-solid fa-star starActive"></i>
                                          <?php }}else{
                                             $cost =  $totalStar - $averageRating;
                                              for($i = 0; $i < $star;$i++){
                 
                                           ?>
                                                <i class="fa-solid fa-star starActive"></i>
                                          <?php }  
                                             for($j = $cost; $j >= $star ; $j--){
                                               
                                          ?>
                                               <i class="fa-solid fa-star starNotActive"></i>
                                           <?php }}}?>
                                           
                                     </td>
                               </tr>
                              <?php  }} ?>
                              
                             </tbody>
                           
                         </table>
                         
                     


                      

                 </div>
    
                
            </div>
        <?php }?>
            <div class="row">
                <div class="col-md-12">
                    <a href = "index.php?page_layout=orderCustomer" class="btn btn-primary " style="background-color: #212529;margin-top:12px;margin-bottom:32px"><i class="fas fa-arrow-left" style="margin-right:6px"></i>Trở Về Trang Trước</a>
                </div>
            </div>
           
   
    </div>
        
</section>

<script>
    const stars = document.getElementsByName("rating");
    console.log(stars);
    for(i=0;i<stars.length;i++){
        stars[i].addEventListener("click",function(event){
            let eventTarget = event.target;
            let targetElement = eventTarget.parentElement.parentElement;
            let idProduct = targetElement.getAttribute("id");
            let valueRating = eventTarget.getAttribute("value");
            let idOrder = $(targetElement).data("order");

            $.ajax({  
                url:"../assets/ratingProduct.php",  
                method:"POST",  
                data:{idProduct:idProduct, idCus:<?php echo $id_customer; ?>, starRating: valueRating, idOrder:idOrder},  
                dataType:"text",  
                success:function(data)  
                {  
                     if(data != '')  
                     {  
                        
                            Swal.fire({
                             icon: "success",
                             title: "Thành Công",
                             text: "Cảm ơn bạn đã đánh giá sản phẩm!",
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
                                                    
                                                   
            })     
        })
    }
</script>