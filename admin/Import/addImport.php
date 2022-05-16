
<?php
include_once './config.php';

if (!isset($_SESSION['username'])) {
    header('location: ./login.php');
}else{
    if(in_array("4", $_SESSION['roleStaff'], true)){
        if(isset($_POST['dateImport'])){
             $date = $_POST['dateImport'];
             $sql = "INSERT into importproduct(date_import) values ('$date')";
             if(mysqli_query($conn,$sql)){
                 $_SESSION['status'] = "Thêm Thành Công!";
                 $_SESSION['status_code']= "success";
                $url = "index.php?page_layout=importproduct";
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
                $url = "index.php?page_layout=importproduct";
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
                    <li class="breadcrumb-item active">Quản Lý Nhập Hàng</li>
                </ol>
            <div class="body-page--function-form">
                <form action="#" method="POST" enctype="multipart/form-data" id = "validator" >
                    <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-table me-1"></i>
                                    Thêm Thông Tin Nhập Hàng Mới
                                </div>
                                <div class="card-body">
                                         <div class="form-group">
                                           <label for="inputName" style="margin-bottom:20px">Chọn Ngày Nhập Hàng</label>
                                           <input type="date" class="form-control" id="dateImport" name="dateImport"  style="width:12%">
                                           <span class="form-group__message"></span>
                                         </div>
                                         <a href = "index.php?page_layout=importproduct" class="btn btn-primary " style="margin-top:12px"><i class="fas fa-arrow-left" style="margin-right:6px"></i>Back</a>
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
               Validator.isRequired('#dateImport')
            ]
        });
        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth() + 1; //January is 0!
        var yyyy = today.getFullYear();
        
        if (dd < 10) {
           dd = '0' + dd;
        }
        
        if (mm < 10) {
           mm = '0' + mm;
        } 
            
        today = yyyy + '-' + mm + '-' + dd;
        document.getElementById("dateImport").setAttribute("min", today);
    </script>