
<?php
include_once './config.php';

if (!isset($_SESSION['username'])) {
    header('location: ./login.php');
}else{
    if(in_array("3", $_SESSION['roleStaff'], true)){
        include './alert.php';
        $id_product = $_REQUEST['id'];
        $query_selling = mysqli_query($conn,"SELECT * from sellingprice where id_product = '$id_product'");
        $query_product = mysqli_query($conn,"SELECT * from product where id_product = '$id_product'");
        $row_product = mysqli_fetch_array($query_product);
        if(isset($_POST['id_import'])){
             $id_product = $_POST['id_product'];
             $id_import = $_POST['id_import'];
             $price = $_POST['selling_price'];
             $dateStart = $_POST['dateStart'];
             if(isset($_POST['dateEnd'])){
                 $dateEnd = $_POST['dateEnd'];
             }else{
                 $dateEnd = "";
             }
             $dateEndOldSell = date('Y-m-d', strtotime($dateStart. ' - 1 day'));
             $query_date = mysqli_query($conn,"SELECT * from sellingprice where id_product = '$id_product' order by id_import desc limit 1");
             $row_date = mysqli_fetch_array($query_date);
             if($row_date['date_start'] > $dateEndOldSell){
                $_SESSION['status'] = "Thêm Thất Bại!";
                $_SESSION['notice'] = "Lỗi Logic Ngày Nhập Hàng";
                $_SESSION['status_code']= "error";
                $conn -> rollback();
                $url = "index.php?page_layout=sellingprice&id=" .$id_product;
                if(headers_sent()){
                    die('<script type ="text/javascript">window.location.href="'.$url.'" </script>');
                }else{
                     header ("location: $url");
                     die();
                }
             }else{
                 $sql .= "UPDATE sellingprice set date_end = '$dateEndOldSell' where id_product = '$id_product' order by id_import desc limit 1;";
                 $sql .= " INSERT into sellingprice(id_product,id_import,selling_price,date_start,date_end) values ('$id_product','$id_import','$price','$dateStart','$dateEnd');";
                 if(mysqli_multi_query($conn,$sql)){
                     $_SESSION['status'] = "Thêm Thành Công!";
                     $_SESSION['status_code']= "success";
                    $url = "index.php?page_layout=sellingprice&id=" .$id_product;
                    if(headers_sent()){
                        die('<script type ="text/javascript">window.location.href="'.$url.'" </script>');
                    }else{
                         header ("location: $url");
                         die();
                    }
                 }else {
                    $_SESSION['status'] = "Thêm Thất Bại!";
                    $_SESSION['status_code']= "error";
                    $conn -> rollback();
                    $url = "index.php?page_layout=sellingprice&id=" .$id_product;
                    if(headers_sent()){
                        die('<script type ="text/javascript">window.location.href="'.$url.'" </script>');
                    }else{
                         header ("location: $url");
                         die();
                    }
                }
            }
        }
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
                    <li class="breadcrumb-item active">Quản Lý Giá Bán</li>
                </ol>
            <div class="body-page--function-form">
                <form action="#" method="POST" enctype="multipart/form-data" id = "validator" >
                    <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-table me-1"></i>
                                    Thêm Chi Tiết Giá Bán Mới
                                </div>
                                <div class="card-body">
                                        <div class="form-group">
                                              <label for="InputTypeGroup"> Sản Phẩm</label>
                                              <select class="form-select form-control" aria-label="Default select example" id="id_product" name="id_product" >
                                                 <option value="<?php echo $row_product['id_product']; ?>"><?php echo $row_product['name_product'];?></option>
                                               </select>
                                              <span class="form-group__message"></span>
                                         </div>
                                         
                                         <div class="form-group">
                                           <label for="inputName" style="margin-bottom:20px">Chọn Mã Nhập Hàng</label>
                                           <select class="form-select form-control" aria-label="Default select example" id="id_import" name="id_import">
                                                   <option value="" selected>Choose</option>
                                                <?php 
                                                  if(mysqli_num_rows($query_selling) > 0){
                                                      $id_importselling = array();
                                                    while($row_selling = mysqli_fetch_array($query_selling)){
                                                        array_push( $id_importselling,$row_selling['id_import']);
                                                    }
                                                    $sql = "SELECT * from importdetails where id_product =  '$id_product'  ";
                                                    for($i = 0; $i< count($id_importselling);$i++){
                                                        $sql .= "and id_import != '".$id_importselling[$i]."'";
                                                    }
                                                       $query_importdetails = mysqli_query($conn,$sql);
                                                       if(mysqli_num_rows($query_importdetails)==0){
                                                        $_SESSION['status'] = "Truy Cập Thất Bại!";
                                                        $_SESSION['status_code']= "error";
                                                        $conn -> rollback();
                                                        $url = "index.php?page_layout=sellingprice&id=" .$id_product;
                                                        if(headers_sent()){
                                                            die('<script type ="text/javascript">window.location.href="'.$url.'" </script>');
                                                        }else{
                                                             header ("location: $url");
                                                             die();
                                                        }
                                                       }else{
                                                        while($row_importdetails = mysqli_fetch_array($query_importdetails)){
                                                        
                                                ?>
                                                    <option value="<?php echo $row_importdetails['id_import']; ?>"><?php echo $row_importdetails['id_import'];?></option>
                                                <?php  }}}else{
                                                ?>
                                                <?php
                                                       $query_importdetails = mysqli_query($conn,"SELECT * from importdetails where id_product =  '$id_product' ");
                                                       while($row_importdetails = mysqli_fetch_array($query_importdetails)){
                                                          $id_importdetails = $row_importdetails['id_import'];
                                                          $query_import = mysqli_query($conn,"SELECT * from importproduct  where id_import = '$id_importdetails' ");
                                                          $row_import = mysqli_fetch_array($query_import);
                                                        
                                                ?>
                                                    <option value="<?php echo $row_import['id_import']; ?>"><?php echo $row_import['id_import'];?></option>
                                                <?php }}?>
                                            </select>
                                           <span class="form-group__message"></span>
                                         </div>
                                       
                                         <div class="form-group">
                                           <label for="inputName" style="margin-bottom:20px">Nhập Giá Bán</label>
                                           <input type="text" class="form-control" id="selling_price" name="selling_price"  placeholder="Enter Price">
                                           <span class="form-group__message"></span>
                                         </div>
                                         <div class="form-group">
                                           <label for="inputName" style="margin-bottom:20px">Chọn Ngày Bắt Đầu Bán Với Giá Vừa Nhập</label>
                                            <input type="date" class="form-control" id="dateStart" name="dateStart"  style="width:12%">
                                          
                                           <span class="form-group__message"></span>
                                         </div>
                                         <div class="form-group">
                                           <label for="inputName" style="margin-bottom:20px">Chọn Ngày Kết Thúc Bán Với Giá Vừa Nhập</label>
                                           <input type="date" class="form-control" id="dateEnd" name="dateEnd"  style="width:12%">
                                           <span class="form-group__message"></span>
                                         </div>
                                         <a href = "index.php?page_layout=sellingprice&id=<?php echo $_REQUEST['id']; ?>" class="btn btn-primary " style="margin-top:12px"><i class="fas fa-arrow-left" style="margin-right:6px"></i>Back</a>
                                         <button type="submit" class="btn btn-primary" style="background-color: #212529;margin-top:12px;" >Submit</button>
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
               Validator.isRequired('#id_import'),
               Validator.isRequired('#selling_price'),
               Validator.isRequired('#id_product'),
               Validator.isRequired('#dateStart')
            ]
        });
        // var today = new Date();
        // var dd = today.getDate() + 1;
        // var mm = today.getMonth() + 1; //January is 0!
        // var yyyy = today.getFullYear();
        
        // if (dd < 10) {
        //    dd = '0' + dd;
        // }
        
        // if (mm < 10) {
        //    mm = '0' + mm;
        // } 
            
        // today = yyyy + '-' + mm + '-' + dd;
        // document.getElementById("dateStart").setAttribute("min", today);
    </script>
   