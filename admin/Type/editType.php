
<?php
include_once './config.php';

if (!isset($_SESSION['username'])) {
    header('location: ./login.php');
}else{
    if(in_array("3", $_SESSION['roleStaff'], true)){
        $id_type = $_REQUEST['id'];
        $query = mysqli_query($conn,"SELECT * from typegroup order by id_typegroup");
        $query_type = mysqli_query($conn,"SELECT * from producttype where id_type ='$id_type'");
        $row_type =mysqli_fetch_array($query_type);
        if(isset($_POST['nameType'])){
             $name = $_POST['nameType'];
             $id_typegroup = $_POST['id_typegroup'];
             $sql = "UPDATE producttype SET id_typegroup = '$id_typegroup',
                                             name_type = '$name'
                                             where id_type = '$id_type' ";
             if(mysqli_query($conn,$sql)){
                 $_SESSION['status'] = "Cập Nhật Thành Công!";
                 $_SESSION['status_code']= "success";
                $url = "index.php?page_layout=type";
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
                $url = "index.php?page_layout=type";
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
                    <li class="breadcrumb-item active">Quản Lý Thể Loại Sản Phẩm</li>
                </ol>
            <div class="body-page--function-form">
                <form action="#" method="POST" enctype="multipart/form-data" id = "validator" >
                    <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-table me-1"></i>
                                    Cập Nhật Thể Loại Sản Phẩm Mới
                                </div>
                                <div class="card-body">
                                         <div class="form-group">
                                            <label for="InputTypeGroup">Chọn Danh Mục </label>   
                                            <select class="form-select form-control" aria-label="Default select example" id="id_typegroup" name="id_typegroup" >
                                                   <option value="" selected>Choose</option>
                                                <?php 
                                                    while($row = mysqli_fetch_array($query)){
                                                ?>
                                                    <option value="<?php echo $row['id_typegroup']; ?>"><?php echo $row['name_typegroup'];?></option>
                                                <?php }?>
                                            </select>
                                            <span class="form-group__message"></span>
                                        </div>
                                         <div class="form-group">
                                           <label for="inputName" style="margin-bottom:20px">Tên Thể Loại Sản Phẩm</label>
                                           <input type="text" class="form-control" id="nameType" name="nameType"  placeholder="Enter Name" value ="<?php echo $row_type['name_type']?>">
                                           <span class="form-group__message"></span>
                                         </div>
                                         <a href = "index.php?page_layout=type" class="btn btn-primary " style="margin-top:12px"><i class="fas fa-arrow-left" style="margin-right:6px"></i>Back</a>
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
               Validator.isRequired('#nameType'),
               Validator.isRequired('#id_typegroup')
            ]
        });
    </script>