
<?php
include_once './config.php';

if (!isset($_SESSION['username'])) {
    header('location: ./login.php');
}else{
    if(in_array("3", $_SESSION['roleStaff'], true)){
        $type = mysqli_query($conn,"SELECT * from producttype order by id_type");
        $publishingcompany = mysqli_query($conn,"SELECT * from publishingcompany order by id_publishingcompany");
        $id_product = $_REQUEST['id'];
        $product = mysqli_query($conn,"SELECT * from product inner join publishingcompany on product.id_publishingcompany = publishingcompany.id_publishingcompany 
                                        inner join producttype on producttype.id_type = product.id_type 
                                        inner join typegroup on producttype.id_typegroup = typegroup.id_typegroup
                                        where id_product = '$id_product' ORDER BY id_product");
        $row_product = mysqli_fetch_array($product);
        if(isset($_POST['nameProduct'])){
             $name = $_POST['nameProduct'];
             $id_type = $_POST['id_type'];
             $id_publishingcompany = $_POST['id_publishingcompany'];
             $author = $_POST['authorProduct'];
             $product_cover = $_POST['product_cover'];
             $note = $_POST['noteProduct'];
             $sql = "UPDATE product SET id_type = '$id_type',
                                        id_publishingcompany = '$id_publishingcompany',
                                        name_product = '$name',
                                        note_product = '$note'
                                        where id_product = '$id_product'";
             if(mysqli_query($conn,$sql)){
                 $_SESSION['status'] = "Cập Nhật Thành Công!";
                 $_SESSION['status_code']= "success";
                $url = "index.php?page_layout=product";
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
                                            <label for="InputTypeGroup">Chọn Thể Loại Sản Phẩm</label>
                                            <select class="form-select form-control" aria-label="Default select example" id="id_type" name="id_type">
                                                   <option value="<?php echo $row_product['id_type']?>" selected><?php echo $row_product['name_typegroup'];?> - <?php echo $row_product['name_type'];?></option>
                                                <?php 
                                                    while($row_type = mysqli_fetch_array($type)){
                                                         $id_typegroup = $row_type['id_typegroup'];
                                                         $typegroup = mysqli_query($conn, "SELECT * from typegroup where id_typegroup = '$id_typegroup'");
                                                         $row_typegroup = mysqli_fetch_array($typegroup);
                                                         if($row_type['id_type'] != $row_product['id_type']){
                                                ?>
                                                    <option value="<?php echo $row_type['id_type']; ?>"><?php echo $row_typegroup['name_typegroup'];?> - <?php echo $row_type['name_type'];?></option>
                                                <?php }}?>
                                            </select>
                                            <span class="form-group__message"></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="InputTypeGroup">Chọn Nhà Xuất Bản</label>
                                            <select class="form-select form-control" aria-label="Default select example" id="id_publishingcompany" name="id_publishingcompany" >
                                                 <option value="<?php echo $row_product['id_publishingcompany']; ?>" selected><?php echo $row_product['name_publishingcompany'];?></option>
                                                <?php 
                                                    while($row_publishingcompany = mysqli_fetch_array($publishingcompany)){
                                                        if($row_publishingcompany['id_publishingcompany'] != $row_product['id_publishingcompany']){
                                                        
                                                ?>
                                                    <option value="<?php echo $row_publishingcompany['id_publishingcompany']; ?>"><?php echo $row_publishingcompany['name_publishingcompany'];?></option>
                                                <?php }}?>
                                            </select>
                                            <span class="form-group__message"></span>
                                        </div>
                                         <div class="form-group">
                                           <label for="inputName" style="margin-bottom:20px">Tên Sản Phẩm</label>
                                           <input type="text" class="form-control" id="nameProduct" name="nameProduct"  placeholder="Enter Name" value = "<?php echo $row_product['name_product'];?>">
                                           <span class="form-group__message"></span>
                                         </div>
                                         <div class="form-group">
                                           <label for="inputNote" style="margin-bottom:20px">Ghi Chú Sản Phẩm</label>
                                           <input type="tex" class="form-control" id="noteProduct" name="noteProduct"  placeholder="Enter Note" value = "<?php echo $row_product['note_product'];?>">
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