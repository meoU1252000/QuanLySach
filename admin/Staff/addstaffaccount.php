
<?php
include_once './config.php';
if (!isset($_SESSION['username'])) {
    header('location: ./login.php');
}else{
    if(in_array("1", $_SESSION['roleStaff'], true)){
        $sql = "SELECT staff.* from staff LEFT JOIN staffaccount ON staff.id_staff = staffaccount.id_staff where staffaccount.id_staff is Null";
        $query = mysqli_query($conn,$sql);
        if(isset($_POST['email']) && isset($_POST['password'])){
            $id_staff = $_POST['id_staff'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $passwordadmin = $_POST['passwordadmin'];
            $query_checkAuth = mysqli_query($conn, "SELECT id_staff from staffaccount as a, roledetails as b where a.id_staff = b.id_staff and b.id_role= 1 and a.password_staff = '$passwordadmin'");
            $row_checkAuth = mysqli_fetch_array($query_checkAuth);
            if($row_checkAuth != NULL){
                $insert = "INSERT into staffaccount(id_staff,email_staff,password_staff) values ('$id_staff','$email',md5('$password'))";
                if(mysqli_query($conn,$insert)){
                    $_SESSION['status'] = "Thêm Thành Công!";
                    $_SESSION['status_code']= "success";
                   $url = "index.php?page_layout=staff";
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
                   $url = "index.php?page_layout=staff";
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
                    <li class="breadcrumb-item active">Quản Lý Thông Tin Nhân Viên</li>
                </ol>
            <div class="body-page--function-form">
                <form action="#" method="POST" enctype="multipart/form-data" id = "validator" >
                    <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-table me-1"></i>
                                    Cấp Tài Khoản Mới
                                </div>
                                <div class="card-body">
                                    <?php if(mysqli_num_rows($query) > 0 ){?>
                                       <h6 class="card-body__heading">Account Infomartion</h6>
                                        <div class="form-group">
                                            <label for="Inputstaff">Choose Staff </label>   
                                            <select class="form-select form-control" aria-label="Default select example" id="id_staff" name="id_staff" >
                                                   <option value="" selected>Choose</option>
                                                <?php 
                                                    while($row = mysqli_fetch_array($query)){
                                                ?>
                                                    <option value="<?php echo $row['id_staff']; ?>"><?php echo $row['name_staff'];?> - ID: <?php echo $row['id_staff'];?></option>
                                                <?php }?>
                                            </select>
                                            <span class="form-group__message"></span>
                                        </div>
                                         <div class="form-group">
                                           <label for="inputEmail">Email address</label>
                                           <input type="email" class="form-control" id="email" name="email"  placeholder="Enter email">
                                           <span class="form-group__message"></span>
                                         </div>
                                         <div class="form-group">
                                           <label for="InputPassword">Password</label>
                                           <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                                           <small id="passwordHelpBlock" class="form-text text-muted">
                                              Your password must be 8-20 characters long, contain letters and numbers, and must not contain spaces, special characters, or emoji.
                                            </small>
                                           <span class="form-group__message"></span>
                                         </div>
                                         <div class="form-group">
                                           <label for="InputPassword">Confirm Password</label>
                                           <input type="password" class="form-control" id="confirmpassword" name="confirmpassword" placeholder="Password">
                                           <span class="form-group__message"></span>
                                         </div>
                                         <h6 class="card-body__heading" style="margin-top:32px">Authencation</h6>
                                         <div class="form-group">
                                           <label for="InputPassword">Password Admin Confirm</label>
                                           <input type="password" class="form-control" id="passwordadmin" placeholder="Password">
                                           <span class="form-group__message"></span>
                                         </div>
                                         <button type="submit" class="btn btn-primary" style="background-color: #212529;margin-top:12px;">Submit</button>
                                    <?php }else{ 
                                         $_SESSION['status'] = "Truy Cập Thất Bại!";
                                         $_SESSION['notice'] = "Không có nhân viên nào chưa có tài khoản !";
                                         $_SESSION['status_code']= "error";
                                         $conn -> rollback();
                                         $url = "index.php?page_layout=staff";
                                         if(headers_sent()){
                                             die('<script type ="text/javascript">window.location.href="'.$url.'" </script>');
                                         }else{
                                              header ("location: $url");
                                              die();
                                         }
                                        }
                                    ?>
                                </div>
                    </div>
                </form>
            </div>

        </div>
    <script src="../assets/script/validator.js"></script>
   
    <script>
        Validator({
            form: '#validator',
            formGroupSelector: '.form-group',
            errorSelector: '.form-group__message',
            rules: [
               Validator.isRequired('#id_staff'),
               Validator.isEmail('#email','<i class="fas fa-exclamation-triangle warn_icon"></i>Email không chính xác'),
               Validator.isPassword('#password','<i class="fas fa-exclamation-triangle warn_icon"></i>Mật khẩu không chính xác'),
               Validator.isPassword('#passwordadmin','<i class="fas fa-exclamation-triangle warn_icon"></i>Mật khẩu không chính xác'),
               Validator.isConfirmed('#confirmpassword',function(){
                   return document.querySelector('#validator #password').value;
               },'<i class="fas fa-exclamation-triangle warn_icon"></i>Mật khẩu không trùng khớp')
            ]
           
        });
    </script>
    <?php   mysqli_close($conn);?>