
<?php
include_once './config.php';

if (!isset($_SESSION['username'])) {
    header('location: ./login.php');
}else{
    if($_SESSION['roleStaff'][0] == 3 || $_SESSION['roleStaff']["3"]){
        $id_publishingcompany = $_REQUEST['id'];
        $query = mysqli_query($conn,"SELECT * from publishingcompany where id_publishingcompany = '$id_publishingcompany'");
        $row = mysqli_fetch_array($query);
        if(isset($_POST['name_publishingcompany'])){
             $name = $_POST['name_publishingcompany'];
             $sql = "UPDATE publishingcompany SET name_publishingcompany = '$name' where id_publishingcompany = '$id_publishingcompany' ";
             if(mysqli_query($conn,$sql)){
                 $_SESSION['status'] = "Cập Nhật Thành Công!";
                 $_SESSION['status_code']= "success";
                $url = "index.php?page_layout=publishingCompany";
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
                $url = "index.php?page_layout=publishingCompany";
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
                    <li class="breadcrumb-item active">Quản Lý Thông Tin Nhà Xuất Bản</li>
                </ol>
            <div class="body-page--function-form">
                <form action="#" method="POST" enctype="multipart/form-data" id = "validator" >
                    <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-table me-1"></i>
                                    Cập Nhật Thông Tin Nhà Xuất Bản 
                                </div>
                                <div class="card-body">
                                         <div class="form-group">
                                           <label for="inputName" style="margin-bottom:20px">Tên Nhà Xuất Bản</label>
                                           <input type="text" class="form-control" id="name_publishingcompany" name="name_publishingcompany"  placeholder="Enter Name" value = "<?php echo $row['name_publishingcompany'];?>">
                                           <span class="form-group__message"></span>
                                         </div>
                                         <a href = "index.php?page_layout=brand" class="btn btn-primary " style="margin-top:12px"><i class="fas fa-arrow-left" style="margin-right:6px"></i>Back</a>
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
               Validator.isRequired('#name_publishingcompany')
            ]
        });
    </script>