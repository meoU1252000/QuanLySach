<?php 
include_once '../admin/config.php';

session_start();

$query_category = mysqli_query($conn,"SELECT * from typegroup order by id_typegroup");
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Bookstore</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.css">
    <link rel="stylesheet" href="./fontawesome-free-5.15.3-web/css/all.min.css">
    <link rel="stylesheet" href="./fontawesome-free-6.0.0-web/css/all.min.css">
    <link href="../assets/css/font-awesome.min.css" rel="stylesheet" />
    <link href = "../assets/css/ion.rangeSlider.min.css" rel="stylesheet" />
     <!-- Custom styles for this template -->
     <link href="../assets/css/style.css" rel="stylesheet" />
     <!-- responsive style -->
     <link href="../assets/css/responsive.css" rel="stylesheet" />
     <link href="../assets/css/style.scss" rel="stylesheet" />
     <link href="../assets/css/style.css.map" rel="stylesheet" />
    <!-- Animation css-->
    <link href="../assets/css/base.css" rel="stylesheet" />
    <!-- Login Validator -->
    <script src="../assets/script/validator.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.4/dist/sweetalert2.all.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

</head>
<body>
    <div class="hero_area">
        <!-- header section strats -->
        <header class="header_section">
          <div class="container-fluid">
            <nav class="navbar navbar-expand-lg custom_nav-container ">
                <a class="navbar-brand" href="index.html">
                    <span>
                      
                    </span>
                  </a>
              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class=""> </span>
              </button>
    
              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav">
                  <li class="nav-item active">
                    <a class="nav-link pl-lg-0" href="index.php" id="home">Home <span class="sr-only">(current)</span></a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" style="cursor: pointer;" id="about"> About</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" style="cursor: pointer;" id="Blog"> Blog </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" style="cursor: pointer;scroll-behavior: smooth;" id="contact">Contact Us</a>
                  </li>
                  
                </ul>
                <form action="./search.php" method="POST" enctype="multipart/form-data" class="search_form">
                  <input type="text" class="form-control" placeholder="Nhập tên sản phẩm ...." name="search" >
                  <button class="" type="submit">
                    <i class="fa fa-search" aria-hidden="true"></i>
                  </button>
                </form>
               <ul class="navbar-nav" style=" margin-left: 1.5%;margin-right: 1%;">
                   <li class="nav-item">
                   <?php 
                      if(!isset($_SESSION['id_customer']) && !isset($_SESSION['idStaff'])){
                    ?>
                        <div class="header_user-wrap">
                              <a href="" data-toggle="modal" data-target="#exampleModal">Đăng Nhập</a>
                              <span></span>
                              <a href="" data-toggle="modal" data-target="#exampleModalS">Đăng Ký</a>
                        </div>
                    <?php }else if(isset($_SESSION['idStaff'])){ 
                        $id_staff = $_SESSION['idStaff'];
                        $query_staff = mysqli_query($conn,"SELECT * from staff where id_staff = '$id_staff'");
                        $row_staff = mysqli_fetch_array($query_staff);
                    ?>
                        <div class="header_user--wrap">
                        <!-- <img src="./img/user4.png" alt=""> -->
                        
                        <a onclick="return showAccountInfo();"><i class="fa-solid fa-circle-user user_icon"></i> </a>
                        <div class="user_wrap hidden">
                          <h3>Hello<p><?php echo $row_staff['name_staff']; ?></p></h3>
                          <ul class="user_wrap--list">
                           
                            <li>
                              <i class="fa-solid fa-arrow-right-from-bracket"></i>
                              <a href="./logout.php" class="logout">Đăng Xuất</a>
                            </li>
                          </ul>

                        </div>
                        </div>
                      </div>
                    <?php }
                    else{
                        $id_customer = $_SESSION['id_customer'];
                        $query_customer = mysqli_query($conn,"SELECT * from customers WHERE id_customer = '$id_customer'");
                        $row_customer = mysqli_fetch_array($query_customer);
                      ?>
                      <div class="header_user--wrap">
                        <!-- <img src="./img/user4.png" alt=""> -->
                        
                        <a onclick="return showAccountInfo();"><i class="fa-solid fa-circle-user user_icon"></i> </a>
                        <div class="user_wrap hidden">
                          <h3>Hello<p><?php echo $row_customer['username_customer']; ?></p></h3>
                          <ul class="user_wrap--list">
                            <li>
                              <i class="fa-solid fa-circle-user"></i>
                              <a href="index.php?page_layout=accountPage">Tài Khoản</a> 
                            </li>
                            <li>
                              <i class="fa-solid fa-pen-to-square"></i>
                              <a href="index.php?page_layout=customeraddress">Địa Chỉ</a> 
                            </li>
                            <li>
                             <i class="fa-solid fa-truck-fast"></i>
                             <a href="index.php?page_layout=orderCustomer">Đơn Hàng</a>  
                            </li>
                            <li>
                              <i class="fa-solid fa-arrow-right-from-bracket"></i>
                              <a href="./logout.php" class="logout">Đăng Xuất</a>
                            </li>
                          </ul>

                        </div>
                        </div>
                      </div>
                   
                      <?php }?>
                   </li>
                   
               </ul>
              </div>
            </nav>
          </div>
        </header>
        <section class="slider_section ">
          <div id="customCarousel1" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
               <?php 
                  date_default_timezone_set('Asia/Ho_Chi_Minh');
                  $datetime_now = date("Y-m-d h:i:s");
                  $query_discount = mysqli_query($conn,"SELECT * FROM codediscount where date_end >= '$datetime_now '");
                  $row_discount = mysqli_fetch_array($query_discount);
                  $id_code = $row_discount['id_code'];
               ?>
              <div class="carousel-item active">
                <div class="container ">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="detail-box">
                        <h5>
                          Mã Giảm Giá Tại Bookstore
                        </h5>
                        <h1>
                          <?php echo $row_discount['code_event']; ?>
                        </h1>
                        <p>
                          Nhập mã code để giảm <?php echo $row_discount['discount_value'];?>% tổng giá trị đơn hàng.
                          <br>Ngày Bắt Đầu: <?php echo $row_discount['date_start']; ?>
                          <br>Ngày Kết Thúc: <?php echo $row_discount['date_end'];?>
                        </p>
                        <a href="">
                          Read More
                        </a>
                       
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="img-box">
                        <img src="../assets/img/slider-img.png" alt=""> 
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <?php $query_discountRest = mysqli_query($conn,"SELECT * FROM codediscount where id_code != '$id_code' and  date_end >= '$datetime_now '  ");
                 while($row_discountRest = mysqli_fetch_array($query_discountRest)){
              ?>
               <div class="carousel-item">
                <div class="container ">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="detail-box">
                        <h5>
                          Mã Giảm Giá Tại Bookstore
                        </h5>
                        <h1>
                          <?php echo $row_discountRest['code_event']; ?>
                        </h1>
                        <p>
                          Nhập mã code để giảm <?php echo $row_discountRest['discount_value'];?>% tổng giá trị đơn hàng.
                          <br>Ngày Bắt Đầu: <?php echo $row_discountRest['date_start']; ?>
                          <br>Ngày Kết Thúc: <?php echo $row_discountRest['date_end'];?>
                        </p>
                        <a href="">
                          Read More
                        </a>
                       
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="img-box">
                        <img src="../assets/img/slider-img.png" alt=""> 
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <?php }?>
            </div>
            <div class="carousel_btn_box">
              <a class="carousel-control-prev" href="#customCarousel1" role="button" data-slide="prev">
                <i class="fa fa-angle-left" aria-hidden="true"></i>
                <span class="sr-only">Previous</span>
              </a>
              <a class="carousel-control-next" href="#customCarousel1" role="button" data-slide="next">
                <i class="fa fa-angle-right" aria-hidden="true"></i>
                <span class="sr-only">Next</span>
              </a>
            </div>
           
          </div>
        </section>
        
   </div>
   <?php
                         //master page
                         if(isset($_GET["page_layout"])){
                            switch($_GET["page_layout"]){
                                case 'productDetails':include_once './productDetails.php';
                                   break;
                                case 'purchase':include_once './purchase.php';
                                   break;
                                case 'cartPage':include_once './cartPage.php';
                                   break;
                                case 'accountPage':include_once './CustomerAction/accountPage.php';
                                   break;
                                case 'customeraddress':include_once './CustomerAction/address.php';
                                   break;
                                case 'addAddress':include_once './CustomerAction/addAddress.php';
                                  break;
                                case 'editAddress':include_once './CustomerAction/editAddress.php';
                                  break;
                                case 'checkOut' :include_once './purchase.php';
                                  break;
                                case 'orderCustomer':include_once './CustomerAction/orderCustomer.php';break;
                                case 'orderDetails':include_once './CustomerAction/orderDetails.php';break;
                                case 'product':include_once './product.php';break;
                              }
                         }else {
                        ?>

  <!-- catagory section -->
   <script>
       const scrollToTop = () => {
            const c = document.documentElement.scrollTop || document.body.scrollTop;
            if (c > 0) {
              window.requestAnimationFrame(scrollToTop);
              window.scrollTo(0, c - c / 8);
            }
         };
        const home =  document.getElementById("home");
        home.addEventListener("click",function(event){
          event.preventDefault();
          return scrollToTop();
        });
        
     
  </script>
  <section class="category_section  layout_padding">
    <div class="category_container">
      <div class="container ">
         <div class="heading_container heading_center">
           <h2>
             Các Thể Loại Sách
           </h2>
           <p>
             Hiện cửa hiệu Bookstore chúng tôi đã và đang cung cấp đa dạng các thể loại sách cho các bạn đọc.
           </p>
         </div>
         <div class="row">
           <?php 
              $i = 0;
              while($row_category = mysqli_fetch_array($query_category)){

           ?>
           <div class="col-sm-6 col-md-4 ">
             <div class="box ">
               <div class="img-box">
                 <img src="
                 <?php 
                     echo "img/cat" .$i+1. .".png";
                 ?>" alt="">
               </div>
               <div class="detail-box">
                 <h5>
                   <a href=""><?php echo $row_category['name_typegroup'];?></a>
                 </h5>
                 <!-- <p>
                   fact that a reader will be distracted by the readable content of a page when looking at its layout.
                   The
                   point of using
                 </p> -->
               </div>
             </div>
           </div>
           <?php 
            $i++;
          }?>
           <!-- <div class="col-sm-6 col-md-4 ">
             <div class="box ">
               <div class="img-box">
                 <img src="img/cat2.png" alt="">
               </div>
               <div class="detail-box">
                 <h5>
                   Science
                 </h5>
                 <p>
                   fact that a reader will be distracted by the readable content of a page when looking at its layout.
                   The
                   point of using
                 </p>
               </div>
             </div>
           </div>
           <div class="col-sm-6 col-md-4 ">
             <div class="box ">
               <div class="img-box">
                 <img src="img/cat3.png" alt="">
               </div>
               <div class="detail-box">
                 <h5>
                   History
                 </h5>
                 <p>
                   fact that a reader will be distracted by the readable content of a page when looking at its layout.
                   The
                   point of using
                 </p>
               </div>
             </div>
           </div>
           <div class="col-sm-6 col-md-4 ">
             <div class="box ">
               <div class="img-box">
                 <img src="img/cat4.png" alt="">
               </div>
               <div class="detail-box">
                 <h5>
                   Biography
                 </h5>
                 <p>
                   fact that a reader will be distracted by the readable content of a page when looking at its layout.
                   The
                   point of using
                 </p>
               </div>
             </div>
           </div>
           <div class="col-sm-6 col-md-4 ">
             <div class="box ">
               <div class="img-box">
                 <img src="img/cat5.png" alt="">
               </div>
               <div class="detail-box">
                 <h5>
                   Adventure
                 </h5>
                 <p>
                   fact that a reader will be distracted by the readable content of a page when looking at its layout.
                   The
                   point of using
                 </p>
               </div>
             </div>
           </div>
           <div class="col-sm-6 col-md-4 ">
             <div class="box ">
               <div class="img-box">
                 <img src="img/cat6.png" alt="">
               </div>
               <div class="detail-box">
                 <h5>
                   Fantasy
                 </h5>
                 <p>
                   fact that a reader will be distracted by the readable content of a page when looking at its layout.
                   The
                   point of using
                 </p>
               </div>
             </div>
           </div> -->
         </div>
       </div>
     </div>
     
    </div>
  </section>

  <section class= "category_section_book  layout_padding">
    <div class="category_container">
     
      <div class="container container_book">
        <div class="heading_container heading_center">
          <h2>
            Sách Hiện Có
          </h2>
         
         
        </div>
        <div class="row">
         <?php 
         $query_book = mysqli_query($conn,"SELECT * from product order by id_product desc limit 6");
         while ($row_book = mysqli_fetch_array($query_book)){
           $id_product = $row_book['id_product'];
           $id_type = $row_book['id_type'];
           $id_publishingcompany = $row_book['id_publishingcompany'];
           $query_img = mysqli_query($conn,"SELECT * from productimage where id_product = '$id_product'");
           $row_img = mysqli_fetch_array($query_img);
           $query_type = mysqli_query($conn,"SELECT * from producttype where id_type = '$id_type'");
           $row_type = mysqli_fetch_array($query_type);
           $query_publishingcompany = mysqli_query($conn,"SELECT * from publishingcompany where id_publishingcompany = '$id_publishingcompany'");
           $row_publishingcompany = mysqli_fetch_array($query_publishingcompany);
           $id_typegroup = $row_type['id_typegroup'];
           $query_typegroup = mysqli_query($conn,"SELECT * from typegroup where id_typegroup = '$id_typegroup'");
           $row_typegroup = mysqli_fetch_array($query_typegroup);
           $currentDate = date("Y-m-d");
           $query_sellingprice = mysqli_query($conn,"SELECT * from sellingprice where id_product = '$id_product' and date_end >= '$currentDate' or date_end = '' and id_product='$id_product'");
           $row_sellingprice = mysqli_fetch_array($query_sellingprice);
         
         ?> 
          <div class="col-sm-6 col-md-4 ">
            <div class="box box_product">
              <div class="img-box">
                <img src="<?php echo $row_img['link_img'];?>" alt="" class="img_book">
                <div class="box_hover">
                   <div class="box_hover--heading">
                       <span class="product_id" hidden><?php echo $row_book['id_product'];?></span>
                       <span class="product_quantity" hidden><?php echo $row_book['number_product'];?></span>
                       <h6  class="product_name"><?php echo $row_book['name_product'];?></h6>
                   </div>
                   <ul class="box_hover--listcontent">
                       <li><span><?php echo $row_typegroup['name_typegroup'];?></span></li>
                       <li><span>Thể Loại: <?php echo $row_type['name_type'];?></span></li>
                       <li>Giá Bán: <span class="product_price"><?php 
                                   if( $row_sellingprice !== NULL){
                                   
                                       echo number_format($row_sellingprice['selling_price'],0,",",".");

                                    
                                   }else{
                                     echo 0;
                                   }
                                 ?> </span>
                                 <span>VNĐ</span>
                        <li hidden><span class="id_sell"><?php  if( $row_sellingprice !== NULL){
                                    echo number_format($row_sellingprice['id_sell']);
                                   }else{
                                     echo 0;
                                   }?></span></li>
                        </li>
                     
                        <li hidden><input type="number" min="1" max="<?php echo $row_book['number_product'] ?>" step="1" value="1" id="my-input" readonly></li>
                        
                   </ul>
                   <?php if($row_book['number_product'] > 0 ){?>
                  <button class="add_cart">Thêm Vào Giỏ Hàng</button>
                   <?php }else{?>
                  <button class="add_cart" style="pointer-events: none; background-color: #AAAAAA">Hết Hàng</button>
                  <?php }?>
               </div>
              </div>
              <div class="detail-box">
                <a href="index.php?page_layout=productDetails&id=<?php echo $row_book['id_product'];?>">
                  <h5>
                  <?php echo $row_book['name_product']; ?>
                </h5>
              </a>
              </div>
              
            </div>
           
          </div>
          <?php }?>
          
         
        </div>
        <div class="row readMore" style="margin-top:36px">
          <a href="index.php?page_layout=product">Xem Thêm</a>
        </div>
      </div>

     
    </div>
  </section>

   <!-- <section class= "category_section_book layout_padding">
    <div class="category_container">
     
      <div class="container container_book">
           <div class="heading_container heading_center">
             <h2>
               Sách Hiện Có
             </h2>
             <p>
               
             </p>
           </div>
           <div class="row">
         <?php 
         $query_book = mysqli_query($conn,"SELECT * from product order by id_product");
         while ($row_book = mysqli_fetch_array($query_book)){
           $id_product = $row_book['id_product'];
           $id_type = $row_book['id_type'];
           $id_publishingcompany = $row_book['id_publishingcompany'];
           $query_img = mysqli_query($conn,"SELECT * from productimage where id_product = '$id_product'");
           $row_img = mysqli_fetch_array($query_img);
           $query_type = mysqli_query($conn,"SELECT * from producttype where id_type = '$id_type'");
           $row_type = mysqli_fetch_array($query_type);
           $query_publishingcompany = mysqli_query($conn,"SELECT * from publishingcompany where id_publishingcompany = '$id_publishingcompany'");
           $row_publishingcompany = mysqli_fetch_array($query_publishingcompany);
           $id_typegroup = $row_type['id_typegroup'];
           $query_typegroup = mysqli_query($conn,"SELECT * from typegroup where id_typegroup = '$id_typegroup'");
           $row_typegroup = mysqli_fetch_array($query_typegroup);
           $query_sellingprice = mysqli_query($conn,"SELECT * from sellingprice where id_product = '$id_product'");
           $row_sellingprice = mysqli_fetch_array($query_sellingprice);
         ?> 
          <div class="col-sm-6 col-md-4 ">
            <div class="box">
              <div class="img-box">
                <img src="<?php echo $row_img['link_img'];?>" alt="" class="img_book">
                <div class="box_hover">
                   <div class="box_hover--heading">
                       <span class="product_id" hidden><?php echo $row_book['id_product'];?></span>
                       <h6  class="product_name"><?php echo $row_book['name_product'];?></h6>
                   </div>
                   <ul class="box_hover--listcontent">
                       <li><span><?php echo $row_typegroup['name_typegroup'];?></span></li>
                       <li><span>Thể Loại: <?php echo $row_type['name_type'];?></span></li>
                       <li>Giá Bán: <span class="product_price"><?php 
                                   if( $row_sellingprice !== NULL){
                                    echo number_format($row_sellingprice['selling_price']);
                                   }else{
                                     echo 0;
                                   }
                                 ?> </span>
                                 <span>VNĐ</span>
                        </li>
                        <li hidden><input type="number" min="1" max="100" step="1" value="1" id="my-input" readonly></li>
                   </ul>
                 <button class="add_cart">Thêm Vào Giỏ Hàng</button>
               </div>
              </div>
              <div class="detail-box">
                <a href="index.php?page_layout=product&id=<?php echo $row_book['id_product'];?>">
                  <h5>
                  <?php echo $row_book['name_product']; ?>
                </h5>
              </a>
              </div>
              
            </div>
           
          </div>
          <?php }?>
          
         
        </div>
        
      </div>
    </div>
  </section>  -->


  <!-- end catagory section -->

<!-- blog section -->

  <section class="blog_section layout_padding">
    <div class="container">
      <div class="heading_container heading_center">
        <h2>
          From Our Blog
        </h2>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="box">
            <div class="img-box">
              <img src="../assets/img/b1.jpg" alt="">
              <h4 class="blog_date">
                <span>
                  19 January 2021
                </span>
              </h4>
            </div>
            <div class="detail-box">
              <h5>
                Eius, dolor? Vel velit sed doloremque
              </h5>
              <p>
                Incidunt magni explicabo ullam ipsa quo consequuntur eveniet illo? Aspernatur nam dolorem a neque? Esse eaque dolores hic debitis cupiditate, ad beatae voluptatem numquam dignissimos ab porro
              </p>
              <a href="">
                Read More
              </a>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="box">
            <div class="img-box">
              <img src="../assets/img/b2.jpg" alt="">
              <h4 class="blog_date">
                <span>
                  19 January 2021
                </span>
              </h4>
            </div>
            <div class="detail-box">
              <h5>
                Minus aliquid alias porro iure fuga
              </h5>
              <p>
                Officiis veritatis id illo eligendi repellat facilis animi adipisci praesentium. Tempore ab provident porro illo ex obcaecati deleniti enim sequi voluptas at. Harum veniam eos nisi distinctio! Porro, reiciendis eius.
              </p>
              <a href="">
                Read More
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  
  
  
  <section class="contact_section layout_padding" id="contactUs">
    <div class="container">
      <div class="row">
        <div class="col-md-6 ">
          <div class="heading_container ">
            <h2 class="">
              Contact Us
            </h2>
          </div>
          <form action="#">
            <div>
              <input type="text" placeholder="Name" />
            </div>
            <div>
              <input type="email" placeholder="Email" />
            </div>
            <div>
              <input type="text" placeholder="Pone Number" />
            </div>
            <div>
              <input type="text" class="message-box" placeholder="Message" />
            </div>
            <div class="btn-box">
              <button>
                SEND
              </button>
            </div>
          </form>
        </div>
        <div class="col-md-6">
          <div class="img-box">
            <img src="../img/Book/contact-img.png" alt="">
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- end contact section -->
  <?php }?>
  

  <!-- info section -->

  <section class="info_section ">
    <div class="container">
      <div class="row">
        <div class="col-md-6 col-lg-3 info-col">
          <div class="info_detail">
            <h4>
              About Us
            </h4>
            <p>
            <!-- SỨ MỆNH CỦA Bookstore: “MANG TRI THỨC, VĂN HÓA ĐỌC ĐẾN VỚI MỌI NHÀ”!<br> -->
            Hiện nay, Công ty Bookstore đã và đang ngày càng nỗ lực vào sự nghiệp phát triển “văn hóa đọc”, làm cho những giá trị vĩnh hằng của sách ngày càng thấm sâu vào đời sống văn hóa tinh thần của xã hội, nhằm góp phần tích cực, đáp ứng yêu cầu nâng cao dân trí.
            </p>
            <div class="info_social">
              <a href="https://www.facebook.com/meo.u.it.student/" target="_blank">
                <i class="fa fa-facebook" aria-hidden="true"></i>
              </a>
              <a href="">
                <i class="fa fa-twitter" aria-hidden="true"></i>
              </a>
              <a href="">
                <i class="fa fa-linkedin" aria-hidden="true"></i>
              </a>
              <a href="">
                <i class="fa fa-instagram" aria-hidden="true"></i>
              </a>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-3 info-col">
          <div class="info_contact">
            <h4>
              Address
            </h4>
            <div class="contact_link_box">
              <a href="">
                <i class="fa fa-map-marker" aria-hidden="true"></i>
                <span style="font-size: 14px;">
                  182/45 Trần Hưng Đạo, phường 7, Quận 3, TP HCM
                </span>
              </a>
              <a href="">
                <i class="fa fa-phone" aria-hidden="true"></i>
                <span style="font-size: 14px;">
                  Call +84 984978407
                </span>
              </a>
              <a href="">
                <i class="fa fa-envelope" aria-hidden="true"></i>
                <span style="font-size: 14px;">
                  datb1809227@student.ctu.edu.vn
                </span>
              </a>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-3 info-col">
          <div class="info_contact">
            <h4>
              Newsletter
            </h4>
            <form action="#">
              <input type="text" placeholder="Enter email" />
              <button type="submit">
                Subscribe
              </button>
            </form>
          </div>
        
        </div>
        <div class="col-md-6 col-lg-3 info-col">
          <div class="map_container">
            <div class="map">
              <div id="googleMap"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- end info section -->

 <!-- footer section -->
 <footer class="footer_section">
    <div class="container">
      <p>
        &copy; <span id="displayYear"></span> All Rights Reserved By
        <a href="https://html.design/">Free Html Templates</a>
      </p>
    </div>
 </footer>
  <!-- footer section -->
  <div class="cart">
        <div class="cart_wrap"  onclick="return showCart();">
            <i class="fa-solid fa-basket-shopping"></i>
            <span class ="cart_notice">
                0
            </span>
           
        </div>
        <div class="cart_wrap--list hidden" >
           
            <div class="header_cart--heading">
                <i class="fa-solid fa-bag-shopping"></i>
                <h4>Giỏ Hàng</h4>
                <span class="close_cart">&times;</span>
                
            </div> 
            <div class="header_cart--no_item">
               <img src="./img/no-cart.png" alt="Chưa có hình ảnh"
              class="header_cart-list--no-cart-img">
              <span class="header_cart-list--no-cart-msg">Chưa có sản phẩm trong giỏ hàng</span> 

            </div>
            <div class="header_cart-list-item_limit">
                <ul class="header_cart-list-item">
                    <!-- <li class="header_cart-item">
                        <img src="./img/truyen-ngan-chi-pheo-nam-cao.jpg" alt="" class="header_cart-img">
                        <div class="header_cart-list-item-info">
                            <div class="header_cart-item-head">
                                <h5 class="header_cart-item-name">Chí Phèo - Nam Cao</h5>
                                <a href="" class="header_cart-item-remove"><i class="fa-solid fa-trash"></i></a>
                            </div>
    
                            <div class="header_cart-item-wrap">
                                <span class="header_cart-item-price"></span><span class="home-detailproduct_heading_price--type">50.000₫</span>
                                <span class="header_cart-item-multiply">x</span>
                                <span class="header_cart-item-quantity">1</span>
                            </div>
    
                         
                        </div>
                    </li>
                   
                    -->
                </ul>
              
            </div>
            <div class="footer_cart hidden">
                <span class="footer_cart--price">Tổng Cộng: <span class ="footer_cart--total"></span><span class="footer_cart--pricetype">₫</span> 
                </span> 
                <a href="index.php?page_layout=cartPage">Xem Giỏ Hàng</a>
                <a href="index.php?page_layout=checkOut">Thanh Toán</a>
            </div>
                
          
       
        </div>
  </div>
  <div
      class="modal fade"
      id="exampleModal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content modal_position">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Đăng Nhập</h5>
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="./login.php" method="POST" enctype="multipart/form-data" id="validator">
              <div class="form-group">
                <label for="username">Tên Đăng Nhập</label>
                <input
                  type="text"
                  class="form-control"
                  id="username"
                  name="username_login"
                />
                 <span class="form__message"></span>
              </div>
              <div class="form-group">
                <label for="password">Password</label>
                <input
                  type="password"
                  class="form-control"
                  id="password"
                  name="password_login"
                />
                 <span class="form__message"></span>
              </div>
              <div class="login-form__forget">
                <a href class="forget_link" data-dismiss="modal" data-toggle="modal" data-target="#exampleModalM"> Quên Mật Khẩu ? </a>
                <span class="login-form__forget-separate"></span>
                <a href class="signin_link" data-dismiss="modal" data-toggle="modal" data-target="#exampleModalS"> Đăng Ký</a>
              </div>
            
              <div class="modal_button">
                  <button type="button" class="btn btn-secondary" style="width:120px" data-dismiss="modal">Trở Lại</button>
                  <button type="submit" class="btn btn-primary" style="width:150px;color: white;background-color:#063547;">Đăng Nhập</button>
              </div>
           </form>
          </div>
         
        </div>
      </div>
  </div>
    

    <div
      class="modal fade"
      id="exampleModalS"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content modal_position_sign">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Đăng Ký</h5>
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="./registration.php" method="POST" enctype="multipart/form-data" id="validator_registration">
              <div class="form-group">
                <label for="username">Tên Đăng Nhập</label>
                <input
                  type="text"
                  class="form-control"
                  id="new-username"
                  placeholder=""
                  name="new-username"
                />
                <span class="form__message"></span>
              </div>
              <div class="form-group">
                <label for="email">Email</label>
                <input
                  type="email"
                  class="form-control"
                  id="new-email"
                  placeholder=""
                  name="new-email"
                />
                <span class="form__message"></span>
              </div>
              <div class="form-group">
                <label for="password">Mật Khẩu</label>
                <input
                  type="password"
                  class="form-control"
                  id="new-password"
                  placeholder=""
                  name="new-password"
                />
                <small id="passwordHelpBlock" class="form-text text-muted">
                     Mật Khẩu phải có tối thiểu tám ký tự, ít nhất một chữ cái viết hoa, một chữ cái viết thường, một số và một kí tự đặc biệt!
                <span class="form__message"></span>
              </div>
              <div class="form-group">
                <label for="new-repassword">Xác Nhận Mật Khẩu</label>
                <input
                  type="password"
                  class="form-control"
                  id="new-repassword"
                  placeholder=""
                />
                <span class="form__message"></span>
              </div>
              <div class="confirm_signup">
                Bằng việc đăng ký, bạn đã đồng ý với <span>BookStore</span>  về <a href="">Điều khoản dịch vụ</a> &  <a href="">Chính sách bảo mật</a>
              </div>
              
              <div class="modal_button">
                  <button type="button" class="btn btn-secondary" style="width:120px" data-dismiss="modal">Trở Lại</button>
                  <button type="submit" class="btn btn-primary" style="width:150px; color: white;background-color:#063547;" name="registration_submit">Đăng Ký</button>
              </div>
           </form>
          </div>
         
        </div>
      </div>
    </div>

    <div
      class="modal fade"
      id="exampleModalM"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content modal_position">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Quên Mật Khẩu</h5>
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="#" method="POST" enctype="multipart/form-data" id="forgetPassword">
              <div class="form-group">
                <label for="emailConfirm">Nhập Email đã đăng ký</label>
                <input
                  type="text"
                  class="form-control"
                  id="emailConfirm"
                />
                 <span class="form__message"></span>
              </div>
              <div class="form-group hidden">
                <label for="confirmCode">Mã Xác Nhận</label>
                <input
                  type="password"
                  class="form-control"
                  id="confirmCode"
                />
                 <span class="form__message"></span>
              </div>
              
              <div class="modal_button">
                  <button type="button" class="btn btn-secondary" style="width:120px" data-dismiss="modal">Trở Lại</button>
                  <button type="submit" class="btn btn-primary" style="width:150px;color: white;background-color:#063547;">Gửi Mã</button>
              </div>
           </form>
          </div>
         
        </div>
      </div>
    </div>
    
  <!-- jQery -->
  <script src="../assets/script/jquery-3.4.1.min.js"></script>
  <!-- bootstrap js -->
  <script src="../assets/script/bootstrap.js"></script>
  <!-- custom js -->
  <script src="../assets/script/custom.js"></script>
  <!-- Google Map -->
 
  </script>
  <!-- Input Custom -->
   <script src="../assets/script/inputcustom.js"></script>
   <script src="../assets/script/cart.js"></script>
   <script src="../assets/script/localStorageCart.js"></script>
  <!-- End Google Map -->
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCh39n5U-4IoWpsVGUHWdqB6puEkhRLdmI&callback=myMap"></script>

</body>
  
<script>
         Validator({
             form: '#validator_registration',
             formGroupSelector: '.form-group',
             errorSelector: '.form__message',
             rules: [
                 Validator.isRequired('#new-username','<i class="fas fa-exclamation-triangle warn_icon"></i>Vui lòng nhập vào tên đăng nhập của bạn'),
                 Validator.isPassword('#new-password','<i class="fas fa-exclamation-triangle warn_icon"></i>Mật khẩu không chính xác'),
                 Validator.isEmail('#new-email','<i class="fas fa-exclamation-triangle warn_icon"></i>Email không chính xác'),
                 Validator.isConfirmed('#new-repassword', function(){
                   return document.querySelector('#validator_registration #new-password').value;
                 }),
             ]
         });
         Validator({
             form: '#validator',
             formGroupSelector: '.form-group',
             errorSelector: '.form__message',
             rules: [
                 Validator.isRequired('#username','<i class="fas fa-exclamation-triangle warn_icon"></i>Vui lòng nhập vào tên đăng nhập của bạn'),
                 Validator.isPassword('#password','<i class="fas fa-exclamation-triangle warn_icon"></i>Mật khẩu không chính xác'),
             ]
         });
    

       
</script>
<?php
if(isset($_SESSION['title']) && $_SESSION['title'] !=''){
?>
<script>
     Swal.fire({
                icon: "<?php echo $_SESSION['icon']?>",
                title: "<?php echo $_SESSION['title'];?>",
                text: "<?php if(isset($_SESSION['text'])){ 
                                echo $_SESSION['text'];
                              }else{ 
                                echo "";
                              }
                        ?>",
                showConfirmButton: true,
              });
</script>

<?php
unset($_SESSION['title']);
unset($_SESSION['text']);
unset($_SESSION['icon']);
}

?>

</html>