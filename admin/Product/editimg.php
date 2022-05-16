
<?php
include_once './config.php';

if (!isset($_SESSION['username'])) {
    header('location: ./login.php');
}else{
    if(in_array("3", $_SESSION['roleStaff'], true)){
        $id_product = $_REQUEST['id'];
        $query = mysqli_query($conn,"SELECT * from productimage where id_product = '$id_product'");
        $row_img = mysqli_fetch_array($query);
        $id_product = $row_img['id_product'];
        $product = mysqli_query($conn,"SELECT * from product where id_product = '$id_product'");
        if(isset($_POST['add-img'])){
            $product_img = '../img/Book/';
            $product_img = $product_img.$_FILES['product-img'] ['name'];
            move_uploaded_file($_FILES['product-img']['tmp_name'],$product_img);
             $sql = "UPDATE productimage SET link_img = '$product_img' where id_img = '$id_img' ";
             if(mysqli_query($conn,$sql)){
                 $_SESSION['status'] = "Cập Nhật Hình Ảnh Thành Công!";
                 $_SESSION['status_code']= "success";
                $url = "index.php?page_layout=productimage&id=" .$id_product;
                if(headers_sent()){
                    die('<script type ="text/javascript">window.location.href="'.$url.'" </script>');
                }else{
                     header ("location: $url");
                     die();
                }
             }else {
                $_SESSION['status'] = "Cập Nhật Hình Ảnh Thất Bại!";
                $_SESSION['status_code']= "error";
                $conn -> rollback();
                $url = "index.php?page_layout=productimage&id=" .$id_product;
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
                    <li class="breadcrumb-item active">Quản Lý Hình Ảnh Sản Phẩm</li>
                </ol>
            <div class="body-page--function-form">
                <form action="#" method="POST" enctype="multipart/form-data">
                    <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-table me-1"></i>
                                    Cập Nhật Hình Ảnh Sản Phẩm 
                                </div>
                                <div class="card-body">
                                         <div class="form-group">
                                            <label for="InputTypeGroup">Chọn Sản Phẩm</label>   
                                            <select class="form-select form-control" aria-label="Default select example" id="id_product" name="id_product" >
                                                <?php 
                                                    $row = mysqli_fetch_array($product);
                                                ?>
                                                    <option value="<?php echo $row['id_product']; ?>" selected><?php echo $row['name_product'];?></option>
                                               
                                            </select>
                                            <span class="form-group__message"></span>
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-file">
                                               <input type="file" class="custom-file-input" id="customFile" name="product-img">
                                               <label class="custom-file-label" for="customFile">Chọn Hình Ảnh</label>
                                            </div>
                                           <span class="form-group__message"></span>
                                        </div>
                                          <a href = "index.php?page_layout=productImg&id_product=<?php echo $row['id_product'];?>" class="btn btn-primary " style="margin-top:12px"><i class="fas fa-arrow-left" style="margin-right:6px"></i>Back</a>
                                         <button type="submit" class="btn btn-primary" name="add-img" style="background-color: #212529;margin-top:12px;">Submit</button>
                                </div>
                    </div>
                </form>
            </div>
        </div>
      
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
   
  