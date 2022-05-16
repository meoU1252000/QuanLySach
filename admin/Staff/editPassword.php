<?php
include_once './config.php';

if (!isset($_SESSION['username'])) {
    header('location: ./login.php');
}else{
        include_once './alert.php';
        $id_staff = $_SESSION['id_staff'];
        $query = mysqli_query($conn,"SELECT * from staff where id_staff ='$id_staff'");
        if(isset($_POST['oldPassword']) && isset($_POST['newPassword']) ){
             $oldPassword = $_POST['oldPassword'];
             $check = mysqli_query($conn,"SELECT * from staffaccount where id_staff = '$id_staff' and password_staff = md5('$oldPassword')");
             if(mysqli_num_rows($check)>0){
                 $newPassword = $_POST['newPassword'];
                 $sql = "UPDATE staffaccount SET password_staff = md5('$newPassword') where id_staff = '$id_staff'";
                 if(mysqli_query($conn,$sql)){
                    echo '<script language="javascript">';
                    echo 'alert("Thay đổi mật khẩu thành công. Vui lòng đăng nhập lại")';
                    echo '</script>';
                    $url = "login.php";
                    if(headers_sent()){
                        die('<script type ="text/javascript">window.location.href="'.$url.'" </script>');
                    }else{
                        header ("location: $url");
                        die();
                    }
                    session_destroy();
                    
                 }else {
                    $_SESSION['status'] = "Cập Nhật Thất Bại!";
                    $_SESSION['status_code']= "error";
                    $conn -> rollback();
                    $url = "index.php?page_layout=changePassword";
                    if(headers_sent()){
                        die('<script type ="text/javascript">window.location.href="'.$url.'" </scrip>');
                    }else{
                         header ("location: $url");
                         die();
                    }
                }

             }else{
                $_SESSION['status'] = "Cập Nhật Thất Bại!";
                $_SESSION['notice'] = "Sai Mật Khẩu! Vui lòng thử lại...";
                $_SESSION['status_code']= "error";
                $conn -> rollback();
                $url = "index.php?page_layout=changePassword";
                if(headers_sent()){
                    die('<script type ="text/javascript">window.location.href="'.$url.'" </script>');
                }else{
                     header ("location: $url");
                     die();
                }
             }
        }
        mysqli_close($conn);
   
}

?>

<div class="container-fluid px-4">
            <h1 class="mt-4">Dashboard</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Quản Lý Tài Khoản</li>
                </ol>
            <div class="body-page--function-form">
                <form action="#" method="POST" enctype="multipart/form-data" id = "validator" >
                    <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-table me-1"></i>
                                    Thay Đổi Mật Khẩu
                                </div>
                                <div class="card-body">
                                   
                                       <div class="form-group">
                                           <label for="InputPassword">Mật Khẩu Hiện Tại</label>
                                           <input type="password" class="form-control" id="oldPassword" name="oldPassword" placeholder="Password">
                                           <small id="passwordHelpBlock" class="form-text text-muted">
                                              Mật Khẩu phải có tối thiểu tám ký tự, ít nhất một chữ cái viết hoa, một chữ cái viết thường, một số và một kí tự đặc biệt!.
                                            </small>
                                           <span class="form-group__message"></span>
                                         </div>
                                        <div class="form-group">
                                           <label for="InputPassword">Mật Khẩu Mới</label>
                                           <input type="password" class="form-control" id="newPassword" name="newPassword" placeholder="Password">
                                           <small id="passwordHelpBlock" class="form-text text-muted">
                                              Mật Khẩu phải có tối thiểu tám ký tự, ít nhất một chữ cái viết hoa, một chữ cái viết thường, một số và một kí tự đặc biệt!.
                                            </small>
                                           <span class="form-group__message"></span>
                                         </div>
                                         <div class="form-group">
                                           <label for="InputPassword">Xác Nhận Mật Khẩu</label>
                                           <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Password">
                                           <span class="form-group__message"></span>
                                         </div>
                                        <a href = "index.php" class="btn btn-primary " style="margin-top:12px"><i class="fas fa-arrow-left" style="margin-right:6px"></i>Back</a>
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
                Validator.isPassword('#oldPassword','<i class="fas fa-exclamation-triangle warn_icon"></i>Mật khẩu không chính xác'),
               Validator.isPassword('#newPassword','<i class="fas fa-exclamation-triangle warn_icon"></i>Mật khẩu không chính xác'),
               Validator.isConfirmed('#confirmPassword',function(){
                   return document.querySelector('#validator #newPassword').value;
               },'<i class="fas fa-exclamation-triangle warn_icon"></i>Mật khẩu không trùng khớp')
            ]
        });
    </script>