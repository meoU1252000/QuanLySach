
<?php
include_once './config.php';

if (!isset($_SESSION['username'])) {
    header('location: ./login.php');
}else{
    if(in_array("3", $_SESSION['roleStaff'], true)){
        $id_selling = $_REQUEST['id'];
        $query = mysqli_query($conn,"SELECT * from sellingprice where id_sell='$id_selling'");
        $row =mysqli_fetch_array($query);
        $id_import = $row['id_import'];
        $query_import = mysqli_query($conn,"SELECT * from importproduct where id_import = '$id_import' ");
        $id_product = $row['id_product'];
        $sell_price = $row['selling_price'];
        $query_product = mysqli_query($conn,"SELECT * from product where id_product = '$id_product'");
        if(isset($_POST['dateEnd'])){
                $date_end = $_POST['dateEnd'];
                $sql = "UPDATE sellingprice SET date_end = '$date_end' where id_sell = '$id_selling'";
                if(mysqli_query($conn,$sql)){
                    $_SESSION['status'] = "Cập Nhật Thành Công!";
                    $_SESSION['status_code']= "success";
                   $url = "index.php?page_layout=sellingprice&id=" .$id_product;
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
                    $url = "index.php?page_layout=sellingprice&id=" .$id_product;
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
                    <li class="breadcrumb-item active">Quản Lý Giá Bán</li>
                </ol>
            <div class="body-page--function-form">
                <form action="#" method="POST" enctype="multipart/form-data" id = "validator" >
                    <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-table me-1"></i>
                                    Cập Nhật Giá Bán
                                </div>
                                <div class="card-body">
                                          <div class="form-group">
                                              <label for="InputTypeGroup"> Sản Phẩm</label>
                                              <select class="form-select form-control" aria-label="Default select example" id="id_product" name="id_product" disabled>
                                                  <?php $row_product = mysqli_fetch_array($query_product); ?>
                                                 <option value="<?php echo $row_product['id_product']; ?>"><?php echo $row_product['name_product'];?></option>
                                               </select>
                                              <span class="form-group__message"></span>
                                         </div>
                                         
                                         <div class="form-group">
                                           <label for="inputName" style="margin-bottom:20px">Mã Nhập Hàng</label>
                                           <select class="form-select form-control" aria-label="Default select example" id="id_import" name="id_import" disabled>
                                                <?php 
                                                        $row_import = mysqli_fetch_array($query_import);
                                                        
                                                ?>
                                                    <option value="<?php echo $row_import['id_import']; ?>" selected><?php echo $row_import['id_import'];?></option>
                                              
                                               
                                               
                                            </select>
                                           <span class="form-group__message"></span>
                                         </div>
                                       
                                         <div class="form-group">
                                           <label for="inputName" style="margin-bottom:20px">Nhập Giá Bán</label>
                                           <input type="text" class="form-control" id="selling_price" name="selling_price"  placeholder="Enter Price" value = "<?php echo $row['selling_price'];?>" disabled>
                                           <span class="form-group__message"></span>
                                         </div>
                                         <div class="form-group">
                                           <label for="inputName" style="margin-bottom:20px">Chọn Ngày Bắt Đầu Bán Với Giá Vừa Nhập</label>
                                           <input type="date" class="form-control" id="dateStart" name="dateStart"  style="width:12%" value = "<?php echo $row['date_start'];?>" disabled> 
                                           <span class="form-group__message"></span>
                                         </div>
                                         <div class="form-group">
                                           <label for="inputName" style="margin-bottom:20px">Chọn Ngày Kết Thúc Bán Với Giá Vừa Nhập</label>
                                           <input type="date" class="form-control" id="dateEnd" name="dateEnd"  style="width:12%" value = "<?php echo $row['date_end'];?> ">
                                           <span class="form-group__message"></span>
                                         </div>
                                         
                                         <a href = "index.php?page_layout=sellingprice&id=<?php echo $id_product?>" class="btn btn-primary " style="margin-top:12px"><i class="fas fa-arrow-left" style="margin-right:6px"></i>Back</a>
                                         <button type="submit" class="btn btn-primary" style="background-color: #212529;margin-top:12px;">Submit</button>
                                        
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
               Validator.isRequired('#dateEnd')
             
            ]
        });
        var today = new Date();
        var dd = today.getDate() + 1;
        var mm = today.getMonth() + 1; //January is 0!
        var yyyy = today.getFullYear();
        
        if (dd < 10) {
           dd = '0' + dd;
        }
        
        if (mm < 10) {
           mm = '0' + mm;
           
        } 
        today = yyyy + '-' + mm + '-' + dd;
        document.getElementById("dateEnd").setAttribute("min", today);
    </script>