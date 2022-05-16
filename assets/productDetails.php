<?php

if(isset($_REQUEST['id'])){
    $id = $_REQUEST['id'];
    $query_book = mysqli_query($conn,"SELECT * from viewproduct where product_id = '$id'");
    $row_book = mysqli_fetch_array($query_book);
    $img = mysqli_query($conn,"SELECT * from productimage where id_product = '$id'");
    $row_img = mysqli_fetch_array($img);
    $query_import = mysqli_query($conn,"SELECT * from importdetails where id_product = '$id'");
    $row_import = mysqli_fetch_array($query_import);
    $id_supplier = $row_import['id_supplier'];
    $query_supplier = mysqli_query($conn,"SELECT * from supplier where id_supplier = '$id_supplier'");
    $row_supplier = mysqli_fetch_array($query_supplier);
    $currentDate = date("Y-m-d");
    $query_sellingprice = mysqli_query($conn,"SELECT * from sellingprice where id_product = '$id' and date_end >= '$currentDate' or date_end = '' and id_product='$id'");
    $row_sellingprice = mysqli_fetch_array($query_sellingprice);
    $query_details = mysqli_query($conn,"SELECT * from productdetails where id_product = '$id'");
    $row_details = mysqli_fetch_array($query_details);
    
}
?>



<style>
    .slider_section {
        display:none;
    }
    .more {
      display: none;
    }
</style>


  <section class="category_section_book detailproduct_section layout_padding">
    <div class="breadcrumb">
        <a href="index.php">Trang Chủ</a>
        <span >></span>
        <a href="index.php?page_layout=product" >Sản Phẩm</a>
        <span >></span>
        <a href="index.php?page_layout=productDetails&id=<?php echo $row_book['product_id'];?>" style="color:#44b89d;text-decoration:underline;"><?php echo $row_book['product_name']; ?></a>
    </div>
    <div class="container" style="margin-top:52px">
      <div class="row">
        <div class="col-md-5">
          <div class="img-box">
            <img src="<?php echo $row_img['link_img'];?>" alt="" class="img_book">
          </div>
        </div>
        <div class="col-md-7">
          <div class="detail-box">
            <div class="heading_container">
              <span class="product_id" hidden><?php echo $row_book['product_id'];?></span>
              <span class="product_quantity" hidden><?php echo $row_book['quantity_in_stock'];?></span>
              <h2 class="product_name">
                <?php echo $row_book['product_name'];?>
              </h2>
            </div>
            <div class="detail_product">
              <div class="detail_product--content">
                <p>
                 Nhà Cung Cấp : <strong><?php echo $row_supplier['name_supplier']; ?></strong>
                </p>
                <p>
                  Nhà Xuất Bản : <strong ><?php echo /*substr($row_book['place_publishing'],17);*/ $row_book['place_publishing'];?></strong>
                </p>
                
              </div>
              <div class="detail_product--content">
                <p>
                Thể Loại: <strong><?php echo $row_book['product_type']; ?> </strong>
                </p>
              </div>
            </div>
            <p>
                Giá: <strong> <span class="product_price"><?php 
                                   if( $row_sellingprice !== NULL){
                                      echo number_format($row_sellingprice['selling_price'],0,",",".");

                                   }else{
                                     echo 0;
                                   }
                                 ?> </span>
                                 <span>VNĐ</span>
                                 <span class="id_sell" hidden><?php  if( $row_sellingprice !== NULL){
                                 echo  $row_sellingprice['id_sell'];
                                   }else{
                                     echo 0;
                                   }?>
                      </strong>
              </p>
              <p class="product_star" id = "<?php echo $row_book['product_id'];?>">
              <fieldset class="rate" id="rateProduct" style="font-size:24px;">
                    <?php 
                      $query_rating = mysqli_query($conn,"SELECT SUM(star_rating) as totalStar, Count(id_product) as totalRating from productrating where id_product = '$id' ");
                      $row_rating = mysqli_fetch_array($query_rating);
                      $sum = 0;
                      $cost =0;
                      $totalStar = 5;
                      $totalStarRating = 0;
                      $averageRating = 0;
                      if($row_rating['totalRating']>0){
                        
                        $sum = $row_rating['totalRating'];
                        $totalStarRating = $row_rating['totalStar'];
                        $averageRating = round($totalStarRating / $sum,2);
                        
                    ?>
                     <?php 
                        $cost =  $totalStar - $averageRating;
                         for($i = 0; $i < intval($averageRating);$i++){

                      ?>
                           <i class="fa-solid fa-star starActive"></i>
                     <?php }  for($j = 0; $j < $cost ; $j++){
                         
                     ?>
                          <i class="fa-solid fa-star starNotActive"></i>
                      <?php }?>
                       <span style="margin-left: 5px;transform: translateY(-30%);font-size:16px;">(<?php echo $sum;?>)  </span>
                    <?php }else{?>
                      <i class="fa-solid fa-star starNotActive"></i>
                      <i class="fa-solid fa-star starNotActive"></i>
                      <i class="fa-solid fa-star starNotActive"></i>
                      <i class="fa-solid fa-star starNotActive"></i>
                      <i class="fa-solid fa-star starNotActive"></i>
                      <span style="margin-left: 5px;transform: translateY(-30%);font-size:16px;">(0)</span>
                      <?php }?>
                  </fieldset>
              </p>
               
            <div class="detail-box_wrap">
              <div class="input-box">
                <button id="decrement" onclick="stepper(this)"> - </button>
                <input type="number" min="1" max="<?php echo $row_book['quantity_in_stock']; ?>" step="1" value="1" id="my-input" readonly>
                <button id="increment" onclick="stepper(this)"> + </button>
              </div>
             
            </div>
          
          </div>
          <?php if($row_book['quantity_in_stock'] > 0){?>
          <button class="add_cart">Thêm Vào Giỏ Hàng</button>
          <?php }else{?>
                  <button class="add_cart" style="pointer-events: none; background-color: #AAAAAA;right:50%">Hết Hàng</button>
           <?php }?>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
            <div class="row_detailproduct--content">
              <div class="row_detailproduct_label--seperate">
                <span>Thông Tin Sản Phẩm</span>
              </div>
            <div class="row_detailproduct--main">
                     <ul >
                            <?php if (mysqli_num_rows($query_details)>0){ ?>
                                <li><span style="width: 25%;">Tác Giả:</span><span style="font-weight: normal;"><?php echo $row_details['author_product']; ?></span></li>
                                <li><span style="width: 25%;">Người Dịch:</span><span style="font-weight: normal;"><?php echo $row_details['translator_product']; ?></span></li>
                                <li><span style="width: 25%;">Năm Xuất Bản:</span><span style="font-weight: normal;"><?php echo $row_details['publishing_year']; ?></span></li>
                                <li><span style="width: 25%;">Số Trang:</span><span style="font-weight: normal;"><?php echo $row_details['pages_product']; ?></span></li>
                                <li><span style="width: 25%;">Hình Thức:</span><span style="font-weight: normal;"><?php echo $row_details['form_product']; ?></span></li>
                            <?php } else {?>
                              <li><span style="width: 25%;">Tác Giả:</span><span style="font-weight: normal;"></span></li>
                                <li><span style="width: 25%;">Người Dịch:</span><span style="font-weight: normal;"></span></li>
                                <li><span style="width: 25%;">Năm Xuất Bản:</span><span style="font-weight: normal;"></span></li>
                                <li><span style="width: 25%;">Số Trang:</span><span style="font-weight: normal;"></span></li>
                                <li><span style="width: 25%;">Hình Thức:</span><span style="font-weight: normal;"></span></li>
                            <?php } ?>
                    </ul>
            <?php if (mysqli_num_rows($query_details)>0){ 
                                    $input = explode("\n",$row_details['introduce_product']);
                                    $n = count($input);
                                    $i = 0;
            ?>
               <?php for ($i = 0; $i<$n; $i++) {?>
                            <p>
                                <?php 
                                  echo $input[$i];
                                 ?>
                           </p>
                <?php }} ?>
                                     
                  <button class="read_more" onclick="readMore()" id="myBtn">Read More</button>
            </div>
          </div>
       </div>
      </div>


      <div class="row">
        <div class="col-md-12">
            <div class="row_detailproduct--content">
              <div class="row_detailproduct_label--seperate">
                <span>Đánh Giá Sản Phẩm</span>
            </div>
            <div class="row_detailproduct--rating">
              <table class="table table-bordered">
                <!-- <thead>
                  <tr>
                    <th scope="col" colspan="2">Đánh Giá Sản Phẩm</th>
                  </tr>
                </thead> -->
                <tbody>
                  <tr>
                   
                    <td width="40%" style="vertical-align: middle;">  
                          <h4><?php echo $averageRating; ?></h4>
                          <?php 
                      $query_rating = mysqli_query($conn,"SELECT SUM(star_rating) as totalStar, Count(id_product) as totalRating from productrating where id_product = '$id' ");
                      $row_rating = mysqli_fetch_array($query_rating);
                      $sum = 0;
                      $cost =0;
                      $totalStar = 5;
                      $totalStarRating = 0;
                      $averageRating = 0;
                      if($row_rating['totalRating']>0){
                        $sum = $row_rating['totalRating'];
                        $totalStarRating = $row_rating['totalStar'];
                        $averageRating = round($totalStarRating / $sum,2);
                        
                    ?>
                     <?php 
                        $cost =  $totalStar - $averageRating;
                         for($i = 0; $i < intval($averageRating);$i++){

                      ?>
                           <i class="fa-solid fa-star starActive"></i>
                     <?php }  for($j = 0; $j < $cost ; $j++){
                         
                     ?>
                          <i class="fa-solid fa-star starNotActive"></i>
                      <?php }?>
                      
                    <?php }else{?>
                          <i class="fa-solid fa-star starNotActive"></i>
                          <i class="fa-solid fa-star starNotActive"></i>
                          <i class="fa-solid fa-star starNotActive"></i>
                          <i class="fa-solid fa-star starNotActive"></i>
                          <i class="fa-solid fa-star starNotActive"></i>
                          <?php }?>
                            <p style="margin-top:8px"><?php echo $sum; ?> đánh giá</p>
                   </td>
                   <td>
                     <?php 
                       $query_rating = mysqli_query($conn,"SELECT star_rating from productrating where id_product = '$id'");
                       $star1 = 0;
                       $star2 = 0;
                       $star3 = 0;
                       $star4 = 0;
                       $star5 = 0;
                       $sum = 0 ;
                       while($row_rating = mysqli_fetch_array($query_rating)){
                           $star = $row_rating['star_rating'];
                           $sum++;
                           switch($star){
                             case '1' : $star1++;break;
                             case '2' : $star2++;break;
                             case '3' : $star3++;break;
                             case '4' : $star4++;break;
                             case '5' : $star5++;break;
                           }
                       }
                       
                     ?>
                      <div class="row">
                       <i class="fa-solid fa-star starActive"></i>
                       <i class="fa-solid fa-star starActive"></i>
                       <i class="fa-solid fa-star starActive"></i>
                       <i class="fa-solid fa-star starActive"></i>
                       <i class="fa-solid fa-star starActive"></i>
                       <div class="progress" style="width: 40%;height:10px;margin-left:12px;">
                         <div class="progress-bar" role="progressbar" style="width: <?php if($star5 > 0){ echo ($star5/$sum)*100;}else{ echo 0;}?>%; background-color:#212529;" aria-valuenow="<?php if($star5 > 0){ echo ($star5/$sum)*100;}else{ echo 0;}?>" aria-valuemin="0" aria-valuemax="100"></div>
                       </div>
                       <span><?php echo $star5; ?></span>
                      </div>

                      <div class="row">
                       <i class="fa-solid fa-star starActive"></i>
                       <i class="fa-solid fa-star starActive"></i>
                       <i class="fa-solid fa-star starActive"></i>
                       <i class="fa-solid fa-star starActive"></i>
                       <i class="fa-solid fa-star starNotActive"></i>
                       <div class="progress" style="width: 40%;height:10px;margin-left:12px;">
                         <div class="progress-bar" role="progressbar" style="width: <?php if($star4 > 0){ echo ($star4/$sum)*100;}else{ echo 0;}?>%; background-color:#212529;" aria-valuenow="<?php if($star4 > 0){ echo ($star4/$sum)*100;}else{ echo 0;}?>" aria-valuemin="0" aria-valuemax="100"></div>
                       </div>
                       <span><?php echo $star4; ?></span>
                      </div>

                      <div class="row">
                       <i class="fa-solid fa-star starActive"></i>
                       <i class="fa-solid fa-star starActive"></i>
                       <i class="fa-solid fa-star starActive"></i>
                       <i class="fa-solid fa-star starNotActive"></i>
                       <i class="fa-solid fa-star starNotActive"></i>
                       <div class="progress" style="width: 40%;height:10px;margin-left:12px;">
                         <div class="progress-bar" role="progressbar" style="width: <?php if($star3 > 0){ echo ($star3/$sum)*100;}else{ echo 0;}?>%; background-color:#212529;"  aria-valuenow="<?php if($star3 > 0){ echo ($star3/$sum)*100;}else{ echo 0;}?>" aria-valuemin="0" aria-valuemax="100"></div>
                       </div>
                       <span><?php echo $star3; ?></span>
                      </div>

                      <div class="row">
                       <i class="fa-solid fa-star starActive"></i>
                       <i class="fa-solid fa-star starActive"></i>
                       <i class="fa-solid fa-star starNotActive"></i>
                       <i class="fa-solid fa-star starNotActive"></i>
                       <i class="fa-solid fa-star starNotActive"></i>
                       <div class="progress" style="width: 40%;height:10px;margin-left:12px;">
                         <div class="progress-bar" role="progressbar" style="width: <?php if($star2 > 0){ echo ($star2/$sum)*100;}else{ echo 0;}?>%; background-color:#212529;"  aria-valuenow="<?php if($star2 > 0){ echo ($star2/$sum)*100;}else{ echo 0;}?>" aria-valuemin="0" aria-valuemax="100"></div>
                       </div>
                       <span><?php echo $star2; ?></span>
                      </div>

                      <div class="row" style="margin-bottom:32px;">
                       <i class="fa-solid fa-star starActive"></i>
                       <i class="fa-solid fa-star starNotActive"></i>
                       <i class="fa-solid fa-star starNotActive"></i>
                       <i class="fa-solid fa-star starNotActive"></i>
                       <i class="fa-solid fa-star starNotActive"></i>
                       <div class="progress" style="width: 40%;height:10px;margin-left:12px;">
                         <div class="progress-bar" role="progressbar" style="width: <?php if($star1 > 0){ echo ($star1/$sum)*100;}else{ echo 0;}?>%; background-color:#212529;"  aria-valuenow="<?php if($star1 > 0){ echo ($star1/$sum)*100;}else{ echo 0;}?>" aria-valuemin="0" aria-valuemax="100"></div>
                       </div>
                       <span><?php echo $star1; ?></span>
                      </div>
                   </td>
                   
                  </tr>
                 
                </tbody>
              </table>

            </div>
                      </div>
          </div>
       </div>
       <div class="row">
          <div class="col-md-12">
            <div class="row_detailproduct--content">
              <div class="row_detailproduct_label--seperate">
                <span>Bình Luận</span>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
             <div class="col-md-12">
            
                 <div class="row_detailproduct--content" style="display:flex;margin-bottom: 0px;">
                      <img src="../assets/img/user11.png" alt="" style="width:62px;height:62px;margin-right:12px;">
                      <div class="form-group" style="width:90%">
                            <textarea class="form-control" rows="2" id="productComment" placeholder="Nhập vào bình luận của bạn ... (tối đa 255 ký tự)" maxlength="255"></textarea>
                      </div>
                    
                    
                  </div>
              
            </div>
            <div class="col-md-12">
                <button class="btn btn-primary " style="background-color: #212529;margin-top:12px;margin-bottom:32px;float: right;margin-right: 32px;" id="submitComment">Đăng Bình Luận</button>
            </div>
        </div>

       
        <div class="row" >
          <div class="col-md-12">
          <?php 
            $query_comment = mysqli_query($conn,"SELECT * from productcomment where id_product = '$id' order by id_product desc limit 10"); 
            $i = 0;
            if(mysqli_num_rows($query_comment) > 0){
              while($row_comment = mysqli_fetch_array($query_comment)){
                 $id_customer = $row_comment['id_customer'];
                 $query_customer = mysqli_query($conn,"SELECT * from customers where id_customer = '$id_customer'");
                 $row_customer = mysqli_fetch_array($query_customer);
                 $i++;
                 $id_comment = $row_comment['id_comment'];
                 $query_commentReply = mysqli_query($conn,"SELECT * from productcommentreply where id_comment = '$id_comment'");
                 
                 
           ?>
             <div class="row_detailproduct--content" style="display:flex;margin-bottom: 0px;">
               <img src="../assets/img/user11.png" alt="" style="width:62px;height:62px;margin-right:12px;">
               <div class="row_detailproduct--comment" id="<?php echo $row_comment['id_comment']; ?>">
                 <span style="font-size:16px"><?php if($row_customer['name_customer'] != NULL){
                   echo $row_customer['name_customer'];
                 }else{ echo $row_customer['username_customer'];} ?></span>
                 <p style="margin-bottom: 4px;"><?php echo $row_comment['product_comment']; ?></p>
                 <?php if(isset($_SESSION['idStaff']) && mysqli_num_rows($query_commentReply) == 0){?>
                  <div class="button_reply" >
                          <button type="button" class="btn btn-link" name="deleteComment" style="transform: translate(-10px,-9px);font-size: 14px;" >Delete</button>
                          <button type="button" class="btn btn-link" name="replyButton" style="transform: translate(-20px,-9px);font-size: 14px;">Reply</button>
                          <p style="font-size:14px;color:#90949c;transform:translateX(-20px);"><?php 
                            echo $row_comment['time_comment']; 
                       ?> </p>
                  </div>
                
                  
                  <div class="row_detailproduct--reply">
                      <img src="../assets/img/user12.png" alt="" style="width:62px;height:62px;margin-right:12px;border-radius:50%">
                      <div class="form-group" style="width:93%">
                            <textarea class="form-control" rows="2" name="productCommentReply" style="border-radius:0px" placeholder="Nhập vào bình luận của bạn ... (tối đa 255 ký tự)" maxlength="255"></textarea>
                            <div class="area_postReply">
                                  <button type="button" class="btn_cancel" name="cancelComment">Cancel</button>
                                  <button type="button" class="btn_primary" name="replyComment">Reply</button>
                            </div>
                      </div>
                  </div>
                  <?php }else if(mysqli_num_rows($query_commentReply) > 0){
                     $row_commentReply = mysqli_fetch_array($query_commentReply);  
                  ?>
                    <div class="button_reply" >
                      <?php if(isset($_SESSION['idStaff'])){?>
                          <button type="button" class="btn btn-link" name="deleteComment" style="transform: translate(-10px,-9px);font-size: 14px;" >Delete</button>
                          <button type="button" class="btn btn-link" name="replyButton" style="transform: translate(-20px,-9px);font-size: 14px;">Reply</button>
                          <p style="font-size:14px;color:#90949c;transform:translateX(-20px);"><?php 
                            echo $row_comment['time_comment']; 
                       ?> </p>
                       <?php }else{?>
                        <button type="button" class="btn btn-link" name="replyButton" style="transform: translate(-10px,-9px);font-size: 14px;">Reply</button>
                        <p style="font-size:14px;color:#90949c;transform:translateX(-10px);"><?php 
                          echo $row_comment['time_comment']; 
                        ?> </p>
                       <?php }?>
                    </div>
                    <div class="row_detailproduct--reply">
                      <img src="../assets/img/user12.png" alt="" style="width:62px;height:62px;margin-right:12px;border-radius:50%">
                      <div class="form-group" style="width:93%">
                            <span style="font-size:16px">Bookstore</span>
                            <p style="margin-bottom: 4px;"><?php echo $row_commentReply['comment_reply']; ?></p>
                            <div class="button_reply" >
                               <p style="font-size:14px;color:#90949c;"><?php 
                                 echo $row_commentReply['time_reply']; 
                               ?> </p>
                            </div>
                      </div>
                  </div>
                  
                 <?php }?>
               </div>
               
             </div>

             <?php }}?>
          
              </div>
          </div>
       
          <!-- <div class="row">
             <div class="col-md-12" style="text-align: center;">
                <button class="btn btn-primary " style="background-color: #212529;margin-top:12px;margin-bottom:32px;width:90%;">Tải Thêm</button>
              </div>
         
           </div> -->

      </div>
       
    </div>
  </section>
  <script src="../assets/script/deleteComment.js"></script>
<script type="text/javascript">
  const input = document.querySelector(".row_detailproduct--main");
  const arrIntroduce = input.querySelectorAll("p");
  const length = arrIntroduce.length;
  for(i = 0 ; i < length; i++){
    if(i > 3 && arrIntroduce[i].innerText == "" && i < 6){
      arrIntroduce[i].setAttribute("id","dots")
    }
    if(i > 6){
      arrIntroduce[i].setAttribute("class","more");
    }
  }
 
    function readMore() {
      if(document.querySelector("#dots")){
        var dots = document.getElementById("dots");
        var moreText = document.querySelectorAll(".more");
        var btnText = document.getElementById("myBtn");
        var lengthArr = moreText.length;
        if (dots.style.display === "none") {
          dots.style.display = "block";
          btnText.innerHTML = "Read more";
          for(i = 0; i< lengthArr;i++){
            moreText[i].style.display = "none";
  
          }
        } else {
          dots.style.display = "none";
          btnText.innerHTML = "Read less";
          for(i = 0; i< lengthArr;i++){
            moreText[i].style.display = "block";
  
          }
    
        }
      }
    };

    const submitCommnet = document.getElementById("submitComment");
    submitCommnet.addEventListener("click", function(){
      const idProduct = <?php echo $id; ?>;
      <?php if(isset($_SESSION['id_customer'])){?>
      const idCustomer = <?php echo $_SESSION['id_customer']; ?>;
      <?php }else{ ?>
             Swal.fire({
              icon: "error",
              title: "Lỗi...",
              text: "Vui lòng đăng nhập để bình luận!",
             });
      <?php }?>
      const productComment = document.getElementById("productComment").value;
      let today = new Date();
      let date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
      let time = today.getHours()+':'+today.getMinutes()+':'+today.getSeconds();
      today = date + ' ' + time; 
      $.ajax({
              url:"../assets/postComment.php",  
              method:"POST",  
              data:{idProduct:idProduct,idCustomer:idCustomer,productComment:productComment,dateTime:today},  
              dataType:"text",  
              success:function(data)  
              {  
                     if(data != '')  
                     {  
                        
                            Swal.fire({
                             icon: "success",
                             title: "Thành Công",
                             text: "Bình luận thành công!",
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

    });
    const replyButton = document.getElementsByName('replyButton');
    for(i = 0; i< replyButton.length; i++){
      
      replyButton[i].addEventListener("click",function(event){
        let eventTarget = event.target;
        let elementParent = eventTarget.parentElement.parentElement;
        let replyComment = elementParent.querySelector(".row_detailproduct--reply");
        replyComment.style.display = "flex";
        let replyAction = replyComment.querySelector(".btn_primary");
        let replyCancel = replyComment.querySelector(".btn_cancel");
        replyCancel.addEventListener("click",function(event){
          replyComment.style.display = "none";
        });
        replyAction.addEventListener("click",function(event){
          let eventTarget = event.target;
          let elementParent = eventTarget.parentElement.parentElement;
          let reply = elementParent.querySelector(".form-control").value;
          let idCommentTarget = elementParent.parentElement.parentElement;
          let idComment = idCommentTarget.getAttribute("id");
          let today = new Date();
          let date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
          let time = today.getHours()+':'+today.getMinutes()+':'+today.getSeconds();
          today = date + ' ' + time; 
          <?php if(isset($_SESSION['idStaff'])){ ?>
          let idStaff = <?php echo $_SESSION['idStaff']; ?>;
          <?php }?>
          $.ajax({
              url:"../assets/postCommentReply.php",  
              method:"POST",  
              data:{idComment:idComment,idStaff:idStaff,reply:reply,dateTime:today},  
              dataType:"text",  
              success:function(data)  
              {  
                     if(data != '')  
                     {  
                        
                            Swal.fire({
                             icon: "success",
                             title: "Thành Công",
                             text: "Bình luận sản phẩm thành công!",
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
        })
      });
 
    }    

    
</script>

