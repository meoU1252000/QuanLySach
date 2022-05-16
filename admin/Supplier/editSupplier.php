
<?php
include_once './config.php';

if (!isset($_SESSION['username'])) {
    header('location: ./login.php');
}else{
    if(in_array("4", $_SESSION['roleStaff'], true)){
        $id_supplier = $_REQUEST['id'];
        $query = mysqli_query($conn,"SELECT * from supplier where id_supplier ='$id_supplier'");
        if(isset($_POST['nameSupplier']) || isset($_POST['addressSupplier']) 
        || isset($_POST['phone']) || isset($_POST['note'])){
             $name = $_POST['nameSupplier'];
             $address = $_POST['addressSupplier'];
             $phone = $_POST['phone'];
             $note = $_POST['note'];
             $sql = "UPDATE supplier SET name_supplier = '$name',
                                      address_supplier = '$address',
                                      phone_supplier = '$phone',
                                      note_supplier = '$note' 
                                      where id_supplier = '$id_supplier'";
             if(mysqli_query($conn,$sql)){
                 $_SESSION['status'] = "Cập Nhật Thành Công!";
                 $_SESSION['status_code']= "success";
                $url = "index.php?page_layout=supplier";
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
                $url = "index.php?page_layout=supplier";
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
                    <li class="breadcrumb-item active">Quản Lý Thông Tin Nhân Viên</li>
                </ol>
            <div class="body-page--function-form">
                <form action="#" method="POST" enctype="multipart/form-data" id = "validator" >
                    <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-table me-1"></i>
                                    Cập Nhật Thông Tin Nhân Viên
                                </div>
                                <div class="card-body">
                                    <?php 
                                       while($row = mysqli_fetch_array($query)){
                                       
                                    ?>
                                         <div class="form-group">
                                           <label for="inputName">Họ Tên Nhân Viên</label>
                                           <input type="text" class="form-control" id="nameSupplier" name="nameSupplier"  placeholder="Enter Name" value = "<?php echo $row['name_supplier'];?>">
                                           <span class="form-group__message"></span>
                                         </div>
                                         <div class="form-group">
                                           <label for="inputAddress">Địa Chỉ Liên Hệ</label>
                                           <input type="text" class="form-control" id="addressSupplier" name="addressSupplier"  placeholder="Enter Address" value = "<?php echo $row['address_supplier'];?>">
                                           <span class="form-group__message"></span>
                                         </div>
                                         <div class="form-group">
                                           <label for="inputEmail">Số Điện Thoại Liên Hệ</label>
                                           <input type="text" class="form-control" id="phone" name="phone"  placeholder="Enter Phone" value = "<?php echo $row['phone_supplier'];?>">
                                           <span class="form-group__message"></span>
                                         </div>
                                         <div class="form-group">
                                           <label for="InputNote">Ghi Chú</label>
                                           <input type="text" class="form-control" id="note" name="note" placeholder="Enter Note" value = "<?php echo $row['note_supplier'];?>">
                                           <span class="form-group__message"></span>
                                         </div>
                                        <?php } ?>
                                        <a href = "index.php?page_layout=staff" class="btn btn-primary " style="margin-top:12px"><i class="fas fa-arrow-left" style="margin-right:6px"></i>Back</a>
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
               Validator.isRequired('#nameSupplier'),
               Validator.isRequired('#addressSupplier'),
               Validator.isRequired('#phone')
            ]
        });
    </script>