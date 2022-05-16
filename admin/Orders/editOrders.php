
<?php
include_once './config.php';

if (!isset($_SESSION['username'])) {
    header('location: ./login.php');
}else{
    $id_staff = $_SESSION['id_staff'];
    $id_order = $_REQUEST['id'];
    $query_order = mysqli_query($conn,"SELECT * FROM orders where id_order = '$id_order'");
    $row_order = mysqli_fetch_array($query_order);
    $idStaffOrder = $row_order['id_staff'];
    $query_staff = mysqli_query($conn,"SELECT * FROM staff where id_staff = '$idStaffOrder'");
    $row_staff = mysqli_fetch_array($query_staff);
    include_once './alert.php';
    if(in_array("2", $_SESSION['roleStaff'], true)){
        if(isset($_POST['order_status']) ){
             $order_status = $_POST['order_status'];
             if($_POST['order_status'] == "Đã Giao" ){
                 $date = date("Y-m-d");
                 $sql = "UPDATE orders SET id_staff = '$id_staff', order_status = '$order_status', date_delivery = '$date' WHERE id_order = '$id_order'";
             }else if($_POST['order_status'] == "Đã Hủy"){
                $sql = "UPDATE orders SET id_staff = '$id_staff', order_status = '$order_status', date_delivery = '$date' WHERE id_order = '$id_order'";
                if(mysqli_query($conn,$sql)){
                    $sql_orderdetails = mysqli_query($conn,"SELECT * FROM orderdetails where id_order = '$id_order'");
                    while($row_orderdetails =mysqli_fetch_array($sql_orderdetails)){
                        $id_sell = $row_orderdetails['id_sell'];
                        $query_sell = mysqli_query($conn,"SELECT id_product FROM sellingprice where id_sell = '$id_sell'");
                        $row_sell= mysqli_fetch_array($query_sell);
                        $id_product = $row_sell['id_product'];
                        $numberProduct = $row_orderdetails['number_order'];
                        $query_product = mysqli_query($conn,"SELECT number_product, product_sold from product WHERE id_product ='$id_product'");
                        $row_product =mysqli_fetch_array($query_product);
                        $numberProductCurrently = $row_product['number_product'];
                        $numberProductUpdate = $numberProductCurrently + $numberProduct;
                        $numberProductSold = $row_product['product_sold'];
                        $numberProductSoldUpdate = $numberProductSold - $numberProduct;
                        $updateProduct = "UPDATE product set number_product = '$numberProductUpdate', product_sold = '$numberProductSoldUpdate' where id_product = '$id_product'";
                        mysqli_query($conn,$updateProduct);
                    }
                    $_SESSION['status'] = "Cập Nhật Thành Công!";
                    $_SESSION['status_code']= "success";
                    $url = "index.php?page_layout=orders";
                    if(headers_sent()){
                        die('<script type ="text/javascript">window.location.href="'.$url.'" </script>');
                    }else{
                         header ("location: $url");
                         die();
                    }
                }else{
                    $_SESSION['status'] = "Cập Nhật Thất Bại!";
                    $_SESSION['status_code']= "success";
                    $url = "index.php?page_layout=orders";
                    if(headers_sent()){
                        die('<script type ="text/javascript">window.location.href="'.$url.'" </script>');
                    }else{
                         header ("location: $url");
                         die();
                    }
                }
             }
             else{
                 $sql = "UPDATE orders SET id_staff = '$id_staff', order_status = '$order_status' WHERE id_order = '$id_order'";

             }
             if(mysqli_query($conn,$sql)){
                 $_SESSION['status'] = "Cập Nhật Thành Công!";
                 $_SESSION['status_code']= "success";
                $url = "index.php?page_layout=orders";
                if(headers_sent()){
                    die('<script type ="text/javascript">window.location.href="'.$url.'" </script>');
                }else{
                     header ("location: $url");
                     die();
                }
             }else {
                $_SESSION['status'] = "Cập Nhật Thất Bại!";
                $_SESSION['status_code']= "error";
                $conn -> rollback();
                $url = "index.php?page_layout=orders";
                if(headers_sent()){
                    die('<script type ="text/javascript">window.location.href="'.$url.'" </script>');
                }else{
                     header ("location: $url");
                     die();
                }
            }
        }
        mysqli_close($conn);
    }else{
        echo '<script language="javascript">';
        echo 'alert("Bạn không có quyền truy cập vào trang này")';
        echo '</script>';
        $url = "index.php";
        if(headers_sent()){
            die('<script type ="text/javascript">window.location.href="'.$url.'" </script>');
        }else{
            header ("location: $url");
            die();
        }
    }
}

?>

         <div class="container-fluid px-4">
            <h1 class="mt-4">Dashboard</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Quản Lý Thông Tin Đơn Hàng</li>
                </ol>
            <div class="body-page--function-form">
                <form action="#" method="POST" enctype="multipart/form-data" id = "validator" >
                    <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-table me-1"></i>
                                    Cập Nhật Tình Trạng Đơn Hàng
                                </div>
                                <div class="card-body">
                                          <div class="form-group">
                                            <div class="form-check" style="margin-left:8px;">
                                            <?php if($row_staff === NULL){?>
                                              <input class="form-check-input" type="checkbox" value="<?php echo $id_staff;?>" id="id_staff" name="id_staff">
                                              <label class="form-check-label" for="flexCheckDefault">
                                                 Xác Nhận Phụ Trách Đơn Hàng Này
                                               </label>
                                               <?php }else if($row_staff['id_staff'] == $id_staff){?>
                                                <input class="form-check-input" type="checkbox" value="<?php echo $row_staff['id_staff'];?>" id="id_staff" name="id_staff" checked disabled>
                                                <label class="form-check-label" for="flexCheckDefault">
                                                 Đơn Hàng đang do bạn phụ trách
                                                </label>
                                               <?php }else if($row_staff['id_staff'] !== $id_staff && $row_staff['id_staff'] !== NULL){
                                                    $_SESSION['status'] = "Truy Cập Thất Bại!";
                                                    $_SESSION['status_code']= "error";
                                                    $url = "index.php?page_layout=orders";
                                                    if(headers_sent()){
                                                        die('<script type ="text/javascript">window.location.href="'.$url.'" </script>');
                                                    }else{
                                                         header ("location: $url");
                                                         die();
                                                    }
                                                  }
                                                ?>
                                            </div>
                                             <span class="form-group__message"></span>
                                         </div>
                                         <div class="form-group">
                                           <label for="inputAddress">Tình Trạng Đơn Hàng</label>
                                          
                                            <?php if($row_order['order_status'] != 'Đã Giao' && $row_order['order_status'] != 'Đã Hủy'){ ?>
                                           <select class="form-select" aria-label="Default select example" id="order_status" name="order_status">
                                              <option selected>Choose</option>
                                              <option value="Đã Xử Lý">Đã Xử Lý</option>
                                              <option value="Đã Giao">Đã Giao</option>
                                              <option value="Đã Hủy">Đã Hủy</option>
                                            </select>
                                            <?php }else if($row_order['order_status'] == 'Đã Giao'){?>
                                            <select class="form-select" aria-label="Default select example" id="order_status" name="order_status">
                                                <option value="Đã Giao" selected  disabled>Đã Giao</option>
                                            </select>
                                            <?php }else if($row_order['order_status'] == 'Đã Hủy'){?>
                                            <select class="form-select" aria-label="Default select example" id="order_status" name="order_status">
                                                <option value="Đã Hủy" selected disabled>Đã Hủy</option>
                                            </select>
                                            <?php }?>
                                           
                                           <span class="form-group__message"></span>
                                         </div>
                                         <a href = "index.php?page_layout=orders" class="btn btn-primary " style="margin-top:12px"><i class="fas fa-arrow-left" style="margin-right:6px"></i>Back</a>
                                         <?php if($row_order['order_status'] == 'Đã Giao' || $row_order['order_status'] == 'Đã Hủy'){ ?>
                                         <button type="submit" class="btn btn-primary" style="background-color: #212529;margin-top:12px;" disabled>Submit</button>
                                         <?php }else{?>
                                          <button type="submit" class="btn btn-primary" style="background-color: #212529;margin-top:12px;" >Submit</button>
                                          <?php }?>
                                </div>
                    </div>
                </form>
            </div>
        </div>
      
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../assets/script/validator.js"></script>
  
    <script>
        Validator({
            form: '#validator',
            formGroupSelector: '.form-group',
            errorSelector: '.form-group__message',
            rules: [
               Validator.isRequired('#id_staff'),
               Validator.isRequired('#order_status'),
              
            ]
        });
    </script>