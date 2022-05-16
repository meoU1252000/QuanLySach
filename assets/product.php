<?php 
$query_category = mysqli_query($conn,"SELECT * from typegroup order by id_typegroup asc");
$query_producttype = mysqli_query($conn,"SELECT * from producttype order by id_type asc");
$listPage="";
$typePage = "";
if(isset($_REQUEST['name_typegroup'])){
    $name_category=$_REQUEST['name_typegroup'];
    $query_typegroup = mysqli_query($conn,"SELECT id_typegroup as id_category  from loaihanghoa where tenloaihang = '$ten_dm'");
    $row_typegroup= mysqli_fetch_array($query_typegroup);
    $id_typegroup = $rowid['id_typegroup'];
    $query_type = mysqli_query($conn,"SELECT id_type from producttype where id_typegroup = '$id_typegroup'");
    $row_type = mysqli_fetch_array($query_type);
    $id_type = $rowid['id_type'];
    $sp_dm = mysqli_query($conn,"SELECT * from product where id_type = '$id_type'");
} else{
    $name_category="";
}

if(isset($_REQUEST['name_type'])){
    $name_type=$_REQUEST['name_type'];
    $query_type = mysqli_query($conn,"SELECT id_type from producttype where name_type = '$name_type'");
    $row_type = mysqli_fetch_array($query_type);
    $id_type = $rowid['id_type'];
    $sp_dm = mysqli_query($conn,"SELECT * from product where id_type = '$id_type'");
} else{
    $name_type="";
}


while($row_category = mysqli_fetch_array($query_category)){
    $name = $row_category['name_typegroup'];
    $listPage.='<span name="categoryGroup" id='.$row_category['id_typegroup'].' class="category-item">'.$name.'</span>';
         
}

while($row_producttype = mysqli_fetch_array($query_producttype)){
    $name1 = $row_producttype['name_type'];
     $typePage.='<span name="category" id='.$row_producttype['id_type'].' class="category-item">'.$name1.'</span>';
         
}


?>


<style>
   .slider_section {
        display:none;
    }
    .category_container{
        display:flex;
        margin-top:52px;
    }
    .col-sm-6  a {
      text-decoration: none;
      color: #44b89d;
      /* font-size: 16px; */
      font-weight: bold;
    }
   
    .col-sm-6:hover{
        box-shadow: 0px 0px 4px 2px rgb(0 0 0 / 10%);
       -webkit-box-shadow: 0px 0px 4px 2px rgb(0 0 0 / 10%);
    }

    .category_container > .container_book{
        margin-left: 36px;
    }
    .category_container > .col-md-2{
        margin-right:36px;
    }
  
</style>

<section class= "body_section category_section_book layout_padding">
    <div class="breadcrumb">
        <a href="index.php">Trang Chủ</a>
        <span >></span>
        <a href="index.php?page_layout=product" style="color:#44b89d;text-decoration:underline;">Sản Phẩm</a>
    </div>
    <div class="category_container">
      
       <div class="col-md-2 container" style="height:fit-content">
                   <nav class="category">
                        <h3 class="category_heading">
                            <i class="fas fa-list-ul category_heading-icon"></i>
                            Tất Cả
                        </h3>

                        <ul class="category-list">
                           
                            <li class="category-item_link">
                                <span id="categoryAll" class="category-item--active">Hiển Thị Tất Cả Sản Phẩm</span>
                            </li>
                         
                          
                        </ul>

                    </nav>
                  <nav class="category">
                        <h3 class="category_heading">
                            <i class="fas fa-list-ul category_heading-icon"></i>
                            Danh mục
                        </h3>

                        <ul class="category-list">
                           
                            <li class="category-item_link">
                                <?php echo $listPage;?>
                            </li>
                         
                          
                        </ul>

                    </nav>
                    <nav class="category" >
                        <h3 class="category_heading" style="border-top: 1px solid rgba(0,0,0,0.5);">
                            <i class="fas fa-list-ul category_heading-icon"></i>
                            Thể Loại
                        </h3>

                        <ul class="category-list">
                           
                            <li class="category-item_link">
                                <?php echo $typePage;?>
                            </li>
                         
                          
                        </ul>

                    </nav>
                 
       </div>
      
      <div class="container container_book col-md-8 ">
        <!-- <div class="row">
           <div class="col-md-12">
                <div class="row_content">
                    <span>Sắp Xếp Theo</span>
                    <button class="btn btn_primary">Mới Nhất</button>
                    <button class="btn btn_primary">Bán Chạy</button>
                    <button class="btn btn_primary">Còn Hàng</button>
                       <select class="form-select form-control" aria-label="Default select example" style="width:20%;">
                         <option value="" selected>Giá</option>
                         <option>Giá Thấp Đến Cao</option>
                         <option>Giá Cao Đến Thấp</option>
                       </select>
                   
                </div>
                <div class="row--seperate">
                </div>
           </div>
        </div> -->

        <div class="row " id="row">
          
         <?php 
         $query_book = mysqli_query($conn,"SELECT * from product order by id_product asc limit 6");
         while ($row_book = mysqli_fetch_array($query_book)){
           $id_product = $row_book['id_product'];
           $query_img = mysqli_query($conn,"SELECT * from productimage where id_product = '$id_product'");
           $row_img = mysqli_fetch_array($query_img);
           $currentDate = date("Y-m-d");
           $query_sellingprice = mysqli_query($conn,"SELECT * from sellingprice where id_product = '$id_product' and date_end >= '$currentDate' or date_end = '' and id_product='$id_product'");
           $row_sellingprice = mysqli_fetch_array($query_sellingprice);
           
         ?> 
          <div class="col-sm-6 col-md-4" name="productCol">
            <a href="index.php?page_layout=productDetails&id=<?php echo $row_book['id_product'];?>">
                <div class="box ">
                  <div class="img-box">
                    <img src="<?php echo $row_img['link_img'];?>" alt="" class="img_book">
                    
                  </div>
                  <div class="detail-box">
                     
                        <h5 style=" display: -webkit-box;-webkit-box-orient: vertical;-webkit-line-clamp: 1;overflow: hidden">
                        <?php echo $row_book['name_product']; ?>
                        </h5>
                      
                      <p style="font-size:1.2rem;color:red"><?php echo number_format($row_sellingprice['selling_price'],0,",","."); ?> VNĐ</p>
                      <p class="product_star">
                            <fieldset class="rate" style="color:#cccccc">
                            <?php 
                                  $query_rating = mysqli_query($conn,"SELECT SUM(star_rating) as totalStar, Count(id_product) as totalRating from productrating where id_product = '$id_product' ");
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
                                   <span style="margin-left: 5px;transform: translateY(-30%);font-size:16px;color:orange;">(<?php echo $sum;?>)  </span>
                                <?php }else{?>
                                  <i class="fa-solid fa-star starNotActive"></i>
                                  <i class="fa-solid fa-star starNotActive"></i>
                                  <i class="fa-solid fa-star starNotActive"></i>
                                  <i class="fa-solid fa-star starNotActive"></i>
                                  <i class="fa-solid fa-star starNotActive"></i>
                                  <span style="margin-left: 5px;transform: translateY(-30%);font-size:16px;color:orange;">(0)</span>
                                  <?php }?>
                               
                            </fieldset>
                 
                        </p>
                  </div>
                  
                </div>
            </a>
          </div>
          <?php }?>
          
          <div class="row readMore" style="margin-top: 36px;margin-bottom:36px;display: block;width: 100%;" id="readMore">
            <button name="btn_more"  data-book="<?php echo $id_product;?>" id="btn_more" style="display:flex;align-item:center;">Xem Thêm</button>
          </div>
         
        </div>
      </div>

     
    </div>
  </section>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
  <script src="../assets/script/product.js"></script>
