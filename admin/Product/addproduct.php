
<?php
include_once './config.php';

if (!isset($_SESSION['username'])) {
    header('location: ./login.php');
}else{
    if(in_array("3", $_SESSION['roleStaff'], true)){
        $type = mysqli_query($conn,"SELECT * from producttype order by id_type");
        $publishingcompany = mysqli_query($conn, "SELECT * from publishingcompany ORDER BY id_publishingcompany ");
        if(isset($_POST['nameProduct'])){
             $name = $_POST['nameProduct'];
             $id_type = $_POST['id_type'];
             $id_publishingcompany = $_POST['id_publishingcompany'];
             $note = $_POST['noteProduct'];
             $sql = "INSERT into product(id_type,id_publishingcompany,name_product,number_product,product_sold,note_product) values ('$id_type','$id_publishingcompany','$name','0','0','$note')";
             if(mysqli_query($conn,$sql)){
                 $_SESSION['status'] = "Thêm Thành Công!";
                 $_SESSION['status_code']= "success";
                $url = "index.php?page_layout=product";
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
                $url = "index.php?page_layout=product";
                if(headers_sent()){
                    die('<script type ="text/javascript">window.location.href="'.$url.'" </script>');
                }else{
                     header ("location: $url");
                     die();
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
                    <li class="breadcrumb-item active">Quản Lý Sản Phẩm</li>
                </ol>
            <div class="body-page--function-form">
                <form action="#" method="POST" enctype="multipart/form-data" id = "validator" >
                    <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-table me-1"></i>
                                    Thêm Sản Phẩm Mới
                                </div>
                                <div class="card-body">
                                        <div class="form-group">
                                            <label for="InputTypeGroup">Chọn Thể Loại Sản Phẩm </label>
                                            <select class="form-select form-control" aria-label="Default select example" id="id_type" name="id_type">
                                                   <option value="" selected>Choose</option>
                                                <?php 
                                                    while($row_type = mysqli_fetch_array($type)){
                                                         $id_typegroup = $row_type['id_typegroup'];
                                                         $typegroup = mysqli_query($conn, "SELECT * from typegroup where id_typegroup = '$id_typegroup'");
                                                         $row_typegroup = mysqli_fetch_array($typegroup);
                                                ?>
                                                    <option value="<?php echo $row_type['id_type']; ?>"><?php echo $row_typegroup['name_typegroup'];?> - <?php echo $row_type['name_type'];?></option>
                                                <?php }?>
                                            </select>
                                            <span class="form-group__message"></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="InputTypeGroup">Chọn Nhà Xuất Bản</label>
                                            <select class="form-select form-control" aria-label="Default select example" id="id_publishingcompany" name="id_publishingcompany" >
                                                   <option value="" selected>Choose</option>
                                                <?php 
                                                    while($row_publishingcompany = mysqli_fetch_array($publishingcompany)){
                                                ?>
                                                    <option value="<?php echo $row_publishingcompany['id_publishingcompany']; ?>"><?php echo $row_publishingcompany['name_publishingcompany'];?></option>
                                                <?php }?>
                                            </select>
                                            <span class="form-group__message"></span>
                                        </div>
                                         <div class="form-group">
                                           <label for="inputName" style="margin-bottom:20px">Tên Sản Phẩm</label>
                                           <input type="text" class="form-control" id="nameProduct" name="nameProduct"  placeholder="Enter Name">
                                           <span class="form-group__message"></span>
                                         </div>
                                         <div class="form-group">
                                           <label for="inputNote" style="margin-bottom:20px">Ghi Chú Sản Phẩm</label>
                                           <input type="tex" class="form-control" id="noteProduct" name="noteProduct"  placeholder="Enter Note">
                                           <span class="form-group__message"></span>
                                         </div>
                                         <a href = "index.php?page_layout=product" class="btn btn-primary " style="margin-top:12px"><i class="fas fa-arrow-left" style="margin-right:6px"></i>Back</a>
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
               Validator.isRequired('#id_type'),
               Validator.isRequired('#id_publishingcompany'),
               Validator.isRequired('#nameProduct')
            ]
        });
    </script>
<?php mysqli_close($conn);?>